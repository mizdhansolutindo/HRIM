<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class Absensi extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();

      $this->load->model('model');
      $this->load->helper('maps');

      if ($this->session->userdata('role') != '2') {
         redirect('login');
      }
      date_default_timezone_set('asia/jakarta');
   }

   public function index()
   {
      $data['title'] = "Riwayat Absensi";

      $data['absen'] = $this->db->query("SELECT * FROM absen
        INNER JOIN karyawan ON karyawan.user_id = absen.user_id
        ORDER BY absen.waktu DESC")->result();

      $data['add'] = $this->db->query("
            SELECT * FROM karyawan
            LEFT JOIN jabatan ON jabatan.id_jabatan = karyawan.id_jabatan
            GROUP BY karyawan.user_id
            ORDER BY karyawan.user_id DESC")->result();

      $this->load->view('layout/other/header', $data);
      $this->load->view('other/riwayat_absen', $data);
      $this->load->view('layout/other/footer');
   }

   public function upload()
   {
      $config['upload_path'] = './excel_upload/'; // Sesuaikan dengan lokasi penyimpanan file
      $config['allowed_types'] = 'xls|xlsx';

      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('excel_file')) {
         // Gagal unggah file
         $error = array('error' => $this->upload->display_errors());
         $this->load->view('upload_form', $error);
      } else {
         // Sukses unggah file
         $file_data = $this->upload->data();
         $file_path = './excel_upload/' . $file_data['file_name'];

         // Proses file Excel
         $spreadsheet = IOFactory::load($file_path);
         $worksheet = $spreadsheet->getActiveSheet();
         $rows = $worksheet->toArray();

         // Mulai dari indeks 1 untuk menghindari baris judul (header)
         for ($i = 1; $i < count($rows); $i++) {
            $user_id = $rows[$i][0];
            $lokasi_kerja = $rows[$i][1];
            $shift_line = $rows[$i][2];
            $aktivitas = $rows[$i][3];
            $kondisi_kesehatan = $rows[$i][4];
            $waktu = $rows[$i][5];
            $keterangan = $rows[$i][6];
            $estimated = $rows[$i][7];
            $kinerja = $rows[$i][8];

            // Validasi data sebelum dimasukkan ke dalam database
            if (!empty($user_id)) {
               $data = array(
                  'user_id' => $user_id,
                  'lokasi_kerja' => $lokasi_kerja,
                  'shift_line' => $shift_line,
                  'aktivitas' => $aktivitas,
                  'kondisi_kesehatan' => $kondisi_kesehatan,
                  'waktu' => $waktu,
                  'keterangan' => $keterangan,
                  'estimated' => $estimated,
                  'kinerja' => $kinerja,
               );
               $this->db->insert('absen', $data);
            } else {
            }
         }

         // Setelah selesai, arahkan pengguna ke halaman yang sesuai
         $this->session->set_flashdata('success', 'Data absensi berhasil diunggah');
         redirect('other/absensi');
      }
   }

   public function getJabatanDepartemen($userId)
   {
      // Sesuaikan dengan struktur tabel dan query yang Anda gunakan
      $query = $this->db->select('jabatan.nama_jabatan, departement.nama_departement')
         ->from('karyawan')
         ->join('jabatan', 'karyawan.id_jabatan = jabatan.id_jabatan', 'left')
         ->join('departement', 'karyawan.id_departement = departement.id_departement', 'left')
         ->where('karyawan.user_id', $userId)
         ->get();

      $data = $query->row_array();

      // Mengirimkannya sebagai respons dalam format JSON
      echo json_encode($data);
   }

   public function proses_multiple()
   {
      // Ambil data dari form
      $user_id = $this->input->post('user_id');
      $waktu = $this->input->post('waktu');
      $lokasi_kerja = $this->input->post('lokasi_kerja');
      $shift_line = $this->input->post('shift_line');
      $aktivitas = $this->input->post('aktivitas');
      $keterangan = $this->input->post('keterangan');
      $kondisi_kesehatan = $this->input->post('kondisi_kesehatan');
      $kinerja = $this->input->post('kinerja');
      $catatan = $this->input->post('catatan');
      $jam_masuk_alternatif = $this->input->post('jam_masuk_alternatif');
      $jam_pulang_alternatif = $this->input->post('jam_pulang_alternatif');

      // Tambahkan tgl_pembayaran dengan tanggal hari ini
      $curdatetime = date('Y-m-d H:i:s'); // Format tanggal dan waktu MySQL (YYYY-MM-DD HH:MM:SS)

      // Inisialisasi array untuk mengumpulkan data yang akan disimpan
      $data_to_insert = array();

      // Loop melalui setiap baris data
      $data_missing = false; // Flag untuk menandakan apakah ada data yang belum ada di database
      for ($i = 0; $i < count($user_id); $i++) {
         $user_id_value = $user_id[$i];
         $time = $curdatetime;

         // Menghitung jumlah inputan 'masuk' atau 'pulang' untuk tanggal dan user_id tertentu
         $this->db->where('user_id', $user_id_value);
         $this->db->where('DATE(waktu)', date('Y-m-d', strtotime($time)));
         $this->db->where_in('keterangan', array('masuk', 'pulang')); // Validasi berdasarkan keterangan
         $existingDataCount = $this->db->count_all_results('absen');

         // Jika sudah ada dua inputan 'masuk' atau 'pulang' untuk tanggal dan user_id tertentu, skip inputan ini
         if ($existingDataCount >= 2) {
            continue;
         }

         // Tambahkan data ke array data_to_insert
         $data_to_insert[] = array(
            'user_id' => $user_id_value,
            'lokasi_kerja' => $lokasi_kerja[$i],
            'shift_line' => $shift_line[$i],
            'aktivitas' => $aktivitas[$i],
            'kondisi_kesehatan' => $kondisi_kesehatan[$i],
            'keterangan' => $keterangan[$i],
            'kinerja' => $kinerja[$i],
            'waktu' => $waktu[$i],
            'catatan' => $catatan[$i],
            'jam_masuk_alternatif' => $jam_masuk_alternatif[$i],
            'jam_pulang_alternatif' => $jam_pulang_alternatif[$i],
            'estimated' => $waktu[$i],
         );
         $data_missing = true; // Set flag bahwa ada data yang belum ada di database
      }

      // Simpan data ke dalam database jika ada data yang belum ada
      if ($data_missing) {
         $this->db->insert_batch('absen', $data_to_insert);
      } else {
         $this->session->set_flashdata('warning', 'Data absensi sudah ada.');
      }

      // Set flash data berdasarkan apakah ada data yang belum ada
      if ($data_missing) {
         $this->session->set_flashdata('success', 'Data absensi berhasil ditambah');
      }

      // Redirect sesuai kebutuhan Anda
      redirect('other/absensi'); // Ganti URL redirect sesuai kebutuhan Anda
   }

   public function proses_ubah()
   {
      $id_absen = $this->input->post('id_absen');
      $waktu = $this->input->post('waktu');
      $estimated = $this->input->post('estimated');
      $lokasi_kerja = $this->input->post('lokasi_kerja');
      $shift_line = $this->input->post('shift_line');
      $jam_masuk_alternatif = $this->input->post('jam_masuk_alternatif');
      $jam_pulang_alternatif = $this->input->post('jam_pulang_alternatif');
      $kondisi_kesehatan = $this->input->post('kondisi_kesehatan');
      $keterangan = $this->input->post('keterangan');
      $catatan = $this->input->post('catatan');

      $data = array(
         'waktu' => $waktu,
         'estimated' => $estimated,
         'lokasi_kerja' => $lokasi_kerja,
         'shift_line' => $shift_line,
         'jam_masuk_alternatif' => $jam_masuk_alternatif,
         'jam_pulang_alternatif' => $jam_pulang_alternatif,
         'kondisi_kesehatan' => $kondisi_kesehatan,
         'keterangan' => $keterangan,
         'catatan' => $catatan,
      );

      $where = array(
         'id_absen' => $id_absen
      );

      $this->model->update('absen', $data, $where);

      $this->session->set_flashdata('success', 'Data absensi berhasil diubah');
      redirect('other/absensi');
   }

   public function delete($id)
   {
      $where = array('id_absen' => $id);
      $this->model->delete($where, 'absen');

      $this->session->set_flashdata('success', 'Data absensi berhasil dihapus');
      redirect('other/absensi');
   }
}
