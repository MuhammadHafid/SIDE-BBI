<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');

	}

// //////////////////////////////////////////////////////////// list barang ////////////////////////////////////////////////////////////////
	public function index()
	{
		
		$data['title'] = 'List Barang | SDO-BBI';
		$data['user'] = $this->db->get_where('user', ['user' => $this->session->userdata('user')])->row_array();

		// ambil data barang
		$this->db->select('*');
		$this->db->from('barang');
		$data['barang'] = $this->db->get()->result_array();

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('barang/list-barang', $data);
		$this->load->view('template/footer', $data);

	}
// //////////////////////////////////////////////////////////// list barang ////////////////////////////////////////////////////////////////


}
