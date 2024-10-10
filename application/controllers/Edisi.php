<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edisi extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');		
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
		cekSessionLogin();
		// admin_access();

	}

// ///////////////////////////////////////////////////////////////// list edisi ////////////////////////////////////////////////////////////////
	public function index()
	{	

		$data['title'] = 'Kelola Edisi';
		$data['judul'] = 'Kelola Edisi | SIDE-BBI';
		
		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// Ambil Data Menu
		$this->db->select('*');
		$this->db->from('edisi');
		$data['edisi'] = $this->db->get()->result_array();

		// user validation 
		$this->form_validation->set_rules('nama_edisi', 'Edisi', 'required|trim');

		if ($this->form_validation->run() == false) {

			$this->load->view('template/sidebar', $data);
			$this->load->view('template/header', $data);
			$this->load->view('edisi/list-edisi', $data);
			$this->load->view('template/footer', $data);

		} else {

			$nama_edisi = $this->input->post('nama_edisi');

			// cek ketersediaan edisi
			$this->db->where('nama_edisi =', $nama_edisi);
			$cek_edisi = $this->db->get('edisi');

			if ($cek_edisi->num_rows() == 1) {

				$this->session->set_flashdata('messageEdisi','<div class="alert alert-danger" role="alert">Edisi sudah terdaftar!</div>');
				redirect('edisi');

			}

			$kode_unik = sha1(time());
			$user = $this->session->userdata('nama_karyawan');

			$data = [

				'nama_edisi' => $nama_edisi,
				'kode_unik' => $kode_unik,
				'user' => $user
			];


			$this->db->insert('edisi', $data);

			$this->session->set_flashdata('messageEdisi','<div class="alert alert-success" role="alert">Edisi baru berhasil ditambahkan!</div>');
			redirect('edisi');

		}

	}
// ///////////////////////////////////////////////////////////////// list edisi ////////////////////////////////////////////////////////////////

// ///////////////////////////////////////////////////////////////// edit edisi ////////////////////////////////////////////////////////////////
	public function edit($id_edisi)
	{	

		$nama_edisi = $this->input->post('nama_edisi');

		// var_dump($nama_edisi); die;

		$this->db->set('nama_edisi', $nama_edisi);
		$this->db->where('id_edisi =', $id_edisi);
		$this->db->update('edisi');

		$this->session->set_flashdata('messageEdisi','<div class="alert alert-success" role="alert">Edisi berhasil diubah!</div>');
		redirect('edisi');

	}
// ///////////////////////////////////////////////////////////////// edit edisi ////////////////////////////////////////////////////////////////

// //////////////////////////////////////////////////////////////// hapus edisi ////////////////////////////////////////////////////////////////
	public function hapus($id_edisi)
	{
		
		// hapus tabel 'edisi' berdasarkan 'id_edisi'
		$this->db->where('id_edisi =', $id_edisi);
		$this->db->delete('edisi');
		$this->session->set_flashdata('messageEdisi','<div class="alert alert-success" role="alert">Edisi berhasil dihapus!</div>');

		redirect('edisi');

	}
// //////////////////////////////////////////////////////////////// hapus edisi ////////////////////////////////////////////////////////////////



}