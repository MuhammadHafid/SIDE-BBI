<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transmittal extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
		cekSessionLogin();
		// admin_access();

	}

	// ////////////////////////////////////////////////////////// list transmittal ///////////////////////////////////////////////////////
	public function index($no_order = 'all')
	{

		$data['title'] = 'Transmittal Dokumen';
		$data['judul'] = 'List Transmittal | SIDE-BBI';

		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		// ambil data transmittal
		$this->db->select('*');
		$this->db->from('transmittal');

		if ($no_order != 'all') {
			$this->db->where('no_order =', $no_order);
		}

		$this->db->group_by('no_sp');
		$this->db->order_by('tgl_transmittal', 'DESC');
		$data['transmittal'] = $this->db->get()->result_array();


		// cek dokumen drawing
		$data['drawing'] = $this->db->get('dokumen_drawing')->num_rows();
		// cek dokumen BQ
		$data['bq'] = $this->db->get('dokumen_bq')->num_rows();
		// cek dokumen EIS
		$data['eis'] = $this->db->get('dokumen_eis')->num_rows();
		// cek dokumen MP
		$data['mp'] = $this->db->get('dokumen_mp')->num_rows();
		// cek dokumen CLO
		$data['clo'] = $this->db->get('dokumen_clo')->num_rows();
		// cek dokumen MRS
		$data['mrs'] = $this->db->get('dokumen_mrs')->num_rows();

		// ambil nomor order pada cc_ord
		$data['no_order'] = $this->db_keuangan->get('cc_ord')->result_array();

		$this->load->view('template/sidebar', $data);
		$this->load->view('template/header', $data);
		$this->load->view('transmittal/list-transmittal', $data);
		$this->load->view('template/footer', $data);
	}
	// ////////////////////////////////////////////////////////// list transmittal ///////////////////////////////////////////////////////

	// ///////////////////////////////////////////////////////// detail transmittal //////////////////////////////////////////////////////
	public function detail($id_transmittal, $no_order, $jenis)
	{

		// ambil no_sp where id transmittal
		$this->db->select('*');
		$this->db->from('transmittal');
		$this->db->where('id_transmittal =', $id_transmittal);
		$t = $this->db->get()->row_array();

		$no_sp = $t['no_sp'];

		// var_dump($id_transmittal); die;

		$data['title'] = 'Transmittal Dokumen';
		$data['judul'] = 'Detail Transmittal | SIDE-BBI';

		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		$data['id_transmittal'] = $id_transmittal;

		$data['no_sp'] = $no_sp;

		$data['jenis'] = $jenis;

		// ambil transmittal
		$data['transmittal'] = $this->db->get_where('transmittal', ['no_sp' => $no_sp])->row_array();

		// data order
		$this->db_keuangan->select('cc_ord.*, customer.nama_customer');
		$this->db_keuangan->from('cc_ord');
		$this->db_keuangan->join('customer', 'customer.id_customer = cc_ord.kode_cst', 'left');
		$this->db_keuangan->where('cc_ord.id_cc_ord =', $no_order);
		$data['order'] = $this->db_keuangan->get()->row_array();

		// ambil data transmittal where no sp
		// $this->db->select('*');
		// $this->db->from('transmittal');
		// $this->db->where('no_sp =', $no_sp);
		// $transmittal = $this->db->get()->row_array();

		// ========================================================== drawing ================================================================ 

		// ambil dokumen drawing where no_sp dan status
		$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_drawing');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_drawing.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_drawing.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_drawing.revisi', 'left');
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);
		$data['dokumen_drawing'] = $this->db->get()->result_array();

		$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_drawing');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_drawing.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_drawing.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_drawing.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['edrawing'] = $this->db->get()->result_array();

		// ========================================================== drawing ================================================================ 

		// ============================================================ BQ =================================================================== 

		// ambil dokumen bq where no_sp dan ststus
		$this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_bq');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_bq.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_bq.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_bq.revisi', 'left');
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);
		$data['dokumen_bq'] = $this->db->get()->result_array();

		$this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_bq');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_bq.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_bq.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_bq.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['ebq'] = $this->db->get()->result_array();

		// ============================================================ BQ ===================================================================

		// ============================================================ EIS ================================================================== 

		// ambil dokumen EIS where no_sp dan ststus
		$this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_eis');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_eis.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_eis.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_eis.revisi', 'left');
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);
		$data['dokumen_eis'] = $this->db->get()->result_array();

		$this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_eis');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_eis.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_eis.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_eis.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['eeis'] = $this->db->get()->result_array();

		// ============================================================ EIS ================================================================== 

		// ============================================================ MP =================================================================== 

		// ambil dokumen MP where no_sp dan status
		$this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_mp');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mp.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_mp.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_mp.revisi', 'left');
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);					
		$data['dokumen_mp'] = $this->db->get()->result_array();

		$this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_mp');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mp.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_mp.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_mp.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['emp'] = $this->db->get()->result_array();

		// ============================================================ MP =================================================================== 		
		// =========================================================== CLO =================================================================== 

		// ambil dokumen CLO where no_sp dan status
		$this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_clo');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_clo.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_clo.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_clo.revisi', 'left');
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);					
		$data['dokumen_clo'] = $this->db->get()->result_array();

		$this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_clo');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_clo.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_clo.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_clo.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['eclo'] = $this->db->get()->result_array();

		// =========================================================== CLO =================================================================== 

		// =========================================================== MRS =================================================================== 

		// ambil dokumen MRS where no_sp dan status
		$this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_mrs');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mrs.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_mrs.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_mrs.revisi', 'left');
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);					
		$data['dokumen_mrs'] = $this->db->get()->result_array();

		$this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_mrs');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mrs.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_mrs.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_mrs.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['emrs'] = $this->db->get()->result_array();

		// =========================================================== MRS =================================================================== 

		$this->load->view('template/sidebar', $data);
		$this->load->view('template/header', $data);
		$this->load->view('transmittal/detail-transmittal', $data);
		$this->load->view('template/footer', $data);
	}
	// //////////////////////////////////////////////////// detail transmittal ///////////////////////////////////////////////////////////	
	// ///////////////////////////////////////////////////// buat transmittal ////////////////////////////////////////////////////////////
	public function create($no_order)
	{

		$data['title'] = 'List Transmittal';
		$data['judul'] = 'Buat Transmittal | SIDE-BBI';

		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();

		$data['no_order'] = $no_order;

		// ambil dokumen drawing where no order
		$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_drawing');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_drawing.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_drawing.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_drawing.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['dokumen_drawing'] = $this->db->get()->result_array();

		// ambil dokumen bq where no order
		$this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_bq');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_bq.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_bq.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_bq.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['dokumen_bq'] = $this->db->get()->result_array();

		// ambil dokumen EIS where no order
		$this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_eis');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_eis.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_eis.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_eis.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['dokumen_eis'] = $this->db->get()->result_array();

		// ambil dokumen MP where no order
		$this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_mp');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mp.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_mp.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_mp.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['dokumen_mp'] = $this->db->get()->result_array();

		// ambil dokumen CLO where no order
		$this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_clo');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_clo.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_clo.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_clo.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['dokumen_clo'] = $this->db->get()->result_array();

		// ambil dokumen MRS where no order
		$this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_mrs');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mrs.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_mrs.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_mrs.revisi', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);
		$this->db->where('no_sp =', NULL);
		$data['dokumen_mrs'] = $this->db->get()->result_array();

		// user validation 
		$this->form_validation->set_rules('no_order', 'Order', 'required|trim');

		if ($this->form_validation->run() == false) {

			$this->load->view('template/sidebar', $data);
			$this->load->view('template/header', $data);
			$this->load->view('transmittal/create-transmittal', $data);
			$this->load->view('template/footer', $data);
		} else {

			// ambil semua no_dokumen yang diambil
			// $no_sp = $this->input->post('no_sp');
			$tgl_transmittal = $this->input->post('tgl_transmittal');
			$ambil = $this->input->post('ambil[]');

			// cek num max
			$this->db->select('max(num) as num');
			$this->db->from('transmittal');
			$this->db->where('no_order =', $no_order);
			$ceknum = $this->db->get()->row_array();

			if ($ceknum['num'] == NULL) {
				$num = 1;
			} else {
				$num = $ceknum['num'] + 1;
			}

			// ambil kode fungsi engineering MPI
			$this->db->select('*');
			$this->db->from('keuangan.cc_ord');
			$this->db->where('id_cc_ord =', '6218');
			$kode = $this->db->get()->row_array();

			// susun no sp = no urut/no oder/kode fungsi/bulan.tahun
			$no_sp = $num . '/' . $no_order . '/' . $kode['kode_fungsi'] . '/' . date('m', strtotime($tgl_transmittal)) . '.' . date('Y', strtotime($tgl_transmittal));

			// var_dump($no_sp); die;

			$kode_unik = sha1(time());

			// looping dokumen yang akan dimasukkan transmittal
			foreach ($ambil as $nd) {

				// cek jenis dokumen
				$result = explode(" ", $nd);

				$jenis = $result[0]; // jenis
				$kode = $result[1]; // kode unik

				if ($jenis == 'd') {
					// update no_sp pada dokumrn_drawing where kode_unik
					$this->db->set('no_sp', $no_sp);
					$this->db->where('kode_unik =', $kode);
					$this->db->update('dokumen_drawing');
				} else if ($jenis == 'b') {
					// update no_sp pada dokumrn_bq where kode_unik
					$this->db->set('no_sp', $no_sp);
					$this->db->where('kode_unik =', $kode);
					$this->db->update('dokumen_bq');
				} else if ($jenis == 'e') {
					// update no_sp pada dokumrn_eis where kode_unik
					$this->db->set('no_sp', $no_sp);
					$this->db->where('kode_unik =', $kode);
					$this->db->update('dokumen_eis');
				} else if ($jenis == 'm') {
					// update no_sp pada dokumrn_mp where kode_unik
					$this->db->set('no_sp', $no_sp);
					$this->db->where('kode_unik =', $kode);
					$this->db->update('dokumen_mp');
				} else if ($jenis == 'c') {
					// update no_sp pada dokumrn_clo where kode_unik
					$this->db->set('no_sp', $no_sp);
					$this->db->where('kode_unik =', $kode);
					$this->db->update('dokumen_clo');
				} else if ($jenis == 'r') {
					// update no_sp pada dokumrn_bq where kode_unik
					$this->db->set('no_sp', $no_sp);
					$this->db->where('kode_unik =', $kode);
					$this->db->update('dokumen_mrs');
				}
			}

			// insert ke tabel transmittal
			$dataT = [

				'no_sp' => $no_sp,
				'tgl_transmittal' => $tgl_transmittal,
				'no_order' => $no_order,
				'date_created' => date('Y-m-d'),
				'user' => $this->session->userdata('nama_karyawan'),
				'num' => $num,
				'kode_unik' => $kode_unik

			];

			$this->db->insert('transmittal', $dataT);

			$this->session->set_flashdata('messageTransmittal', '<div class="alert alert-success" role="alert">Transmittal berhasil ditambahkan!</div>');
			redirect('transmittal');
		}
	}
	// ///////////////////////////////////////////////////// buat transmittal ////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////// hapus transmittal ////////////////////////////////////////////////////////////
	public function hapus($id_transmittal)
	{

		// ambil no_sp where id transmittal
		$this->db->select('*');
		$this->db->from('transmittal');
		$this->db->where('id_transmittal =', $id_transmittal);
		$t = $this->db->get()->row_array();

		$no_sp = $t['no_sp'];

		// update dokumen drawing no sp = null where no sp 
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_drawing');

		// update dokumen BQ no sp = null where no sp 
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_bq');

		// update dokumen EIS no sp = null where no sp 
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_eis');

		// update dokumen MP no sp = null where no sp 
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_mp');

		// update dokumen CLO no sp = null where no sp 
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_clo');

		// update dokumen MRS no sp = null where no sp 
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_mrs');

		// hapus transmittal where no sp
		$this->db->where('no_sp =', $no_sp);
		$this->db->delete('transmittal');
		$this->session->set_flashdata('messageTransmittal', '<div class="alert alert-success" role="alert">Transmittal berhasil dihapus!</div>');

		redirect('transmittal');
	}
	// //////////////////////////////////////////////////// hapus transmittal ////////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////////// edit drawing ///////////////////////////////////////////////////////////////
	public function edrawing($id_transmittal, $no_order)
	{

		// ambil no_sp where id transmittal
		$this->db->select('*');
		$this->db->from('transmittal');
		$this->db->where('id_transmittal =', $id_transmittal);
		$t = $this->db->get()->row_array();

		$no_sp = $t['no_sp'];

		$jenis = 'drawing';

		// update no sp = null where no sp
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_drawing');

		$dokumen_drawing = $this->input->post('ambil[]');

		foreach ($dokumen_drawing as $dd) {

			// update no sp where kode_unik
			$this->db->set('no_sp', $no_sp);
			$this->db->where('kode_unik =', $dd);
			$this->db->update('dokumen_drawing');
		}


		$this->session->set_flashdata('messageTransmittalDrawing', '<div class="alert alert-success" role="alert">Transmittal berhasil diperbarui!</div>');

		redirect('transmittal/detail/' . $id_transmittal . '/' . $no_order . '/' . $jenis);
	}
	// ////////////////////////////////////////////////////// edit drawing ///////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////// edit BQ //////////////////////////////////////////////////////////////////
	public function ebq($id_transmittal, $no_order)
	{

		// ambil no_sp where id transmittal
		$this->db->select('*');
		$this->db->from('transmittal');
		$this->db->where('id_transmittal =', $id_transmittal);
		$t = $this->db->get()->row_array();

		$no_sp = $t['no_sp'];

		$jenis = 'bq';

		// update no sp = null where no sp
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_bq');

		$dokumen_bq = $this->input->post('ambil[]');

		foreach ($dokumen_bq as $db) {

			// update no sp where kode_unik
			$this->db->set('no_sp', $no_sp);
			$this->db->where('kode_unik =', $db);
			$this->db->update('dokumen_bq');
		}


		$this->session->set_flashdata('messageTransmittalBq', '<div class="alert alert-success" role="alert">Transmittal berhasil diperbarui!</div>');

		redirect('transmittal/detail/' . $id_transmittal . '/' . $no_order . '/' . $jenis);
	}
	// //////////////////////////////////////////////////////// edit BQ //////////////////////////////////////////////////////////////////

	// /////////////////////////////////////////////////////// edit EIS //////////////////////////////////////////////////////////////////
	public function eeis($id_transmittal, $no_order)
	{

		// ambil no_sp where id transmittal
		$this->db->select('*');
		$this->db->from('transmittal');
		$this->db->where('id_transmittal =', $id_transmittal);
		$t = $this->db->get()->row_array();

		$no_sp = $t['no_sp'];

		$jenis = 'eis';

		// update no sp = null where no sp
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_eis');

		$dokumen_eis = $this->input->post('ambil[]');

		foreach ($dokumen_eis as $de) {

			// update no sp where kode_unik
			$this->db->set('no_sp', $no_sp);
			$this->db->where('kode_unik =', $de);
			$this->db->update('dokumen_eis');
		}


		$this->session->set_flashdata('messageTransmittalEis', '<div class="alert alert-success" role="alert">Transmittal berhasil diperbarui!</div>');

		redirect('transmittal/detail/' . $id_transmittal . '/' . $no_order . '/' . $jenis);
	}
	// /////////////////////////////////////////////////////// edit EIS //////////////////////////////////////////////////////////////////

	// /////////////////////////////////////////////////////// edit MP ///////////////////////////////////////////////////////////////////
	public function emp($id_transmittal, $no_order)
	{

		// ambil no_sp where id transmittal
		$this->db->select('*');
		$this->db->from('transmittal');
		$this->db->where('id_transmittal =', $id_transmittal);
		$t = $this->db->get()->row_array();

		$no_sp = $t['no_sp'];

		$jenis = 'mp';

		// update no sp = null where no sp
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_mp');

		$dokumen_mp = $this->input->post('ambil[]');

		foreach ($dokumen_mp as $dm) {

			// update no sp where kode_unik
			$this->db->set('no_sp', $no_sp);
			$this->db->where('kode_unik =', $dm);
			$this->db->update('dokumen_mp');
		}


		$this->session->set_flashdata('messageTransmittalMp', '<div class="alert alert-success" role="alert">Transmittal berhasil diperbarui!</div>');

		redirect('transmittal/detail/' . $id_transmittal . '/' . $no_order . '/' . $jenis);
	}
	// /////////////////////////////////////////////////////// edit MP ///////////////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////////// edit CLO ////////////////////////////////////////////////////////////////////
	public function eclo($id_transmittal, $no_order)
	{

		// ambil no_sp where id transmittal
		$this->db->select('*');
		$this->db->from('transmittal');
		$this->db->where('id_transmittal =', $id_transmittal);
		$t = $this->db->get()->row_array();

		$no_sp = $t['no_sp'];

		$jenis = 'clo';

		// update no sp = null where no sp
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_clo');

		$dokumen_clo = $this->input->post('ambil[]');

		foreach ($dokumen_clo as $dc) {

			// update no sp where kode_unik
			$this->db->set('no_sp', $no_sp);
			$this->db->where('kode_unik =', $dc);
			$this->db->update('dokumen_clo');
		}


		$this->session->set_flashdata('messageTransmittalClo', '<div class="alert alert-success" role="alert">Transmittal berhasil diperbarui!</div>');

		redirect('transmittal/detail/' . $id_transmittal . '/' . $no_order . '/' . $jenis);
	}
	// ////////////////////////////////////////////////////// edit CLO ////////////////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////////// edit MRS ////////////////////////////////////////////////////////////////////
	public function emrs($id_transmittal, $no_order)
	{

		// ambil no_sp where id transmittal
		$this->db->select('*');
		$this->db->from('transmittal');
		$this->db->where('id_transmittal =', $id_transmittal);
		$t = $this->db->get()->row_array();

		$no_sp = $t['no_sp'];

		$jenis = 'mrs';

		// update no sp = null where no sp
		$this->db->set('no_sp', NULL);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('dokumen_mrs');

		$dokumen_mrs = $this->input->post('ambil[]');

		foreach ($dokumen_mrs as $dm) {

			// update no sp where kode_unik
			$this->db->set('no_sp', $no_sp);
			$this->db->where('kode_unik =', $dm);
			$this->db->update('dokumen_mrs');
		}


		$this->session->set_flashdata('messageTransmittalMrs', '<div class="alert alert-success" role="alert">Transmittal berhasil diperbarui!</div>');

		redirect('transmittal/detail/' . $id_transmittal . '/' . $no_order . '/' . $jenis);
	}
	// ////////////////////////////////////////////////////// edit MRS ////////////////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////// submit transmittal /////////////////////////////////////////////////////////////
	public function submit($id_transmittal)
	{

		// ambil no_sp where id transmittal
		$this->db->select('*');
		$this->db->from('transmittal');
		$this->db->where('id_transmittal =', $id_transmittal);
		$t = $this->db->get()->row_array();

		$no_sp = $t['no_sp'];

		// update submit = 1 where no sp (transmittal)
		$this->db->set('submit', 1);
		$this->db->where('no_sp =', $no_sp);
		$this->db->update('transmittal');

		$this->session->set_flashdata('messageTransmittal', '<div class="alert alert-success" role="alert">Transmittal berhasil di submit!</div>');

		redirect('transmittal/index');
	}
	// ////////////////////////////////////////////////// submit transmittal /////////////////////////////////////////////////////////////


}
