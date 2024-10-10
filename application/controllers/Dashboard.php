<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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

		// ambil dokumen drawing whewe no order
		$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_drawing');
		$this->db->join('status_dokumen', 'dokumen_drawing.status_dokumen = status_dokumen.id_status', 'left');
		$this->db->join('edisi', 'dokumen_drawing.edisi = edisi.id_edisi', 'left');
		$this->db->join('revisi', 'dokumen_drawing.revisi = revisi.id_revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_drawing.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('status =', 1);
		$this->db->order_by('dokumen_drawing.tgl_dokumen', 'DESC');
		$data['dokumen_drawing'] = $this->db->get()->result_array();

		// ambil dokumen bq whewe no order
		$this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_bq');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_bq.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_bq.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_bq.revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_bq.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('status =', 1);
		$this->db->order_by('dokumen_bq.tgl_dokumen', 'DESC');
		$data['dokumen_bq'] = $this->db->get()->result_array();

		// ambil dokumen EIS whewe no order
		$this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_eis');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_eis.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_eis.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_eis.revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_eis.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('status =', 1);
		$this->db->order_by('dokumen_eis.tgl_dokumen', 'DESC');
		$data['dokumen_eis'] = $this->db->get()->result_array();

		// ambil dokumen MP whewe no order
		$this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_mp');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mp.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_mp.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_mp.revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_mp.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('status =', 1);
		$this->db->order_by('dokumen_mp.tgl_dokumen', 'DESC');
		$data['dokumen_mp'] = $this->db->get()->result_array();

		// ambil dokumen CLO whewe no order
		$this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_clo');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_clo.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_clo.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_clo.revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_clo.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('status =', 1);
		$this->db->order_by('dokumen_clo.tgl_dokumen', 'DESC');
		$data['dokumen_clo'] = $this->db->get()->result_array();

		// ambil dokumen MRS
		$this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_mrs');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mrs.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_mrs.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_mrs.revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_mrs.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('status =', 1);
		$this->db->order_by('dokumen_mrs.tgl_dokumen', 'DESC');
		$data['dokumen_mrs'] = $this->db->get()->result_array();

		// ambil dokumen SPK
		$this->db->select('dokumen_spk.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_spk');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_spk.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_spk.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_spk.revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_spk.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('status =', 1);
		$this->db->order_by('dokumen_spk.tgl_dokumen', 'DESC');
		$data['dokumen_spk'] = $this->db->get()->result_array();

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('template/footer', $data);
	}
	// //////////////////////////////////////////////////////////// dashboard admin  ////////////////////////////////////////////////////////////////


}
