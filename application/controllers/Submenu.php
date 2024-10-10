<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submenu extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
		cekSessionLogin();

	}

// //////////////////////////////////////////////////////////////// list submenu ///////////////////////////////////////////////////////////////
	public function index()
	{	

		$data['title'] = 'Submenu';
		$data['judul'] = 'Manajemen Submenu | SIDE-BBI';

		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// ambil data 'submenu'
		$this->db->select('submenu.*, nama_menu');
		$this->db->from('submenu');
		$this->db->join('menu', 'submenu.id_menu = menu.id_menu', 'left');
		$data['submenu'] = $this->db->get()->result_array();

		// ambil data 'menu'
		$this->db->select('*');
		$this->db->from('menu');
		$this->db->where('submenu =', 1);
		$data['menu'] = $this->db->get()->result_array();

		// user validation 
		$this->form_validation->set_rules('nama_submenu', 'Submenu', 'required|trim');
		$this->form_validation->set_rules('url_submenu', 'URL', 'required|trim');
		$this->form_validation->set_rules('id_menu', 'Menu', 'required|trim');

		if ($this->form_validation->run() == false) {

			$this->load->view('template/sidebar', $data);
			$this->load->view('template/header', $data);
			$this->load->view('admin/menu/list-submenu', $data);
			$this->load->view('template/footer');

		} else {

			$nama_submenu = $this->input->post('nama_submenu');
			$url_submenu = $this->input->post('url_submenu');
			$id_menu = $this->input->post('id_menu');

			$kode_unik = sha1(time());

			$data = [

				'nama_submenu' => $nama_submenu,
				'url_submenu' => $url_submenu,
				'kode_unik' => $kode_unik,
				'id_menu' => $id_menu

			];


			$this->db->insert('submenu', $data);

			$this->session->set_flashdata('messageSubmenu','<div class="alert alert-success" role="alert">Submenu baru berhasil ditambahkan!</div>');
			redirect('submenu');

		}

	}
// //////////////////////////////////////////////////////////////// list submenu ///////////////////////////////////////////////////////////////

// ///////////////////////////////////////////////////////////////// edit menu /////////////////////////////////////////////////////////////////
	public function edit($id_submenu)
	{	

		$data['title'] = 'Edit Submenu';
		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		$nama_submenu = $this->input->post('nama_submenu');
		$url_submenu = $this->input->post('url_submenu');
		$id_menu = $this->input->post('id_menu');

		$this->db->set('nama_submenu', $nama_submenu);
		$this->db->set('url_submenu', $url_submenu);
		$this->db->set('id_menu', $id_menu);
		$this->db->where('id_submenu =', $id_submenu);
		$this->db->update('submenu');

		$this->session->set_flashdata('messageSubmenu','<div class="alert alert-success" role="alert">Submenu berhasil diupdate!</div>');
		redirect('submenu');

	}
// ///////////////////////////////////////////////////////////////// edit menu /////////////////////////////////////////////////////////////////

// /////////////////////////////////////////////////////////////// hapus submenu ///////////////////////////////////////////////////////////////
	public function hapus($id_submenu)
	{
		
		$this->db->where('id_submenu =', $id_submenu);
		$this->db->delete('submenu');
		$this->session->set_flashdata('messageSubmenu','<div class="alert alert-success" role="alert">Submenu berhasil dihapus!</div>');

		redirect('submenu');

	}
// /////////////////////////////////////////////////////////////// hapus submenu ///////////////////////////////////////////////////////////////











}