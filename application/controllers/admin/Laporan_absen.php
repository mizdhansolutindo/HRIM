<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Laporan_absen extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();

      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');
      $this->load->model(array('Model'));

      if ($this->session->userdata('role') != '1') {

         redirect('login');
      }
      date_default_timezone_set('asia/jakarta');
   }

   public function index()
   {
      $data['title'] = "Laporan Absen";

      $data['employee'] = $this->model->get('karyawan')->result();
      $data['jabatan'] = $this->model->get('jabatan')->result();
      $data['departement'] = $this->model->get('departement')->result();

      // Buat query untuk menghitung total jam_masuk_reguler, jam_pulang_reguler, jam_masuk_lembur, jam_pulang_lembur, total aktivitas, dan total sakit
      $this->db->select('
        karyawan.*,
        departement.nama_departement,
        jabatan.nama_jabatan,
        SUM(TIME_TO_SEC(TIMEDIFF(absen.jam_pulang_reguler, absen.jam_masuk_reguler))) as total_jam_kerja_reguler,
        SUM(TIME_TO_SEC(TIMEDIFF(absen.jam_pulang_lembur, absen.jam_masuk_lembur))) as total_jam_kerja_lembur,
        SUM(absen.aktivitas) as total_aktivitas,
        (SELECT COUNT(*) FROM absen AS sub_absen WHERE sub_absen.user_id = absen.user_id AND sub_absen.status = "Sakit") as total_sakit,
        (SELECT COUNT(*) FROM absen AS sub_absen WHERE sub_absen.user_id = absen.user_id AND sub_absen.status = "Izin") as total_izin,
        (SELECT COUNT(*) FROM absen AS sub_absen WHERE sub_absen.user_id = absen.user_id AND sub_absen.status = "Alpha") as total_alpha,
        (SELECT COUNT(*) FROM absen AS sub_absen WHERE sub_absen.user_id = absen.user_id AND sub_absen.status = "Cuti") as total_cuti
    ');
      $this->db->from('absen');
      $this->db->join('karyawan', 'karyawan.user_id = absen.user_id');
      $this->db->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan');
      $this->db->join('departement', 'departement.id_departement = karyawan.id_departement');
      $this->db->where('MONTH(absen.tanggal)', date('m')); // Filter berdasarkan bulan saat ini
      $this->db->group_by('absen.user_id'); // Mengelompokkan berdasarkan user_id karyawan

      $query = $this->db->get();
      $data['absen'] = $query->result();

      // Convert total seconds to hours for both reguler and lembur
      foreach ($data['absen'] as $row) {
         $total_jam_kerja_reguler_in_hours = $row->total_jam_kerja_reguler / 3600;
         $total_jam_kerja_lembur_in_hours = $row->total_jam_kerja_lembur / 3600;
         $row->total_jam_kerja_reguler = $total_jam_kerja_reguler_in_hours;
         $row->total_jam_kerja_lembur = $total_jam_kerja_lembur_in_hours;
      }

      $this->load->view('layout/admin/header', $data);
      $this->load->view('admin/list_laporan_absen', $data);
      $this->load->view('layout/admin/footer');
   }

   // public function filter()
   // {
   //    $data['title'] = "Laporan Absen";

   //    $data['employee'] = $this->model->get('karyawan')->result();
   //    $data['jabatan'] = $this->model->get('jabatan')->result();
   //    $data['departement'] = $this->model->get('departement')->result();

   //    $bulan = $this->input->post('bulan');
   //    $id_departement = $this->input->post('id_departement');
   //    $id_jabatan = $this->input->post('id_jabatan');

   //    $this->db->select('*');
   //    $this->db->from('absen');
   //    $this->db->join('karyawan', 'karyawan.user_id = absen.user_id');

   //    // Tambahkan kondisi WHERE untuk bulan jika tidak kosong
   //    if (!empty($bulan)) {
   //       $this->db->where('MONTH(tanggal)', $bulan);
   //    }

   //    // Tambahkan kondisi WHERE untuk departemen jika tidak kosong
   //    if (!empty($id_departement)) {
   //       $this->db->where('id_departement', $id_departement);
   //    }

   //    // Tambahkan kondisi WHERE untuk jabatan jika tidak kosong
   //    if (!empty($id_jabatan)) {
   //       $this->db->where('id_jabatan', $id_jabatan);
   //    }

   //    $query = $this->db->get();
   //    $data['absen'] = $query->result();

   //    // Muat view laporan absen dengan data yang sudah difilter
   //    $this->load->view('layout/admin/header', $data);
   //    $this->load->view('admin/result_laporan_absen', $data);
   //    $this->load->view('layout/admin/footer');
   // }

   public function filter()
   {
      $data['title'] = "Laporan Absen";

      $data['employee'] = $this->model->get('karyawan')->result();
      $data['jabatan'] = $this->model->get('jabatan')->result();
      $data['departement'] = $this->model->get('departement')->result();

      $bulan = $this->input->post('bulan');
      $id_departement = $this->input->post('id_departement');
      $id_jabatan = $this->input->post('id_jabatan');

      $this->db->select('
        karyawan.*,
        departement.nama_departement,
        jabatan.nama_jabatan,
        SUM(TIME_TO_SEC(TIMEDIFF(absen.jam_pulang_reguler, absen.jam_masuk_reguler))) as total_jam_kerja_reguler,
        SUM(TIME_TO_SEC(TIMEDIFF(absen.jam_pulang_lembur, absen.jam_masuk_lembur))) as total_jam_kerja_lembur,
        SUM(absen.aktivitas) as total_aktivitas,
        (SELECT COUNT(*) FROM absen AS sub_absen WHERE sub_absen.user_id = absen.user_id AND sub_absen.status = "Sakit") as total_sakit,
        (SELECT COUNT(*) FROM absen AS sub_absen WHERE sub_absen.user_id = absen.user_id AND sub_absen.status = "Izin") as total_izin,
        (SELECT COUNT(*) FROM absen AS sub_absen WHERE sub_absen.user_id = absen.user_id AND sub_absen.status = "Alpha") as total_alpha,
        (SELECT COUNT(*) FROM absen AS sub_absen WHERE sub_absen.user_id = absen.user_id AND sub_absen.status = "Cuti") as total_cuti
    ');
      $this->db->from('absen');
      $this->db->join('karyawan', 'karyawan.user_id = absen.user_id');
      $this->db->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan');
      $this->db->join('departement', 'departement.id_departement = karyawan.id_departement');
      $this->db->where('MONTH(absen.tanggal)', date('m')); // Filter berdasarkan bulan saat ini

      // Tambahkan kondisi WHERE untuk bulan jika tidak kosong
      if (!empty($bulan)) {
         $this->db->where('MONTH(absen.tanggal)', $bulan);
      }

      // Tambahkan kondisi WHERE untuk departemen jika tidak kosong
      if (!empty($id_departement)) {
         $this->db->where('karyawan.id_departement', $id_departement);
      }

      // Tambahkan kondisi WHERE untuk jabatan jika tidak kosong
      if (!empty($id_jabatan)) {
         $this->db->where('karyawan.id_jabatan', $id_jabatan);
      }

      $this->db->group_by('absen.user_id'); // Mengelompokkan berdasarkan user_id karyawan

      $query = $this->db->get();
      $data['absen'] = $query->result();

      // Convert total seconds to hours for both reguler and lembur
      foreach ($data['absen'] as $row) {
         $total_jam_kerja_reguler_in_hours = $row->total_jam_kerja_reguler / 3600;
         $total_jam_kerja_lembur_in_hours = $row->total_jam_kerja_lembur / 3600;
         $row->total_jam_kerja_reguler = $total_jam_kerja_reguler_in_hours;
         $row->total_jam_kerja_lembur = $total_jam_kerja_lembur_in_hours;
      }

      // Muat view laporan absen dengan data yang sudah difilter
      $this->load->view('layout/admin/header', $data);
      $this->load->view('admin/result_laporan_absen', $data);
      $this->load->view('layout/admin/footer');
   }



   public function exportExcel()
   {
      // Ambil data dari database
      $this->db->select('*');
      $this->db->from('absen');
      $this->db->join('karyawan', 'karyawan.user_id = absen.user_id');
      $query = $this->db->get();
      $data = $query->result_array();

      // Buat objek Spreadsheet
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

      // Buat header untuk Excel
      $sheet->setCellValue('A1', 'TANGGAL');
      $sheet->setCellValue('B1', 'NIK');
      $sheet->setCellValue('C1', 'NAMA');
      $sheet->setCellValue('D1', 'WAKTU KERJA');
      $sheet->setCellValue('E1', 'KONDISI');
      $sheet->setCellValue('F1', 'AKTIVITAS');
      $sheet->setCellValue('G1', 'WAKTU ABSEN');
      $sheet->setCellValue('H1', 'LOKASI');
      $sheet->setCellValue('I1', 'KETERANGAN');

      // Tambahkan gaya ke header
      $headerStyle = [
         'font' => ['bold' => true],
         'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
         'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
         'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']],
      ];
      $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

      // Masukkan data laporan absen ke dalam Excel
      $row = 2;
      foreach ($data as $item) {
         $sheet->setCellValue('A' . $row, $item['estimated']);
         $sheet->setCellValue('B' . $row, $item['id_karyawan']);
         $sheet->setCellValue('C' . $row, $item['nama_karyawan']);
         $sheet->setCellValue('D' . $row, $item['shift_line']);
         $sheet->setCellValue('E' . $row, $item['kondisi_kesehatan']);
         $sheet->setCellValue('F' . $row, $item['aktivitas']);
         $sheet->setCellValue('G' . $row, $item['waktu']);
         $sheet->setCellValue('H' . $row, $item['lokasi_kerja']);
         $sheet->setCellValue('I' . $row, $item['keterangan']);
         $row++;
      }

      // Mengatur lebar kolom agar sesuai dengan isi
      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getColumnDimension('B')->setAutoSize(true);
      $sheet->getColumnDimension('C')->setAutoSize(true);
      $sheet->getColumnDimension('D')->setAutoSize(true);
      $sheet->getColumnDimension('E')->setAutoSize(true);
      $sheet->getColumnDimension('F')->setAutoSize(true);
      $sheet->getColumnDimension('G')->setAutoSize(true);
      $sheet->getColumnDimension('H')->setAutoSize(true);
      $sheet->getColumnDimension('I')->setAutoSize(true);

      // Atur header untuk file Excel
      $filename = 'laporan_absen.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');

      // Eksport file Excel
      $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      $writer->save('php://output');
   }
}
