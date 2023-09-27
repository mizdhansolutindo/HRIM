<?php

class Izin extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();

      $this->load->model('model');

      if ($this->session->userdata('role') != '2') {
         redirect('login');
      }
   }

   public function index()
   {
      $data['title'] = "Pengajuan Izin";

      $data['izin'] = $this->db->query("SELECT * FROM izin
        INNER JOIN karyawan ON karyawan.user_id = izin.user_id
        ORDER BY izin.created_at DESC")->result();

      $this->load->view('layout/other/header', $data);
      $this->load->view('other/izin', $data);
      $this->load->view('layout/other/footer');
   }

   public function accept($id)
   {
      $this->db->update('izin', ['status_izin' => '1'], ['id_izin' => $id]);
      $_SESSION["sukses"] = 'Berhasil menerima pengajuan ini.';
      redirect('other/izin');
   }

   public function reject($id)
   {
      $this->db->update('izin', ['status_izin' => '2'], ['id_izin' => $id]);
      $_SESSION["sukses"] = 'Berhasil menerima pengajuan ini.';
      redirect('other/izin');
   }
}
