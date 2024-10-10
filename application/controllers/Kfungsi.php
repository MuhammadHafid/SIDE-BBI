<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kfungsi extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
		cekSessionLogin();

	}

// //////////////////////////////////////////////////////////// list kode fungsi ///////////////////////////////////////////////////////////////
	public function index()
	{	

		$data['title'] = 'Kode Fungsi';
		$data['judul'] = 'Kode Fungsi | SIDE-BBI';

		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// ambil data kode_fungsi
		$this->db->select('a.*, b.nama_cc_ord');
		$this->db->from('sdo.kode_fungsi a');
		$this->db->join('keuangan.cc_ord b','b.id_cc_ord = a.organisasi','left');
		$data['kode_fungsi'] = $this->db->get()->result_array();

		// ambil data cc_ord
		$this->db->select('*');
		$this->db->from('keuangan.cc_ord');
		$this->db->where('grup =','cc');
		$data['cc_ord'] = $this->db->get()->result_array();

		$this->load->view('template/sidebar', $data);
		$this->load->view('template/header', $data);
		$this->load->view('admin/kode/kode-fungsi', $data);
		$this->load->view('template/footer');

	}
// //////////////////////////////////////////////////////////// list kode fungsi ///////////////////////////////////////////////////////////////

// //////////////////////////////////////////////////////////// edit kode fungsi ///////////////////////////////////////////////////////////////
	public function edit($id)
	{	

		$data['title'] = 'Edit Kode Fungsi';
		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		$kode_fungsi = $this->input->post('kode_fungsi');

		$this->db->set('kode_fungsi', $kode_fungsi);
		$this->db->where('id =', $id);
		$this->db->update('keuangan.cc_ord');

		$this->session->set_flashdata('messageKode','<div class="alert alert-success" role="alert">Kode fungsi berhasil diperbarui!</div>');
		redirect('Kfungsi');

	}
// //////////////////////////////////////////////////////////// edit kode fungsi ///////////////////////////////////////////////////////////////

// /////////////////////////////////////////////////////////// hapus kode fungsi ///////////////////////////////////////////////////////////////
	public function hapus($id)
	{
		
		$this->db->where('id =', $id);
		$this->db->delete('kode_fungsi');
		$this->session->set_flashdata('messageKode','<div class="alert alert-success" role="alert">Kode fungsi berhasil dihapus!</div>');

		redirect('Kfungsi');

	}
// /////////////////////////////////////////////////////////// hapus kode fungsi ///////////////////////////////////////////////////////////////











}