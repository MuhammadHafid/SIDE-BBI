<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Revisi extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');		
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
		cekSessionLogin();
		// admin_access();

	}

// ///////////////////////////////////////////////////////////////// list revisi ///////////////////////////////////////////////////////////////
	public function index()
	{	

		$data['title'] = 'Kelola Revisi';
		$data['judul'] = 'Kelola Revisi | SIDE-BBI';
		
		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// ambil data revisi
		$this->db->select('*');
		$this->db->from('revisi');
		$data['revisi'] = $this->db->get()->result_array();

		// user validation 
		$this->form_validation->set_rules('nama_revisi', 'Revisi', 'required|trim');

		if ($this->form_validation->run() == false) {

			$this->load->view('template/sidebar', $data);
			$this->load->view('template/header', $data);
			$this->load->view('revisi/list-revisi', $data);
			$this->load->view('template/footer', $data);

		} else {

			$nama_revisi = $this->input->post('nama_revisi');

			// cek ketersediaan revisi
			$this->db->where('nama_revisi =', $nama_revisi);
			$cek_revisi = $this->db->get('revisi');

			if ($cek_revisi->num_rows() == 1) {

				$this->session->set_flashdata('messageRevisi','<div class="alert alert-danger" role="alert">Revisi sudah terdaftar!</div>');
				redirect('revisi');

			}

			$kode_unik = sha1(time());
			$user = $this->session->userdata('nama_karyawan');

			$data = [

				'nama_revisi' => $nama_revisi,
				'kode_unik' => $kode_unik,
				'user' => $user
			];


			$this->db->insert('revisi', $data);

			$this->session->set_flashdata('messageRevisi','<div class="alert alert-success" role="alert">Revisi baru berhasil ditambahkan!</div>');
			redirect('revisi');

		}

	}
// ///////////////////////////////////////////////////////////////// list revisi ///////////////////////////////////////////////////////////////

// ///////////////////////////////////////////////////////////////// edit revisi ///////////////////////////////////////////////////////////////
	public function edit($id_revisi)
	{	

		$nama_revisi = $this->input->post('nama_revisi');

		$this->db->set('nama_revisi', $nama_revisi);
		$this->db->where('id_revisi =', $id_revisi);
		$this->db->update('revisi');

		$this->session->set_flashdata('messageRevisi','<div class="alert alert-success" role="alert">Revisi berhasil diubah!</div>');
		redirect('revisi');

	}
// ///////////////////////////////////////////////////////////////// edit revisi ///////////////////////////////////////////////////////////////

// //////////////////////////////////////////////////////////////// hapus revisi ///////////////////////////////////////////////////////////////
	public function hapus($id_revisi)
	{
		
		// hapus tabel 'revisi' berdasarkan 'id_revisi'
		$this->db->where('id_revisi =', $id_revisi);
		$this->db->delete('revisi');
		$this->session->set_flashdata('messageRevisi','<div class="alert alert-success" role="alert">Revisi berhasil dihapus!</div>');

		redirect('revisi');

	}
// //////////////////////////////////////////////////////////////// hapus revisi ///////////////////////////////////////////////////////////////



}