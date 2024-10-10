<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ps extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('secure');
        $this->db_keuangan = $this->load->database('keuangan', TRUE);
    }

    // ///////////////////////////////////////////////////// view dokumen ps //////////////////////////////////////////////////////
    public function view($nama_file)
    {

        $data['judul'] = $nama_file;
        $data['file'] = $nama_file;

        $nik = $this->session->userdata('nik');

        // cek user join role
        $this->db->select('user.*, nama_role');
        $this->db->from('user');
        $this->db->join('role', 'role.id_role = user.id_role', 'left');
        $this->db->where('nik =', $nik);
        $role = $this->db->get()->row_array();

        $jenis_dokumen = 'Production Schedule';
        $tgl_view = date('Y-m-d');

        // cek apakah ada history view where nama_file & user
        $this->db->select('*');
        $this->db->from('dokumen_view');
        $this->db->where('nama_file =', $nama_file);
        $this->db->where('nik =', $nik);
        $cek_view = $this->db->get()->num_rows();

        if ($cek_view > 0) {
            // update
            $this->db->set('tgl_view', $tgl_view);
            $this->db->set('role', $role['nama_role']);
            $this->db->where('nama_file =', $nama_file);
            $this->db->where('nik =', $nik);
            $this->db->update('dokumen_view');
        } else {
            // insert
            $data_view = [
                'nama_file' => $nama_file,
                'jenis_dokumen' => $jenis_dokumen,
                'nik' => $nik,
                'role' => $role['nama_role'],
                'tgl_view' => $tgl_view
            ];
            $this->db->insert('dokumen_view', $data_view);
        }


        $this->load->view('dokumen/view-ps', $data);
    }
    // ///////////////////////////////////////////////////// view dokumen ps //////////////////////////////////////////////////////

    // //////////////////////////////////////////////////// tambah dokumen ps /////////////////////////////////////////////////////
    public function tambah($no_ord, $fungsi = 'nol')
    {
        // decript no_order
        $no_order = $no_ord;

        // ambil inputan
        $no_dokumen = $this->input->post('no_dokumen');
        $nama_dokumen = $this->input->post('nama_dokumen');
        $tgl_dokumen = $this->input->post('tgl_dokumen');
        $status_dokumen = $this->input->post('status_dokumen');
        $revisi = $this->input->post('revisi');
        $edisi = $this->input->post('edisi');
        // $issue_sheet = $this->input->post('issue_sheet');
        $total1 = $this->input->post('total1');
        $total2 = $this->input->post('total2');
        $ukuran = $this->input->post('ukuran');
        $id_dd = $this->input->post('distribusi_dokumen');
        $nama_file = '';

        $date_created = date('Y-m-d');
        $user = $this->session->userdata('nama_karyawan');
        $kode_unik = sha1(time());

        // file spk
        $file = $_FILES['file_mscurve']['name'];

        // cek apakah nomor dokumen sudah terdaftar ?
        $cekNoDok = $this->db->get_where('dokumen_ps', ['no_dokumen' => $no_dokumen])->num_rows();

        if ($cekNoDok >= 1) {

            $this->session->set_flashdata('messageDokumen', '<div class="alert alert-danger" role="alert">No dokumen sudah terdaftar!</div>');
            redirect('order/dokumen/' . $no_order . '/' . $fungsi);
        }

        // file ps
        if ($file) {
            $this->load->model('Dokumen_model', 'dokumen');
            $nama_file = $this->dokumen->tambahPs($file);
        }
        // file ps

        $data = [
            'no_order' => $no_order,
            'no_dokumen' => $no_dokumen,
            'nama_dokumen' => $nama_dokumen,
            'tgl_dokumen' => $tgl_dokumen,
            'status_dokumen' => $status_dokumen,
            'revisi' => $revisi,
            'edisi' => $edisi,
            // 'issue_sheet' => $issue_sheet,
            'total1' => $total1,
            'total2' => $total2,
            'ukuran' => $ukuran,
            'id_dd' => $id_dd,
            'status' => 1,
            'nama_file' => $nama_file,
            'date_created' => $date_created,
            'user' => $user,
            'kode_unik' => $kode_unik
        ];

        $this->db->insert('dokumen_ps', $data);

        $this->session->set_flashdata('messageDokumen', '<div class="alert alert-success" role="alert">Dokumen Production Schedule berhasil ditambahkan!</div>');


        // $encrypt_no_order = $this->secure->encrypt_url($no_order);
        redirect('order/dokumen/' . $no_order . '/' . $fungsi);
    }
    // ////////////////////////////////////////////////// tambah dokumen ps /////////////////////////////////////////////////////

    // /////////////////////////////////////////////////// edit dokumen ps ///////////////////////////////////////////////////////
    public function edit($id_dokumen, $fungsi = 'nol')
    {
        // ambil no order where id dokumen
        $fd = $this->db->get_where('dokumen_ps', ['id' => $id_dokumen])->row_array();
        // ambil inputan
        $no_dokumen = $this->input->post('no_dokumen', true);
        $nama_dokumen = $this->input->post('nama_dokumen', true);
        $tgl_dokumen = $this->input->post('tgl_dokumen', true);
        $status_dokumen = $this->input->post('status_dokumen', true);
        $revisi = $this->input->post('revisi', true);
        $edisi = $this->input->post('edisi', true);
        // $issue_sheet = $this->input->post('issue_sheet');
        $total1 = $this->input->post('total1', true);
        $total2 = $this->input->post('total2', true);
        $ukuran = $this->input->post('ukuran', true);
        $id_dd = $this->input->post('distribusi_dokumen', true);
        $status = $this->input->post('status', true);

        $date_update = date('Y-m-d');
        $user = $this->session->userdata('nama_karyawan');

        // file ps
        $file = $_FILES['file_ps']['name'];

        // file ps
        if ($file) {
            $this->load->model('Dokumen_model', 'dokumen');
            $nama_file = $this->dokumen->editPs($fd['nama_file'], $file);
            $this->db->set('nama_file', $nama_file);
        }
        // file ps

        $this->db->set('no_dokumen', $no_dokumen);
        $this->db->set('nama_dokumen', $nama_dokumen);
        $this->db->set('tgl_dokumen', $tgl_dokumen);
        $this->db->set('status_dokumen', $status_dokumen);
        $this->db->set('revisi', $revisi);
        $this->db->set('edisi', $edisi);
        // $this->db->set('issue_sheet', $issue_sheet);
        $this->db->set('total1', $total1);
        $this->db->set('total2', $total2);
        $this->db->set('ukuran', $ukuran);
        $this->db->set('id_dd', $id_dd);
        $this->db->set('status', $status);
        $this->db->set('date_update', $date_update);
        $this->db->set('user', $user);

        $this->db->where('id =', $id_dokumen);
        $this->db->update('dokumen_ps');

        $this->session->set_flashdata('messageDokumen', '<div class="alert alert-success" role="alert">Dokumen Production Schedule berhasil diubah!</div>');
        redirect('order/dokumen/' . $fd['no_order'] . '/' . $fungsi);
    }
    // ////////////////////////////////////////////////// edit dokumen ps ///////////////////////////////////////////////////////

    // //////////////////////////////////////////////// revisi dokumen ps ///////////////////////////////////////////////////////
    public function revisi($kode_unik, $no_order, $fungsi = 'nol')
    {
        $data['fungsi'] = $fungsi;
        $data['title'] = 'List Order';
        $data['judul'] = 'Revisi Dokumen | SIDE-BBI';
        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['kode_unik'] = $kode_unik;
        $data['no_order'] = $no_order;
        // ambil data status dokumen
        $data['status_dokumen'] = $this->db->get('status_dokumen')->result_array();
        // ambil data edisi
        $data['edisi'] = $this->db->get('edisi')->result_array();
        // ambil data revisi
        $data['revisi'] = $this->db->get('revisi')->result_array();
        // ambil dokumen drawing where kode unik
        $this->db->select('dokumen_ps.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
        $this->db->from('dokumen_ps');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_ps.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_ps.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_ps.revisi', 'left');
        $this->db->join('distribusi_dokumen', 'distribusi_dokumen.id_dd = dokumen_ps.id_dd', 'left');
        $this->db->where('dokumen_ps.kode_unik =', $kode_unik);
        $data['dd'] = $this->db->get()->row_array();

        $data['disdok'] = $this->db->get('distribusi_dokumen')->result_array();

        // user validation 
        $this->form_validation->set_rules('no_dokumen', 'No Dokumen', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/header', $data);
            $this->load->view('dokumen/revisi-ps', $data);
            $this->load->view('template/footer', $data);
        } else {
            $no_dokumen = $this->input->post('no_dokumen');
            $nama_dokumen = $this->input->post('nama_dokumen');
            $tgl_dokumen = $this->input->post('tgl_dokumen');

            $status_dokumen = $this->input->post('status_dokumen');
            $revisi = $this->input->post('revisi');
            $edisi = $this->input->post('edisi');
            // $issue_sheet = $this->input->post('issue_sheet');

            $total1 = $this->input->post('total1');
            $total2 = $this->input->post('total2');
            $ukuran = $this->input->post('ukuran');
            $id_dd = $this->input->post('distribusi_dokumen');

            // ubah status dokumen menjadi tidak valid / 0
            $this->db->set('status', 0);
            $this->db->where('kode_unik =', $kode_unik);
            $this->db->update('dokumen_ps');

            // cek jumlah dokumen mscurve where no_dokumen dan status valid
            $this->db->select('*');
            $this->db->from('dokumen_ps');
            $this->db->where('no_dokumen =', $no_dokumen);
            $this->db->where('status =', 1);
            $cDV = $this->db->get()->num_rows();

            if ($cDV == 0) {

                // insert dokumen ps baru berdasarkan revisi
                $date_created = date('Y-m-d');
                $user = $this->session->userdata('nama_karyawan');
                $kode_unik = sha1(time());

                // upload file revisi
                $file = $_FILES['file_ps']['name'];

                $this->load->model('Dokumen_model', 'dokumen');
                $nama_file = $this->dokumen->revisiPs($file);

                $data = [

                    'no_order' => $no_order,
                    'no_dokumen' => $no_dokumen,
                    'nama_dokumen' => $nama_dokumen,
                    'tgl_dokumen' => $tgl_dokumen,
                    'status_dokumen' => $status_dokumen,
                    'revisi' => $revisi,
                    'edisi' => $edisi,
                    // 'issue_sheet' => $issue_sheet,
                    'total1' => $total1,
                    'total2' => $total2,
                    'ukuran' => $ukuran,
                    'id_dd' => $id_dd,
                    'status' => 1,
                    'nama_file' => $nama_file,
                    'date_created' => $date_created,
                    'user' => $user,
                    'kode_unik' => $kode_unik

                ];

                $this->db->insert('dokumen_ps', $data);
            }

            $this->session->set_flashdata('messageDokumen', '<div class="alert alert-success" role="alert">Dokumen Production Schedule berhasil direvisi!</div>');
            redirect('order/dokumen/' . $no_order . '/' . $fungsi);
        }
    }
    // ///////////////////////////////////////////////// revisi dokumen ps ///////////////////////////////////////////////////////

    // //////////////////////////////////////////////// history dokumen ps ///////////////////////////////////////////////////////
    public function history($kode_unik, $no_order)
    {

        $data['title'] = 'List Order';
        $data['judul'] = 'Histori Dokumen | SIDE-BBI';


        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

        // ambil dokumen mscurve where kode unik
        $d = $this->db->get_where('dokumen_ps', ['kode_unik' => $kode_unik])->row_array();
        $no_dokumen = $d['no_dokumen'];

        $data['no_order'] = $no_order;

        // ambil dokumen ps where no dokumen, status
        $this->db->select('dokumen_ps.*, nama_status, nama_edisi, nama_revisi');
        $this->db->from('dokumen_ps');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_ps.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_ps.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_ps.revisi', 'left');
        $this->db->where('dokumen_ps.no_dokumen =', $no_dokumen);
        $this->db->where('dokumen_ps.status =', 0);
        $data['dokumen_history'] = $this->db->get()->result_array();

        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('dokumen/history-ps', $data);
        $this->load->view('template/footer', $data);
    }
    // //////////////////////////////////////////////// history dokumen ps ///////////////////////////////////////////////////////

    // //////////////////////////////////////////////// viewer dokumen ps ////////////////////////////////////////////////////////
    public function viewer($nama_file)
    {

        // ambil dokumen_ps where nama_file
        $this->db->select('dokumen_ps.*, nama_status, nama_edisi, nama_revisi');
        $this->db->from('dokumen_ps');
        $this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_ps.status_dokumen', 'left');
        $this->db->join('edisi', 'edisi.id_edisi = dokumen_ps.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = dokumen_ps.revisi', 'left');
        $this->db->where('dokumen_ps.nama_file =', $nama_file);
        $data['dokumen'] = $this->db->get()->row_array();

        $data['title'] = 'Viewer ' . $data['dokumen']['nama_dokumen'];
        $data['judul'] = 'Viewer Document | SIDE-BBI';

        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

        // ambil dokumen_view where nama_file, jenis
        $this->db->select('*');
        $this->db->from('dokumen_view');
        $this->db->where('nama_file =', $nama_file);
        $this->db->where('jenis_dokumen =', 'Production Schedule');
        $data['viewer'] = $this->db->get()->result_array();

        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('dokumen/viewer', $data);
        $this->load->view('template/footer', $data);
    }
    // //////////////////////////////////////////////// viewer dokumen ps ////////////////////////////////////////////////////////

    // //////////////////////////////////////////////// hapus dokumen ps ////////////////////////////////////////////////////////
    public function hapus($id_dokumen, $no_order, $nama_file, $fungsi = 'nol')
    {

        $this->db->where('id =', $id_dokumen);
        $this->db->delete('dokumen_ps');

        if ($nama_file != '' or $nama_file != NULL) {

            if (file_exists('assets/file/ps/' . $nama_file)) {
                unlink(FCPATH . 'assets/file/ps/' . $nama_file);
            }
        }

        $this->session->set_flashdata('messageDokumen', '<div class="alert alert-success" role="alert">Dokumen Production Schedule berhasil dihapus!</div>');

        redirect('order/dokumen/' . $no_order . '/' . $fungsi);
    }
    // //////////////////////////////////////////////// hapus dokumen ps ////////////////////////////////////////////////////////


}
