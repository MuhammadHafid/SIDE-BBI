<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('secure');
		cekSessionLogin();
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
	}

	// /////////////////////////////////////////////////////////////// list order //////////////////////////////////////////////////////////////////
	public function index()
	{
		$data['title'] = 'List Order';
		$data['judul'] = 'List Order | SIDE-BBI';
		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();
		// data order
		$this->db_keuangan->select('cc_ord.*, customer.nama_customer');
		$this->db_keuangan->from('cc_ord');
		$this->db_keuangan->join('customer', 'customer.id_customer = cc_ord.kode_cst', 'left');
		$this->db_keuangan->where('cc_ord.grup =', 'order');
		$data['order'] = $this->db_keuangan->get()->result_array();

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('order/list-order', $data);
		$this->load->view('template/footer', $data);
	}
	// /////////////////////////////////////////////////////////////// list order //////////////////////////////////////////////////////////////
	// ////////////////////////////////////////////////////////////// dokumen order /////////////////////////////////////////////////////////////
	public function dokumen($no_order, $fungsi = 'nol')
	{
		$data['title'] = 'Dokumen Order';
		$data['judul'] = 'Dokumen Order | SIDE-BBI';
		$data['fungsi'] = $fungsi;

		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();
		// ambil nama role berdasarkan id role dari session
		$role = $this->db->get_where('role', ['id_role' => $this->session->userdata('id_role')])->row_array();
		$nama_role = $role['nama_role'];
		$data['nama_role'] = $nama_role;

		// var_dump($fungsi);
		// var_dump($nama_role);
		// die;

		// ambil data order where no order
		$this->db_keuangan->select('cc_ord.*, nama_customer');
		$this->db_keuangan->from('cc_ord');
		$this->db_keuangan->join('customer', 'customer.id_customer = cc_ord.kode_cst', 'left');
		$this->db_keuangan->where('id_cc_ord =', $no_order);
		$data['order'] = $this->db_keuangan->get()->row_array();
		// ambil data status dokumen
		$data['status_dokumen'] = $this->db->get('status_dokumen')->result_array();
		// ambil data edisi
		$data['edisi'] = $this->db->get('edisi')->result_array();
		// ambil data revisi
		$data['revisi'] = $this->db->get('revisi')->result_array();
		// ambil semua fungsi/role yang mnyediakan dokumen berdasarkan hak akses role login
		// $this->db->select('*');
		// $this->db->from('role');
		// $this->db->where('nama_role !=', 'Super Admin');
		// $this->db->where('nama_role !=', 'Admin');
		// $this->db->where('nama_role !=', 'Dokon Center');
		// $this->db->where('nama_role !=', 'FAB');
		// $this->db->where('nama_role !=', 'Keuangan');
		// $this->db->where('nama_role !=', 'Produksi');
		// $this->db->where('nama_role !=', 'HRD');
		// $this->db->where('nama_role !=', 'MPI');
		// $this->db->where('nama_role !=', 'Expedisi');
		// if ($nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
		// 	// super admin, admin dan dokon center bisa melihat semua dokumen
		// } else if ($nama_role == 'PPC') {
		// 	// hanya bisa melihat dokumen sesuai role
		// 	$this->db->where('nama_role =', 'PPC');
		// } else if ($nama_role == 'QA') {
		// 	$this->db->where('nama_role =', 'QA');
		// } else if ($nama_role == 'QC') {
		// 	$this->db->where('nama_role =', 'QC');
		// } else if ($nama_role == 'Sales') {
		// 	$this->db->where('nama_role =', 'Sales');
		// } else if ($nama_role == 'Logistik') {
		// 	$this->db->where('nama_role =', 'Logistik');
		// } else if ($nama_role == 'Engineering') {
		// 	$this->db->where('nama_role =', 'Engineering');
		// } else if ($nama_role == 'MM') {
		// 	$this->db->where('nama_role =', 'MM');
		// } else {
		// 	echo "Anda tidak memiliki akses!";
		// 	die;
		// }
		// $data['role'] = $this->db->get()->result_array();


		// akses dokumen berdasarkan role
		$this->db->select('dokumen_akses.*, nama_role');
		$this->db->from('dokumen_akses');
		$this->db->join('role', 'dokumen_akses.id_role_dokumen = role.id_role', 'left');
		$this->db->where('dokumen_akses.id_role_user =', $this->session->userdata('id_role'));
		$data['dokumen_akses'] = $this->db->get()->result_array();

		// //////////////////////////////////////////// dokumen Engineering //////////////////////////////////////////////////
		if ($fungsi == 'Engineering') {
			// ambil dokumen fungsi engineering (drawing, bq, eis, mp, clo, mrs) sesuai hak akses role user login
			// ambil dokumen drawing where no order dan hanya diambil sesuai hak akses dokumen user yang login
			$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_drawing');
			$this->db->join('status_dokumen', 'dokumen_drawing.status_dokumen = status_dokumen.id_status', 'left');
			$this->db->join('edisi', 'dokumen_drawing.edisi = edisi.id_edisi', 'left');
			$this->db->join('revisi', 'dokumen_drawing.revisi = revisi.id_revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_drawing.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);
			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp_dokumen !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}
			$data['dokumen_drawing'] = $this->db->get()->result_array();

			// ambil dokumen bq whewe no order
			$this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_bq');
			$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_bq.status_dokumen', 'left');
			$this->db->join('edisi', 'edisi.id_edisi = dokumen_bq.edisi', 'left');
			$this->db->join('revisi', 'revisi.id_revisi = dokumen_bq.revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_bq.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);
			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp_dokumen !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}
			$data['dokumen_bq'] = $this->db->get()->result_array();

			// ambil dokumen EIS whewe no order
			$this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_eis');
			$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_eis.status_dokumen', 'left');
			$this->db->join('edisi', 'edisi.id_edisi = dokumen_eis.edisi', 'left');
			$this->db->join('revisi', 'revisi.id_revisi = dokumen_eis.revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_eis.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);
			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp_dokumen !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}
			$data['dokumen_eis'] = $this->db->get()->result_array();

			// ambil dokumen MP whewe no order
			$this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_mp');
			$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mp.status_dokumen', 'left');
			$this->db->join('edisi', 'edisi.id_edisi = dokumen_mp.edisi', 'left');
			$this->db->join('revisi', 'revisi.id_revisi = dokumen_mp.revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_mp.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);
			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp_dokumen !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}
			$data['dokumen_mp'] = $this->db->get()->result_array();

			// ambil dokumen CLO whewe no order
			$this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_clo');
			$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_clo.status_dokumen', 'left');
			$this->db->join('edisi', 'edisi.id_edisi = dokumen_clo.edisi', 'left');
			$this->db->join('revisi', 'revisi.id_revisi = dokumen_clo.revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_clo.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);
			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp_dokumen !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}
			$data['dokumen_clo'] = $this->db->get()->result_array();

			// ambil dokumen MRS whewe no order
			$this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_mrs');
			$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mrs.status_dokumen', 'left');
			$this->db->join('edisi', 'edisi.id_edisi = dokumen_mrs.edisi', 'left');
			$this->db->join('revisi', 'revisi.id_revisi = dokumen_mrs.revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_mrs.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);
			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp_dokumen !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}
			$data['dokumen_mrs'] = $this->db->get()->result_array();
		}
		// //////////////////////////////////////////// dokumen Engineering //////////////////////////////////////////////////

		// /////////////////////////////////////////////// dokumen Sales //////////////////////////////////////////////////
		if ($fungsi == 'Sales') {
			// ambil dokumen fungsi sales (spk) sesuai hak akses role user login
			// ambil dokumen spk where no order dan hanya diambil sesuai hak akses dokumen user yang login
			$this->db->select('dokumen_spk.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_spk');
			$this->db->join('status_dokumen', 'dokumen_spk.status_dokumen = status_dokumen.id_status', 'left');
			$this->db->join('edisi', 'dokumen_spk.edisi = edisi.id_edisi', 'left');
			$this->db->join('revisi', 'dokumen_spk.revisi = revisi.id_revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_spk.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);
			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Sales' or $nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
				// bisa melihat semua dokumen
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp_dokumen !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}
			$data['dokumen_spk'] = $this->db->get()->result_array();
		}
		// /////////////////////////////////////////////// dokumen Sales //////////////////////////////////////////////////

		// /////////////////////////////////////////////// dokumen PPC //////////////////////////////////////////////////
		if ($fungsi == 'PPC') {
			// ambil dokumen fungsi PPC (Master Schedule 'S' Curve dan Production Schedule) sesuai hak akses role user login
			// ambil dokumen mscurve where no order dan hanya diambil sesuai hak akses dokumen user yang login
			$this->db->select('dokumen_mscurve.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_mscurve');
			$this->db->join('status_dokumen', 'dokumen_mscurve.status_dokumen = status_dokumen.id_status', 'left');
			$this->db->join('edisi', 'dokumen_mscurve.edisi = edisi.id_edisi', 'left');
			$this->db->join('revisi', 'dokumen_mscurve.revisi = revisi.id_revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_mscurve.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);
			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'PPC' or $nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp_dokumen !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}
			$data['dokumen_mscurve'] = $this->db->get()->result_array();
			// var_dump($data['dokumen_mscurve']);
			// die;

			// ambil dokumen_ps where no order dan hanya diambil sesuai hak akses dokumen user yang login
			$this->db->select('dokumen_ps.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_ps');
			$this->db->join('status_dokumen', 'dokumen_ps.status_dokumen = status_dokumen.id_status', 'left');
			$this->db->join('edisi', 'dokumen_ps.edisi = edisi.id_edisi', 'left');
			$this->db->join('revisi', 'dokumen_ps.revisi = revisi.id_revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_ps.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);
			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'PPC' or $nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp_dokumen !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}
			$data['dokumen_ps'] = $this->db->get()->result_array();
		}
		// /////////////////////////////////////////////// dokumen PPC //////////////////////////////////////////////////

		// /////////////////////////////////////////////// dokumen MM //////////////////////////////////////////////////
		if ($fungsi == 'MM') {
			// ambil dokumen fungsi MM (Purchase Requisition Sheet (PR) dan Inspection Material Request For Stock (IMR)) sesuai hak akses role user login
			// ambil dokumen PR where no order dan hanya diambil sesuai hak akses dokumen user yang login
			$this->db->select('dokumen_pr.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_pr');
			$this->db->join('status_dokumen', 'dokumen_pr.status_dokumen = status_dokumen.id_status', 'left');
			$this->db->join('edisi', 'dokumen_pr.edisi = edisi.id_edisi', 'left');
			$this->db->join('revisi', 'dokumen_pr.revisi = revisi.id_revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_pr.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);
			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'MM' or $nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp_dokumen !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}
			$data['dokumen_pr'] = $this->db->get()->result_array();
			// var_dump($data['dokumen_mscurve']);
			// die;

			// ambil dokumen_imr where no order dan hanya diambil sesuai hak akses dokumen user yang login
			$this->db->select('dokumen_imr.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_imr');
			$this->db->join('status_dokumen', 'dokumen_imr.status_dokumen = status_dokumen.id_status', 'left');
			$this->db->join('edisi', 'dokumen_imr.edisi = edisi.id_edisi', 'left');
			$this->db->join('revisi', 'dokumen_imr.revisi = revisi.id_revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_imr.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);
			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'MM' or $nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp_dokumen !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}
			$data['dokumen_imr'] = $this->db->get()->result_array();
		}
		// /////////////////////////////////////////////// dokumen MM //////////////////////////////////////////////////

		// distribusi dokumen
		$data['disdok'] = $this->db->get('distribusi_dokumen')->result_array();

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('order/dokumen-order', $data);
		$this->load->view('template/footer', $data);
	}
	// ////////////////////////////////////////////////////////////// dokumen order ////////////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////////////////// dokumenOrder ////////////////////////////////////////////////////////////////
	public function dokumenOrder($fungsi, $no_ord)
	{
		$data['title'] = 'List Order';
		$data['judul'] = 'Dokumen Order | SIDE-BBI';

		$data['fungsi'] = $fungsi;

		// decript no_order
		$no_order = $no_ord;

		var_dump($no_order);
		die;

		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();
		// ambil nama role berdasarkan id role dari session
		$role = $this->db->get_where('role', ['id_role' => $this->session->userdata('id_role')])->row_array();
		$nama_role = $role['nama_role'];
		// ambil data order where no order
		$this->db_keuangan->select('cc_ord.*, nama_customer');
		$this->db_keuangan->from('cc_ord');
		$this->db_keuangan->join('customer', 'customer.id_customer = cc_ord.kode_cst', 'left');
		$this->db_keuangan->where('id_cc_ord =', $no_order);
		$data['order'] = $this->db_keuangan->get()->row_array();
		// ambil data status dokumen
		$data['status_dokumen'] = $this->db->get('status_dokumen')->result_array();
		// ambil data edisi
		$data['edisi'] = $this->db->get('edisi')->result_array();
		// ambil data revisi
		$data['revisi'] = $this->db->get('revisi')->result_array();
		// ambil hak akses lihat dokumen berdasarkan role
		$this->db->select('*');
		$this->db->from('role');
		$this->db->where('id_role !=', 1);
		$this->db->where('id_role !=', 5);
		$this->db->where('id_role !=', 14);
		if ($nama_role == 'Super Admin' or $nama_role == 'Admin' or $nama_role == 'Dokon Center') {
			// super admin, admin dan dokon center bisa melihat semua dokumen
		} else if ($nama_role == 'PPC') {
			// hanya bisa melihat dokumen sesuai role
			$this->db->where('nama_role =', 'PPC');
		} else if ($nama_role == 'QA') {
			$this->db->where('nama_role =', 'QA');
		} else if ($nama_role == 'QC') {
			$this->db->where('nama_role =', 'QC');
		} else if ($nama_role == 'FAB') {
			$this->db->where('nama_role =', 'FAB');
		} else if ($nama_role == 'Logistik') {
			$this->db->where('nama_role =', 'Logistik');
		} else if ($nama_role == 'Keuangan') {
			$this->db->where('nama_role =', 'Keuangan');
		} else if ($nama_role == 'Engineering') {
			$this->db->where('nama_role =', 'Engineering');
		} else if ($nama_role == 'Logistik') {
			$this->db->where('nama_role =', 'Logistik');
		} else {
			echo "Anda tidak memiliki akses!";
			die;
		}
		$data['role'] = $this->db->get()->result_array();

		// distribusi dokumen
		$data['disdok'] = $this->db->get('distribusi_dokumen')->result_array();

		if ($fungsi == 'PPC') {
			# code...
		} else if ($fungsi == 'QA') {
			# code...
		} else if ($fungsi == 'QC') {
			# code...
		} else if ($fungsi == 'FAB') {
			# code...
		} else if ($fungsi == 'MM') {
			# code...
		} else if ($fungsi == 'Logistik') {
			# code...
		} else if ($fungsi == 'Keuangan') {
			# code...
		} else if ($fungsi == 'Engineering') {
			// ambil dokumen drawing whewe no order
			$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_drawing');
			$this->db->join('status_dokumen', 'dokumen_drawing.status_dokumen = status_dokumen.id_status', 'left');
			$this->db->join('edisi', 'dokumen_drawing.edisi = edisi.id_edisi', 'left');
			$this->db->join('revisi', 'dokumen_drawing.revisi = revisi.id_revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_drawing.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);

			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'Admin') {
				// bisa melihat semua dokumen 
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}

			$data['dokumen_drawing'] = $this->db->get()->result_array();

			// var_dump($data['dokumen_drawing']);
			// die;

			// ambil dokumen bq whewe no order
			$this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_bq');
			$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_bq.status_dokumen', 'left');
			$this->db->join('edisi', 'edisi.id_edisi = dokumen_bq.edisi', 'left');
			$this->db->join('revisi', 'revisi.id_revisi = dokumen_bq.revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_bq.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);

			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'Admin') {
				// bisa melihat semua dokumen 
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}

			$data['dokumen_bq'] = $this->db->get()->result_array();

			// ambil dokumen EIS whewe no order
			$this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_eis');
			$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_eis.status_dokumen', 'left');
			$this->db->join('edisi', 'edisi.id_edisi = dokumen_eis.edisi', 'left');
			$this->db->join('revisi', 'revisi.id_revisi = dokumen_eis.revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_eis.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);

			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'Admin') {
				// bisa melihat semua dokumen 
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}

			$data['dokumen_eis'] = $this->db->get()->result_array();

			// ambil dokumen MP whewe no order
			$this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_mp');
			$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mp.status_dokumen', 'left');
			$this->db->join('edisi', 'edisi.id_edisi = dokumen_mp.edisi', 'left');
			$this->db->join('revisi', 'revisi.id_revisi = dokumen_mp.revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_mp.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);

			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'Admin') {
				// bisa melihat semua dokumen 
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}

			$data['dokumen_mp'] = $this->db->get()->result_array();

			// ambil dokumen CLO whewe no order
			$this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_clo');
			$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_clo.status_dokumen', 'left');
			$this->db->join('edisi', 'edisi.id_edisi = dokumen_clo.edisi', 'left');
			$this->db->join('revisi', 'revisi.id_revisi = dokumen_clo.revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_clo.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);

			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'Admin') {
				// bisa melihat semua dokumen 
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}

			$data['dokumen_clo'] = $this->db->get()->result_array();

			// ambil dokumen MRS whewe no order
			$this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
			$this->db->from('dokumen_mrs');
			$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mrs.status_dokumen', 'left');
			$this->db->join('edisi', 'edisi.id_edisi = dokumen_mrs.edisi', 'left');
			$this->db->join('revisi', 'revisi.id_revisi = dokumen_mrs.revisi', 'left');
			$this->db->join('distribusi_dokumen', 'dokumen_mrs.id_dd = distribusi_dokumen.id_dd', 'left');
			$this->db->where('no_order =', $no_order);
			$this->db->where('status =', 1);

			// hak akses sesuai distribusi dokumen
			if ($nama_role == 'Super Admin') {
				// bisa meliat semua dokumen
			} else if ($nama_role == 'Admin') {
				// bisa melihat semua dokumen 
			} else if ($nama_role == 'PPC') {
				$this->db->where('distribusi_dokumen.ppc !=', 0);
			} else if ($nama_role == 'QA') {
				$this->db->where('distribusi_dokumen.qa !=', 0);
			} else if ($nama_role == 'QC') {
				$this->db->where('distribusi_dokumen.qc !=', 0);
			} else if ($nama_role == 'FAB') {
				$this->db->where('distribusi_dokumen.fab !=', 0);
			} else if ($nama_role == 'MM') {
				$this->db->where('distribusi_dokumen.mm !=', 0);
			} else if ($nama_role == 'Logistik') {
				$this->db->where('distribusi_dokumen.Log !=', 0);
			} else if ($nama_role == 'Keuangan') {
				$this->db->where('distribusi_dokumen.keu !=', 0);
			} else if ($nama_role == 'Engineering') {
				$this->db->where('distribusi_dokumen.eng !=', 0);
			} else if ($nama_role == 'Produksi') {
				$this->db->where('distribusi_dokumen.prod !=', 0);
			} else if ($nama_role == 'HRD') {
				$this->db->where('distribusi_dokumen.hrd !=', 0);
			} else if ($nama_role == 'Sales') {
				$this->db->where('distribusi_dokumen.sales !=', 0);
			} else if ($nama_role == 'MPI') {
				$this->db->where('distribusi_dokumen.mpi !=', 0);
			} else if ($nama_role == 'Expedisi') {
				$this->db->where('distribusi_dokumen.exp !=', 0);
			} else {
				echo "Anda tidak memiliki akses!";
				die;
			}

			$data['dokumen_mrs'] = $this->db->get()->result_array();
		}

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('order/dokumen-order', $data);
		$this->load->view('template/footer', $data);
	}
	// ////////////////////////////////////////////////////////////// dokumenOrder ////////////////////////////////////////////////////////////////

	// /////////////////////////////////////////////////////////// dokumen order index ////////////////////////////////////////////////////////////////
	public function dokumenIndex($no_ord)
	{
		$data['title'] = 'List Order';
		$data['judul'] = 'Dokumen Order | SIDE-BBI';
		// decript no_order
		$no_order = $this->secure->decrypt_url($no_ord);
		$data['user'] = $this->db_keuangan->get_where('karyawan', ['nik' => $this->session->userdata('nik')])->row_array();
		// ambil nama role berdasarkan id role dari session
		$role = $this->db->get_where('role', ['id_role' => $this->session->userdata('id_role')])->row_array();
		$nama_role = $role['nama_role'];
		// ambil data order where no order
		$this->db_keuangan->select('cc_ord.*, nama_customer');
		$this->db_keuangan->from('cc_ord');
		$this->db_keuangan->join('customer', 'customer.id_customer = cc_ord.kode_cst', 'left');
		$this->db_keuangan->where('id_cc_ord =', $no_order);
		$data['order'] = $this->db_keuangan->get()->row_array();
		// ambil data status dokumen
		$data['status_dokumen'] = $this->db->get('status_dokumen')->result_array();
		// ambil data edisi
		$data['edisi'] = $this->db->get('edisi')->result_array();
		// ambil data revisi
		$data['revisi'] = $this->db->get('revisi')->result_array();

		// ambil dokumen drawing where no order
		$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_drawing');
		$this->db->join('status_dokumen', 'dokumen_drawing.status_dokumen = status_dokumen.id_status', 'left');
		$this->db->join('edisi', 'dokumen_drawing.edisi = edisi.id_edisi', 'left');
		$this->db->join('revisi', 'dokumen_drawing.revisi = revisi.id_revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_drawing.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);

		// hak akses sesuai distribusi dokumen
		if ($nama_role == 'Super Admin') {
			// bisa meliat semua dokumen
		} else if ($nama_role == 'Admin') {
			// bisa melihat semua dokumen 
		} else if ($nama_role == 'PPC') {
			$this->db->where('distribusi_dokumen.ppc !=', 0);
		} else if ($nama_role == 'QA') {
			$this->db->where('distribusi_dokumen.qa !=', 0);
		} else if ($nama_role == 'QC') {
			$this->db->where('distribusi_dokumen.qc !=', 0);
		} else if ($nama_role == 'FAB') {
			$this->db->where('distribusi_dokumen.fab !=', 0);
		} else if ($nama_role == 'MM') {
			$this->db->where('distribusi_dokumen.mm !=', 0);
		} else if ($nama_role == 'Logistik') {
			$this->db->where('distribusi_dokumen.Log !=', 0);
		} else if ($nama_role == 'Keuangan') {
			$this->db->where('distribusi_dokumen.keu !=', 0);
		} else if ($nama_role == 'Engineering') {
			$this->db->where('distribusi_dokumen.eng !=', 0);
		} else if ($nama_role == 'Produksi') {
			$this->db->where('distribusi_dokumen.prod !=', 0);
		} else if ($nama_role == 'HRD') {
			$this->db->where('distribusi_dokumen.hrd !=', 0);
		} else if ($nama_role == 'Sales') {
			$this->db->where('distribusi_dokumen.sales !=', 0);
		} else if ($nama_role == 'MPI') {
			$this->db->where('distribusi_dokumen.mpi !=', 0);
		} else if ($nama_role == 'Expedisi') {
			$this->db->where('distribusi_dokumen.exp !=', 0);
		} else {
			echo "Anda tidak memiliki akses!";
			die;
		}

		$data['dokumen_drawing'] = $this->db->get()->result_array();

		// ambil dokumen bq whewe no order
		$this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_bq');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_bq.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_bq.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_bq.revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_bq.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);

		// hak akses sesuai distribusi dokumen
		if ($nama_role == 'Super Admin') {
			// bisa meliat semua dokumen
		} else if ($nama_role == 'Admin') {
			// bisa melihat semua dokumen 
		} else if ($nama_role == 'PPC') {
			$this->db->where('distribusi_dokumen.ppc !=', 0);
		} else if ($nama_role == 'QA') {
			$this->db->where('distribusi_dokumen.qa !=', 0);
		} else if ($nama_role == 'QC') {
			$this->db->where('distribusi_dokumen.qc !=', 0);
		} else if ($nama_role == 'FAB') {
			$this->db->where('distribusi_dokumen.fab !=', 0);
		} else if ($nama_role == 'MM') {
			$this->db->where('distribusi_dokumen.mm !=', 0);
		} else if ($nama_role == 'Logistik') {
			$this->db->where('distribusi_dokumen.Log !=', 0);
		} else if ($nama_role == 'Keuangan') {
			$this->db->where('distribusi_dokumen.keu !=', 0);
		} else if ($nama_role == 'Engineering') {
			$this->db->where('distribusi_dokumen.eng !=', 0);
		} else if ($nama_role == 'Produksi') {
			$this->db->where('distribusi_dokumen.prod !=', 0);
		} else if ($nama_role == 'HRD') {
			$this->db->where('distribusi_dokumen.hrd !=', 0);
		} else if ($nama_role == 'Sales') {
			$this->db->where('distribusi_dokumen.sales !=', 0);
		} else if ($nama_role == 'MPI') {
			$this->db->where('distribusi_dokumen.mpi !=', 0);
		} else if ($nama_role == 'Expedisi') {
			$this->db->where('distribusi_dokumen.exp !=', 0);
		} else {
			echo "Anda tidak memiliki akses!";
			die;
		}

		$data['dokumen_bq'] = $this->db->get()->result_array();

		// ambil dokumen EIS whewe no order
		$this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_eis');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_eis.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_eis.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_eis.revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_eis.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);

		// hak akses sesuai distribusi dokumen
		if ($nama_role == 'Super Admin') {
			// bisa meliat semua dokumen
		} else if ($nama_role == 'Admin') {
			// bisa melihat semua dokumen 
		} else if ($nama_role == 'PPC') {
			$this->db->where('distribusi_dokumen.ppc !=', 0);
		} else if ($nama_role == 'QA') {
			$this->db->where('distribusi_dokumen.qa !=', 0);
		} else if ($nama_role == 'QC') {
			$this->db->where('distribusi_dokumen.qc !=', 0);
		} else if ($nama_role == 'FAB') {
			$this->db->where('distribusi_dokumen.fab !=', 0);
		} else if ($nama_role == 'MM') {
			$this->db->where('distribusi_dokumen.mm !=', 0);
		} else if ($nama_role == 'Logistik') {
			$this->db->where('distribusi_dokumen.Log !=', 0);
		} else if ($nama_role == 'Keuangan') {
			$this->db->where('distribusi_dokumen.keu !=', 0);
		} else if ($nama_role == 'Engineering') {
			$this->db->where('distribusi_dokumen.eng !=', 0);
		} else if ($nama_role == 'Produksi') {
			$this->db->where('distribusi_dokumen.prod !=', 0);
		} else if ($nama_role == 'HRD') {
			$this->db->where('distribusi_dokumen.hrd !=', 0);
		} else if ($nama_role == 'Sales') {
			$this->db->where('distribusi_dokumen.sales !=', 0);
		} else if ($nama_role == 'MPI') {
			$this->db->where('distribusi_dokumen.mpi !=', 0);
		} else if ($nama_role == 'Expedisi') {
			$this->db->where('distribusi_dokumen.exp !=', 0);
		} else {
			echo "Anda tidak memiliki akses!";
			die;
		}

		$data['dokumen_eis'] = $this->db->get()->result_array();

		// ambil dokumen MP whewe no order
		$this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_mp');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mp.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_mp.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_mp.revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_mp.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);

		// hak akses sesuai distribusi dokumen
		if ($nama_role == 'Super Admin') {
			// bisa meliat semua dokumen
		} else if ($nama_role == 'Admin') {
			// bisa melihat semua dokumen 
		} else if ($nama_role == 'PPC') {
			$this->db->where('distribusi_dokumen.ppc !=', 0);
		} else if ($nama_role == 'QA') {
			$this->db->where('distribusi_dokumen.qa !=', 0);
		} else if ($nama_role == 'QC') {
			$this->db->where('distribusi_dokumen.qc !=', 0);
		} else if ($nama_role == 'FAB') {
			$this->db->where('distribusi_dokumen.fab !=', 0);
		} else if ($nama_role == 'MM') {
			$this->db->where('distribusi_dokumen.mm !=', 0);
		} else if ($nama_role == 'Logistik') {
			$this->db->where('distribusi_dokumen.Log !=', 0);
		} else if ($nama_role == 'Keuangan') {
			$this->db->where('distribusi_dokumen.keu !=', 0);
		} else if ($nama_role == 'Engineering') {
			$this->db->where('distribusi_dokumen.eng !=', 0);
		} else if ($nama_role == 'Produksi') {
			$this->db->where('distribusi_dokumen.prod !=', 0);
		} else if ($nama_role == 'HRD') {
			$this->db->where('distribusi_dokumen.hrd !=', 0);
		} else if ($nama_role == 'Sales') {
			$this->db->where('distribusi_dokumen.sales !=', 0);
		} else if ($nama_role == 'MPI') {
			$this->db->where('distribusi_dokumen.mpi !=', 0);
		} else if ($nama_role == 'Expedisi') {
			$this->db->where('distribusi_dokumen.exp !=', 0);
		} else {
			echo "Anda tidak memiliki akses!";
			die;
		}

		$data['dokumen_mp'] = $this->db->get()->result_array();

		// ambil dokumen CLO whewe no order
		$this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_clo');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_clo.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_clo.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_clo.revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_clo.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);

		// hak akses sesuai distribusi dokumen
		if ($nama_role == 'Super Admin') {
			// bisa meliat semua dokumen
		} else if ($nama_role == 'Admin') {
			// bisa melihat semua dokumen 
		} else if ($nama_role == 'PPC') {
			$this->db->where('distribusi_dokumen.ppc !=', 0);
		} else if ($nama_role == 'QA') {
			$this->db->where('distribusi_dokumen.qa !=', 0);
		} else if ($nama_role == 'QC') {
			$this->db->where('distribusi_dokumen.qc !=', 0);
		} else if ($nama_role == 'FAB') {
			$this->db->where('distribusi_dokumen.fab !=', 0);
		} else if ($nama_role == 'MM') {
			$this->db->where('distribusi_dokumen.mm !=', 0);
		} else if ($nama_role == 'Logistik') {
			$this->db->where('distribusi_dokumen.Log !=', 0);
		} else if ($nama_role == 'Keuangan') {
			$this->db->where('distribusi_dokumen.keu !=', 0);
		} else if ($nama_role == 'Engineering') {
			$this->db->where('distribusi_dokumen.eng !=', 0);
		} else if ($nama_role == 'Produksi') {
			$this->db->where('distribusi_dokumen.prod !=', 0);
		} else if ($nama_role == 'HRD') {
			$this->db->where('distribusi_dokumen.hrd !=', 0);
		} else if ($nama_role == 'Sales') {
			$this->db->where('distribusi_dokumen.sales !=', 0);
		} else if ($nama_role == 'MPI') {
			$this->db->where('distribusi_dokumen.mpi !=', 0);
		} else if ($nama_role == 'Expedisi') {
			$this->db->where('distribusi_dokumen.exp !=', 0);
		} else {
			echo "Anda tidak memiliki akses!";
			die;
		}

		$data['dokumen_clo'] = $this->db->get()->result_array();

		// ambil dokumen MRS whewe no order
		$this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi, judul_dokumen');
		$this->db->from('dokumen_mrs');
		$this->db->join('status_dokumen', 'status_dokumen.id_status = dokumen_mrs.status_dokumen', 'left');
		$this->db->join('edisi', 'edisi.id_edisi = dokumen_mrs.edisi', 'left');
		$this->db->join('revisi', 'revisi.id_revisi = dokumen_mrs.revisi', 'left');
		$this->db->join('distribusi_dokumen', 'dokumen_mrs.id_dd = distribusi_dokumen.id_dd', 'left');
		$this->db->where('no_order =', $no_order);
		$this->db->where('status =', 1);

		// hak akses sesuai distribusi dokumen
		if ($nama_role == 'Super Admin') {
			// bisa meliat semua dokumen
		} else if ($nama_role == 'Admin') {
			// bisa melihat semua dokumen 
		} else if ($nama_role == 'PPC') {
			$this->db->where('distribusi_dokumen.ppc !=', 0);
		} else if ($nama_role == 'QA') {
			$this->db->where('distribusi_dokumen.qa !=', 0);
		} else if ($nama_role == 'QC') {
			$this->db->where('distribusi_dokumen.qc !=', 0);
		} else if ($nama_role == 'FAB') {
			$this->db->where('distribusi_dokumen.fab !=', 0);
		} else if ($nama_role == 'MM') {
			$this->db->where('distribusi_dokumen.mm !=', 0);
		} else if ($nama_role == 'Logistik') {
			$this->db->where('distribusi_dokumen.Log !=', 0);
		} else if ($nama_role == 'Keuangan') {
			$this->db->where('distribusi_dokumen.keu !=', 0);
		} else if ($nama_role == 'Engineering') {
			$this->db->where('distribusi_dokumen.eng !=', 0);
		} else if ($nama_role == 'Produksi') {
			$this->db->where('distribusi_dokumen.prod !=', 0);
		} else if ($nama_role == 'HRD') {
			$this->db->where('distribusi_dokumen.hrd !=', 0);
		} else if ($nama_role == 'Sales') {
			$this->db->where('distribusi_dokumen.sales !=', 0);
		} else if ($nama_role == 'MPI') {
			$this->db->where('distribusi_dokumen.mpi !=', 0);
		} else if ($nama_role == 'Expedisi') {
			$this->db->where('distribusi_dokumen.exp !=', 0);
		} else {
			echo "Anda tidak memiliki akses!";
			die;
		}

		$data['dokumen_mrs'] = $this->db->get()->result_array();

		// distribusi dokumen
		$data['disdok'] = $this->db->get('distribusi_dokumen')->result_array();

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('order/dokumen-order', $data);
		$this->load->view('template/footer', $data);
	}
	// /////////////////////////////////////////////////////////// dokumen order index ////////////////////////////////////////////////////////////////







}
