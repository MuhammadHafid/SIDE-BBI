<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Import extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		cekSessionLogin();

	}


	public function dd()
	{
		
		$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		if(isset($_FILES['file_import']['name']) && in_array($_FILES['file_import']['type'], $file_mimes)) {

			$arr_file = explode('.', $_FILES['file_import']['name']);
			$extension = end($arr_file);

			if('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

			$spreadsheet = $reader->load($_FILES['file_import']['tmp_name']);

			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			for($i = 2;$i < count($sheetData);$i++)
			{

				$judul_dokumen = $sheetData[$i]['1'];
				$ppc = $sheetData[$i]['3'];
				$qc = $sheetData[$i]['4'];
				$qa = $sheetData[$i]['5'];
				$fab = $sheetData[$i]['6'];
				$mm = $sheetData[$i]['7'];
				$log = $sheetData[$i]['8'];
				$keu = $sheetData[$i]['9'];
				$eng = $sheetData[$i]['10'];
				$prod = $sheetData[$i]['11'];
				$hrd = $sheetData[$i]['12'];
				$sales = $sheetData[$i]['13'];
				$mpi = $sheetData[$i]['14'];
				$exp_dokumen = $sheetData[$i]['15'];				

				$jml_dokumen = intval($ppc) + intval($qc) + intval($qa) + intval($fab) + intval($mm) + intval($log) + intval($keu) + intval($eng)+ intval($prod) + intval($hrd) + intval($sales) + intval($mpi) + intval($exp_dokumen);

				// update distribusi_dokumen
				$this->db->set('jml_dokumen', $jml_dokumen);
				$this->db->set('ppc', $ppc);
				$this->db->set('qc', $qc);
				$this->db->set('qa', $qa);
				$this->db->set('fab', $fab);
				$this->db->set('mm', $mm);
				$this->db->set('log', $log);
				$this->db->set('keu', $keu);
				$this->db->set('eng', $eng);
				$this->db->set('prod', $prod);
				$this->db->set('hrd', $hrd);
				$this->db->set('sales', $sales);
				$this->db->set('mpi', $mpi);
				$this->db->set('exp_dokumen', $exp_dokumen);				

				$this->db->where('judul_dokumen =', $judul_dokumen);
				$this->db->update('distribusi_dokumen');

			}

			$this->session->set_flashdata('messageDd','<div class="alert alert-success" role="alert">Data berhasil diupdate!</div>');
			redirect('dd');

		}
	}




}