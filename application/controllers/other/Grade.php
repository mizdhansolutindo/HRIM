<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grade extends CI_Controller
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
      $data['title'] = 'Grade Jabatan';

      $this->db->select('*');
      $this->db->from('grade');
      $this->db->order_by('id_grade', 'desc');
      $data['grade'] = $this->db->get()->result();

      $this->load->view('layout/other/header', $data);
      $this->load->view('other/grade', $data);
      $this->load->view('layout/other/footer');
   }

   public function proses()
   {
      $this->form_validation->set_rules('nilai', 'nilai grade', 'required');

      if ($this->form_validation->run() == FALSE) {
         $data['title'] = 'Tambah Grade';

         $this->db->select('*');
         $this->db->from('grade');
         $this->db->order_by('id_grade', 'desc');
         $data['grade'] = $this->db->get()->result();

         $this->load->view('layout/other/header', $data);
         $this->load->view('other/grade', $data);
         $this->load->view('layout/other/footer');
      } else {

         $data = array(
            'nilai' => $this->input->post('nilai'),
         );

         $this->db->insert('grade', $data);

         $this->session->set_flashdata('success', 'Data grade berhasil ditambah');
         redirect('other/grade');
      }
   }



   public function proses_ubah()
   {
      $id_grade = $this->input->post('id_grade');
      $nilai = $this->input->post('nilai');

      $data = array(
         'nilai' => $nilai,
      );

      $where = array(
         'id_grade' => $id_grade
      );

      $this->model->update('grade', $data, $where);

      $this->session->set_flashdata('success', 'Data grade berhasil diubah');
      redirect('other/grade');
   }

   public function delete($id)
   {
      $where = array('id_grade' => $id);
      $this->model->delete($where, 'grade');

      $this->session->set_flashdata('success', 'Data grade berhasil dihapus');
      redirect('other/grade');
   }
}
