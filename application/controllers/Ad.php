<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->db_keuangan = $this->load->database('keuangan', TRUE);
        cekSessionLogin();
        // admin_access();
    }

    // /////////////////////////////////////////////////////////////// list akses dokumen ///////////////////////////////////////////////////////////////////
    public function index()
    {

        $data['title'] = 'Akses Dokumen';
        $data['judul'] = 'Role | SIDE-BBI';

        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

        // ambil role / menu
        $this->db->select('*');
        $this->db->from('role');
        $data['role'] = $this->db->get()->result_array();

        // Ambil data pada tabel 'sdm_menu'
        $this->db->select('*');
        $this->db->from('menu');
        $data['menu'] = $this->db->get()->result_array();

        // user validation 
        $this->form_validation->set_rules('nama_role', 'Role', 'required|trim');

        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/role/list-role', $data);
            $this->load->view('template/footer');
        } else {

            $nama_role = $this->input->post('nama_role');

            // cek ketersediaan 'nama_role'
            $this->db->where('nama_role =', $nama_role);
            $cek_role = $this->db->get('role');

            if ($cek_role->num_rows() == 1) {

                $this->session->set_flashdata('messageRole', '<div class="alert alert-danger" role="alert">Role sudah terdaftar!</div>');
                redirect('role');
            }

            $kode_unik = sha1(time());

            $data = [

                'nama_role' => $nama_role,
                'kode_unik' => $kode_unik

            ];

            $this->db->insert('role', $data);

            $this->session->set_flashdata('messageRole', '<div class="alert alert-success" role="alert">Role berhasil ditambahkan!</div>');
            redirect('role');
        }
    }
    // /////////////////////////////////////////////////////////////// list role ///////////////////////////////////////////////////////////////////

    // /////////////////////////////////////////////////////////////// edit role ///////////////////////////////////////////////////////////////////
    public function edit($kode_unik)
    {

        $data['title'] = 'Role Akses';
        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

        // Ambil data role berdasarkan 'kode_unik'
        $this->db->select('*');
        $this->db->from('role');
        $this->db->where('kode_unik =', $kode_unik);
        $data['role'] = $this->db->get()->row_array();

        // Ambil akses menu berdasarkan 'id_role' pada tabel sdm_role_akses
        $this->db->select('role_akses.*, nama_menu');
        $this->db->from('role_akses');
        $this->db->join('menu', 'role_akses.id_menu = menu.id_menu', 'left');
        $this->db->where('role_akses.id_role =', $data['role']['id_role']);
        $data['aksesMenu'] = $this->db->get()->result_array();

        // Ambil data pada tabel 'sdm_menu'
        $this->db->select('*');
        $this->db->from('menu');
        $data['menu'] = $this->db->get()->result_array();

        // user validation 
        $this->form_validation->set_rules('nama_role', 'Role Name', 'required|trim');

        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/role/edit-role', $data);
            $this->load->view('template/footer');
        } else {

            $id_role = $this->input->post('id_role');
            $nama_role = $this->input->post('nama_role');
            $id_menu = $this->input->post('id_menu[]');

            if ($id_menu == NULL) {
                // jika tidak memiliki akses menu sama sekali (0)
                // hapus dari tabel 'sdm_role_akses' berdasarkan 'id_role'
                $this->db->where('id_role =', $id_role);
                $this->db->delete('role_akses');
            }

            // update tabel 'sdm_role'
            $this->db->set('nama_role', $nama_role);
            $this->db->where('kode_unik =', $kode_unik);
            $this->db->update('role');

            // update tabel 'sdm_role_akses' berdasarkan 'id_menu' dan 'id_role'
            foreach ($id_menu as $im) {
                // cek apakah ada 'id_role' pada tabel 'sdm_role_akses'
                $this->db->select('*');
                $this->db->from('role_akses');
                $this->db->where('id_role =', $id_role);
                $this->db->where('id_menu =', $im);
                $cek = $this->db->get()->num_rows();

                if ($cek == 0) {
                    // jika tidak ada, insert ke tabel 'role_akses'
                    $dataRA = [
                        'id_role' => $id_role,
                        'id_menu' => $im
                    ];

                    $this->db->insert('role_akses', $dataRA);
                } else {
                    // 'id_role' ada, tapi 'id_menu' tidak ada
                    // hapus dari tabel 'sdm_role_akses' berdasarkan 'id_role' dan 'id_menu' != 'id_menu'
                    $this->db->where('id_role =', $id_role);
                    $this->db->where('id_menu !=', $im);
                    $this->db->delete('role_akses');
                }
            }

            $this->session->set_flashdata('messageRole', '<div class="alert alert-success" role="alert">Role berhasil diupdate!</div>');

            redirect('role');
        }
    }
    // /////////////////////////////////////////////////////////////// edit role ///////////////////////////////////////////////////////////////////

    // ////////////////////////////////////////////////////////////// hapus role ///////////////////////////////////////////////////////////////////
    public function hapus($id_role)
    {

        // hapus pada tabel 'role' berdasarkan 'id_role'
        $this->db->where('id_role =', $id_role);
        $this->db->delete('role');

        // hapus pada tabel 'role_akses' berdasarkan 'id_role'
        $this->db->where('id_role =', $id_role);
        $this->db->delete('role_akses');

        $this->session->set_flashdata('messageRole', '<div class="alert alert-success" role="alert">Role berhasil dihapus!</div>');

        redirect('role');
    }
    // ////////////////////////////////////////////////////////////// hapus role ///////////////////////////////////////////////////////////////////




}
