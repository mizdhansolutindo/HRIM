<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class Permintaan_gudang extends CI_Controller
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
        $data['title'] = 'Daftar Permintaan Staff Gudang';

        $this->db->select('permintaan.*, karyawan.nama_karyawan, users.user_id, barang.nama_brg, permintaan.status as status_permintaan, barang.harga');
        $this->db->from('permintaan');
        $this->db->join('users', 'users.user_id = permintaan.user_id', 'left');
        $this->db->join('karyawan', 'karyawan.user_id = users.user_id', 'left');
        $this->db->join('barang', 'barang.id_brg = permintaan.id_brg', 'left');
        $this->db->where("(permintaan.status = 'accept' OR permintaan.status = 'in process')");
        $this->db->order_by('permintaan.created_at', 'desc');
        $data['request_gudang'] = $this->db->get()->result();

        $this->load->view('layout/others/header', $data);
        $this->load->view('others/permintaan_gudang', $data);
        $this->load->view('layout/others/footer');
    }

    public function konfirmasi($id)
    {
        // Update status permintaan menjadi "in process"
        $this->db->update('permintaan', ['status' => 'in process'], ['id' => $id]);
        $this->session->set_flashdata('berhasil', 'Permintaan barang telah diproses.');

        // Insert data ke tabel pembelian
        $data_pembelian = [
            'id_permintaan' => $id,
            'status' => 'proses' // Gantilah dengan status yang sesuai
        ];

        $this->db->insert('pembelian', $data_pembelian);

        redirect('others/permintaan_gudang');
    }
}
