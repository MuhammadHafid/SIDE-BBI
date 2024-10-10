<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		cekSessionLogin();
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
	}

	// /////////////////////////////////////////////////////////////// list user ///////////////////////////////////////////////////////////////////
	public function index()
	{

		$data['title'] = 'Kelola User';
		$data['judul'] = 'User | SIDE-BBI';

		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// data user
		$this->db->select('a.*, b.nama_role, c.nama_karyawan');
		$this->db->from('sdo.user a');
		$this->db->join('sdo.role b', 'b.id_role = a.id_role', 'left');
		$this->db->join('keuangan.karyawan c', 'c.nik = a.nik', 'left');
		$data['users'] = $this->db->get()->result_array();

		// data role
		$data['role'] = $this->db->get('role')->result_array();

		// ambil data karyawan dari db keuangan
		$data['karyawan'] = $this->db_keuangan->get('karyawan')->result_array();


		// user validation 
		$this->form_validation->set_rules('nik', 'NIK', 'required|trim');
		$this->form_validation->set_rules('id_role', 'Role', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]|max_length[25]|callback_valid_password');
		$this->form_validation->set_rules('password2', 'Repeat Password', 'trim|matches[password]');

		if ($this->form_validation->run() == false) {

			$this->load->view('template/header', $data);
			$this->load->view('template/sidebar', $data);
			$this->load->view('admin/user/list-user', $data);
			$this->load->view('template/footer', $data);
		} else {

			// ambil inputan
			$nik = $this->input->post('nik');
			$id_role = $this->input->post('id_role');

			// cek apakah nik terdaftar sebegai karyawan ?
			$cekNIK = $this->db_keuangan->get_where('karyawan', ['nik' => $nik])->num_rows();

			if ($cekNIK < 1) {

				$this->session->set_flashdata('messageUser', '<div class="alert alert-danger" role="alert">NIK tidak valid!</div>');
				redirect('user');
			}

			// cek apakah nik sudah ada di tabel user ?
			$cekUser = $this->db->get_where('user', ['nik' => $nik])->num_rows();

			if ($cekUser == 1) {

				$this->session->set_flashdata('messageUser', '<div class="alert alert-danger" role="alert">NIK sudah terdaftar!</div>');
				redirect('user');
			}

			$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$date_created = date('Y-m-d');

			$data = [

				'nik' => $nik,
				'password' => $password,
				'id_role' => $id_role,
				'date_created' => $date_created

			];

			$this->db->insert('user', $data);

			$this->session->set_flashdata('messageUser', '<div class="alert alert-success" role="alert">User berhasil ditambahkan!</div>');
			redirect('user');
		}
	}
	// /////////////////////////////////////////////////////////////// list user ///////////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////// callback valid password ///////////////////////////////////////////////////////////
	public function valid_password($password = '')
	{

		$regex_lowercase = '/[a-z]/';
		$regex_uppercase = '/[A-Z]/';
		$regex_number = '/[0-9]/';

		if (preg_match_all($regex_lowercase, $password) < 1) {
			$this->form_validation->set_message('valid_password', 'Password must contain at least one uppercase character one lowercase character and one number!');
			return FALSE;
		}

		if (preg_match_all($regex_uppercase, $password) < 1) {
			$this->form_validation->set_message('valid_password', 'Password must contain at least one uppercase character one lowercase character and one number!');
			return FALSE;
		}

		if (preg_match_all($regex_number, $password) < 1) {
			$this->form_validation->set_message('valid_password', 'Password must contain at least one uppercase character one lowercase character and one number!');
			return FALSE;
		}

		return TRUE;
	}
	// //////////////////////////////////////////////////////// callback valid password ///////////////////////////////////////////////////////////

	// /////////////////////////////////////////////////////////////// edit user ///////////////////////////////////////////////////////////////////
	public function edit($id_user)
	{

		$data['title'] = 'Kelola User';

		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// data user
		$this->db->select('a.*, b.nama_role, c.nama_karyawan');
		$this->db->from('sdo.user a');
		$this->db->join('sdo.role b', 'b.id_role = a.id_role', 'left');
		$this->db->join('keuangan.karyawan c', 'c.nik = a.nik', 'left');
		$data['users'] = $this->db->get()->result_array();

		// data role
		$data['role'] = $this->db->get('role')->result_array();

		$this->form_validation->set_rules('nik', 'NIK', 'required|trim');
		$this->form_validation->set_rules('id_role', 'Role', 'required|trim');
		$this->form_validation->set_rules('password', 'New password', 'trim|min_length[8]|max_length[25]');
		// $this->form_validation->set_rules('password', 'New password', 'trim|min_length[8]|max_length[25]|callback_valid_password');
		$this->form_validation->set_rules('password2', 'Repeat password', 'trim|matches[password]');

		if ($this->form_validation->run() == false) {

			$this->load->view('template/header', $data);
			$this->load->view('template/sidebar', $data);
			$this->load->view('admin/user/list-user', $data);
			$this->load->view('template/footer', $data);
		} else {

			$nik = $this->input->post('nik');
			$id_role = $this->input->post('id_role');
			$password = $this->input->post('password');
			$password2 = $this->input->post('password2');

			// jika password baru tidak kosong
			if ($password != '' or $password != NULL) {
				$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				$this->db->set('password', $password);
			}

			$this->db->set('nik', $nik);
			$this->db->set('id_role', $id_role);
			$this->db->where('id_user =', $id_user);

			$this->db->update('user');

			$this->session->set_flashdata('messageUser', '<div class="alert alert-success" role="alert">User berhasil diupdate!</div>');

			redirect('user');
		}
	}
	// /////////////////////////////////////////////////////////////// edit user ///////////////////////////////////////////////////////////////////


	// ////////////////////////////////////////////////////////////// hapus user ///////////////////////////////////////////////////////////////////
	public function hapus($id_user)
	{

		// hapus user where id_user
		$this->db->where('id_user =', $id_user);
		$this->db->delete('user');
		$this->session->set_flashdata('messageUser', '<div class="alert alert-success" role="alert">User berhasil dihapus!</div>');

		redirect('user');
	}
	// ////////////////////////////////////////////////////////////// hapus user ///////////////////////////////////////////////////////////////////



}
