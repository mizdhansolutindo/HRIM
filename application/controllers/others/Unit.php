<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unit extends CI_Controller
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
        $data['title'] = 'Unit Barang';

        $this->db->select('*');
        $this->db->from('unit');
        $this->db->order_by('id_unit', 'desc');
        $data['unit'] = $this->db->get()->result();

        $this->load->view('layout/others/header', $data);
        $this->load->view('others/unit', $data);
        $this->load->view('layout/others/footer');
    }


    public function proses()
    {
        // Ambil data dari form atau request
        $nama_unit = $this->input->post('nama_unit');
        $nomor_unit = $this->input->post('nomor_unit');
        $tgl_kontrak = $this->input->post('tgl_kontrak');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $kondisi = $this->input->post('kondisi');

        // Data untuk tabel 'karyawan' termasuk id_user
        $data = array(
            'nama_unit' => $nama_unit,
            'nomor_unit' => $nomor_unit,
            'tgl_kontrak' => $tgl_kontrak,
            'tgl_akhir' => $tgl_akhir,
            'kondisi' => $kondisi,
        );

        // Simpan data karyawan ke tabel karyawan
        $this->db->insert('unit', $data);

        // Redirect atau berikan respons sesuai kebutuhan Anda
        $this->session->set_flashdata('success', 'Data unit berhasil ditambah');
        redirect('others/unit');
    }


    public function proses_ubah()
    {
        $id_unit = $this->input->post('id_unit');
        $nama_unit = $this->input->post('nama_unit');
        $nomor_unit = $this->input->post('nomor_unit');
        $tgl_kontrak = $this->input->post('tgl_kontrak');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $kondisi = $this->input->post('kondisi');

        $data = array(
            'nama_unit' => $nama_unit,
            'nomor_unit' => $nomor_unit,
            'tgl_kontrak' => $tgl_kontrak,
            'tgl_akhir' => $tgl_akhir,
            'kondisi' => $kondisi,
        );

        $where = array(
            'id_unit' => $id_unit
        );

        $this->model->update('unit', $data, $where);

        $this->session->set_flashdata('success', 'Data unit berhasil diubah');
        redirect('others/unit');
    }

    public function delete($id)
    {
        $where = array('id_unit' => $id);
        $this->model->delete($where, 'unit');

        $this->session->set_flashdata('success', 'Data unit berhasil dihapus');
        redirect('others/unit');
    }
}
