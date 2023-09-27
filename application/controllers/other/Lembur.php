<?php

class Lembur extends CI_Controller
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
      $data['title'] = "Pengajuan Lembur";

      $data['lembur'] = $this->db->query("SELECT * FROM lembur
        INNER JOIN karyawan ON karyawan.user_id = lembur.user_id
        ORDER BY lembur.id_lembur DESC")->result();

      $this->load->view('layout/other/header', $data);
      $this->load->view('other/lembur', $data);
      $this->load->view('layout/other/footer');
   }

   public function accept($id)
   {
      $this->db->update('lembur', ['statement' => '1'], ['id_lembur' => $id]);
      $_SESSION["sukses"] = 'Berhasil menerima pengajuan ini.';
      redirect('other/lembur');
   }

   public function reject($id)
   {
      $this->db->update('lembur', ['statement' => '2'], ['id_lembur' => $id]);
      $_SESSION["sukses"] = 'Berhasil menerima pengajuan ini.';
      redirect('other/lembur');
   }
}
