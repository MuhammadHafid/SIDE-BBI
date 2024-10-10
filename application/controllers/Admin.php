<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->db_keuangan = $this->load->database('keuangan', TRUE);

		cekSessionLogin();
	}

	// //////////////////////////////////////////////////////////// dashboard admin  ////////////////////////////////////////////////////////////////
	public function index()
	{

		$data['title'] = 'Dashboard';
		$data['judul'] = 'Dashboard | SIDE-BBI';
		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('template/footer', $data);
	}
	// //////////////////////////////////////////////////////////// dashboard admin  ////////////////////////////////////////////////////////////////


}
