<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');		
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
		cekSessionLogin();
		// admin_access();

	}

// ///////////////////////////////////////////////////////////////// list menu /////////////////////////////////////////////////////////////////
	public function index()
	{	

		$data['title'] = 'Menu';
		$data['judul'] = 'Manajemen Menu | SIDE-BBI';
		
		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// Ambil Data Menu
		$this->db->select('*');
		$this->db->from('menu');
		$data['menu'] = $this->db->get()->result_array();

		// user validation 
		$this->form_validation->set_rules('nama_menu', 'Menu', 'required|trim');
		$this->form_validation->set_rules('url_menu', 'URL', 'required|trim');
		$this->form_validation->set_rules('icon_menu', 'Icon', 'required|trim');

		if ($this->form_validation->run() == false) {

			$this->load->view('template/sidebar', $data);
			$this->load->view('template/header', $data);
			$this->load->view('admin/menu/list-menu', $data);
			$this->load->view('template/footer', $data);

		} else {

			$nama_menu = $this->input->post('nama_menu');
			$url_menu = $this->input->post('url_menu');
			$icon_menu = $this->input->post('icon_menu');
			
			if ($this->input->post('submenu') != NULL) {
				$submenu = 1;
			} else {
				$submenu = 0;
			}

			// cek ketersediaan menu
			$this->db->where('nama_menu =', $nama_menu);
			$cek_menu = $this->db->get('menu');

			if ($cek_menu->num_rows() == 1) {

				$this->session->set_flashdata('messageMenu','<div class="alert alert-danger" role="alert">Nama menu sudah terdaftar!</div>');
				redirect('menu');

			}

			$kode_unik = sha1(time());

			$data = [

				'nama_menu' => $nama_menu,
				'url_menu' => $url_menu,
				'icon_menu' => $icon_menu,
				'kode_unik' => $kode_unik,
				'submenu' => $submenu
			];


			$this->db->insert('menu', $data);

			$this->session->set_flashdata('messageMenu','<div class="alert alert-success" role="alert">Menu baru berhasil ditambahkan!</div>');
			redirect('menu');

		}

	}
// ///////////////////////////////////////////////////////////////// list menu /////////////////////////////////////////////////////////////////

// ///////////////////////////////////////////////////////////////// edit menu /////////////////////////////////////////////////////////////////
	public function edit($id_menu)
	{	

		$data['title'] = 'Edit Gaji Pokok';
		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// Ambil data menu berdasarkan 'id_menu'
		$data['menu'] = $this->db->get_where('menu', array('id_menu' => $id_menu))->row_array();

		$nama_menu = $this->input->post('nama_menu');
		$url_menu = $this->input->post('url_menu');
		$icon_menu = $this->input->post('icon_menu');				
		$submenu = $this->input->post('submenu');

		$this->db->set('nama_menu', $nama_menu);
		$this->db->set('url_menu', $url_menu);		
		$this->db->set('icon_menu', $icon_menu);				
		$this->db->set('submenu', $submenu);
		$this->db->where('id_menu =', $id_menu);
		$this->db->update('menu');

		$this->session->set_flashdata('messageMenu','<div class="alert alert-success" role="alert">Menu berhasil diupdate!</div>');
		redirect('menu');

	}
// ///////////////////////////////////////////////////////////////// edit menu /////////////////////////////////////////////////////////////////

// //////////////////////////////////////////////////////////////// hapus menu /////////////////////////////////////////////////////////////////
	public function hapus($id_menu)
	{
		
		// hapus tabel 'role_akses' berdasarkan 'id_menu' 
		$this->db->where('id_menu =', $id_menu);
		$this->db->delete('role_akses');

		// hapus tabel 'submenu' berdasarkan 'id_menu'
		$this->db->where('id_menu =', $id_menu);
		$this->db->delete('submenu');

		// hapus tabel 'menu' berdasarkan 'id_menu'
		$this->db->where('id_menu =', $id_menu);
		$this->db->delete('menu');
		$this->session->set_flashdata('messageMenu','<div class="alert alert-success" role="alert">Menu berhasil dihapus!</div>');

		redirect('menu');

	}
// //////////////////////////////////////////////////////////////// hapus menu /////////////////////////////////////////////////////////////////



}