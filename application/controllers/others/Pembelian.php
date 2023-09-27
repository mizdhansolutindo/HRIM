<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class Pembelian extends CI_Controller
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
        $data['title'] = 'Daftar Pembelian Barang';

        $this->db->select('pembelian.*, barang.*, permintaan_gudang.*, pembelian.status as status_pembelian, permintaan_gudang.status as status_permintaan_gudang');
        $this->db->from('pembelian');
        $this->db->join('permintaan_gudang', 'permintaan_gudang.id = pembelian.id_permintaan', 'left');
        $this->db->join('barang', 'barang.id_brg = permintaan_gudang.id_brg', 'left');
        $this->db->order_by('pembelian.created_at', 'desc');
        $data['pembelian'] = $this->db->get()->result();

        $this->load->view('layout/others/header', $data);
        $this->load->view('others/pembelian', $data);
        $this->load->view('layout/others/footer');
    }

    public function add()
    {
        $data['title'] = "Tambah Pembelian Barang";

        $data['product'] = $this->db->query("SELECT * FROM barang")->result();
        $data['karyawan'] = $this->db->query("SELECT * FROM karyawan JOIN departement on departement.id_departement = karyawan.id_departement")->result();

        $this->load->view('layout/others/header', $data);
        $this->load->view('others/add_pembelian', $data);
        $this->load->view('layout/others/footer');
    }

    public function add_proses()
    {
        // Ambil data dari form
        $id_brg = $this->input->post('id_brg');
        $id_karyawan = $this->input->post('id_karyawan');
        $jumlah = $this->input->post('jumlah');
        $status = $this->input->post('status');

        $invoice_number = $this->generate_invoice_number();

        $data = array(
            'id_brg' => $id_brg,
            'id_karyawan' => $id_karyawan,
            'jumlah' => $jumlah,
            'status' => $status,
            'invoice_number' => $invoice_number
        );

        $this->db->insert('pembelian', $data);
        $this->session->set_flashdata('success', 'Berhasil tambah pembelian barang');
        redirect('others/pembelian');
    }


    private function generate_invoice_number()
    {
        // Mendapatkan tahun sekarang
        $year = date('Y');

        // Mendapatkan nomor invoice terakhir untuk tahun ini
        $last_invoice = $this->db->select_max('invoice_number')
            ->like('invoice_number', 'PMB' . $year, 'after')
            ->get('pembelian')
            ->row()
            ->invoice_number;

        // Jika tidak ada invoice sebelumnya untuk tahun ini, atur nilai awal ke 1
        if (empty($last_invoice)) {
            return 'PMB' . $year . '-001';
        }

        // Ambil nomor urutan dari kode invoice terakhir, tambahkan 1, dan format ulang
        $last_invoice_number = intval(substr($last_invoice, -3));
        $next_invoice_number = $last_invoice_number + 1;
        $next_invoice = 'PMB' . $year . '-' . sprintf('%03d', $next_invoice_number);

        return $next_invoice;
    }
}
