<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model');

        if ($this->session->userdata('role') != '4' && $this->session->userdata('role') != '5' && $this->session->userdata('role') != '6') {
            redirect('login');
        }
    }


    public function index()
    {
        $data['title'] = 'Kategori Barang';

        $this->db->select('*');
        $this->db->from('kategori');
        $this->db->order_by('id_kategori', 'desc');
        $data['kategori'] = $this->db->get()->result();

        $this->load->view('layout/others/header', $data);
        $this->load->view('others/kategori', $data);
        $this->load->view('layout/others/footer');
    }


    public function proses()
    {
        // Ambil data dari form atau request
        $nama_kategori = $this->input->post('nama_kategori');

        // Data untuk tabel 'karyawan' termasuk id_user
        $data = array(
            'nama_kategori' => $nama_kategori,
        );

        // Simpan data karyawan ke tabel karyawan
        $this->db->insert('kategori', $data);

        // Redirect atau berikan respons sesuai kebutuhan Anda
        $this->session->set_flashdata('success', 'Data kategori berhasil ditambah');
        redirect('others/kategori');
    }


    public function proses_ubah()
    {
        $id_kategori = $this->input->post('id_kategori');
        $nama_kategori = $this->input->post('nama_kategori');

        $data = array(
            'nama_kategori' => $nama_kategori,
        );

        $where = array(
            'id_kategori' => $id_kategori
        );

        $this->model->update('kategori', $data, $where);

        $this->session->set_flashdata('success', 'Data kategori berhasil diubah');
        redirect('others/kategori');
    }

    public function delete($id)
    {
        $where = array('id_kategori' => $id);
        $this->model->delete($where, 'kategori');

        $this->session->set_flashdata('success', 'Data kategori berhasil dihapus');
        redirect('others/kategori');
    }
}
