<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Barang extends CI_Controller
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
        $data['title'] = 'List Barang';

        $this->db->select('*');
        $this->db->from('barang');
        $this->db->join('kategori', 'kategori.id_kategori = barang.id_kategori');
        $this->db->join('supplier', 'supplier.id_supplier = barang.id_supplier');
        $this->db->order_by('barang.stok', 'desc');
        $data['barang'] = $this->db->get()->result();

        $this->load->view('layout/others/header', $data);
        $this->load->view('others/barang', $data);
        $this->load->view('layout/others/footer');
    }

    public function add()
    {
        $data['title'] = 'Tambah Barang';

        $data['kategori'] = $this->model->get('kategori')->result();
        $data['unit'] = $this->model->get('unit')->result();
        $data['supplier'] = $this->model->get('supplier')->result();

        $this->load->view('layout/others/header', $data);
        $this->load->view('others/addbarang', $data);
        $this->load->view('layout/others/footer');
    }

    public function proses()
    {
        // Ambil data dari form
        $id_brg = $this->input->post('id_brg');
        $id_kategori = $this->input->post('id_kategori');
        $nama_brg = $this->input->post('nama_brg');
        $merek = $this->input->post('merek');
        $id_supplier = $this->input->post('id_supplier');
        $harga = $this->input->post('harga');

        // Loop melalui setiap baris data
        for ($i = 0; $i < count($id_brg); $i++) {
            $data = array(
                'id_brg' => $id_brg[$i],
                'id_kategori' => $id_kategori[$i],
                'nama_brg' => $nama_brg[$i],
                'merek' => $merek[$i],
                'id_supplier' => $id_supplier[$i],
                'harga' => $harga[$i],
            );

            // Simpan data karyawan ke tabel karyawan
            $this->db->insert('barang', $data);
        }

        // Redirect atau berikan respons sesuai kebutuhan Anda
        $this->session->set_flashdata('success', 'Data inventaris berhasil ditambah');
        redirect('others/barang');
    }

    public function update($id)
    {
        $data['title'] = 'Update Barang';

        $data['kategori'] = $this->model->get('kategori')->result();
        $data['unit'] = $this->model->get('unit')->result();
        $data['supplier'] = $this->model->get('supplier')->result();

        $where = array('id_brg' => $id);

        $this->db->select('*');
        $this->db->from('barang');
        $this->db->join('kategori', 'kategori.id_kategori = barang.id_kategori');
        $this->db->join('supplier', 'supplier.id_supplier = barang.id_supplier');
        $this->db->where('barang.id_brg', $id);
        $data['barang'] = $this->db->get()->row();

        $this->load->view('layout/others/header', $data);
        $this->load->view('others/updatebarang', $data);
        $this->load->view('layout/others/footer');
    }


    public function proses_ubah()
    {
        $id_brg = $this->input->post('id_brg');
        $id_kategori = $this->input->post('id_kategori');
        $nama_brg = $this->input->post('nama_brg');
        $merek = $this->input->post('merek');
        $id_supplier = $this->input->post('id_supplier');
        $harga = $this->input->post('harga');

        $data = array(
            'id_kategori' => $id_kategori,
            'nama_brg' => $nama_brg,
            'merek' => $merek,
            'id_supplier' => $id_supplier,
            'harga' => $harga,
        );

        $where = array(
            'id_brg' => $id_brg
        );

        $this->model->update('barang', $data, $where);

        $this->session->set_flashdata('success', 'Data inventaris berhasil diubah');
        redirect('others/barang');
    }

    public function delete($id)
    {
        $where = array('id_brg' => $id);
        $this->model->delete($where, 'barang');

        $this->session->set_flashdata('success', 'Data inventaris berhasil dihapus');
        redirect('others/barang');
    }

    public function exportExcel()
    {
        // Ambil data dari database
        $this->db->select('*');
        $this->db->from('barang');
        $this->db->join('kategori', 'kategori.id_kategori = barang.id_kategori');
        $this->db->join('supplier', 'supplier.id_supplier = barang.id_supplier');
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get();
        $data = $query->result_array();

        // Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat header untuk Excel
        $sheet->setCellValue('A1', 'PART NUMBER');
        $sheet->setCellValue('B1', 'NAMA BARANG');
        $sheet->setCellValue('C1', 'MEREK BARANG');
        $sheet->setCellValue('D1', 'TIPE');
        $sheet->setCellValue('E1', 'HARGA');
        $sheet->setCellValue('F1', 'STOK');
        $sheet->setCellValue('G1', 'SUPPLIER');

        // Tambahkan gaya ke header
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']],
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

        // Masukkan data laporan absen ke dalam Excel
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['id_brg']);
            $sheet->setCellValue('B' . $row, $item['nama_brg']);
            $sheet->setCellValue('C' . $row, $item['merek']);
            $sheet->setCellValue('D' . $row, $item['nama_kategori']);
            $sheet->setCellValue('E' . $row, $item['harga']);
            $sheet->setCellValue('F' . $row, $item['stok']);
            $sheet->setCellValue('G' . $row, $item['nama_supplier']);
            $row++;
        }

        // Mengatur lebar kolom agar sesuai dengan isi
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        // Atur header untuk file Excel
        $filename = 'all_barang.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Eksport file Excel
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
