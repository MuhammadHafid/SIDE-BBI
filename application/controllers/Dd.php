<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dd extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		cekSessionLogin();
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
	}

// /////////////////////////////////////////////////// list document distribution /////////////////////////////////////////////////////
	public function index()
	{
		
		$data['title'] = 'Distribusi Dokumen';
		$data['judul'] = 'Distribusi Dokumen | SIDE-BBI';

		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// data order
		$data['distribusi_dokumen'] = $this->db->get('distribusi_dokumen')->result_array();

		// validation 
		$this->form_validation->set_rules('judul_dokumen', 'Judul', 'required|trim');

		if ($this->form_validation->run() == false) {

			$this->load->view('template/header', $data);
			$this->load->view('template/sidebar', $data);
			$this->load->view('engineering/dd/distribusi-dokumen', $data);
			$this->load->view('template/footer', $data);

		} else {

			$judul_dokumen = $this->input->post('judul_dokumen', true);
			$exp_dokumen = $this->input->post('exp_dokumen', true);		
			$ppc = $this->input->post('ppc', true);
			$qc = $this->input->post('qc', true);
			$qa = $this->input->post('qa', true);
			$fab = $this->input->post('fab', true);
			$mm = $this->input->post('mm', true);
			$log = $this->input->post('log', true);
			$keu = $this->input->post('keu', true);
			$eng = $this->input->post('eng', true);
			$prod = $this->input->post('prod', true);
			$hrd = $this->input->post('hrd', true);
			$sales = $this->input->post('sales', true);
			$mpi = $this->input->post('mpi', true);

			$jml_dokumen = intval($ppc) + intval($qc) + intval($qa) + intval($fab) + intval($mm) + intval($log) + intval($keu) + intval($eng) + intval($exp_dokumen) + intval($prod) + intval($hrd) + intval($sales) + intval($mpi);

			$kode_unik = sha1(time());

			// insert
			$data = [
				'judul_dokumen' => $judul_dokumen,
				'jml_dokumen' => $jml_dokumen,
				'ppc' => $ppc,
				'qc' => $qc,
				'qa' => $qa,
				'fab' => $fab,
				'mm' => $mm,				
				'log' => $log,
				'keu' => $keu,
				'eng' => $eng,
				'prod' => $prod,				
				'hrd' => $hrd,
				'sales' => $sales,
				'mpi' => $mpi,
				'exp_dokumen' => $exp_dokumen,
				'kode_unik' => $kode_unik
			];

			$this->db->insert('distribusi_dokumen', $data);

			$this->session->set_flashdata('messageDd','<div class="alert alert-success" role="alert">Data berhasil ditambahkan!</div>');
			redirect('dd');

		}
	}
// /////////////////////////////////////////////////// list document distribution /////////////////////////////////////////////////////

// /////////////////////////////////////////////////// edit document distribution /////////////////////////////////////////////////////
	public function edit($id_dd)
	{
		
		$judul_dokumen = $this->input->post('judul_dokumen', true);
		$exp_dokumen = $this->input->post('exp_dokumen', true);		
		$ppc = $this->input->post('ppc', true);
		$qc = $this->input->post('qc', true);
		$qa = $this->input->post('qa', true);
		$fab = $this->input->post('fab', true);
		$mm = $this->input->post('mm', true);
		$log = $this->input->post('log', true);
		$keu = $this->input->post('keu', true);
		$eng = $this->input->post('eng', true);
		$prod = $this->input->post('prod', true);
		$hrd = $this->input->post('hrd', true);
		$sales = $this->input->post('sales', true);
		$mpi = $this->input->post('mpi', true);
		$jml_dokumen = intval($ppc) + intval($qc) + intval($qa) + intval($fab) + intval($mm) + intval($log) + intval($keu) + intval($eng) + intval($exp_dokumen) + intval($prod) + intval($hrd) + intval($sales) + intval($mpi);

		// update
		$data = [
			'judul_dokumen' => $judul_dokumen,
			'jml_dokumen' => $jml_dokumen,			
			'ppc' => $ppc,
			'qc' => $qc,
			'qa' => $qa,
			'fab' => $fab,
			'mm' => $mm,				
			'log' => $log,
			'keu' => $keu,
			'eng' => $eng,
			'prod' => $prod,				
			'hrd' => $hrd,
			'sales' => $sales,
			'mpi' => $mpi,			
			'exp_dokumen' => $exp_dokumen			
		];

		$this->db->where('id_dd', $id_dd);
		$this->db->update('distribusi_dokumen', $data);

		$this->session->set_flashdata('messageDd','<div class="alert alert-success" role="alert">Data berhasil diupdate!</div>');
		redirect('dd');

	}
// /////////////////////////////////////////////////// edit document distribution /////////////////////////////////////////////////////

// ////////////////////////////////////////////////// hapus document distribution ///////////////////////////////////////////////////
	public function hapus($id_dd)
	{
		
		// hapus tabel 'distribusi_dokumen' berdasarkan 'id_dd'
		$this->db->where('id_dd =', $id_dd);
		$this->db->delete('distribusi_dokumen');
		$this->session->set_flashdata('messageDd','<div class="alert alert-success" role="alert">Data berhasil dihapus!</div>');

		redirect('dd');

	}
// ////////////////////////////////////////////////// hapus document distribution ///////////////////////////////////////////////////




}