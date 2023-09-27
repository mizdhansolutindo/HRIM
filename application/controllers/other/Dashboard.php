<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();

      $this->load->model('model');

      // Ambil peran pengguna dari sesi
      $role = $this->session->userdata('role');

      // Izinkan akses hanya untuk peran dengan ID 2, 4, dan 6
      if ($role != '2' && $role != '4' && $role != '6') {
         redirect('login');
      }
   }


   public function index()
   {
      $data['title'] = 'Dashboard';

      $id = $this->session->userdata('user_id');

      // Query untuk mengambil nama_karyawan berdasarkan user_id
      $query = $this->db->get_where('karyawan', array('user_id' => $id));

      // Mengecek apakah data ditemukan
      if ($query->num_rows() > 0) {
         // Mengambil hasil query
         $result = $query->row();
         $data['nama_karyawan'] = $result->nama_karyawan;
      } else {
         // Jika data tidak ditemukan, atur nama_karyawan ke kosong atau sesuai kebutuhan
         $data['nama_karyawan'] = '';
      }

      $permintaan = $this->db->query("SELECT * FROM permintaan");
      $data['permintaan'] = $permintaan->num_rows();

      // Mendapatkan tanggal hari ini dalam format MySQL
      $currentDate = date('Y-m-d');

      // Query untuk menghitung jumlah data user_id dengan keterangan masuk pada hari ini
      $query = $this->db->select('COUNT(DISTINCT user_id) AS jumlah_masuk')
         ->from('absen')
         ->where('keterangan', 'masuk')
         ->where('DATE(waktu)', $currentDate)
         ->get();

      $result = $query->row();

      // Ambil jumlah data user_id yang sudah melakukan absen masuk pada hari ini
      $data['jumlah_masuk'] = $result->jumlah_masuk;

      // Mendapatkan bulan dan tahun saat ini
      $currentMonth = date('m');
      $currentYear = date('Y');

      // Query untuk menghitung jumlah jam kerja per karyawan dalam bulan ini
      $query = $this->db->select('karyawan.user_id, karyawan.id_jabatan, jabatan.target, karyawan.nama_karyawan')
         ->from('karyawan')
         ->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan')
         ->get();

      $karyawanList = $query->result();

      // Menginisialisasi variabel untuk menyimpan jumlah karyawan yang mencapai dan tidak mencapai target
      $karyawanMencapaiTarget = 0;
      $karyawanTidakMencapaiTarget = 0;

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

         // Menghitung persentase kinerja
         $persentase_kinerja = ($total_jam_kerja / 180) * 100;
         $karyawan->persentase_kinerja = round($persentase_kinerja, 2);

         // Menentukan apakah karyawan mencapai target atau tidak
         if ($persentase_kinerja >= $karyawan->target) {
            $karyawanMencapaiTarget++;
         } else {
            $karyawanTidakMencapaiTarget++;
         }
      }

      // Menghitung persentase karyawan yang mencapai target dan yang tidak mencapai target
      $totalKaryawan = count($karyawanList);
      $persentaseKaryawanMencapaiTarget = ($karyawanMencapaiTarget / $totalKaryawan) * 100;
      $persentaseKaryawanTidakMencapaiTarget = ($karyawanTidakMencapaiTarget / $totalKaryawan) * 100;

      // Menyimpan persentase karyawan ke dalam data
      $data['persentase_karyawan_mencapai_target'] = round($persentaseKaryawanMencapaiTarget, 2);
      $data['persentase_karyawan_tidak_mencapai_target'] = round($persentaseKaryawanTidakMencapaiTarget, 2);

      $this->load->view('layout/other/header', $data);
      $this->load->view('other/dashboard', $data);
      $this->load->view('layout/other/footer');
   }


   public function getPayrollData()
   {
      // Array untuk menyimpan data gaji per bulan
      $monthlyData = array_fill(1, 12, 0);

      $currentYear = date('Y');
      $payrollData = $this->db
         ->select('MONTH(tanggal_pembayaran) as month, SUM(thp) as total_salary')
         ->where('YEAR(tanggal_pembayaran)', $currentYear)
         ->group_by('MONTH(tanggal_pembayaran)')
         ->get('payroll')
         ->result();

      // Mengisi data gaji berdasarkan bulan
      foreach ($payrollData as $data) {
         $month = (int) $data->month;
         $monthlyData[$month] = (float) $data->total_salary;
      }

      // Membuat array untuk label bulan
      $monthLabels = array(
         'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
         'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
      );

      $chartData = [
         'labels' => $monthLabels,
         'values' => array_values($monthlyData), // Menggunakan array_values untuk mengambil nilai-nilai dari array asosiatif
      ];

      $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode($chartData));
   }
}