<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drawing extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->db_keuangan = $this->load->database('keuangan', TRUE);			

	}

// ///////////////////////////////////////////////////////// view dokumen drawing  ////////////////////////////////////////////////////////////
	public function view($nama_file)
	{

		$data['judul'] = $nama_file;
		$data['file'] = $nama_file;

		$nik = $this->session->userdata('nik');
		$jenis_dokumen = 'Drawing';
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
			$this->db->where('nama_file =', $nama_file);
			$this->db->where('nik =', $nik);		
			$this->db->update('dokumen_view');
		} else {
			// insert
			$data_view = [
				'nama_file' => $nama_file,
				'jenis_dokumen' => $jenis_dokumen,
				'nik' => $nik,
				'tgl_view' => $tgl_view			
			];
			$this->db->insert('dokumen_view', $data_view);
		}


		$this->load->view('dokumen/view-drawing', $data);

	}


// ///////////////////////////////////////////////////////// tambah dokumen drawing  ///////////////////////////////////////////////////////////
	public function tambah($no_order)
	{
		
		// ambil inputan
		$no_dokumen = $this->input->post('no_dokumen');
		$nama_dokumen = $this->input->post('nama_dokumen');
		$tgl_dokumen = $this->input->post('tgl_dokumen');
		$status_dokumen = $this->input->post('status_dokumen');		
		$revisi = $this->input->post('revisi');
		$edisi = $this->input->post('edisi');
		$issue_sheet = $this->input->post('issue_sheet');
		$total1 = $this->input->post('total1');
		$total2 = $this->input->post('total2');
		$ukuran = $this->input->post('ukuran');
		$nama_file = '';

		$date_created = date('Y-m-d');
		$user = $this->session->userdata('nama_karyawan');	
		$kode_unik = sha1(time());	

	 	// file drawing
		$file = $_FILES['file_drawing']['name'];

		// cek apakah nomor dokumen sudah terdaftar ?
		$cekNoDok = $this->db->get_where('dokumen_drawing',['no_dokumen'=>$no_dokumen])->num_rows();

		if ($cekNoDok == 1) {

			$this->session->set_flashdata('messageDokumen','<div class="alert alert-danger" role="alert">No dokumen sudah terdaftar!</div>');
			redirect('order/dokumen/'.$no_order);

		}


	    // file drawing
		if ($file) {

			$this->load->model('Dokumen_model', 'dokumen');
			$nama_file = $this->dokumen->tambahDrawing($file);

		}
	    // file drawing

		$data = [

			'no_order' => $no_order,
			'no_dokumen' => $no_dokumen,
			'nama_dokumen' => $nama_dokumen,			
			'tgl_dokumen' => $tgl_dokumen,
			'status_dokumen' => $status_dokumen,
			'revisi' => $revisi,
			'edisi' => $edisi,
			'issue_sheet' => $issue_sheet,
			'total1' => $total1,
			'total2' => $total2,
			'ukuran' => $ukuran,		
			'status' => 1,
			'nama_file' => $nama_file,
			'date_created' => $date_created,
			'user' => $user,
			'kode_unik' => $kode_unik									

		];

		$this->db->insert('dokumen_drawing', $data);

		$this->session->set_flashdata('messageDokumen','<div class="alert alert-success" role="alert">Dokumen drawing berhasil ditambahkan!</div>');
		redirect('order/dokumen/'.$no_order);

	}
// ///////////////////////////////////////////////////////// tambah dokumen drawing  ///////////////////////////////////////////////////////////

// ////////////////////////////////////////////////////////// edit dokumen drawing  ////////////////////////////////////////////////////////////
	public function edit($id_dokumen)
	{
		
		// ambil no order where id dokumen
		$fd = $this->db->get_where('dokumen_drawing',['id_dokumen' => $id_dokumen])->row_array();

		// ambil inputan
		$no_dokumen = $this->input->post('no_dokumen');
		$nama_dokumen = $this->input->post('nama_dokumen');
		$tgl_dokumen = $this->input->post('tgl_dokumen');
		$status_dokumen = $this->input->post('status_dokumen');		
		$revisi = $this->input->post('revisi');
		$edisi = $this->input->post('edisi');
		$issue_sheet = $this->input->post('issue_sheet');
		$total1 = $this->input->post('total1');
		$total2 = $this->input->post('total2');
		$ukuran = $this->input->post('ukuran');						
		$status = $this->input->post('status');		

		$date_update = date('Y-m-d');
		$user = $this->session->userdata('nama_karyawan');		

	 	// file drawing
		$file = $_FILES['file_drawing']['name'];

	    // file drawing
		if ($file) {

			$this->load->model('Dokumen_model', 'dokumen');
			$nama_file = $this->dokumen->editDrawing($fd['nama_file'], $file);
			$this->db->set('nama_file', $nama_file);

		}
	    // file drawing

		$this->db->set('no_dokumen', $no_dokumen);
		$this->db->set('nama_dokumen', $nama_dokumen);		
		$this->db->set('tgl_dokumen', $tgl_dokumen);
		$this->db->set('status_dokumen', $status_dokumen);
		$this->db->set('revisi', $revisi);
		$this->db->set('edisi', $edisi);
		$this->db->set('issue_sheet', $issue_sheet);
		$this->db->set('total1', $total1);
		$this->db->set('total2', $total2);
		$this->db->set('ukuran', $ukuran);
		$this->db->set('status', $status);				
		$this->db->set('date_update', $date_update);
		$this->db->set('user', $user);		

		$this->db->where('id_dokumen =', $id_dokumen);
		$this->db->update('dokumen_drawing');

		$this->session->set_flashdata('messageDokumen','<div class="alert alert-success" role="alert">Dokumen drawing berhasil diubah!</div>');
		redirect('order/dokumen/'.$fd['no_order']);

	}
// ////////////////////////////////////////////////////////// edit dokumen drawing  ////////////////////////////////////////////////////////////

// ///////////////////////////////////////////////////////// revisi dokumen drawing ////////////////////////////////////////////////////////////
	public function revisi($kode_unik, $no_order)
	{	

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
		$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_drawing');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_drawing.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_drawing.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_drawing.revisi','left');				
		$this->db->where('dokumen_drawing.kode_unik =', $kode_unik);
		$data['dd'] = $this->db->get()->row_array();

		// user validation 
		$this->form_validation->set_rules('no_dokumen', 'No Dokumen', 'required|trim');

		if ($this->form_validation->run() == false) {

			$this->load->view('template/sidebar', $data);
			$this->load->view('template/header', $data);
			$this->load->view('dokumen/revisi-drawing', $data);
			$this->load->view('template/footer', $data);

		} else {

			$no_dokumen = $this->input->post('no_dokumen');
			$nama_dokumen = $this->input->post('nama_dokumen');
			$tgl_dokumen = $this->input->post('tgl_dokumen');

			$status_dokumen = $this->input->post('status_dokumen');			
			$revisi = $this->input->post('revisi');			
			$edisi = $this->input->post('edisi');
			$issue_sheet = $this->input->post('issue_sheet');

			$total1 = $this->input->post('total1');
			$total2 = $this->input->post('total2');
			$ukuran = $this->input->post('ukuran');

			// ubah status dokumen menjadi tidak valid / 0
			$this->db->set('status', 0);
			$this->db->where('kode_unik =', $kode_unik);
			$this->db->update('dokumen_drawing');

			// insert dokumen drawing baru berdasarkan revisi

			$date_created = date('Y-m-d');
			$user = $this->session->userdata('nama_karyawan');	
			$kode_unik = sha1(time()); 

			// upload file revisi
			$file = $_FILES['file_drawing']['name'];

			$this->load->model('Dokumen_model', 'dokumen');
			$nama_file = $this->dokumen->revisiDrawing($file);

			$data = [

				'no_order' => $no_order,
				'no_dokumen' => $no_dokumen,
				'nama_dokumen' => $nama_dokumen,			
				'tgl_dokumen' => $tgl_dokumen,
				'status_dokumen' => $status_dokumen,
				'revisi' => $revisi,
				'edisi' => $edisi,
				'issue_sheet' => $issue_sheet,
				'total1' => $total1,
				'total2' => $total2,
				'ukuran' => $ukuran,			
				'status' => 1,
				'nama_file' => $nama_file,
				'date_created' => $date_created,
				'user' => $user,
				'kode_unik' => $kode_unik									

			];

			$this->db->insert('dokumen_drawing', $data);

			$this->session->set_flashdata('messageDokumen','<div class="alert alert-success" role="alert">Dokumen drawing berhasil direvisi!</div>');
			redirect('order/dokumen/'.$no_order);

		}

	}
// ///////////////////////////////////////////////////////// revisi dokumen drawing ////////////////////////////////////////////////////////////

// //////////////////////////////////////////////////////// history dokumen drawing ////////////////////////////////////////////////////////////
	public function history($kode_unik, $no_order)
	{
		
		$data['title'] = 'List Order';
		$data['judul'] = 'Histori Dokumen | SIDE-BBI';


		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// ambil dokumen drawing where kode unik
		$d = $this->db->get_where('dokumen_drawing',['kode_unik' => $kode_unik])->row_array();
		$no_dokumen = $d['no_dokumen'];

		$data['no_order'] = $no_order;

		// ambil dokumen drawing where no dokumen, status
		$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_drawing');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_drawing.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_drawing.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_drawing.revisi','left');				
		$this->db->where('dokumen_drawing.no_dokumen =', $no_dokumen);
		$this->db->where('dokumen_drawing.status =', 0);		
		$data['dokumen_history'] = $this->db->get()->result_array();

		$this->load->view('template/sidebar', $data);
		$this->load->view('template/header', $data);
		$this->load->view('dokumen/history-drawing', $data);
		$this->load->view('template/footer', $data);


	}
// //////////////////////////////////////////////////////// history dokumen drawing ////////////////////////////////////////////////////////////

// //////////////////////////////////////////////////////// viewer dokumen drawing ////////////////////////////////////////////////////////////
	public function viewer($nama_file)
	{
		
		// ambil dokumen_drawing where nama_file
		$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_drawing');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_drawing.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_drawing.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_drawing.revisi','left');				
		$this->db->where('dokumen_drawing.nama_file =', $nama_file);
		$data['dokumen'] = $this->db->get()->row_array();

		$data['title'] = 'Viewer '.$data['dokumen']['nama_dokumen'];
		$data['judul'] = 'Viewer Document | SIDE-BBI';

		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// ambil dokumen_view where nama_file, jenis
		$this->db->select('*');
		$this->db->from('dokumen_view');
		$this->db->where('nama_file =', $nama_file);
		$this->db->where('jenis_dokumen =', 'Drawing');
		$data['viewer'] = $this->db->get()->result_array();

		$this->load->view('template/sidebar', $data);
		$this->load->view('template/header', $data);
		$this->load->view('dokumen/viewer', $data);
		$this->load->view('template/footer', $data);


	}
// //////////////////////////////////////////////////////// viewer dokumen drawing ////////////////////////////////////////////////////////////

// ///////////////////////////////////////////////////////// hapus dokumen drawing  ////////////////////////////////////////////////////////////
	public function hapus($id_dokumen, $no_order, $nama_file){

		$this->db->where('id_dokumen =', $id_dokumen);
		$this->db->delete('dokumen_drawing');

		if ($nama_file != '' OR $nama_file != NULL) {

			unlink(FCPATH . 'assets/file/drawing/' . $nama_file);

		}

		$this->session->set_flashdata('messageDokumen','<div class="alert alert-success" role="alert">Dokumen Drawing berhasil dihapus!</div>');

		redirect('order/dokumen/'.$no_order);

	}
// ///////////////////////////////////////////////////////// hapus dokumen drawing  ////////////////////////////////////////////////////////////


}
