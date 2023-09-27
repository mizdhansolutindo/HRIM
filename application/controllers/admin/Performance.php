<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Performance extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();

      $this->load->model('model');

      if ($this->session->userdata('role') != '1') {
         redirect('login');
      }
   }


   // public function index()
   // {
   //    $data['title'] = "Performance";


   //    // Mendapatkan bulan dan tahun saat ini
   //    $currentMonth = date('m');
   //    $currentYear = date('Y');

   //    // Query untuk menghitung jumlah jam kerja per karyawan dalam bulan ini
   //    $query = $this->db->select('karyawan.user_id, karyawan.id_jabatan, jabatan.target, karyawan.nama_karyawan, SUM(TIMESTAMPDIFF(SECOND, absen.waktu, (SELECT MAX(waktu) FROM absen WHERE user_id = karyawan.user_id))) AS total_jam_kerja')
   //       ->from('karyawan')
   //       ->join('absen', 'absen.user_id = karyawan.user_id',)
   //       ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan')
   //       ->where('MONTH(absen.waktu)', $currentMonth)
   //       ->where('YEAR(absen.waktu)', $currentYear)
   //       ->group_by('karyawan.user_id, karyawan.nama_karyawan')
   //       ->get();

   //    $jamKerjaKaryawan = $query->result();

   //    // Query untuk mengambil target kinerja per jabatan
   //    $query = $this->db->select('jabatan.id_jabatan, jabatan.target AS target_kinerja')
   //       ->from('jabatan')
   //       ->get();

   //    $targetKinerja = $query->result();

   //    // Hitung persentase kinerja per karyawan
   //    foreach ($jamKerjaKaryawan as &$karyawan) {
   //       foreach ($targetKinerja as $jabatan) {
   //          if ($karyawan->id_jabatan === $karyawan->id_jabatan) {
   //             $karyawan->persentase_kinerja = ($karyawan->total_jam_kerja / ($karyawan->target * 3600)) * 100;
   //             break;
   //          }
   //       }
   //    }

   //    // Load view untuk menampilkan data
   //    $data['jam_kerja_karyawan'] = $jamKerjaKaryawan;

   //    // Load view untuk menampilkan data
   //    $this->load->view('layout/admin/header', $data);
   //    $this->load->view('admin/performance', $data);
   //    $this->load->view('layout/admin/footer');
   // }

   // public function index()
   // {
   //    $data['title'] = "Performance";

   //    // Mendapatkan bulan dan tahun saat ini
   //    $currentMonth = date('m');
   //    $currentYear = date('Y');

   //    // Query untuk menghitung jumlah jam kerja per karyawan dalam bulan ini
   //    $query = $this->db->select('karyawan.user_id, karyawan.id_jabatan, jabatan.target, karyawan.nama_karyawan')
   //       ->from('karyawan')
   //       ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan')
   //       ->get();

   //    $karyawanList = $query->result();

   //    // Menginisialisasi array untuk menyimpan data jam kerja per karyawan
   //    $jamKerjaKaryawan = [];

   //    foreach ($karyawanList as $karyawan) {
   //       $total_jam_kerja = 0;

   //       // Query untuk mengambil data absen per bulan per karyawan
   //       $query = $this->db->select('DATE(absen.waktu) AS tanggal, absen.keterangan')
   //          ->from('absen')
   //          ->where('MONTH(absen.waktu)', $currentMonth)
   //          ->where('YEAR(absen.waktu)', $currentYear)
   //          ->where('absen.user_id', $karyawan->user_id)
   //          ->get();

   //       $absenData = $query->result();

   //       foreach ($absenData as $absen) {
   //          if ($absen->keterangan == 'masuk') {
   //             $total_jam_kerja += 6; // Menghitung 6 jam per "masuk"
   //          }
   //       }

   //       $karyawan->total_jam_kerja = $total_jam_kerja;
   //       $karyawan->persentase_kinerja = ($total_jam_kerja / ($karyawan->target * 6 * 30)) * 100;

   //       $jamKerjaKaryawan[] = $karyawan;
   //    }

   //    // Load view untuk menampilkan data
   //    $data['jam_kerja_karyawan'] = $jamKerjaKaryawan;

   //    // Load view untuk menampilkan data
   //    $this->load->view('layout/admin/header', $data);
   //    $this->load->view('admin/performance', $data);
   //    $this->load->view('layout/admin/footer');
   // }

   public function index()
   {
      $data['title'] = "Performance";

      // Mendapatkan bulan dan tahun saat ini
      $currentMonth = date('m');
      $currentYear = date('Y');

      // Query untuk menghitung jumlah jam kerja per karyawan dalam bulan ini
      $query = $this->db->select('karyawan.user_id, karyawan.id_jabatan, jabatan.target, karyawan.nama_karyawan')
         ->from('karyawan')
         ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan')
         ->get();

      $karyawanList = $query->result();

      // Menginisialisasi array untuk menyimpan data jam kerja per karyawan
      $jamKerjaKaryawan = [];

      foreach ($karyawanList as $karyawan) {
         $total_jam_kerja = 0;

         // Query untuk mengambil data absen per bulan per karyawan
         $query = $this->db->select('DATE(absen.waktu) AS tanggal, absen.keterangan')
            ->from('absen')
            ->where('MONTH(absen.waktu)', $currentMonth)
            ->where('YEAR(absen.waktu)', $currentYear)
            ->where('absen.user_id', $karyawan->user_id)
            ->get();

         $absenData = $query->result();

         foreach ($absenData as $absen) {
            if ($absen->keterangan == 'pulang') {
               $total_jam_kerja += 6; // Menghitung 6 jam per "masuk"
            }
         }

         // Menyesuaikan total jam kerja agar tidak melebihi 180 jam (jika total lebih dari 180)
         $total_jam_kerja = min($total_jam_kerja, 180);

         $karyawan->total_jam_kerja = $total_jam_kerja;

         // Menghitung persentase kinerja
         $persentase_kinerja = ($total_jam_kerja / 180) * 100;
         $karyawan->persentase_kinerja = round($persentase_kinerja, 2);

         $jamKerjaKaryawan[] = $karyawan;
      }

      // Load view untuk menampilkan data
      $data['jam_kerja_karyawan'] = $jamKerjaKaryawan;

      // Load view untuk menampilkan data
      $this->load->view('layout/admin/header', $data);
      $this->load->view('admin/performance', $data);
      $this->load->view('layout/admin/footer');
   }
}
