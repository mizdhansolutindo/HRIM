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

      if ($this->session->userdata('role') != '1') {
         redirect('login');
      }
      date_default_timezone_set('asia/jakarta');
   }

   public function index()
   {
      $data['title'] = "Riwayat Absensi";

      $data['absen'] = $this->db->query("SELECT * FROM absen
        INNER JOIN karyawan ON karyawan.user_id = absen.user_id
        ORDER BY absen.tanggal DESC")->result();

      $data['add'] = $this->db->query("
            SELECT * FROM karyawan
            LEFT JOIN jabatan ON jabatan.id_jabatan = karyawan.id_jabatan
            LEFT JOIN departement ON departement.id_departement = karyawan.id_departement
            GROUP BY karyawan.user_id
            ORDER BY karyawan.user_id DESC")->result();

      $this->load->view('layout/admin/header', $data);
      $this->load->view('admin/riwayat_absen', $data);
      $this->load->view('layout/admin/footer');
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
            $shift = $rows[$i][1];
            $status = $rows[$i][2];
            $jam_masuk_reguler = $rows[$i][3];
            $jam_pulang_reguler = $rows[$i][4];
            $jam_masuk_lembur = $rows[$i][5];
            $jam_pulang_lembur = $rows[$i][6];
            $aktivitas = $rows[$i][7];
            $tanggal = $rows[$i][8];

            // Validasi data sebelum dimasukkan ke dalam database
            if (!empty($user_id)) {
               $data = array(
                  'user_id' => $user_id,
                  'shift' => $shift,
                  'status' => $status,
                  'jam_masuk_reguler' => $jam_masuk_reguler,
                  'jam_pulang_reguler' => $jam_pulang_reguler,
                  'jam_masuk_lembur' => $jam_masuk_lembur,
                  'jam_pulang_lembur' => $jam_pulang_lembur,
                  'aktivitas' => $aktivitas,
                  'tanggal' => $tanggal,
               );
               $this->db->insert('absen', $data);
            } else {
            }
         }

         // Setelah selesai, arahkan pengguna ke halaman yang sesuai
         $this->session->set_flashdata('success', 'Data absensi berhasil di upload');
         redirect('admin/absensi');
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
      $shift = $this->input->post('shift');
      $status = $this->input->post('status');
      $jam_masuk_reguler = $this->input->post('jam_masuk_reguler');
      $jam_pulang_reguler = $this->input->post('jam_pulang_reguler');
      $jam_masuk_lembur = $this->input->post('jam_masuk_lembur');
      $jam_pulang_lembur = $this->input->post('jam_pulang_lembur');
      $aktivitas = $this->input->post('aktivitas');
      $tanggal = $this->input->post('tanggal');

      // Tambahkan tgl_pembayaran dengan tanggal hari ini
      $time = date('Y-m-d');

      // Inisialisasi array untuk mengumpulkan data yang akan disimpan
      $data_to_insert = array();

      // Loop melalui setiap baris data
      $data_missing = false; // Flag untuk menandakan apakah ada data yang belum ada di database
      for ($i = 0; $i < count($user_id); $i++) {
         $user_id_value = $user_id[$i];

         // Periksa apakah data sudah ada di database untuk user_id dan tanggal tertentu
         $this->db->where('user_id', $user_id_value);
         $this->db->where('tanggal', $time);
         $query = $this->db->get('absen');

         // Jika sudah ada data, skip inputan ini
         if ($query->num_rows() >= 1) {
            continue;
         }

         // Tambahkan data ke array data_to_insert
         $data_to_insert[] = array(
            'user_id' => $user_id_value,
            'shift' => $shift[$i],
            'status' => $status[$i],
            'jam_masuk_reguler' => $jam_masuk_reguler[$i],
            'jam_pulang_reguler' => $jam_pulang_reguler[$i],
            'jam_masuk_lembur' => $jam_masuk_lembur[$i],
            'jam_pulang_lembur' => $jam_pulang_lembur[$i],
            'aktivitas' => $aktivitas[$i],
            'tanggal' => $tanggal[$i],
         );
         $data_missing = true; // Set flag bahwa ada data yang belum ada di database
      }

      // Simpan data ke dalam database jika ada data yang belum ada
      if ($data_missing) {
         $this->db->insert_batch('absen', $data_to_insert);
      } else {
         $this->session->set_flashdata('warning', 'Sudah melakukan absen pada hari ini.');
      }

      // Set flash data berdasarkan apakah ada data yang belum ada
      if ($data_missing) {
         $this->session->set_flashdata('success', 'Data absensi berhasil ditambah');
      }

      // Redirect sesuai kebutuhan Anda
      redirect('admin/absensi'); // Ganti URL redirect sesuai kebutuhan Anda
   }

   public function proses_ubah()
   {
      $id_absen = $this->input->post('id_absen');
      $shift = $this->input->post('shift');
      $status = $this->input->post('status');
      $jam_masuk_reguler = $this->input->post('jam_masuk_reguler');
      $jam_pulang_reguler = $this->input->post('jam_pulang_reguler');
      $jam_masuk_lembur = $this->input->post('jam_masuk_lembur');
      $jam_pulang_lembur = $this->input->post('jam_pulang_lembur');
      $aktivitas = $this->input->post('aktivitas');
      $tanggal = $this->input->post('tanggal');

      $data = array(
         'shift' => $shift,
         'status' => $status,
         'jam_masuk_reguler' => $jam_masuk_reguler,
         'jam_pulang_reguler' => $jam_pulang_reguler,
         'jam_masuk_lembur' => $jam_masuk_lembur,
         'jam_pulang_lembur' => $jam_pulang_lembur,
         'aktivitas' => $aktivitas,
         'tanggal' => $tanggal,
      );

      $where = array(
         'id_absen' => $id_absen
      );

      $this->model->update('absen', $data, $where);

      $this->session->set_flashdata('success', 'Data absensi berhasil diubah');
      redirect('admin/absensi');
   }

   public function delete($id)
   {
      $where = array('id_absen' => $id);
      $this->model->delete($where, 'absen');

      $this->session->set_flashdata('success', 'Data absensi berhasil dihapus');
      redirect('admin/absensi');
   }
}
