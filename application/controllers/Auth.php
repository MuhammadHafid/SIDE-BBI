<?php
defined('BASEPATH') or exit('No direct script access allowed');

// //////////////////////////////////////////////////////////// validasi form login ////////////////////////////////////////////////////////////
class Auth extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
		// Load database kedua
		// $db2 = $this->load->database('database_kedua', TRUE);	

		// cekSessionLogin();
	}


	public function index()
	{

		if ($this->session->userdata('online')) {
			redirect('dashboard');
		}

		$this->form_validation->set_rules('nik', 'NIK', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|alpha_numeric|min_length[3]');

		if ($this->form_validation->run() == false) {

			$data['title'] = 'User Login | SIDE-BBI';
			// $this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login', $data);
			// $this->load->view('templates/auth_footer');

		} else {

			//setelah validasi success
			$this->_login();
		}
	}
	// //////////////////////////////////////////////////////////// validasi form login ////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////////////// proses login ///////////////////////////////////////////////////////////////
	private function _login()
	{

		$nik = $this->input->post('nik');
		$password = $this->input->post('password');

		$user = $this->db->get_where('user', ['nik' => $nik])->row_array();

		//jika user ada
		if ($user) {

			// ambil data karyawan where nik
			$data_session = $this->db_keuangan->get_where('karyawan', ['nik' => $user['nik']])->row_array();

			//cek password
			// password_verify($password, $user['password'])
			if (password_verify($password, $user['password'])) {

				$data = [
					'nik' => $user['nik'],
					'nama_karyawan' => $data_session['nama_karyawan'],
					'id_role' => $user['id_role'],
					'online' => 1
				];

				$this->session->set_userdata($data);

				if ($user['id_role'] == 1) {

					redirect('dashboard');
				} else {

					redirect('dashboard');
				}
			} else {

				$this->session->set_flashdata('messageAuth', '<div class="alert alert-danger" role="alert">Password salah!</div>');
				redirect('auth');
			}
		} else {

			$this->session->set_flashdata('messageAuth', '<div class="alert alert-danger" role="alert">User belum terdaftar!</div>');
			redirect('auth');
		}
	}
	// //////////////////////////////////////////////////////////////// proses login ///////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////////////// proses logout //////////////////////////////////////////////////////////////
	public function logout()
	{

		$this->session->unset_userdata('nik');
		$this->session->unset_userdata('nama_karyawan');
		$this->session->unset_userdata('id_role');
		$this->session->unset_userdata('online');

		$this->session->set_flashdata('messageAuth', '<div class="alert alert-success" role="alert">Logout berhasil!</div>');

		redirect('auth');
	}
	// //////////////////////////////////////////////////////////////// proses logout //////////////////////////////////////////////////////////////

	// /////////////////////////////////////////////////////////////// halaman blokir //////////////////////////////////////////////////////////////
	public function blocked()
	{

		$this->load->view('auth/blocked');
	}
	// /////////////////////////////////////////////////////////////// halaman blokir //////////////////////////////////////////////////////////////

}
