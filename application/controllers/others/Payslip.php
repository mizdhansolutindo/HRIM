<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Payslip extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();

      $this->load->model('model');

      if ($this->session->userdata('role') != '4' && $this->session->userdata('role') != '5' && $this->session->userdata('role') != '6') {
         redirect('login');
      }

      date_default_timezone_set('asia/jakarta');
   }


   public function index()
   {
      $data['title'] = "Payroll";
      $data['potongan'] = $this->model->get('potongan')->result();

      $data['data'] = $this->db->query("SELECT *, potongan.jumlah AS jumlah_potongan FROM payroll
        LEFT JOIN karyawan ON karyawan.id_karyawan = payroll.id_karyawan
        LEFT JOIN jabatan ON jabatan.id_jabatan = payroll.id_jabatan
        LEFT JOIN departement ON departement.id_departement = payroll.id_departement
        LEFT JOIN potongan ON potongan.id_potongan = payroll.id_potongan
        ORDER BY payroll.id_pembayaran DESC")->result();

      $data['add'] = $this->db->query("
            SELECT karyawan.user_id, karyawan.id_karyawan, karyawan.id_jabatan, karyawan.id_departement, karyawan.nama_karyawan, jabatan.*, departement.nama_departement, 
            SUM(CASE WHEN MONTH(absen.waktu) = MONTH(CURDATE()) AND absen.keterangan = 'pulang' THEN 1 ELSE 0 END) AS qty
            FROM karyawan
            LEFT JOIN jabatan ON jabatan.id_jabatan = karyawan.id_jabatan
            LEFT JOIN departement ON departement.id_departement = karyawan.id_departement
            LEFT JOIN absen ON karyawan.user_id = absen.user_id
            GROUP BY karyawan.user_id, karyawan.nama_karyawan, jabatan.nama_jabatan, departement.nama_departement
            ORDER BY karyawan.user_id DESC")->result();

      $this->load->view('layout/others/header', $data);
      $this->load->view('others/list_gaji', $data);
      $this->load->view('layout/others/footer');
   }

   public function hitung_gaji()
   {
      $data['title'] = "Hitung Gaji";
      $data['karyawan'] = $this->model->get('karyawan')->result();
      $data['jabatan'] = $this->model->get('jabatan')->result();
      $data['departement'] = $this->model->get('departement')->result();
      $data['potongan'] = $this->model->get('potongan')->result();

      $this->load->view('layout/others/header', $data);
      $this->load->view('others/hitung_gaji', $data);
      $this->load->view('layout/others/footer');
   }

   public function getKaryawanDetail($id_karyawan)
   {
      // Misalkan tabel karyawan Anda adalah "karyawan" dan tabel jabatan dan departemen adalah "jabatan" dan "departemen"
      $this->db->select('users.user_id, jabatan.nama_jabatan, departement.nama_departement, karyawan.id_departement AS id_dept, karyawan.id_jabatan, jabatan.gaji_pokok, jabatan.tunjangan_jabatan, jabatan.tunjangan_makan, jabatan.tunjangan_aktifitas, karyawan.id_karyawan, jabatan.tipe_pajak, jabatan.nominal_pajak, jabatan.bpjs, lembur.jam_mulai, lembur.jam_akhir');
      $this->db->from('karyawan');
      $this->db->join('jabatan', 'karyawan.id_jabatan = jabatan.id_jabatan');
      $this->db->join('departement', 'karyawan.id_departement = departement.id_departement');
      $this->db->join('users', 'karyawan.user_id = users.user_id');
      $this->db->where('karyawan.id_karyawan', $id_karyawan);

      // Gabungkan dengan tabel "lembur" untuk menghitung upah lembur
      $this->db->join('lembur', 'karyawan.user_id = lembur.user_id');

      // Hitung total jam lembur
      $this->db->select('SUM(TIMESTAMPDIFF(SECOND, lembur.jam_mulai, lembur.jam_akhir)) as total_jam_lembur', false);

      $data = $this->db->get()->row();

      // Gantilah ini dengan tarif upah lembur per jam yang sesuai
      $tarif_upah_lembur_per_jam = 50000; // Ganti dengan tarif upah lembur per jam yang sesuai

      // Tarif upah lembur per jam (hardcoded)
      $tarif_upah_lembur_per_jam_pertama = 1.5 * $tarif_upah_lembur_per_jam; // Jam pertama pada hari kerja 1,5x gaji di satu jam pertama lembur
      $tarif_upah_lembur_per_jam_berikutnya = 2 * $tarif_upah_lembur_per_jam; // Jam berikutnya pada hari kerja 2x upah per satu jam lembur

      // Hitung total jam lembur
      $total_jam_lembur = $data->total_jam_lembur / 3600;

      // Hitung upah lembur berdasarkan total jam lembur
      if (
         $total_jam_lembur > 0
      ) {
         $total_upah_lembur = $tarif_upah_lembur_per_jam_pertama;

         // Hitung upah lembur untuk jam berikutnya (jika ada)
         if ($total_jam_lembur > 1) {
            $total_upah_lembur += ($total_jam_lembur - 1) * $tarif_upah_lembur_per_jam_berikutnya;
         }
      } else {
         $total_upah_lembur = 0;
      }

      // Rumus upah lembur per hari: 1/173 x gaji satu bulan
      $upah_lembur_per_hari = (1 / 173) * $data->gaji_pokok;

      // Masukkan nilai total upah lembur dan upah lembur per hari ke dalam data
      $data->total_upah_lembur = $total_upah_lembur;
      $data->upah_lembur_per_hari = $upah_lembur_per_hari;

      // Format data sebagai JSON
      header('Content-Type: application/json');
      echo json_encode($data);
   }

   public function proses()
   {
      $id_pembayaran = $this->input->post('id_pembayaran');
      $user_id = $this->input->post('user_id');
      $id_karyawan = $this->input->post('id_karyawan');
      $id_potongan = $this->input->post('id_potongan');
      $tanggal_pembayaran = $this->input->post('tanggal_pembayaran');
      $tanggal_penggajian = $this->input->post('tanggal_penggajian');
      $id_jabatan = $this->input->post('id_jabatan');
      $id_departement = $this->input->post('id_departement');
      $gaji_pokok = $this->input->post('gaji_pokok');
      $upah_lembur = $this->input->post('upah_lembur');
      $tunjangan_aktivitas = $this->input->post('tunjangan_aktivitas');
      $qty = $this->input->post('qty');
      $tunjangan_jabatan = $this->input->post('tunjangan_jabatan');
      $tunjangan_makan = $this->input->post('tunjangan_makan');
      $bonus_kinerja = $this->input->post('bonus_kinerja');
      $pph23 = $this->input->post('pph23');
      $bpjs = $this->input->post('bpjs');
      $pinjaman = $this->input->post('pinjaman');
      $pot_absensi = $this->input->post('pot_absensi');
      $keterangan_pembayaran = $this->input->post('keterangan_pembayaran');

      // Ambil bulan dan tahun dari tanggal pembayaran
      $bulan_tahun = date('Y-m', strtotime($tanggal_pembayaran));

      // Lakukan pengecekan di database apakah sudah ada data gaji dengan tanggal pembayaran pada bulan yang sama
      $existingData = $this->db->get_where('payroll', array(
         'user_id' => $user_id,
         'MONTH(tanggal_pembayaran)' => date('m', strtotime($tanggal_pembayaran)),
         'YEAR(tanggal_pembayaran)' => date('Y', strtotime($tanggal_pembayaran))
      ))->row();

      if ($existingData) {
         // Jika data sudah ada, berikan pesan kesalahan dan hentikan proses
         $this->session->set_flashdata('warning', 'Data gaji untuk bulan yang sama sudah ada.');
         redirect('others/payslip');
         return;
      }

      // Ambil jumlah potongan dari tabel potongan sesuai dengan id_potongan
      $potongan_query = $this->db->get_where('potongan', array('id_potongan' => $id_potongan));
      $potongan_data = $potongan_query->row();

      if ($potongan_data) {
         $pot = $pph23 + $bpjs + $pinjaman + $pot_absensi;
         $total = $pot - $potongan_data->jumlah;
         $thp = $gaji_pokok + $upah_lembur + $tunjangan_aktivitas + $tunjangan_jabatan + $tunjangan_makan + $bonus_kinerja - $total;

         $data = array(
            'id_pembayaran' => $id_pembayaran,
            'user_id' => $user_id,
            'id_karyawan' => $id_karyawan,
            'id_potongan' => $id_potongan,
            'tanggal_pembayaran' => $tanggal_pembayaran,
            'tanggal_penggajian' => $tanggal_penggajian,
            'id_jabatan' => $id_jabatan,
            'id_departement' => $id_departement,
            'gaji_pokok' => $gaji_pokok,
            'upah_lembur' => $upah_lembur,
            'tunjangan_aktivitas' => $tunjangan_aktivitas * $qty,
            'qty' => $qty,
            'tunjangan_jabatan' => $tunjangan_jabatan,
            'tunjangan_makan' => $tunjangan_makan,
            'bonus_kinerja' => $bonus_kinerja,
            'pph23' => $pph23,
            'bpjs' => $bpjs,
            'pinjaman' => $pinjaman,
            'pot_absensi' => $pot_absensi,
            'thp' => $thp,
            'keterangan_pembayaran' => $keterangan_pembayaran,
         );

         $this->db->insert('payroll', $data);

         $this->session->set_flashdata('success', 'Berhasil membuat slip gaji karyawan');
         redirect('others/payslip');
      } else {
         $this->session->set_flashdata('error', 'Data potongan tidak ditemukan');
         redirect('others/payslip');
      }
   }

   public function exportToPDF($id)
   {
      // Fetch data from the database, similar to your 'view' function
      $data['view'] = $this->db->query("SELECT * FROM payroll
        LEFT JOIN karyawan ON karyawan.id_karyawan = payroll.id_karyawan
        LEFT JOIN jabatan ON jabatan.id_jabatan = payroll.id_jabatan
        LEFT JOIN departement ON departement.id_departement = payroll.id_departement
        WHERE payroll.id_pembayaran='$id'")->result();

      // Load the PDF view
      $pdf_html = $this->load->view('admin/cetak_gaji', $data, true);

      // Create DOMPDF options
      $options = new Options();
      $options->set('defaultFont', 'Helvetica'); // Set default font (optional)

      // Create a DOMPDF instance
      $pdf = new Dompdf($options);

      // Load HTML content for the PDF
      $pdf->loadHtml($pdf_html);

      // Set paper size and orientation (optional)
      $pdf->setPaper('A4', 'portrait');

      // Render the PDF (optional)
      $pdf->render();

      // Set the filename for the PDF file
      $filename = 'slip_gaji.pdf';

      // Stream the PDF to the browser for download
      $pdf->stream($filename, array('Attachment' => 0));
   }

   public function proses_multiple()
   {
      // Ambil data dari form
      $id_pembayaran = $this->input->post('id_pembayaran');
      $user_id = $this->input->post('user_id');
      $id_karyawan = $this->input->post('id_karyawan');
      $id_potongan = $this->input->post('id_potongan');
      $id_jabatan = $this->input->post('id_jabatan');
      $id_departement = $this->input->post('id_departement');
      $gaji_pokok = $this->input->post('gaji_pokok');
      $tunjangan_aktivitas = $this->input->post('tunjangan_aktivitas');
      $qty = $this->input->post('qty');
      $tunjangan_jabatan = $this->input->post('tunjangan_jabatan');
      $tunjangan_makan = $this->input->post('tunjangan_makan');
      $bonus_kinerja = $this->input->post('bonus_kinerja');
      $pph23 = $this->input->post('pph23');
      $pph21 = $this->input->post('pph21');
      $bpjs = $this->input->post('bpjs');
      $pinjaman = $this->input->post('pinjaman');

      // Tambahkan tgl_pembayaran dengan tanggal hari ini
      $curdate = date('Y-m-d'); // Format tanggal MySQL (YYYY-MM-DD)

      // Inisialisasi array untuk mengumpulkan data yang akan disimpan
      $data_to_insert = array();

      // Loop melalui setiap baris data
      $data_missing = false; // Flag untuk menandakan apakah ada data yang belum ada di database
      for ($i = 0; $i < count($id_pembayaran); $i++) {
         $user_id_value = $user_id[$i];
         $tanggal_pembayaran = $curdate;
         $tanggal_penggajian = $curdate;

         // Lakukan pengecekan di database apakah data dengan user_id, tanggal_pembayaran, dan bulan-tahun yang sama sudah ada
         $existingData = $this->db->get_where('payroll', array(
            'user_id' => $user_id_value,
            'MONTH(tanggal_pembayaran)' => date('m', strtotime($tanggal_pembayaran)),
            'YEAR(tanggal_pembayaran)' => date('Y', strtotime($tanggal_pembayaran))
         ))->row();

         if (!$existingData) {
            // Jika data belum ada, tambahkan data ke array data_to_insert
            $data_to_insert[] = array(
               'id_pembayaran' => $id_pembayaran[$i],
               'user_id' => $user_id_value,
               'id_karyawan' => $id_karyawan[$i],
               'id_potongan' => $id_potongan[$i],
               'id_jabatan' => $id_jabatan[$i],
               'id_departement' => $id_departement[$i],
               'gaji_pokok' => $gaji_pokok[$i],
               'tunjangan_aktivitas' => $tunjangan_aktivitas[$i],
               'qty' => $qty[$i],
               'tunjangan_jabatan' => $tunjangan_jabatan[$i],
               'tunjangan_makan' => $tunjangan_makan[$i],
               'bonus_kinerja' => $bonus_kinerja[$i],
               'pph23' => $pph23[$i],
               'pph21' => $pph21[$i],
               'bpjs' => $bpjs[$i],
               'pinjaman' => $pinjaman[$i],
               'tanggal_pembayaran' => $tanggal_pembayaran,
               'tanggal_penggajian' => $tanggal_penggajian,
            );
            $data_missing = true; // Set flag bahwa ada data yang belum ada di database
         }
      }

      // Simpan data ke dalam database jika ada data yang belum ada
      if ($data_missing) {
         $this->db->insert_batch('payroll', $data_to_insert);
      }

      // Set flash data berdasarkan apakah ada data yang belum ada
      if ($data_missing) {
         $this->session->set_flashdata('success', 'Data payroll berhasil ditambah');
      } else {
         $this->session->set_flashdata('warning', 'Data gaji karyawan pada bulan ini sudah ada.');
      }

      // Redirect sesuai kebutuhan Anda
      redirect('others/payslip'); // Ganti URL redirect sesuai kebutuhan Anda
   }

   public function proses_ubah()
   {
      $id_pembayaran = $this->input->post('id_pembayaran');
      $tanggal_pembayaran = $this->input->post('tanggal_pembayaran');
      $tanggal_penggajian = $this->input->post('tanggal_penggajian');
      $gaji_pokok = $this->input->post('gaji_pokok');
      $upah_lembur = $this->input->post('upah_lembur');
      $tunjangan_aktivitas = $this->input->post('tunjangan_aktivitas');
      $tunjangan_jabatan = $this->input->post('tunjangan_jabatan');
      $tunjangan_makan = $this->input->post('tunjangan_makan');
      $bonus_kinerja = $this->input->post('bonus_kinerja');
      $pph21 = $this->input->post('pph21');
      $bpjs = $this->input->post('bpjs');
      $pinjaman = $this->input->post('pinjaman');
      $pot_absensi = $this->input->post('pot_absensi');

      // Setel nilai-nilai menjadi null jika mereka kosong

      if (empty($gaji_pokok)) {
         $gaji_pokok = null;
      }
      if (empty($upah_lembur)) {
         $upah_lembur = null;
      }
      if (empty($tunjangan_aktivitas)) {
         $tunjangan_aktivitas = null;
      }
      if (empty($tunjangan_jabatan)) {
         $tunjangan_jabatan = null;
      }
      if (empty($tunjangan_makan)) {
         $tunjangan_makan = null;
      }
      if (empty($bonus_kinerja)) {
         $bonus_kinerja = null;
      }
      if (empty($pph21)) {
         $pph21 = null;
      }
      if (empty($bpjs)) {
         $bpjs = null;
      }
      if (empty($pinjaman)) {
         $pinjaman = null;
      }
      if (empty($pot_absensi)) {
         $pot_absensi = null;
      }

      $data = array(
         'tanggal_pembayaran' => $tanggal_pembayaran,
         'tanggal_penggajian' => $tanggal_penggajian,
         'gaji_pokok' => $gaji_pokok,
         'upah_lembur' => $upah_lembur,
         'tunjangan_aktivitas' => $tunjangan_aktivitas,
         'tunjangan_jabatan' => $tunjangan_jabatan,
         'tunjangan_makan' => $tunjangan_makan,
         'bonus_kinerja' => $bonus_kinerja,
         'pph21' => $pph21,
         'bpjs' => $bpjs,
         'pinjaman' => $pinjaman,
         'pot_absensi' => $pot_absensi,
      );

      $where = array(
         'id_pembayaran' => $id_pembayaran
      );

      $this->model->update('payroll', $data, $where);

      $this->session->set_flashdata('success', 'Data payslip berhasil diubah');
      redirect('others/payslip');
   }
}
