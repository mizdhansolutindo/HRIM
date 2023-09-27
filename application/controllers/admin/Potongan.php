<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Potongan extends CI_Controller
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
      $data['title'] = 'Potongan';

      $this->db->select('*');
      $this->db->from('potongan');
      $this->db->order_by('id_potongan', 'desc');
      $data['potongan'] = $this->db->get()->result();

      $this->load->view('layout/admin/header', $data);
      $this->load->view('admin/potongan', $data);
      $this->load->view('layout/admin/footer');
   }

   public function proses()
   {
      $this->form_validation->set_rules('tipe_potongan', 'tipe potongan', 'required');
      $this->form_validation->set_rules('jumlah', 'jumlah', 'required');

      if ($this->form_validation->run() == FALSE) {
         $data['title'] = 'Tambah Potongan';

         $this->db->select('*');
         $this->db->from('potongan');
         $this->db->order_by('id_potongan', 'desc');
         $data['potongan'] = $this->db->get()->result();

         $this->load->view('layout/admin/header', $data);
         $this->load->view('admin/potongan', $data);
         $this->load->view('layout/admin/footer');
      } else {

         $data = array(
            'tipe_potongan' => $this->input->post('tipe_potongan'),
            'jumlah' => $this->input->post('jumlah'),
         );

         $this->db->insert('potongan', $data);

         $this->session->set_flashdata('success', 'Data potongan berhasil ditambah');
         redirect('admin/potongan');
      }
   }



   public function proses_ubah()
   {
      $id_potongan = $this->input->post('id_potongan');
      $jumlah = $this->input->post('jumlah');

      $data = array(
         'jumlah' => $jumlah,
      );

      $where = array(
         'id_potongan' => $id_potongan
      );

      $this->model->update('potongan', $data, $where);

      $this->session->set_flashdata('success', 'Data potongan berhasil diubah');
      redirect('admin/potongan');
   }

   public function delete($id)
   {
      $where = array('id_potongan' => $id);
      $this->model->delete($where, 'potongan');

      $this->session->set_flashdata('success', 'Data potongan berhasil dihapus');
      redirect('admin/potongan');
   }
}
