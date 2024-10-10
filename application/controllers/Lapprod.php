<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lapprod extends CI_Controller
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

    // //////////////////////////////////////////////////// laporan produksi /////////////////////////////////////////////////////
    public function index()
    {
        $data['title'] = 'Laporan Produksi';
        $data['judul'] = 'Laporan Produksi | SIDE-BBI';

        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();
        // ambil nama role berdasarkan id role dari session
        $role = $this->db->get_where('role', ['id_role' => $this->session->userdata('id_role')])->row_array();
        $nama_role = $role['nama_role'];
        $data['nama_role'] = $nama_role;

        // ambil data edisi
        $data['edisi'] = $this->db->get('edisi')->result_array();
        // ambil data revisi
        $data['revisi'] = $this->db->get('revisi')->result_array();

        // ambil data laporan produksi
        $this->db->select('laporan_produksi.*, nama_edisi, nama_revisi');
        $this->db->from('laporan_produksi');
        $this->db->join('edisi', 'laporan_produksi.edisi = edisi.id_edisi', 'left');
        $this->db->join('revisi', 'laporan_produksi.revisi = revisi.id_revisi', 'left');
        $this->db->where('status =', 1);
        $data['laporan_produksi'] = $this->db->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('laporan-produksi/list-laporan-produksi', $data);
        $this->load->view('template/footer', $data);
    }
    // //////////////////////////////////////////////////// laporan produksi /////////////////////////////////////////////////////

    // //////////////////////////////////////////////// tambah laporan produksi  /////////////////////////////////////////////////
    public function tambah()
    {
        // ambil inputan
        $no_dokumen = $this->input->post('no_dokumen');
        $nama_dokumen = $this->input->post('nama_dokumen');
        $divisi = $this->input->post('divisi');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $tgl_pembuatan = $this->input->post('tgl_pembuatan');
        $edisi = $this->input->post('edisi');
        $revisi = $this->input->post('revisi');
        $nama_file = '';

        $date_created = date('Y-m-d');
        $user = $this->session->userdata('nama_karyawan');
        $kode_unik = sha1(time());

        // file laporan produksi
        $file = $_FILES['file_laporan']['name'];

        // cek apakah nomor dokumen sudah terdaftar ?
        $cekNoDok = $this->db->get_where('laporan_produksi', ['no_dokumen' => $no_dokumen])->num_rows();

        if ($cekNoDok >= 1) {
            $this->session->set_flashdata('messageLapprod', '<div class="alert alert-danger" role="alert">No dokumen sudah terdaftar!</div>');
            redirect('lapprod');
        }

        // file laporan produksi
        if ($file) {
            $this->load->model('Dokumen_model', 'dokumen');
            $nama_file = $this->dokumen->tambahLapprod($file);
        }
        // file laporan produksi

        $data = [
            'no_dokumen' => $no_dokumen,
            'nama_dokumen' => $nama_dokumen,
            'divisi' => $divisi,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tgl_pembuatan' => $tgl_pembuatan,
            'edisi' => $edisi,
            'revisi' => $revisi,
            'status' => 1,
            'nama_file' => $nama_file,
            'date_created' => $date_created,
            'user' => $user,
            'kode_unik' => $kode_unik
        ];

        $this->db->insert('laporan_produksi', $data);

        $this->session->set_flashdata('messageLapprod', '<div class="alert alert-success" role="alert">Laporan Produksi berhasil ditambahkan!</div>');

        // $encrypt_no_order = $this->secure->encrypt_url($no_order);
        redirect('lapprod');
    }
    // //////////////////////////////////////////////// tambah laporan produksi  /////////////////////////////////////////////////

    // ///////////////////////////////////////////////// view laporan produksi  //////////////////////////////////////////////////
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

        $jenis_dokumen = 'Laporan Produksi';
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

        $this->load->view('dokumen/view-laporan-produksi', $data);
    }
    // ///////////////////////////////////////////////// view laporan produksi //////////////////////////////////////////////////

    // //////////////////////////////////////////////// edit laporan produksi ///////////////////////////////////////////////////
    public function edit($kode_unik)
    {
        $data['title'] = 'Edit Laporan Produksi';
        $data['judul'] = 'Edit Laporan Produksi | SIDE-BBI';
        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

        // ambil data edisi
        $data['edisi'] = $this->db->get('edisi')->result_array();
        // ambil data revisi
        $data['revisi'] = $this->db->get('revisi')->result_array();
        // ambil laporan produksi where kode unik
        $this->db->select('laporan_produksi.*, nama_edisi, nama_revisi');
        $this->db->from('laporan_produksi');
        $this->db->join('edisi', 'edisi.id_edisi = laporan_produksi.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = laporan_produksi.revisi', 'left');
        $this->db->where('laporan_produksi.kode_unik =', $kode_unik);
        $data['laporan'] = $this->db->get()->row_array();

        // user validation 
        $this->form_validation->set_rules('no_dokumen', 'No Dokumen', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/header', $data);
            $this->load->view('dokumen/edit-laporan-produksi', $data);
            $this->load->view('template/footer', $data);
        } else {

            // ambil inputan
            $no_dokumen = $this->input->post('no_dokumen');
            $nama_dokumen = $this->input->post('nama_dokumen');
            $divisi = $this->input->post('divisi');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $tgl_pembuatan = $this->input->post('tgl_pembuatan');
            $edisi = $this->input->post('edisi');
            $revisi = $this->input->post('revisi');

            $date_update = date('Y-m-d');
            $user = $this->session->userdata('nama_karyawan');

            // file laporan produksi
            $file = $_FILES['file_laporan']['name'];
            if ($file) {
                $this->load->model('Dokumen_model', 'dokumen');
                $nama_file = $this->dokumen->editLapprod($data['laporan']['nama_file'], $file);
                $this->db->set('nama_file', $nama_file);
            }
            // file laporan produksi

            $this->db->set('no_dokumen', $no_dokumen);
            $this->db->set('nama_dokumen', $nama_dokumen);
            $this->db->set('divisi', $divisi);
            $this->db->set('bulan', $bulan);
            $this->db->set('tahun', $tahun);
            $this->db->set('tgl_pembuatan', $tgl_pembuatan);
            $this->db->set('edisi', $edisi);
            $this->db->set('revisi', $revisi);

            $this->db->set('date_update', $date_update);
            $this->db->set('user', $user);

            $this->db->where('kode_unik =', $kode_unik);
            $this->db->update('laporan_produksi');

            $this->session->set_flashdata('messageLapprod', '<div class="alert alert-success" role="alert">Laporan Produksi berhasil diedit!</div>');
            redirect('lapprod');
        }
    }
    // //////////////////////////////////////////////// edit laporan produksi ///////////////////////////////////////////////////

    // //////////////////////////////////////////////// hapus laporan produksi /////////////////////////////////////////////////
    public function hapus($id, $nama_file)
    {

        $this->db->where('id =', $id);
        $this->db->delete('laporan_produksi');

        if ($nama_file != '' or $nama_file != NULL) {
            if (file_exists('assets/file/lapprod/' . $nama_file)) {
                unlink(FCPATH . 'assets/file/lapprod/' . $nama_file);
            }
        }
        $this->session->set_flashdata('messageLapprod', '<div class="alert alert-success" role="alert">Dokumen berhasil dihapus!</div>');
        redirect('lapprod');
    }
    // //////////////////////////////////////////////// hapus laporan produksi /////////////////////////////////////////////////

    // /////////////////////////////////////////////// revisi laporan produksi /////////////////////////////////////////////////
    public function revisi($kode_unik)
    {

        $data['title'] = 'Revisi Laporan Produksi';
        $data['judul'] = 'Revisi Dokumen | SIDE-BBI';
        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();
        $data['kode_unik'] = $kode_unik;
        // ambil data edisi
        $data['edisi'] = $this->db->get('edisi')->result_array();
        // ambil data revisi
        $data['revisi'] = $this->db->get('revisi')->result_array();
        // ambil laporan produksi where kode unik
        $this->db->select('laporan_produksi.*, nama_edisi, nama_revisi');
        $this->db->from('laporan_produksi');
        $this->db->join('edisi', 'edisi.id_edisi = laporan_produksi.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = laporan_produksi.revisi', 'left');
        $this->db->where('laporan_produksi.kode_unik =', $kode_unik);
        $data['laporan'] = $this->db->get()->row_array();

        // user validation 
        $this->form_validation->set_rules('no_dokumen', 'No Dokumen', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/header', $data);
            $this->load->view('dokumen/revisi-laporan-produksi', $data);
            $this->load->view('template/footer', $data);
        } else {

            $no_dokumen = $this->input->post('no_dokumen');
            $nama_dokumen = $this->input->post('nama_dokumen');
            $divisi = $this->input->post('divisi');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $tgl_pembuatan = $this->input->post('tgl_pembuatan');
            $edisi = $this->input->post('edisi');
            $revisi = $this->input->post('revisi');

            // ubah status dokumen menjadi tidak valid / 0
            $this->db->set('status', 0);
            $this->db->where('kode_unik =', $kode_unik);
            $this->db->update('laporan_produksi');

            // cek jumlah laporan produksi where no_dokumen dan status valid
            $this->db->select('*');
            $this->db->from('laporan_produksi');
            $this->db->where('no_dokumen =', $no_dokumen);
            $this->db->where('status =', 1);
            $cDV = $this->db->get()->num_rows();

            if ($cDV == 0) {
                // insert laporan produksi baru berdasarkan revisi
                $date_created = date('Y-m-d');
                $user = $this->session->userdata('nama_karyawan');
                $kode_unik = sha1(time());

                // upload file revisi
                $file = $_FILES['file_laporan']['name'];

                $this->load->model('Dokumen_model', 'dokumen');
                $nama_file = $this->dokumen->revisiLapprod($file);

                $data = [
                    'no_dokumen' => $no_dokumen,
                    'nama_dokumen' => $nama_dokumen,
                    'divisi' => $divisi,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'tgl_pembuatan' => $tgl_pembuatan,
                    'edisi' => $edisi,
                    'revisi' => $revisi,
                    'status' => 1,
                    'nama_file' => $nama_file,
                    'date_created' => $date_created,
                    'user' => $user,
                    'kode_unik' => $kode_unik
                ];

                $this->db->insert('laporan_produksi', $data);
            }

            $this->session->set_flashdata('messageLapprod', '<div class="alert alert-success" role="alert">Laporan Produksi berhasil direvisi!</div>');
            redirect('lapprod');
        }
    }
    // /////////////////////////////////////////////// revisi laporan produksi /////////////////////////////////////////////////

    // ////////////////////////////////////////////// history laporan produksi /////////////////////////////////////////////////
    public function history($kode_unik)
    {

        $data['title'] = 'Histori Dokumen';
        $data['judul'] = 'Histori Dokumen | SIDE-BBI';

        $data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

        // ambil laporan produksi where kode unik
        $d = $this->db->get_where('laporan_produksi', ['kode_unik' => $kode_unik])->row_array();
        $no_dokumen = $d['no_dokumen'];

        // ambil laporan produksi where no dokumen
        $this->db->select('laporan_produksi.*, nama_edisi, nama_revisi');
        $this->db->from('laporan_produksi');
        $this->db->join('edisi', 'edisi.id_edisi = laporan_produksi.edisi', 'left');
        $this->db->join('revisi', 'revisi.id_revisi = laporan_produksi.revisi', 'left');
        $this->db->where('laporan_produksi.no_dokumen =', $no_dokumen);
        $this->db->where('laporan_produksi.status =', 0);
        $data['dokumen_history'] = $this->db->get()->result_array();

        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('dokumen/history-laporan-produksi', $data);
        $this->load->view('template/footer', $data);
    }
    // ////////////////////////////////////////////// history laporan produksi /////////////////////////////////////////////////




























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
