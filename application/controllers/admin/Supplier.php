<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Supplier extends CI_Controller
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
        $data['title'] = 'List Supplier';

        // Mendapatkan kode unik terakhir dari database
        $last_id_query = $this->db->query("SELECT MAX(id_supplier) AS max_id FROM supplier");
        $last_id = $last_id_query->row_array();
        $last_number = intval(substr($last_id['max_id'], 3));

        // Menghasilkan kode unik berikutnya
        $new_number = $last_number + 1;
        $new_id = "SPL" . str_pad($new_number, 4, '0', STR_PAD_LEFT);

        // Mengirim kode unik berikutnya ke view
        $data['id_supplier'] = $new_id;

        $this->db->select('*');
        $this->db->from('supplier');
        $data['supplier'] = $this->db->get()->result();

        $this->load->view('layout/admin/header', $data);
        $this->load->view('admin/supplier', $data);
        $this->load->view('layout/admin/footer');
    }

    public function proses()
    {
        // Ambil data dari form atau request
        $id_supplier = $this->input->post('id_supplier');
        $nama_supplier = $this->input->post('nama_supplier');

        // Data untuk tabel 'karyawan' termasuk id_user
        $data = array(
            'id_supplier' => $id_supplier,
            'nama_supplier' => $nama_supplier,
        );

        // Simpan data karyawan ke tabel karyawan
        $this->db->insert('supplier', $data);

        // Redirect atau berikan respons sesuai kebutuhan Anda
        $this->session->set_flashdata('success', 'Data supplier berhasil ditambah');
        redirect('admin/supplier');
    }


    public function proses_ubah()
    {
        $id_supplier = $this->input->post('id_supplier');
        $nama_supplier = $this->input->post('nama_supplier');

        $data = array(
            'nama_supplier' => $nama_supplier,
        );

        $where = array(
            'id_supplier' => $id_supplier
        );

        $this->model->update('supplier', $data, $where);

        $this->session->set_flashdata('success', 'Data supplier berhasil diubah');
        redirect('admin/supplier');
    }

    public function delete($id)
    {
        $where = array('id_supplier' => $id);
        $this->model->delete($where, 'supplier');

        $this->session->set_flashdata('success', 'Data supplier berhasil dihapus');
        redirect('admin/supplier');
    }
}
