<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokumen_model extends CI_Model
{

	function tgl_indo($tanggal)
	{
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);

		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun

		return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
	}

	// /////////////////////////////////////////////////// tambah laporan produksi //////////////////////////////////////////////////////////
	public function tambahLapprod($file)
	{
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'lapprod' . '-' . time() . '-' . $file;
		$config['upload_path'] = './assets/file/lapprod/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_laporan')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// /////////////////////////////////////////////////// tambah laporan produksi //////////////////////////////////////////////////////////

	// /////////////////////////////////////////////////////////// tambah dokumen drawing //////////////////////////////////////////////////////////
	public function tambahDrawing($file)
	{

		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'drawing' . '-' . time() . '-' . $file;
		$config['upload_path'] = './assets/file/drawing/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_drawing')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// /////////////////////////////////////////////////////////// tambah dokumen drawing //////////////////////////////////////////////////////////

	// /////////////////////////////////////////////////////////// tambah dokumen spk //////////////////////////////////////////////////////////
	public function tambahSpk($file)
	{

		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'spk' . '-' . time() . '-' . $file;
		$config['upload_path'] = './assets/file/spk/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_spk')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// /////////////////////////////////////////////////////////// tambah dokumen spk //////////////////////////////////////////////////////////

	// ///////////////////////////////////////////////////////// tambah dokumen mscurve //////////////////////////////////////////////////////////
	public function tambahMscurve($file)
	{

		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'mscurve' . '-' . time() . '-' . $file;
		$config['upload_path'] = './assets/file/mscurve/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_mscurve')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ///////////////////////////////////////////////////////// tambah dokumen mscurve //////////////////////////////////////////////////////////

	// ///////////////////////////////////////////////////////// tambah dokumen ps //////////////////////////////////////////////////////////
	public function tambahPs($file)
	{

		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'ps' . '-' . time() . '-' . $file;
		$config['upload_path'] = './assets/file/ps/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_ps')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ///////////////////////////////////////////////////////// tambah dokumen ps //////////////////////////////////////////////////////////

	// ///////////////////////////////////////////////////////// tambah dokumen PR //////////////////////////////////////////////////////////
	public function tambahPr($file)
	{

		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'pr' . '-' . time() . '-' . $file;
		$config['upload_path'] = './assets/file/pr/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_pr')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ///////////////////////////////////////////////////////// tambah dokumen PR //////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////////////////// tambah dokumen BQ ////////////////////////////////////////////////////////////
	public function tambahBQ($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);

		// var_dump($extensi); die;

		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'bq' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/bq/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_bq')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ////////////////////////////////////////////////////////////// tambah dokumen BQ ////////////////////////////////////////////////////////////

	// ///////////////////////////////////////////////////////////// tambah dokumen EIS ////////////////////////////////////////////////////////////
	public function tambahEIS($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);

		// var_dump($extensi); die;

		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'eis' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/eis/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_eis')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ///////////////////////////////////////////////////////////// tambah dokumen EIS ////////////////////////////////////////////////////////////

	// ///////////////////////////////////////////////////////////// tambah dokumen MP ////////////////////////////////////////////////////////////
	public function tambahMP($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);

		// var_dump($extensi); die;

		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'mp' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/mp/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_mp')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ///////////////////////////////////////////////////////////// tambah dokumen MP ////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////////// tambah dokumen CLO ////////////////////////////////////////////////////////////
	public function tambahCLO($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);

		// var_dump($extensi); die;

		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'clo' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/clo/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_clo')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// //////////////////////////////////////////////////////////// tambah dokumen CLO ////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////////// tambah dokumen MRS ////////////////////////////////////////////////////////////
	public function tambahMRS($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);

		// var_dump($extensi); die;

		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'mrs' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/mrs/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_mrs')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// //////////////////////////////////////////////////////////// tambah dokumen MRS ////////////////////////////////////////////////////////////

	// /////////////////////////////////////////////////////////// revisi dokumen drawing //////////////////////////////////////////////////////////
	public function revisiDrawing($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'drawing' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/drawing/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_drawing')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// /////////////////////////////////////////////////////////// revisi dokumen drawing //////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////////////// revisi laporan produksi //////////////////////////////////////////////////////////
	public function revisiLapprod($file)
	{
		// ambil extensi file   
		$extensi = substr($file, strpos($file, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'lapprod' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/lapprod/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_laporan')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ////////////////////////////////////////////////////////// revisi laporan produksi //////////////////////////////////////////////////////////

	// /////////////////////////////////////////////////////////// revisi dokumen spk //////////////////////////////////////////////////////////
	public function revisiSpk($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'spk' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/spk/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_spk')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// /////////////////////////////////////////////////////////// revisi dokumen spk //////////////////////////////////////////////////////////

	// /////////////////////////////////////////////////////////// revisi dokumen mscurve //////////////////////////////////////////////////////////
	public function revisiMscurve($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'mscurve' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/mscurve/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_mscurve')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// /////////////////////////////////////////////////////////// revisi dokumen mscurve //////////////////////////////////////////////////////////

	// /////////////////////////////////////////////////////////// revisi dokumen ps //////////////////////////////////////////////////////////
	public function revisiPs($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'ps' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/ps/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_ps')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// /////////////////////////////////////////////////////////// revisi dokumen ps //////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////////////////// revisi dokumen BQ ////////////////////////////////////////////////////////////
	public function revisiBQ($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'drawing' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/bq/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_bq')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ////////////////////////////////////////////////////////////// revisi dokumen BQ ////////////////////////////////////////////////////////////

	// ///////////////////////////////////////////////////////////// revisi dokumen EIS ////////////////////////////////////////////////////////////
	public function revisiEIS($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'eis' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/eis/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_eis')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ///////////////////////////////////////////////////////////// revisi dokumen EIS ////////////////////////////////////////////////////////////

	// ///////////////////////////////////////////////////////////// revisi dokumen MP /////////////////////////////////////////////////////////////
	public function revisiMP($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'mp' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/mp/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_mp')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ///////////////////////////////////////////////////////////// revisi dokumen MP /////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////////// revisi dokumen CLO /////////////////////////////////////////////////////////////
	public function revisiCLO($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'clo' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/clo/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_clo')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// //////////////////////////////////////////////////////////// revisi dokumen CLO /////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////////// revisi dokumen MRS /////////////////////////////////////////////////////////////
	public function revisiMRS($file)
	{

		// ambil extensi foto   
		$extensi = substr($file, strpos($file, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'mrs' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/mrs/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_mrs')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// //////////////////////////////////////////////////////////// revisi dokumen CLO /////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////////// edit dokumen drawing ///////////////////////////////////////////////////////////
	public function editDrawing($file_lama, $file_baru)
	{

		if ($file_lama != NULL or $file_lama != '') {
			if (file_exists($file_lama)) {
				unlink(FCPATH . 'assets/file/drawing/' . $file_lama);
			}
		}

		// ambil extensi foto   
		$extensi = substr($file_baru, strpos($file_baru, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'drawing' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/drawing/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_drawing')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// //////////////////////////////////////////////////////////// edit dokumen drawing ///////////////////////////////////////////////////////

	// ///////////////////////////////////////////////// edit laporan produksi ///////////////////////////////////////////////////////
	public function editLapprod($file_lama, $file_baru)
	{

		if ($file_lama != NULL or $file_lama != '') {
			if (file_exists($file_lama)) {
				unlink(FCPATH . 'assets/file/lapprod/' . $file_lama);
			}
		}

		// ambil extensi foto   
		$extensi = substr($file_baru, strpos($file_baru, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'lapprod' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/lapprod/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_laporan')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ///////////////////////////////////////////////// edit laporan produksi ///////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////////// edit dokumen spk ///////////////////////////////////////////////////////////
	public function editSpk($file_lama, $file_baru)
	{
		if ($file_lama != NULL or $file_lama != '') {
			if (file_exists($file_lama)) {
				unlink(FCPATH . 'assets/file/spk/' . $file_lama);
			}
		}

		// ambil extensi foto   
		$extensi = substr($file_baru, strpos($file_baru, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'spk' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/spk/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_spk')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// //////////////////////////////////////////////////////////// edit dokumen spk ///////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////////////// edit dokumen mscurve ///////////////////////////////////////////////////////////
	public function editMscurve($file_lama, $file_baru)
	{
		if ($file_lama != NULL or $file_lama != '') {
			if (file_exists($file_lama)) {
				unlink(FCPATH . 'assets/file/mscurve/' . $file_lama);
			}
		}

		// ambil extensi foto   
		$extensi = substr($file_baru, strpos($file_baru, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'mscurve' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/mscurve/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_mscurve')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ////////////////////////////////////////////////////////// edit dokumen mscurve ///////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////////////// edit dokumen ps ///////////////////////////////////////////////////////////
	public function editPs($file_lama, $file_baru)
	{
		if ($file_lama != NULL or $file_lama != '') {
			if (file_exists($file_lama)) {
				unlink(FCPATH . 'assets/file/ps/' . $file_lama);
			}
		}

		// ambil extensi foto   
		$extensi = substr($file_baru, strpos($file_baru, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'ps' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/ps/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_ps')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ////////////////////////////////////////////////////////// edit dokumen ps ///////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////////////// edit dokumen PR ///////////////////////////////////////////////////////////
	public function editPr($file_lama, $file_baru)
	{
		if ($file_lama != NULL or $file_lama != '') {
			if (file_exists($file_lama)) {
				unlink(FCPATH . 'assets/file/pr/' . $file_lama);
			}
		}

		// ambil extensi foto   
		$extensi = substr($file_baru, strpos($file_baru, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'pr' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/pr/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_pr')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ////////////////////////////////////////////////////////// edit dokumen PR ///////////////////////////////////////////////////////////

	// ////////////////////////////////////////////////////////////// edit dokumen BQ //////////////////////////////////////////////////////////////
	public function editBQ($file_lama, $file_baru)
	{

		if ($file_lama != NULL or $file_lama != '') {
			if (file_exists($file_lama)) {
				unlink(FCPATH . 'assets/file/bq/' . $file_lama);
			}
		}

		// ambil extensi foto   
		$extensi = substr($file_baru, strpos($file_baru, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'drawing' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/bq/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_bq')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ////////////////////////////////////////////////////////////// edit dokumen BQ //////////////////////////////////////////////////////////////

	// ///////////////////////////////////////////////////////////// edit dokumen EIS //////////////////////////////////////////////////////////////
	public function editEIS($file_lama, $file_baru)
	{

		if ($file_lama != NULL or $file_lama != '') {
			if (file_exists($file_lama)) {
				unlink(FCPATH . 'assets/file/eis/' . $file_lama);
			}
		}

		// ambil extensi foto   
		$extensi = substr($file_baru, strpos($file_baru, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'eis' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/eis/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_eis')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ///////////////////////////////////////////////////////////// edit dokumen EIS //////////////////////////////////////////////////////////////

	// ///////////////////////////////////////////////////////////// edit dokumen MP ///////////////////////////////////////////////////////////////
	public function editMP($file_lama, $file_baru)
	{

		if ($file_lama != NULL or $file_lama != '') {
			if (file_exists($file_lama)) {
				unlink(FCPATH . 'assets/file/mp/' . $file_lama);
			}
		}

		// ambil extensi foto   
		$extensi = substr($file_baru, strpos($file_baru, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'mp' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/mp/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_mp')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// ///////////////////////////////////////////////////////////// edit dokumen MP ///////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////////// edit dokumen CLO ///////////////////////////////////////////////////////////////
	public function editCLO($file_lama, $file_baru)
	{

		if ($file_lama != NULL or $file_lama != '') {
			if (file_exists($file_lama)) {
				unlink(FCPATH . 'assets/file/clo/' . $file_lama);
			}
		}

		// ambil extensi foto   
		$extensi = substr($file_baru, strpos($file_baru, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'clo' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/clo/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_clo')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// //////////////////////////////////////////////////////////// edit dokumen CLO ///////////////////////////////////////////////////////////////

	// //////////////////////////////////////////////////////////// edit dokumen MRS ///////////////////////////////////////////////////////////////
	public function editMRS($file_lama, $file_baru)
	{

		if ($file_lama != NULL or $file_lama != '') {
			if (file_exists($file_lama)) {
				unlink(FCPATH . 'assets/file/mrs/' . $file_lama);
			}
		}

		// ambil extensi foto   
		$extensi = substr($file_baru, strpos($file_baru, ".") + 1);
		$config['allowed_types'] = 'pdf|xlsx';
		$config['max_size']     = '100000';
		$config['file_name'] = 'mrs' . sha1(time()) . '.' . $extensi;
		$config['upload_path'] = './assets/file/mrs/';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file_mrs')) {
			$nama_file = $this->upload->data('file_name');
			return $nama_file;
		} else {
			echo $this->display_errors();
		}
	}
	// //////////////////////////////////////////////////////////// edit dokumen MRS ///////////////////////////////////////////////////////////////


}
