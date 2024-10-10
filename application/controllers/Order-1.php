<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('secure');
        cekSessionLogin();
        $this->db_keuangan = $this->load->database('keuangan', TRUE);
    }

    // /////////////////////////////////////////////////////////////// list order //////////////////////////////////////////////////////////////////
    public function index()
    {

        $data['title'] = 'List Order';
        $data['judul'] = 'List Order | SIDE-BBI';

        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

        // data order
        $this->db_keuangan->select('cc_ord.*, customer.nama_customer');
        $this->db_keuangan->from('cc_ord');
        $this->db_keuangan->join('customer', 'customer.id_customer = cc_ord.kode_cst', 'left');
        $this->db_keuangan->where('cc_ord.grup =', 'order');
        $data['order'] = $this->db_keuangan->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('order/list-order', $data);
        $this->load->view('template/footer', $data);
    }
    // /////////////////////////////////////////////////////////////// list order //////////////////////////////////////////////////////////////////

    // ////////////////////////////////////////////////////////////// dokumen order ////////////////////////////////////////////////////////////////
    public function dokumen($no_ord)
    {
        $data['title'] = 'List Order';
        $data['judul'] = 'Dokumen Order | SIDE-BBI';
        // decript no_order
        $no_order = $this->secure->decrypt_url($no_ord);
        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();
        // ambil nama role berdasarkan id role dari session
        $role = $this->db->get_where('role', ['id_role' => $this->session->userdata('id_role')])->row_array();
        $nama_role = $role['nama_role'];
        // ambil data order where no order
        $this->db_keuangan->select('cc_ord.*, nama_customer');
        $this->db_keuangan->from('cc_ord');
        $this->db_keuangan->join('customer', 'customer.id_customer = cc_ord.kode_cst', 'left');
        $this->db_keuangan->where('id_cc_ord =', $no_order);
        $data['order'] = $this->db_keuangan->get()->row_array();
        // ambil data status dokumen
        $data['status_dokumen'] = $this->db->get('status_dokumen')->result_array();
        // ambil data edisi
        $data['edisi'] = $this->db->get('edisi')->result_array();
        // ambil data revisi
        $data['revisi'] = $this->db->get('revisi')->result_array();
        // ambil hak akses lihat dokumen berdasarkan role
        $this->db->select('*');
        $this->db->from('role');
        $this->db->where('id_role !=', 1);
        $this->db->where('id_role !=', 5);
        $this->db->where('id_role !=', 14);
        if ($nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
            // super admin, admin dan dokon center bisa melihat semua dokumen
        } else if ($nama_role == 'PPC') {
            // hanya bisa melihat dokumen sesuai role
            $this->db->where('nama_role =', 'PPC');
        } else if ($nama_role == 'QA') {
            $this->db->where('nama_role =', 'QA');
        } else if ($nama_role == 'QC') {
            $this->db->where('nama_role =', 'QC');
        } else if ($nama_role == 'FAB') {
            $this->db->where('nama_role =', 'FAB');
        } else if ($nama_role == 'Logistik') {
            $this->db->where('nama_role =', 'Logistik');
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('nama_role =', 'Keuangan');
        } else if ($nama_role == 'Engineering') {
            $this->db->where('nama_role =', 'Engineering');
        } else if ($nama_role == 'Logistik') {
            $this->db->where('nama_role =', 'Logistik');
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }
        $data['role'] = $this->db->get()->result_array();

        // ambil dokumen drawing whewe no order
        $this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_drawing');
        $this->db->join('status_dokumen', 'dokumen_drawing.status_dokumen = status_dokumen.id_status', 'left');
        $this->db->join('edisi', 'dokumen_drawing.edisi = edisi.id_edisi', 'left');
        $this->db->join('revisi', 'dokumen_drawing.revisi = revisi.id_revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_drawing.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_drawing'] = $this->db->get()->result_array();

        // ambil dokumen bq whewe no order
        $this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_bq');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_bq.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_bq.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_bq.revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_bq.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_bq'] = $this->db->get()->result_array();

        // ambil dokumen EIS whewe no order
        $this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_eis');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_eis.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_eis.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_eis.revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_eis.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_eis'] = $this->db->get()->result_array();

        // ambil dokumen MP whewe no order
        $this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_mp');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mp.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_mp.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_mp.revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_mp.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_mp'] = $this->db->get()->result_array();

        // ambil dokumen CLO whewe no order
        $this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_clo');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_clo.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_clo.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_clo.revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_clo.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_clo'] = $this->db->get()->result_array();

        // ambil dokumen MRS whewe no order
        $this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_mrs');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mrs.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_mrs.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_mrs.revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_mrs.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_mrs'] = $this->db->get()->result_array();

        // distribusi dokumen
        $data['disdok'] = $this->db->get('distribusi_dokumen')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('order/dokumen-order', $data);
        $this->load->view('template/footer', $data);
    }
    // ////////////////////////////////////////////////////////////// dokumen order ////////////////////////////////////////////////////////////////

    // ////////////////////////////////////////////////////////////// dokumenOrder ////////////////////////////////////////////////////////////////
    public function dokumenOrder($fungsi, $no_ord)
    {
        $data['title'] = 'List Order';
        $data['judul'] = 'Dokumen Order | SIDE-BBI';

        var_dump($fungsi);
        var_dump($no_ord);
        die;

        // decript no_order
        $no_order = $this->secure->decrypt_url($no_ord);
        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();
        // ambil nama role berdasarkan id role dari session
        $role = $this->db->get_where('role', ['id_role' => $this->session->userdata('id_role')])->row_array();
        $nama_role = $role['nama_role'];
        // ambil data order where no order
        $this->db_keuangan->select('cc_ord.*, nama_customer');
        $this->db_keuangan->from('cc_ord');
        $this->db_keuangan->join('customer', 'customer.id_customer = cc_ord.kode_cst', 'left');
        $this->db_keuangan->where('id_cc_ord =', $no_order);
        $data['order'] = $this->db_keuangan->get()->row_array();
        // ambil data status dokumen
        $data['status_dokumen'] = $this->db->get('status_dokumen')->result_array();
        // ambil data edisi
        $data['edisi'] = $this->db->get('edisi')->result_array();
        // ambil data revisi
        $data['revisi'] = $this->db->get('revisi')->result_array();
        // ambil hak akses lihat dokumen berdasarkan role
        $this->db->select('*');
        $this->db->from('role');
        $this->db->where('id_role !=', 1);
        $this->db->where('id_role !=', 5);
        $this->db->where('id_role !=', 14);
        if ($nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
            // super admin, admin dan dokon center bisa melihat semua dokumen
        } else if ($nama_role == 'PPC') {
            // hanya bisa melihat dokumen sesuai role
            $this->db->where('nama_role =', 'PPC');
        } else if ($nama_role == 'QA') {
            $this->db->where('nama_role =', 'QA');
        } else if ($nama_role == 'QC') {
            $this->db->where('nama_role =', 'QC');
        } else if ($nama_role == 'FAB') {
            $this->db->where('nama_role =', 'FAB');
        } else if ($nama_role == 'Logistik') {
            $this->db->where('nama_role =', 'Logistik');
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('nama_role =', 'Keuangan');
        } else if ($nama_role == 'Engineering') {
            $this->db->where('nama_role =', 'Engineering');
        } else if ($nama_role == 'Logistik') {
            $this->db->where('nama_role =', 'Logistik');
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }
        $data['role'] = $this->db->get()->result_array();

        // distribusi dokumen
        $data['disdok'] = $this->db->get('distribusi_dokumen')->result_array();

        if ($fungsi == 'PPC') {
            # code...
        } else if ($fungsi == 'QA') {
            # code...
        } else if ($fungsi == 'QC') {
            # code...
        } else if ($fungsi == 'FAB') {
            # code...
        } else if ($fungsi == 'MM') {
            # code...
        } else if ($fungsi == 'Logistik') {
            # code...
        } else if ($fungsi == 'Keuangan') {
            # code...
        } else if ($fungsi == 'Engineering') {
            // ambil dokumen drawing whewe no order
            $this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
            $this->db->from('dokumen_drawing');
            $this->db->join('status_dokumen', 'dokumen_drawing.status_dokumen = status_dokumen.id_status', 'left');
            $this->db->join('edisi', 'dokumen_drawing.edisi = edisi.id_edisi', 'left');
            $this->db->join('revisi', 'dokumen_drawing.revisi = revisi.id_revisi', 'left');
            $this->db->join('distribusi_dokumen', 'dokumen_drawing.id_dd = distribusi_dokumen.id_dd', 'left');
            $this->db->where('no_order =', $no_order);
            $this->db->where('status =', 1);

            // hak akses sesuai distribusi dokumen
            if ($nama_role == 'Super Admin') {
                // bisa meliat semua dokumen
            } else if ($nama_role == 'Admin') {
                // bisa melihat semua dokumen 
            } else if ($nama_role == 'PPC') {
                $this->db->where('distribusi_dokumen.ppc !=', 0);
            } else if ($nama_role == 'QA') {
                $this->db->where('distribusi_dokumen.qa !=', 0);
            } else if ($nama_role == 'QC') {
                $this->db->where('distribusi_dokumen.qc !=', 0);
            } else if ($nama_role == 'FAB') {
                $this->db->where('distribusi_dokumen.fab !=', 0);
            } else if ($nama_role == 'MM') {
                $this->db->where('distribusi_dokumen.mm !=', 0);
            } else if ($nama_role == 'Logistik') {
                $this->db->where('distribusi_dokumen.Log !=', 0);
            } else if ($nama_role == 'Keuangan') {
                $this->db->where('distribusi_dokumen.keu !=', 0);
            } else if ($nama_role == 'Engineering') {
                $this->db->where('distribusi_dokumen.eng !=', 0);
            } else if ($nama_role == 'Produksi') {
                $this->db->where('distribusi_dokumen.prod !=', 0);
            } else if ($nama_role == 'HRD') {
                $this->db->where('distribusi_dokumen.hrd !=', 0);
            } else if ($nama_role == 'Sales') {
                $this->db->where('distribusi_dokumen.sales !=', 0);
            } else if ($nama_role == 'MPI') {
                $this->db->where('distribusi_dokumen.mpi !=', 0);
            } else if ($nama_role == 'Expedisi') {
                $this->db->where('distribusi_dokumen.exp !=', 0);
            } else {
                echo "Anda tidak memiliki akses!";
                die;
            }

            $data['dokumen_drawing'] = $this->db->get()->result_array();

            // ambil dokumen bq whewe no order
            $this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
            $this->db->from('dokumen_bq');
            $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_bq.status_dokumen', 'left');
            $this->db->join('edisi', 'edisi.id_edisi = dokumen_bq.edisi', 'left');
            $this->db->join('revisi', 'revisi.id_revisi = dokumen_bq.revisi', 'left');
            $this->db->join('distribusi_dokumen', 'dokumen_bq.id_dd = distribusi_dokumen.id_dd', 'left');
            $this->db->where('no_order =', $no_order);
            $this->db->where('status =', 1);

            // hak akses sesuai distribusi dokumen
            if ($nama_role == 'Super Admin') {
                // bisa meliat semua dokumen
            } else if ($nama_role == 'Admin') {
                // bisa melihat semua dokumen 
            } else if ($nama_role == 'PPC') {
                $this->db->where('distribusi_dokumen.ppc !=', 0);
            } else if ($nama_role == 'QA') {
                $this->db->where('distribusi_dokumen.qa !=', 0);
            } else if ($nama_role == 'QC') {
                $this->db->where('distribusi_dokumen.qc !=', 0);
            } else if ($nama_role == 'FAB') {
                $this->db->where('distribusi_dokumen.fab !=', 0);
            } else if ($nama_role == 'MM') {
                $this->db->where('distribusi_dokumen.mm !=', 0);
            } else if ($nama_role == 'Logistik') {
                $this->db->where('distribusi_dokumen.Log !=', 0);
            } else if ($nama_role == 'Keuangan') {
                $this->db->where('distribusi_dokumen.keu !=', 0);
            } else if ($nama_role == 'Engineering') {
                $this->db->where('distribusi_dokumen.eng !=', 0);
            } else if ($nama_role == 'Produksi') {
                $this->db->where('distribusi_dokumen.prod !=', 0);
            } else if ($nama_role == 'HRD') {
                $this->db->where('distribusi_dokumen.hrd !=', 0);
            } else if ($nama_role == 'Sales') {
                $this->db->where('distribusi_dokumen.sales !=', 0);
            } else if ($nama_role == 'MPI') {
                $this->db->where('distribusi_dokumen.mpi !=', 0);
            } else if ($nama_role == 'Expedisi') {
                $this->db->where('distribusi_dokumen.exp !=', 0);
            } else {
                echo "Anda tidak memiliki akses!";
                die;
            }

            $data['dokumen_bq'] = $this->db->get()->result_array();

            // ambil dokumen EIS whewe no order
            $this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
            $this->db->from('dokumen_eis');
            $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_eis.status_dokumen', 'left');
            $this->db->join('edisi', 'edisi.id_edisi = dokumen_eis.edisi', 'left');
            $this->db->join('revisi', 'revisi.id_revisi = dokumen_eis.revisi', 'left');
            $this->db->join('distribusi_dokumen', 'dokumen_eis.id_dd = distribusi_dokumen.id_dd', 'left');
            $this->db->where('no_order =', $no_order);
            $this->db->where('status =', 1);

            // hak akses sesuai distribusi dokumen
            if ($nama_role == 'Super Admin') {
                // bisa meliat semua dokumen
            } else if ($nama_role == 'Admin') {
                // bisa melihat semua dokumen 
            } else if ($nama_role == 'PPC') {
                $this->db->where('distribusi_dokumen.ppc !=', 0);
            } else if ($nama_role == 'QA') {
                $this->db->where('distribusi_dokumen.qa !=', 0);
            } else if ($nama_role == 'QC') {
                $this->db->where('distribusi_dokumen.qc !=', 0);
            } else if ($nama_role == 'FAB') {
                $this->db->where('distribusi_dokumen.fab !=', 0);
            } else if ($nama_role == 'MM') {
                $this->db->where('distribusi_dokumen.mm !=', 0);
            } else if ($nama_role == 'Logistik') {
                $this->db->where('distribusi_dokumen.Log !=', 0);
            } else if ($nama_role == 'Keuangan') {
                $this->db->where('distribusi_dokumen.keu !=', 0);
            } else if ($nama_role == 'Engineering') {
                $this->db->where('distribusi_dokumen.eng !=', 0);
            } else if ($nama_role == 'Produksi') {
                $this->db->where('distribusi_dokumen.prod !=', 0);
            } else if ($nama_role == 'HRD') {
                $this->db->where('distribusi_dokumen.hrd !=', 0);
            } else if ($nama_role == 'Sales') {
                $this->db->where('distribusi_dokumen.sales !=', 0);
            } else if ($nama_role == 'MPI') {
                $this->db->where('distribusi_dokumen.mpi !=', 0);
            } else if ($nama_role == 'Expedisi') {
                $this->db->where('distribusi_dokumen.exp !=', 0);
            } else {
                echo "Anda tidak memiliki akses!";
                die;
            }

            $data['dokumen_eis'] = $this->db->get()->result_array();

            // ambil dokumen MP whewe no order
            $this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
            $this->db->from('dokumen_mp');
            $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mp.status_dokumen', 'left');
            $this->db->join('edisi', 'edisi.id_edisi = dokumen_mp.edisi', 'left');
            $this->db->join('revisi', 'revisi.id_revisi = dokumen_mp.revisi', 'left');
            $this->db->join('distribusi_dokumen', 'dokumen_mp.id_dd = distribusi_dokumen.id_dd', 'left');
            $this->db->where('no_order =', $no_order);
            $this->db->where('status =', 1);

            // hak akses sesuai distribusi dokumen
            if ($nama_role == 'Super Admin') {
                // bisa meliat semua dokumen
            } else if ($nama_role == 'Admin') {
                // bisa melihat semua dokumen 
            } else if ($nama_role == 'PPC') {
                $this->db->where('distribusi_dokumen.ppc !=', 0);
            } else if ($nama_role == 'QA') {
                $this->db->where('distribusi_dokumen.qa !=', 0);
            } else if ($nama_role == 'QC') {
                $this->db->where('distribusi_dokumen.qc !=', 0);
            } else if ($nama_role == 'FAB') {
                $this->db->where('distribusi_dokumen.fab !=', 0);
            } else if ($nama_role == 'MM') {
                $this->db->where('distribusi_dokumen.mm !=', 0);
            } else if ($nama_role == 'Logistik') {
                $this->db->where('distribusi_dokumen.Log !=', 0);
            } else if ($nama_role == 'Keuangan') {
                $this->db->where('distribusi_dokumen.keu !=', 0);
            } else if ($nama_role == 'Engineering') {
                $this->db->where('distribusi_dokumen.eng !=', 0);
            } else if ($nama_role == 'Produksi') {
                $this->db->where('distribusi_dokumen.prod !=', 0);
            } else if ($nama_role == 'HRD') {
                $this->db->where('distribusi_dokumen.hrd !=', 0);
            } else if ($nama_role == 'Sales') {
                $this->db->where('distribusi_dokumen.sales !=', 0);
            } else if ($nama_role == 'MPI') {
                $this->db->where('distribusi_dokumen.mpi !=', 0);
            } else if ($nama_role == 'Expedisi') {
                $this->db->where('distribusi_dokumen.exp !=', 0);
            } else {
                echo "Anda tidak memiliki akses!";
                die;
            }

            $data['dokumen_mp'] = $this->db->get()->result_array();

            // ambil dokumen CLO whewe no order
            $this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
            $this->db->from('dokumen_clo');
            $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_clo.status_dokumen', 'left');
            $this->db->join('edisi', 'edisi.id_edisi = dokumen_clo.edisi', 'left');
            $this->db->join('revisi', 'revisi.id_revisi = dokumen_clo.revisi', 'left');
            $this->db->join('distribusi_dokumen', 'dokumen_clo.id_dd = distribusi_dokumen.id_dd', 'left');
            $this->db->where('no_order =', $no_order);
            $this->db->where('status =', 1);

            // hak akses sesuai distribusi dokumen
            if ($nama_role == 'Super Admin') {
                // bisa meliat semua dokumen
            } else if ($nama_role == 'Admin') {
                // bisa melihat semua dokumen 
            } else if ($nama_role == 'PPC') {
                $this->db->where('distribusi_dokumen.ppc !=', 0);
            } else if ($nama_role == 'QA') {
                $this->db->where('distribusi_dokumen.qa !=', 0);
            } else if ($nama_role == 'QC') {
                $this->db->where('distribusi_dokumen.qc !=', 0);
            } else if ($nama_role == 'FAB') {
                $this->db->where('distribusi_dokumen.fab !=', 0);
            } else if ($nama_role == 'MM') {
                $this->db->where('distribusi_dokumen.mm !=', 0);
            } else if ($nama_role == 'Logistik') {
                $this->db->where('distribusi_dokumen.Log !=', 0);
            } else if ($nama_role == 'Keuangan') {
                $this->db->where('distribusi_dokumen.keu !=', 0);
            } else if ($nama_role == 'Engineering') {
                $this->db->where('distribusi_dokumen.eng !=', 0);
            } else if ($nama_role == 'Produksi') {
                $this->db->where('distribusi_dokumen.prod !=', 0);
            } else if ($nama_role == 'HRD') {
                $this->db->where('distribusi_dokumen.hrd !=', 0);
            } else if ($nama_role == 'Sales') {
                $this->db->where('distribusi_dokumen.sales !=', 0);
            } else if ($nama_role == 'MPI') {
                $this->db->where('distribusi_dokumen.mpi !=', 0);
            } else if ($nama_role == 'Expedisi') {
                $this->db->where('distribusi_dokumen.exp !=', 0);
            } else {
                echo "Anda tidak memiliki akses!";
                die;
            }

            $data['dokumen_clo'] = $this->db->get()->result_array();

            // ambil dokumen MRS whewe no order
            $this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
            $this->db->from('dokumen_mrs');
            $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mrs.status_dokumen', 'left');
            $this->db->join('edisi', 'edisi.id_edisi = dokumen_mrs.edisi', 'left');
            $this->db->join('revisi', 'revisi.id_revisi = dokumen_mrs.revisi', 'left');
            $this->db->join('distribusi_dokumen', 'dokumen_mrs.id_dd = distribusi_dokumen.id_dd', 'left');
            $this->db->where('no_order =', $no_order);
            $this->db->where('status =', 1);

            // hak akses sesuai distribusi dokumen
            if ($nama_role == 'Super Admin') {
                // bisa meliat semua dokumen
            } else if ($nama_role == 'Admin') {
                // bisa melihat semua dokumen 
            } else if ($nama_role == 'PPC') {
                $this->db->where('distribusi_dokumen.ppc !=', 0);
            } else if ($nama_role == 'QA') {
                $this->db->where('distribusi_dokumen.qa !=', 0);
            } else if ($nama_role == 'QC') {
                $this->db->where('distribusi_dokumen.qc !=', 0);
            } else if ($nama_role == 'FAB') {
                $this->db->where('distribusi_dokumen.fab !=', 0);
            } else if ($nama_role == 'MM') {
                $this->db->where('distribusi_dokumen.mm !=', 0);
            } else if ($nama_role == 'Logistik') {
                $this->db->where('distribusi_dokumen.Log !=', 0);
            } else if ($nama_role == 'Keuangan') {
                $this->db->where('distribusi_dokumen.keu !=', 0);
            } else if ($nama_role == 'Engineering') {
                $this->db->where('distribusi_dokumen.eng !=', 0);
            } else if ($nama_role == 'Produksi') {
                $this->db->where('distribusi_dokumen.prod !=', 0);
            } else if ($nama_role == 'HRD') {
                $this->db->where('distribusi_dokumen.hrd !=', 0);
            } else if ($nama_role == 'Sales') {
                $this->db->where('distribusi_dokumen.sales !=', 0);
            } else if ($nama_role == 'MPI') {
                $this->db->where('distribusi_dokumen.mpi !=', 0);
            } else if ($nama_role == 'Expedisi') {
                $this->db->where('distribusi_dokumen.exp !=', 0);
            } else {
                echo "Anda tidak memiliki akses!";
                die;
            }

            $data['dokumen_mrs'] = $this->db->get()->result_array();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('order/dokumen-order-engineering', $data);
            $this->load->view('template/footer', $data);
        }
    }
    // ////////////////////////////////////////////////////////////// dokumenOrder ////////////////////////////////////////////////////////////////

    // /////////////////////////////////////////////////////////// dokumen order index ////////////////////////////////////////////////////////////////
    public function dokumenIndex($no_ord)
    {
        $data['title'] = 'List Order';
        $data['judul'] = 'Dokumen Order | SIDE-BBI';
        // decript no_order
        $no_order = $this->secure->decrypt_url($no_ord);
        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();
        // ambil nama role berdasarkan id role dari session
        $role = $this->db->get_where('role', ['id_role' => $this->session->userdata('id_role')])->row_array();
        $nama_role = $role['nama_role'];
        // ambil data order where no order
        $this->db_keuangan->select('cc_ord.*, nama_customer');
        $this->db_keuangan->from('cc_ord');
        $this->db_keuangan->join('customer', 'customer.id_customer = cc_ord.kode_cst', 'left');
        $this->db_keuangan->where('id_cc_ord =', $no_order);
        $data['order'] = $this->db_keuangan->get()->row_array();
        // ambil data status dokumen
        $data['status_dokumen'] = $this->db->get('status_dokumen')->result_array();
        // ambil data edisi
        $data['edisi'] = $this->db->get('edisi')->result_array();
        // ambil data revisi
        $data['revisi'] = $this->db->get('revisi')->result_array();

        // ambil dokumen drawing where no order
        $this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_drawing');
        $this->db->join('status_dokumen', 'dokumen_drawing.status_dokumen = status_dokumen.id_status', 'left');
        $this->db->join('edisi', 'dokumen_drawing.edisi = edisi.id_edisi', 'left');
        $this->db->join('revisi', 'dokumen_drawing.revisi = revisi.id_revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_drawing.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_drawing'] = $this->db->get()->result_array();

        // ambil dokumen bq whewe no order
        $this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_bq');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_bq.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_bq.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_bq.revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_bq.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_bq'] = $this->db->get()->result_array();

        // ambil dokumen EIS whewe no order
        $this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_eis');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_eis.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_eis.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_eis.revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_eis.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_eis'] = $this->db->get()->result_array();

        // ambil dokumen MP whewe no order
        $this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_mp');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mp.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_mp.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_mp.revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_mp.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_mp'] = $this->db->get()->result_array();

        // ambil dokumen CLO whewe no order
        $this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_clo');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_clo.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_clo.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_clo.revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_clo.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_clo'] = $this->db->get()->result_array();

        // ambil dokumen MRS whewe no order
        $this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_mrs');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mrs.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_mrs.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_mrs.revisi', 'left');
        $this->db->join('distribusi_dokumen', 'dokumen_mrs.id_dd = distribusi_dokumen.id_dd', 'left');
        $this->db->where('no_order =', $no_order);
        $this->db->where('status =', 1);

        // hak akses sesuai distribusi dokumen
        if ($nama_role == 'Super Admin') {
            // bisa meliat semua dokumen
        } else if ($nama_role == 'Admin') {
            // bisa melihat semua dokumen 
        } else if ($nama_role == 'PPC') {
            $this->db->where('distribusi_dokumen.ppc !=', 0);
        } else if ($nama_role == 'QA') {
            $this->db->where('distribusi_dokumen.qa !=', 0);
        } else if ($nama_role == 'QC') {
            $this->db->where('distribusi_dokumen.qc !=', 0);
        } else if ($nama_role == 'FAB') {
            $this->db->where('distribusi_dokumen.fab !=', 0);
        } else if ($nama_role == 'MM') {
            $this->db->where('distribusi_dokumen.mm !=', 0);
        } else if ($nama_role == 'Logistik') {
            $this->db->where('distribusi_dokumen.Log !=', 0);
        } else if ($nama_role == 'Keuangan') {
            $this->db->where('distribusi_dokumen.keu !=', 0);
        } else if ($nama_role == 'Engineering') {
            $this->db->where('distribusi_dokumen.eng !=', 0);
        } else if ($nama_role == 'Produksi') {
            $this->db->where('distribusi_dokumen.prod !=', 0);
        } else if ($nama_role == 'HRD') {
            $this->db->where('distribusi_dokumen.hrd !=', 0);
        } else if ($nama_role == 'Sales') {
            $this->db->where('distribusi_dokumen.sales !=', 0);
        } else if ($nama_role == 'MPI') {
            $this->db->where('distribusi_dokumen.mpi !=', 0);
        } else if ($nama_role == 'Expedisi') {
            $this->db->where('distribusi_dokumen.exp !=', 0);
        } else {
            echo "Anda tidak memiliki akses!";
            die;
        }

        $data['dokumen_mrs'] = $this->db->get()->result_array();

        // distribusi dokumen
        $data['disdok'] = $this->db->get('distribusi_dokumen')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('order/dokumen-order', $data);
        $this->load->view('template/footer', $data);
    }
    // /////////////////////////////////////////////////////////// dokumen order index ////////////////////////////////////////////////////////////////







}
