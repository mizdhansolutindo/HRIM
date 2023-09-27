<?php

class Permintaan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model');

        if ($this->session->userdata('role') != '3') {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = "Permintaan Peminjaman Barang";

        $id = $this->session->userdata('user_id');

        $data['request'] = $this->db->query("SELECT permintaan.*, karyawan.nama_karyawan, users.user_id, barang.nama_brg, permintaan.status as status_permintaan FROM permintaan
        LEFT JOIN users ON users.user_id = permintaan.user_id
        LEFT JOIN karyawan ON karyawan.user_id = users.user_id
        LEFT JOIN barang ON barang.id_brg = permintaan.id_brg
        WHERE users.user_id='$id'
        ORDER BY permintaan.id DESC")->result();

        $this->load->view('layout/pegawai/header', $data);
        $this->load->view('pegawai/permintaan', $data);
        $this->load->view('layout/pegawai/footer');
    }

    public function pengajuan()
    {
        $data['title'] = "Pengajuan Peminjaman Barang";

        $data['product'] = $this->db->query("SELECT * FROM barang")->result();
        $data['unit'] = $this->db->query("SELECT * FROM unit")->result();
        $data['departement'] = $this->db->query("SELECT * FROM departement")->result();

        $this->load->view('layout/pegawai/header', $data);
        $this->load->view('pegawai/ajukan_permintaan', $data);
        $this->load->view('layout/pegawai/footer');
    }

    private function cek_stok_barang($id_brg)
    {
        $query = $this->db->get_where('barang', array('id_brg' => $id_brg));
        $barang = $query->row();
        $stok_barang = $barang->stok;

        return $stok_barang;
    }

    public function proses_permintaan()
    {
        $user_id = $this->session->userdata('user_id');
        $pilihan = $this->input->post('pilih_unit_departemen');
        $id_brg = $this->input->post('id_brg');
        $qty = $this->input->post('qty');
        $status = $this->input->post('status');
        $invoice_number = $this->generate_invoice_number();

        // Pengecekan jika qty kurang dari atau sama dengan 0
        if ($qty <= 0) {
            $this->session->set_flashdata('failed', 'Quantity harus lebih besar dari 0.');
            redirect('pegawai/permintaan/pengajuan');
        }

        // check stock product
        $stok_barang = $this->cek_stok_barang($id_brg);

        if ($stok_barang >= $qty) {
            $data = array(
                'user_id' => $user_id,
                'id_brg' => $id_brg,
                'qty' => $qty,
                'status' => $status,
                'invoice_number' => $invoice_number
            );

            if ($pilihan === 'unit') {
                $data['id_unit'] = $this->input->post('id_unit');
            } elseif ($pilihan === 'departemen') {
                $data['id_departement'] = $this->input->post('id_departement');
            }

            $this->db->insert('permintaan', $data);
            $this->session->set_flashdata('success', 'Berhasil mengajukan permintaan');
            redirect('pegawai/permintaan');
        } else {
            $this->session->set_flashdata('failed', 'Stok barang tidak mencukupi untuk permintaan ini');
            redirect('pegawai/permintaan/pengajuan');
        }
    }


    private function generate_invoice_number()
    {
        // Mendapatkan tahun sekarang
        $year = date('Y');

        // Mendapatkan nomor invoice terakhir untuk tahun ini
        $last_invoice = $this->db->select_max('invoice_number')
            ->like('invoice_number', 'PRM' . $year, 'after')
            ->get('permintaan')
            ->row()
            ->invoice_number;

        // Jika tidak ada invoice sebelumnya untuk tahun ini, atur nilai awal ke 1
        if (empty($last_invoice)) {
            return 'PRM' . $year . '-001';
        }

        // Ambil nomor urutan dari kode invoice terakhir, tambahkan 1, dan format ulang
        $last_invoice_number = intval(substr($last_invoice, -3));
        $next_invoice_number = $last_invoice_number + 1;
        $next_invoice = 'PRM' . $year . '-' . sprintf('%03d', $next_invoice_number);

        return $next_invoice;
    }
}
