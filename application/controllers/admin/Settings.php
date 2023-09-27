<?php

class Settings extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();

      $this->load->model('model');

      if ($this->session->userdata('role') != '1') {
         redirect('login');
      }
   }

   public function index()
   {
      $data['title'] = "Pengaturan";

      $id = $this->session->userdata('user_id');

      $data['general'] = $this->db->query("SELECT * FROM karyawan
        LEFT JOIN users ON users.user_id = karyawan.user_id
        WHERE karyawan.user_id='$id'")->result();

      $data['bio'] = $this->db->query("SELECT bio, user_id FROM karyawan
        WHERE user_id='$id'")->result();

      $data['account'] = $this->db->query("SELECT * FROM users
        WHERE user_id='$id'")->result();

      $this->load->view('layout/admin/header', $data);
      $this->load->view('admin/pengaturan', $data);
      $this->load->view('layout/admin/footer');
   }


   public function ubah_akun()
   {
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $confirm_password = $this->input->post('confirm_password');

      // Validasi form
      $this->form_validation->set_rules('username', 'Username', 'required');

      // Hanya tambahkan validasi untuk password jika password tidak kosong
      if (!empty($password)) {
         $this->form_validation->set_rules('password', 'Password Baru', 'required|matches[confirm_password]');
         $this->form_validation->set_rules('confirm_password', 'Ulangi Password', 'required');
      }

      if ($this->form_validation->run() != FALSE) {
         $user_id = $this->session->userdata('user_id');

         // Data yang akan diupdate untuk tabel 'users'
         $data_users = array(
            'username' => $username
         );

         // Hanya update password jika password tidak kosong
         if (!empty($password)) {
            $data_users['password'] = md5($password);
         }

         $where_users = array(
            'user_id' => $user_id
         );

         // Melakukan update data di tabel 'users'
         $this->model->update('users', $data_users, $where_users);
         redirect('login/logout');
      } else {
         $data['title'] = "Ubah Password";

         $this->load->view('layout/admin/header', $data);
         $this->load->view('admin/pengaturan', $data);
         $this->load->view('layout/admin/footer');
      }
   }
}
