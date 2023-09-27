<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class Permintaan_purchasing extends CI_Controller
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
        $this->db->where("(permintaan.status = 'in process' OR permintaan.status = 'finish')");
        $this->db->order_by('permintaan.created_at', 'desc');
        $data['request_gudang'] = $this->db->get()->result();

        $this->load->view('layout/others/header', $data);
        $this->load->view('others/permintaan_purchasing', $data);
        $this->load->view('layout/others/footer');
    }

    public function konfirmasi($id)
    {
        // Ambil data permintaan berdasarkan ID
        $permintaan = $this->db->get_where('permintaan', ['id' => $id])->row();

        // Menghitung selisih waktu antara deadline_at dan tanggal saat ini
        $deadline_date = new DateTime($permintaan->deadline_at);
        $current_date = new DateTime();
        $interval = $current_date->diff($deadline_date);

        // Jika selisih hari lebih dari nol (artinya deadline terlewatkan)
        if ($interval->days > 0) {
            $this->session->set_flashdata('gagal', 'Maaf, pembayaran sudah melebihi satu hari sejak deadline.');
        } else {
            // Update status permintaan menjadi "finish"
            $this->db->update('permintaan', ['status' => 'finish'], ['id' => $id]);
            $this->session->set_flashdata('berhasil', 'Permintaan barang telah diproses.');

            // Update status pembelian menjadi "berhasil"
            $this->db->update('pembelian', ['status' => 'berhasil'], ['id_permintaan' => $id]);
        }

        redirect('others/permintaan_purchasing');
    }
}
