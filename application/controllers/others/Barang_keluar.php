<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class Barang_keluar extends CI_Controller
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
        $data['title'] = 'Daftar Barang Keluar';

        $this->db->select('barang_keluar.*, barang_keluar.status as status_barang_keluar, karyawan.nama_karyawan, jabatan.nama_jabatan, departement.nama_departement, barang.id_brg, barang.nama_brg');
        $this->db->from('barang_keluar');
        $this->db->join('barang', 'barang.id_brg = barang_keluar.id_brg', 'left');
        $this->db->join('karyawan', 'karyawan.id_karyawan = barang_keluar.id_karyawan', 'left');
        $this->db->join('jabatan', 'jabatan.id_jabatan = karyawan.id_jabatan', 'left');
        $this->db->join('departement', 'departement.id_departement = karyawan.id_departement', 'left');
        $this->db->order_by('barang_keluar.created_at', 'desc');
        $data['productOut'] = $this->db->get()->result();

        $this->load->view('layout/others/header', $data);
        $this->load->view('others/barang_keluar', $data);
        $this->load->view('layout/others/footer');
    }

    public function import_excel()
    {
        $config['upload_path'] = './excel_upload/'; // Sesuaikan dengan lokasi penyimpanan file
        $config['allowed_types'] = 'xls|xlsx';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('excel_file')) {
            // Gagal unggah file
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_form', $error);
        } else {
            // Sukses unggah file
            $file_data = $this->upload->data();
            $file_path = './excel_upload/' . $file_data['file_name'];

            // Proses file Excel
            $spreadsheet = IOFactory::load($file_path);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Mulai dari indeks 1 untuk menghindari baris judul (header)
            for ($i = 1; $i < count($rows); $i++) {
                $username = $rows[$i][0];
                $email = $rows[$i][1];
                $password = md5($rows[$i][2]); // Kolom password

                // Cek apakah pengguna dengan username tersebut sudah ada
                $existing_user = $this->db->get_where('users', array('username' => $username))->row();

                if ($existing_user) {
                    $user_id = $existing_user->user_id;
                } else {
                    // Jika belum ada, buat pengguna baru di tabel "users"
                    $user_data = array(
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'role' => 3,
                        'status' => 1,
                    );
                    $this->db->insert('users', $user_data);

                    // Ambil user_id yang baru saja dibuat
                    $user_id = $this->db->insert_id();
                }

                // Insert data ke tabel "karyawan" dengan user_id yang sesuai
                $id_karyawan = $rows[$i][3];
                $nama_karyawan = $rows[$i][4];
                $jabatan = $rows[$i][5];
                $departement = $rows[$i][6];
                $nik = $rows[$i][7];
                $no_kk = $rows[$i][8];
                $alamat = $rows[$i][9];
                $no_kontrak = $rows[$i][10];
                $tgl_kontrak = $rows[$i][11];
                $tgl_kontrak_berakhir = $rows[$i][12];

                $karyawan_data = array(
                    'id_karyawan' => $id_karyawan,
                    'user_id' => $user_id,
                    'nama_karyawan' => $nama_karyawan,
                    'id_jabatan' => $jabatan,
                    'id_departement' => $departement,
                    'nik' => $nik,
                    'no_kk' => $no_kk,
                    'alamat' => $alamat,
                    'no_kontrak' => $no_kontrak,
                    'tgl_kontrak' => $tgl_kontrak,
                    'tgl_kontrak_berakhir' => $tgl_kontrak_berakhir,
                );
                $this->db->insert('karyawan', $karyawan_data);
            }

            // Setelah selesai, arahkan pengguna ke halaman yang sesuai
            $this->session->set_flashdata('success', 'Data karyawan berhasil diunggah');
            redirect('others/karyawan');
        }
    }

    public function add()
    {
        $data['title'] = "Tambah Barang Keluar";

        $data['product'] = $this->db->query("SELECT * FROM barang")->result();
        $data['karyawan'] = $this->db->query("SELECT * FROM karyawan JOIN departement on departement.id_departement = karyawan.id_departement")->result();
        $data['unit'] = $this->db->query("SELECT * FROM unit")->result();
        $data['departement'] = $this->db->query("SELECT * FROM departement")->result();

        $this->load->view('layout/others/header', $data);
        $this->load->view('others/add_barang_keluar', $data);
        $this->load->view('layout/others/footer');
    }

    private function cek_stok_barang($id_brg)
    {
        // Query database untuk mendapatkan stok barang berdasarkan $id_brg
        $result = $this->db->select('stok')->where('id_brg', $id_brg)->get('barang')->row();

        if ($result) {
            return $result->stok;
        } else {
            return 0;
        }
    }

    public function add_proses()
    {
        // Ambil data dari form
        $pilihan = $this->input->post('pilih_unit_departemen');
        $id_brg = $this->input->post('id_brg');
        $id_karyawan = $this->input->post('id_karyawan');
        $jumlah = $this->input->post('jumlah');
        $status = $this->input->post('status');
        $created_at = $this->input->post('created_at');

        // Loop melalui setiap baris data yang diinputkan
        for ($i = 0; $i < count($id_brg); $i++) {
            $stok_barang = $this->cek_stok_barang($id_brg[$i]);

            // Cek stok barang untuk setiap baris
            if ($stok_barang >= $jumlah[$i]) {
                // Mendapatkan kode unik otomatis
                $invoice_number = $this->generate_invoice_number();

                $data = array(
                    'id_brg' => $id_brg[$i],
                    'id_karyawan' => $id_karyawan[$i],
                    'jumlah' => $jumlah[$i],
                    'status' => $status[$i],
                    'created_at' => $created_at[$i],
                    'invoice_number' => $invoice_number // Setiap baris mendapatkan invoice number yang berbeda
                );

                if ($pilihan[$i] === 'unit') {
                    $data['id_unit'] = $this->input->post('id_unit')[$i];
                } elseif ($pilihan[$i] === 'departemen') {
                    $data['id_departement'] = $this->input->post('id_departement')[$i];
                }

                // Simpan data ke dalam tabel barang_keluar
                $this->db->insert('barang_keluar', $data);
            } else {
                $this->session->set_flashdata('failed', 'Stok barang tidak mencukupi untuk permintaan ini');
                redirect('others/barang_keluar/add');
            }
        }

        $this->session->set_flashdata('success', 'Berhasil tambah barang keluar');
        redirect('others/barang_keluar');
    }


    private function generate_invoice_number()
    {
        // Mendapatkan tahun sekarang
        $year = date('Y');

        // Mendapatkan nomor invoice terakhir untuk tahun ini
        $last_invoice = $this->db->select_max('invoice_number')
            ->like('invoice_number', 'STCK' . $year, 'after')
            ->get('barang_keluar')
            ->row()
            ->invoice_number;

        // Jika tidak ada invoice sebelumnya untuk tahun ini, atur nilai awal ke 1
        if (empty($last_invoice)) {
            return 'STCK' . $year . '-001';
        }

        // Ambil nomor urutan dari kode invoice terakhir, tambahkan 1, dan format ulang
        $last_invoice_number = intval(substr($last_invoice, -3));
        $next_invoice_number = $last_invoice_number + 1;
        $next_invoice = 'STCK' . $year . '-' . sprintf('%03d', $next_invoice_number);

        return $next_invoice;
    }
}
