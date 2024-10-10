<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class Export extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
	}

// //////////////////////////////////////////////// export excel dokumen order ////////////////////////////////////////////////////
	public function dokumenOrder($id)
	{
		
// ========================================================== data ================================================================

		// ambil cc_order where id
		$order = $this->db_keuangan->get_where('cc_ord', ['id'=> $id])->row_array();

		// ambil dokumen drawing where no order
		$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_drawing');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_drawing.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_drawing.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_drawing.revisi','left');
		$this->db->where('no_order =', $order['id_cc_ord']);
		$this->db->where('status =', 1);		
		$drawing = $this->db->get()->result_array();

		// ambil dokumen BQ where no order
		$this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_bq');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_bq.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_bq.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_bq.revisi','left');
		$this->db->where('no_order =', $order['id_cc_ord']);
		$this->db->where('status =', 1);		
		$bq = $this->db->get()->result_array();

		// ambil dokumen EIS where no order
		$this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_eis');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_eis.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_eis.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_eis.revisi','left');
		$this->db->where('no_order =', $order['id_cc_ord']);
		$this->db->where('status =', 1);		
		$eis = $this->db->get()->result_array();

		// ambil dokumen MP where no order
		$this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_mp');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_mp.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_mp.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_mp.revisi','left');
		$this->db->where('no_order =', $order['id_cc_ord']);
		$this->db->where('status =', 1);		
		$mp = $this->db->get()->result_array();	

		// ambil dokumen CLO where no order
		$this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_clo');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_clo.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_clo.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_clo.revisi','left');
		$this->db->where('no_order =', $order['id_cc_ord']);
		$this->db->where('status =', 1);		
		$clo = $this->db->get()->result_array();				

		// ambil dokumen MRS where no order
		$this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_mrs');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_mrs.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_mrs.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_mrs.revisi','left');
		$this->db->where('no_order =', $order['id_cc_ord']);
		$this->db->where('status =', 1);		
		$mrs = $this->db->get()->result_array();						

// =========================================================== data ===============================================================

// ======================================================= export excell ==========================================================
		
		$extension = 'xlsx';

		$fileName = 'Dokumen Order '.$order['id_cc_ord'];

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

		$from = "A1";
		$to = "J1";
		$spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold( true );
		$spreadsheet->getActiveSheet()->getStyle("A2:J2")->getFont()->setBold( true );
		$spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize( 16 );

		$spreadsheet->getActiveSheet()->mergeCells('A1:J1');

		$spreadsheet->getActiveSheet()->getStyle('A1')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$sheet->setCellValue('A1', 'Dokumen Order '.$order['id_cc_ord']);

		$sheet->setCellValue('A2', 'No');
		$sheet->setCellValue('B2', 'No Dokumen');
		$sheet->setCellValue('C2', 'Nama Dokumen');
		$sheet->setCellValue('D2', 'Tgl Dokumen');
		$sheet->setCellValue('E2', 'Status');
		$sheet->setCellValue('F2', 'Edisi');
		$sheet->setCellValue('G2', 'Revisi');
		$sheet->setCellValue('H2', 'Issue Sheet');
		$sheet->setCellValue('I2', 'Jenis');
		$sheet->setCellValue('J2', 'Valid');		

		// cetak mulai baris ke-3
		$rowCount = 3;
		$no = 1;

		// looping drawing
		foreach ($drawing as $d) {
			$sheet->setCellValue('A' . $rowCount, $no);
			$sheet->setCellValue('B' . $rowCount, $d['no_dokumen']);
			$sheet->setCellValue('C' . $rowCount, $d['nama_dokumen']);
			$spreadsheet->getActiveSheet()->getStyle('D' . $rowCount)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
			$sheet->setCellValue('D' . $rowCount, date('d-m-Y', strtotime($d['tgl_dokumen'])));
			$sheet->setCellValue('E' . $rowCount, $d['nama_status']);
			$sheet->setCellValue('F' . $rowCount, $d['nama_edisi']);
			$sheet->setCellValue('G' . $rowCount, $d['nama_revisi']);
			$sheet->setCellValue('H' . $rowCount, $d['no_sp']);			
			$sheet->setCellValue('I' . $rowCount, 'Drawing');
			if ($d['status'] == 1) {
				$sheet->setCellValue('J' . $rowCount, 'Valid');
			} else if ($d['status'] == 0) {
				$sheet->setCellValue('J' . $rowCount, 'Tidak Valid');
			}

			$rowCount++;
			$no++;
		}
		// looping drawing

		// looping BQ
		foreach ($bq as $b) {
			$sheet->setCellValue('A' . $rowCount, $no);
			$sheet->setCellValue('B' . $rowCount, $b['no_dokumen']);
			$sheet->setCellValue('C' . $rowCount, $b['nama_dokumen']);
			$spreadsheet->getActiveSheet()->getStyle('D' . $rowCount)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
			$sheet->setCellValue('D' . $rowCount, date('d-m-Y', strtotime($b['tgl_dokumen'])));
			$sheet->setCellValue('E' . $rowCount, $b['nama_status']);
			$sheet->setCellValue('F' . $rowCount, $b['nama_edisi']);
			$sheet->setCellValue('G' . $rowCount, $b['nama_revisi']);
			$sheet->setCellValue('H' . $rowCount, $b['no_sp']);			
			$sheet->setCellValue('I' . $rowCount, 'BQ');
			if ($b['status'] == 1) {
				$sheet->setCellValue('J' . $rowCount, 'Valid');
			} else if ($b['status'] == 0) {
				$sheet->setCellValue('J' . $rowCount, 'Tidak Valid');
			}

			$rowCount++;
			$no++;
		}
		// looping BQ

		// looping EIS
		foreach ($eis as $e) {
			$sheet->setCellValue('A' . $rowCount, $no);
			$sheet->setCellValue('B' . $rowCount, $e['no_dokumen']);
			$sheet->setCellValue('C' . $rowCount, $e['nama_dokumen']);
			$spreadsheet->getActiveSheet()->getStyle('D' . $rowCount)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
			$sheet->setCellValue('D' . $rowCount, date('d-m-Y', strtotime($e['tgl_dokumen'])));
			$sheet->setCellValue('E' . $rowCount, $e['nama_status']);
			$sheet->setCellValue('F' . $rowCount, $e['nama_edisi']);
			$sheet->setCellValue('G' . $rowCount, $e['nama_revisi']);
			$sheet->setCellValue('H' . $rowCount, $e['no_sp']);			
			$sheet->setCellValue('I' . $rowCount, 'EIS');
			if ($e['status'] == 1) {
				$sheet->setCellValue('J' . $rowCount, 'Valid');
			} else if ($e['status'] == 0) {
				$sheet->setCellValue('J' . $rowCount, 'Tidak Valid');
			}

			$rowCount++;
			$no++;
		}
		// looping EIS

		// looping MP
		foreach ($mp as $m) {
			$sheet->setCellValue('A' . $rowCount, $no);
			$sheet->setCellValue('B' . $rowCount, $m['no_dokumen']);
			$sheet->setCellValue('C' . $rowCount, $m['nama_dokumen']);
			$spreadsheet->getActiveSheet()->getStyle('D' . $rowCount)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
			$sheet->setCellValue('D' . $rowCount, date('d-m-Y', strtotime($m['tgl_dokumen'])));
			$sheet->setCellValue('E' . $rowCount, $m['nama_status']);
			$sheet->setCellValue('F' . $rowCount, $m['nama_edisi']);
			$sheet->setCellValue('G' . $rowCount, $m['nama_revisi']);
			$sheet->setCellValue('H' . $rowCount, $m['no_sp']);			
			$sheet->setCellValue('I' . $rowCount, 'MP');
			if ($m['status'] == 1) {
				$sheet->setCellValue('J' . $rowCount, 'Valid');
			} else if ($m['status'] == 0) {
				$sheet->setCellValue('J' . $rowCount, 'Tidak Valid');
			}

			$rowCount++;
			$no++;
		}
		// looping MP				

		// looping CLO
		foreach ($clo as $c) {
			$sheet->setCellValue('A' . $rowCount, $no);
			$sheet->setCellValue('B' . $rowCount, $c['no_dokumen']);
			$sheet->setCellValue('C' . $rowCount, $c['nama_dokumen']);
			$spreadsheet->getActiveSheet()->getStyle('D' . $rowCount)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
			$sheet->setCellValue('D' . $rowCount, date('d-m-Y', strtotime($c['tgl_dokumen'])));
			$sheet->setCellValue('E' . $rowCount, $c['nama_status']);
			$sheet->setCellValue('F' . $rowCount, $c['nama_edisi']);
			$sheet->setCellValue('G' . $rowCount, $c['nama_revisi']);
			$sheet->setCellValue('H' . $rowCount, $c['no_sp']);			
			$sheet->setCellValue('I' . $rowCount, 'CLO');
			if ($c['status'] == 1) {
				$sheet->setCellValue('J' . $rowCount, 'Valid');
			} else if ($c['status'] == 0) {
				$sheet->setCellValue('J' . $rowCount, 'Tidak Valid');
			}

			$rowCount++;
			$no++;
		}
		// looping CLO

		// looping MRS
		foreach ($mrs as $mr) {
			$sheet->setCellValue('A' . $rowCount, $no);
			$sheet->setCellValue('B' . $rowCount, $mr['no_dokumen']);
			$sheet->setCellValue('C' . $rowCount, $mr['nama_dokumen']);
			$spreadsheet->getActiveSheet()->getStyle('D' . $rowCount)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
			$sheet->setCellValue('D' . $rowCount, date('d-m-Y', strtotime($mr['tgl_dokumen'])));
			$sheet->setCellValue('E' . $rowCount, $mr['nama_status']);
			$sheet->setCellValue('F' . $rowCount, $mr['nama_edisi']);
			$sheet->setCellValue('G' . $rowCount, $mr['nama_revisi']);
			$sheet->setCellValue('H' . $rowCount, $mr['no_sp']);			
			$sheet->setCellValue('I' . $rowCount, 'MRS');
			if ($mr['status'] == 1) {
				$sheet->setCellValue('J' . $rowCount, 'Valid');
			} else if ($mr['status'] == 0) {
				$sheet->setCellValue('J' . $rowCount, 'Tidak Valid');
			}

			$rowCount++;
			$no++;
		}
		// looping MRS				




		if($extension == 'csv'){          
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
			$fileName = $fileName.'.csv';
		} elseif($extension == 'xlsx') {
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
			$fileName = $fileName.'.xlsx';
		} else {
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
			$fileName = $fileName.'.xls';
		}

		$spreadsheet->getActiveSheet()->setTitle('Dokumen Order '.$order['id_cc_ord']);

		// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='.$fileName);
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit;
		// End Coba Download

// ======================================================== export excell =========================================================




	}
// ///////////////////////////////////////////////// export excel dokumen order ///////////////////////////////////////////////////

// ////////////////////////////////////////////////// export excel transmittal ////////////////////////////////////////////////////
	public function transmittal($id_transmittal, $no_order)
	{
		
// =========================================================== data ==============================================================

		// ambil no_sp where id transmittal
		$this->db->select('*');
		$this->db->from('transmittal');
		$this->db->where('id_transmittal =', $id_transmittal);
		$t = $this->db->get()->row_array();

		$no_sp = $t['no_sp'];

		// ambil transmittal where no sp
		$transmittal = $this->db->get_where('transmittal',['no_sp' => $no_sp])->row_array();

		// ambil cc_order where id cc order
		$this->db_keuangan->select('cc_ord.*, customer.nama_customer');
		$this->db_keuangan->from('cc_ord');
		$this->db_keuangan->join('customer','customer.id_customer = cc_ord.kode_cst','left');
		$this->db_keuangan->where('cc_ord.id_cc_ord =', $no_order);
		$order = $this->db_keuangan->get()->row_array();

		// ambil dokumen drawing where no_sp dan status
		$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_drawing');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_drawing.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_drawing.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_drawing.revisi','left');		
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);
		$drawing = $this->db->get()->result_array();

		// var_dump($drawing); die;

		// ambil dokumen bq where no_sp dan ststus
		$this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_bq');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_bq.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_bq.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_bq.revisi','left');
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);
		$bq = $this->db->get()->result_array();

		// ambil dokumen EIS where no_sp dan ststus
		$this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_eis');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_eis.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_eis.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_eis.revisi','left');
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);
		$eis = $this->db->get()->result_array();

		// ambil dokumen MP where no_sp dan status
		$this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_mp');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_mp.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_mp.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_mp.revisi','left');
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);					
		$mp = $this->db->get()->result_array();	

		// ambil dokumen CLO where no_sp dan status
		$this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_clo');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_clo.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_clo.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_clo.revisi','left');
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);					
		$clo = $this->db->get()->result_array();				

		// ambil dokumen MRS where no_sp dan status
		$this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi');
		$this->db->from('dokumen_mrs');
		$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_mrs.status_dokumen','left');
		$this->db->join('edisi','edisi.id_edisi = dokumen_mrs.edisi','left');
		$this->db->join('revisi','revisi.id_revisi = dokumen_mrs.revisi','left');
		$this->db->where('no_sp =', $no_sp);
		// $this->db->where('status =', 1);					
		$mrs = $this->db->get()->result_array();						

// =========================================================== data ==============================================================

// ======================================================== export excell ========================================================
		
		$extension = 'xlsx';

		$fileName = 'Transmittal Dokumen Order '.$no_order;

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);

		// header dokumen 
		$from = "A1";
		$to = "U1";
		$spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold( true );
		// $spreadsheet->getActiveSheet()->getStyle("A2:J2")->getFont()->setBold( true );
		$spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize( 16 );

		$spreadsheet->getActiveSheet()->mergeCells('A1:U1');

		$spreadsheet->getActiveSheet()->getStyle('A1')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$sheet->setCellValue('A1', 'Transmittal Dokumen Order '.$no_order);
		// header dokumen

		// QP 
		$a = "A2";
		$b = "U2";
		$spreadsheet->getActiveSheet()->getStyle("A2")->getFont()->setSize( 9 );

		$spreadsheet->getActiveSheet()->mergeCells('A2:U2');

		$spreadsheet->getActiveSheet()->getStyle('A2')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->setCellValue('A2', 'Form : QP-2110-04-01');
		// QP

		// PEMBUAT DOKUMEN (ORIGINATOR) : ENGINEERING
		$spreadsheet->getActiveSheet()->getStyle("A3")->getFont()->setSize( 10 );
		$spreadsheet->getActiveSheet()->mergeCells('A3:C4');
		$spreadsheet->getActiveSheet()->getStyle('A3:C4')
		->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);
		$spreadsheet->getActiveSheet()->getStyle('A3:C4')
		->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// PEMBUAT DOKUMEN (ORIGINATOR) : ENGINEERING

		// No. SP (ISSUE NO) : 79/20.032.1/2640/02.2021
		$spreadsheet->getActiveSheet()->getStyle("A5")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('A5:C6');
		$spreadsheet->getActiveSheet()->getStyle('A5:C6')
		->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A5')->getAlignment()->setWrapText(true);	
		$spreadsheet->getActiveSheet()->getStyle('A5')
		->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// No. SP (ISSUE NO) : 79/20.032.1/2640/02.2021

		// LEMBAR PENGIRIMAN DAN PEMBATALAN DOKUMEN
		$spreadsheet->getActiveSheet()->getStyle("D3")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('D3:M4');
		$spreadsheet->getActiveSheet()->getStyle('D3:M4')
		->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('D3')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle("D3")->getFont()->setBold( true );
		$spreadsheet->getActiveSheet()->getStyle('D3:M6')
		->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// LEMBAR PENGIRIMAN DAN PEMBATALAN DOKUMEN

		// (ISSUE & CANCELATION SHEET)
		$spreadsheet->getActiveSheet()->getStyle("D5")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('D5:M5');
		$spreadsheet->getActiveSheet()->getStyle('D5')
		->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('D5')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle("D5")->getFont()->setBold( true );
		$spreadsheet->getActiveSheet()->mergeCells('D6:M6');
		// (ISSUE & CANCELATION SHEET)

		// ORDER
		$spreadsheet->getActiveSheet()->getStyle("N3")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('N3:P3');
		$spreadsheet->getActiveSheet()->getStyle('N3:U6')
		->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$spreadsheet->getActiveSheet()->getStyle('N3:U6')
		->getBorders()->getHorizontal()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);		
		// ORDER

		// :
		$spreadsheet->getActiveSheet()->getStyle("Q3")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('Q3')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		// :

		// No Order
		$spreadsheet->getActiveSheet()->getStyle("R3")->getFont()->setSize( 10 );
		$spreadsheet->getActiveSheet()->mergeCells('R3:U3');
		// No Order

		// CUSTOMER
		$spreadsheet->getActiveSheet()->getStyle("N4")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('N4:P4');
		// CUSTOMER

		// :
		$spreadsheet->getActiveSheet()->getStyle("Q4")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('Q4')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		// :

		// Nama Customer
		$spreadsheet->getActiveSheet()->getStyle("R4")->getFont()->setSize( 8 );
		$spreadsheet->getActiveSheet()->mergeCells('R4:U4');
		// Nama Customer

		// PROJECT
		$spreadsheet->getActiveSheet()->getStyle("N5")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('N5:P5');
		// PROJECT

		// :
		$spreadsheet->getActiveSheet()->getStyle("Q5")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('Q5')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		// :

		// Nama Project
		$spreadsheet->getActiveSheet()->getStyle("R5")->getFont()->setSize( 8 );
		$spreadsheet->getActiveSheet()->mergeCells('R5:U5');
		// Nama Project

		// HALAMAN (PAGE)
		$spreadsheet->getActiveSheet()->getStyle("N6")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('N6:P6');
		// HALAMAN (PAGE)

		// :
		$spreadsheet->getActiveSheet()->getStyle("Q6")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('Q6')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		// :

		// Halaman
		$spreadsheet->getActiveSheet()->getStyle("R6")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('R6:U6');
		// Halaman

		// NO
		$spreadsheet->getActiveSheet()->getStyle("A7")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('A7:A9');
		$spreadsheet->getActiveSheet()->getStyle('A7:A9')
		->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		// NO

		// Nama Dokumen
		$spreadsheet->getActiveSheet()->getStyle("B7")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('B7:B8');
		$spreadsheet->getActiveSheet()->getStyle('B7:B8')
		->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B7')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// Nama Dokumen

		// No Dokumen
		$spreadsheet->getActiveSheet()->getStyle("B9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('B9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// No Dokumen

		// Total
		$spreadsheet->getActiveSheet()->getStyle("C7")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('C7')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// Total

		// Ukuran
		$spreadsheet->getActiveSheet()->getStyle("C8")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('C8')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// Ukuran

		// Size
		$spreadsheet->getActiveSheet()->getStyle("C9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('C9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// Size

		// PENGIRIMAN (ISSUE)
		$spreadsheet->getActiveSheet()->getStyle("D7")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('D7:L7');		
		$spreadsheet->getActiveSheet()->getStyle('D7')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// PENGIRIMAN (ISSUE)

		// Rev./Ed.
		$spreadsheet->getActiveSheet()->getStyle("D8")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('D8:D9');		
		$spreadsheet->getActiveSheet()->getStyle('D8')
		->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('D8')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// Rev./Ed.

		// KEPADA (to)
		$spreadsheet->getActiveSheet()->getStyle("E8")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('E8:L8');		
		$spreadsheet->getActiveSheet()->getStyle('E8')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// KEPADA (to)

		// PPC
		$spreadsheet->getActiveSheet()->getStyle("E9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('E9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// PPC

		// QA
		$spreadsheet->getActiveSheet()->getStyle("F9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('F9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// QA		

		// QC
		$spreadsheet->getActiveSheet()->getStyle("G9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('G9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// QC

		// FAB
		$spreadsheet->getActiveSheet()->getStyle("H9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('H9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// FAB		

		// MM
		$spreadsheet->getActiveSheet()->getStyle("I9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('I9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// MM

		// LOG
		$spreadsheet->getActiveSheet()->getStyle("J9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('J9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// LOG		

		// KEU
		$spreadsheet->getActiveSheet()->getStyle("K9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('K9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// KEU

		// Engineering
		$spreadsheet->getActiveSheet()->getStyle("L9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('L9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// Engineering

		// PEMBATALAN (CANCELATION)
		$spreadsheet->getActiveSheet()->getStyle("M7")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('M7:U7');
		$spreadsheet->getActiveSheet()->getStyle('M7')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// PEMBATALAN (CANCELATION)

		// Rev./Ed.
		$spreadsheet->getActiveSheet()->getStyle("M8")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('M8:M9');		
		$spreadsheet->getActiveSheet()->getStyle('M8')
		->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('M8')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// Rev./Ed.

		// DARI (From)
		$spreadsheet->getActiveSheet()->getStyle("N8")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('N8:U8');		
		$spreadsheet->getActiveSheet()->getStyle('N8')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// DARI (From)

		// PPC
		$spreadsheet->getActiveSheet()->getStyle("N9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('N9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// PPC

		// QA
		$spreadsheet->getActiveSheet()->getStyle("O9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('O9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// QA		

		// QC
		$spreadsheet->getActiveSheet()->getStyle("P9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('P9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// QC

		// FAB
		$spreadsheet->getActiveSheet()->getStyle("Q9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('Q9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// FAB

		// MM
		$spreadsheet->getActiveSheet()->getStyle("R9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('R9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// MM

		// Logistik
		$spreadsheet->getActiveSheet()->getStyle("S9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('S9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// Logistik		

		// Keuangan
		$spreadsheet->getActiveSheet()->getStyle("T9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('T9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// Keuangan

		// Engineering
		$spreadsheet->getActiveSheet()->getStyle("U9")->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->getStyle('U9')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		// Engineering

		$sheet->setCellValue('A3', 'PEMBUAT DOKUMEN (ORIGINATOR) : ENGINEERING');
		$sheet->setCellValue('D3', 'LEMBAR PENGIRIMAN DAN PEMBATALAN DOKUMEN');
		$sheet->setCellValue('D5', '(ISSUE & CANCELATION SHEET)');		
		$sheet->setCellValue('A5', 'No. SP (ISSUE NO) : '.$no_sp);
		$sheet->setCellValue('N3', 'ORDER');
		$sheet->setCellValue('N4', 'CUSTOMER');
		$sheet->setCellValue('N5', 'PROJECT');		
		$sheet->setCellValue('N6', 'HALAMAN (PAGE)');				
		$sheet->setCellValue('Q3', ':');
		$sheet->setCellValue('Q4', ':');
		$sheet->setCellValue('Q5', ':');
		$sheet->setCellValue('Q6', ':');
		$sheet->setCellValue('R3', $order['id_cc_ord']);					
		$sheet->setCellValue('R4', $order['nama_customer']);
		$sheet->setCellValue('R5', $order['pekerjaan']);						
		$sheet->setCellValue('R6', '1 of 1');
		$sheet->setCellValue('A7', 'NO');
		$sheet->setCellValue('B7', 'NAMA DOKUMEN (Document Title)');
		$sheet->setCellValue('B9', 'NO. DOKUMEN (Doc. No)');
		$sheet->setCellValue('C7', 'TOTAL');			
		$sheet->setCellValue('C8', 'UKURAN');
		$sheet->setCellValue('C9', '(SIZE)');
		$sheet->setCellValue('D7', 'PENGIRIMAN (ISSUE)');
		$sheet->setCellValue('D8', 'Rev./Ed.');
		$sheet->setCellValue('E8', 'KEPADA (To)');	
		$sheet->setCellValue('E9', 'PPC');	
		$sheet->setCellValue('F9', 'QA');	
		$sheet->setCellValue('G9', 'QC');	
		$sheet->setCellValue('H9', 'FAB');
		$sheet->setCellValue('I9', 'MM');	
		$sheet->setCellValue('J9', 'LOG');	
		$sheet->setCellValue('K9', '');	
		$sheet->setCellValue('L9', '');
		$sheet->setCellValue('M7', 'PEMBATALAN (CANCELATION)');
		$sheet->setCellValue('M8', 'Rev./Ed.');
		$sheet->setCellValue('N8', 'DARI (From)');		
		$sheet->setCellValue('N9', 'PPC');	
		$sheet->setCellValue('O9', 'QA');	
		$sheet->setCellValue('P9', 'QC');	
		$sheet->setCellValue('Q9', 'FAB');
		$sheet->setCellValue('R9', 'MM');	
		$sheet->setCellValue('S9', 'LOG');	
		$sheet->setCellValue('T9', '');	
		$sheet->setCellValue('U9', '');


// ========================================================== looping =============================================================

		$row = 10;
		// $row_no = $row + 2;
		$no = 1;
		// $row_nama_dokumen = $row + 1;
		// $row_no_dokumen = $row + 2;
		// $row_jumlah = $row + 1;
		// $row_ukuran = $row + 2;

		// border
		$spreadsheet->getActiveSheet()->getStyle('A7:U9')
		->getBorders()->getAllborders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// border

// ==================================================== looping drawing ===========================================================

		foreach ($drawing as $dr) {

			$row_no = $row + 2;
			$row_nama_dokumen = $row + 1;
			$row_no_dokumen = $row + 2;
			$row_jumlah = $row + 1;
			$row_ukuran = $row + 2;
			$row_revisi = $row + 2;			
			$row_border = $row + 2;

			// ambil dokumen terakhir sebelum di revisi, where no sp, status = 0, order by tgl dokumen, desc
			$this->db->select('dokumen_drawing.*, nama_status, nama_edisi, nama_revisi');
			$this->db->from('dokumen_drawing');
			$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_drawing.status_dokumen','left');
			$this->db->join('edisi','edisi.id_edisi = dokumen_drawing.edisi','left');
			$this->db->join('revisi','revisi.id_revisi = dokumen_drawing.revisi','left');		
			$this->db->where('no_dokumen =', $dr['no_dokumen']);
			$this->db->where('status =', 0);
			
			if ($dr['status'] == 0) {

				$this->db->where('revisi !=', $dr['revisi']);
			}

			$this->db->order_by('tgl_dokumen','DESC');
			$r_drawing = $this->db->get()->row_array();

			// ambil distribusi dokumen
			$disdok = $this->db->get_where('distribusi_dokumen',['id_dd'=>$dr['id_dd']])->row_array();

		// NO
			$spreadsheet->getActiveSheet()->getStyle("A".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('A'.$row.':A'.$row_no);
			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':A'.$row_no)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('A'.$row, $no);
		// NO

		// Nama Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('B'.$row.':B'.$row_nama_dokumen);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row.':B'.$row_nama_dokumen)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);

			$sheet->setCellValue('B'.$row, $dr['nama_dokumen']);
		// Nama Dokumen

		// No Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row_no_dokumen)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('B'.$row_no_dokumen)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$sheet->setCellValue('B'.$row_no_dokumen, $dr['no_dokumen']);
		// No Dokumen

		// Jumlah
			$spreadsheet->getActiveSheet()->getStyle("C".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('C'.$row.':C'.$row_jumlah);		
			$spreadsheet->getActiveSheet()->getStyle('C'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('C'.$row.':C'.$row_jumlah)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

			$sheet->setCellValue('C'.$row, $dr['total1'].'x'.$dr['total2']);
		// Jumlah		

		// Ukuran
			$spreadsheet->getActiveSheet()->getStyle("C".$row_ukuran)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
		// Ukuran		

			$sheet->setCellValue('C'.$row_ukuran, $dr['ukuran']);

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("D".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('D'.$row.':D'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row.':D'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('D'.$row, $dr['nama_revisi'].'/'.$dr['nama_edisi']);
		// Rev./Ed.		

		// PPC
			$spreadsheet->getActiveSheet()->getStyle("E".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('E'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('E'.$row)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);		

			if ($disdok['ppc'] != 0) {
				$sheet->setCellValue('E'.$row, $disdok['ppc'].'x1');
			}else{
				$sheet->setCellValue('E'.$row, '');
			}
		// PPC

		// QA
			$spreadsheet->getActiveSheet()->getStyle("F".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('F'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			if ($disdok['qa'] != 0) {
				$sheet->setCellValue('F'.$row, $disdok['qa'].'x1');
			}else{
				$sheet->setCellValue('F'.$row, '');
			}
		// QA

		// QC
			$spreadsheet->getActiveSheet()->getStyle("G".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('G'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			if ($disdok['qc'] != 0) {
				$sheet->setCellValue('G'.$row, $disdok['qc'].'x1');
			}else{
				$sheet->setCellValue('G'.$row, '');
			}
		// QC

		// FAB
			$spreadsheet->getActiveSheet()->getStyle("H".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('H'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			if ($disdok['fab'] != 0) {
				$sheet->setCellValue('H'.$row, $disdok['fab'].'x1');
			}else{
				$sheet->setCellValue('H'.$row, '');
			}
		// FAB

		// MM
			$spreadsheet->getActiveSheet()->getStyle("I".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('I'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			if ($disdok['mm'] != 0) {
				$sheet->setCellValue('I'.$row, $disdok['mm'].'x1');
			}else{
				$sheet->setCellValue('I'.$row, '');
			}
		// MM

		// LOG
			$spreadsheet->getActiveSheet()->getStyle("J".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('J'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			if ($disdok['log'] != 0) {
				$sheet->setCellValue('J'.$row, $disdok['log'].'x1');
			}else{
				$sheet->setCellValue('J'.$row, '');
			}
		// log

		// KEU
			$spreadsheet->getActiveSheet()->getStyle("K".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('K'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			if ($disdok['keu'] != 0) {
				$sheet->setCellValue('K'.$row, '');
			}else{
				$sheet->setCellValue('K'.$row, '');
			}
		// KEU

		// Engineering
			$spreadsheet->getActiveSheet()->getStyle("L".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('L'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			if ($disdok['eng'] != 0) {
				$sheet->setCellValue('L'.$row, '');
			}else{
				$sheet->setCellValue('L'.$row, '');
			}
		// Engineering

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("M".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('M'.$row.':M'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row.':M'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('M'.$row)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);		

			if ($r_drawing == NULL) {

				$sheet->setCellValue('M'.$row, '');
				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('N'.$row, '');
				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('O'.$row, '');
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('P'.$row, '');
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('Q'.$row, '');
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('R'.$row, '');	
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('S'.$row, '');	
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('T'.$row, '');	
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('U'.$row, '');	
				// ENG


			} else {

				$sheet->setCellValue('M'.$row, $r_drawing['nama_revisi'].'/'.$r_drawing['nama_edisi']);
				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

				if ($disdok['ppc'] != 0) {
					$sheet->setCellValue('N'.$row, $disdok['ppc'].'x1');
				}else{
					$sheet->setCellValue('N'.$row, '');
				}
				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				
				if ($disdok['qa'] != 0) {
					$sheet->setCellValue('O'.$row, $disdok['qa'].'x1');
				}else{
					$sheet->setCellValue('O'.$row, '');
				}
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

				if ($disdok['qc'] != 0) {
					$sheet->setCellValue('P'.$row, $disdok['qc'].'x1');
				}else{
					$sheet->setCellValue('P'.$row, '');
				}
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

				if ($disdok['fab'] != 0) {
					$sheet->setCellValue('Q'.$row, $disdok['fab'].'x1');
				}else{
					$sheet->setCellValue('Q'.$row, '');
				}
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

				if ($disdok['mm'] != 0) {
					$sheet->setCellValue('R'.$row, $disdok['mm'].'x1');
				}else{
					$sheet->setCellValue('R'.$row, '');
				}
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

				if ($disdok['log'] != 0) {
					$sheet->setCellValue('S'.$row, $disdok['log'].'x1');
				}else{
					$sheet->setCellValue('S'.$row, '');
				}
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

				if ($disdok['keu'] != 0) {
					$sheet->setCellValue('T'.$row, '');
				}else{
					$sheet->setCellValue('T'.$row, '');
				}
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

				if ($disdok['eng'] != 0) {
					$sheet->setCellValue('U'.$row, '');
				}else{
					$sheet->setCellValue('U'.$row, '');
				}
				// ENG


			}

		// Rev./Ed.

			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':U'.$row_border)
			->getBorders()->getAllborders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


			$row += 3;
			$no ++;

		}
// ====================================================== looping drawing ===========================================================

// ======================================================== looping BQ ==============================================================
		foreach ($bq as $dbq) {

			$row_no = $row + 2;
			$row_nama_dokumen = $row + 1;
			$row_no_dokumen = $row + 2;
			$row_jumlah = $row + 1;
			$row_ukuran = $row + 2;
			$row_revisi = $row + 2;			
			$row_border = $row + 2;

		// ambil dokumen terakhir sebelum di revisi, where no sp, status = 0, order by tgl dokumen, desc
			$this->db->select('dokumen_bq.*, nama_status, nama_edisi, nama_revisi');
			$this->db->from('dokumen_bq');
			$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_bq.status_dokumen','left');
			$this->db->join('edisi','edisi.id_edisi = dokumen_bq.edisi','left');
			$this->db->join('revisi','revisi.id_revisi = dokumen_bq.revisi','left');		
			$this->db->where('no_dokumen =', $dbq['no_dokumen']);
			$this->db->where('status =', 0);

			if ($dbq['status'] == 0) {

				$this->db->where('revisi !=', $dbq['revisi']);
			}

			$this->db->order_by('tgl_dokumen','DESC');
			$r_bq = $this->db->get()->row_array();

			// ambil distribusi dokumen
			$disdok = $this->db->get_where('distribusi_dokumen',['id_dd'=>$dbq['id_dd']])->row_array();

		// NO
			$spreadsheet->getActiveSheet()->getStyle("A".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('A'.$row.':A'.$row_no);
			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':A'.$row_no)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('A'.$row, $no);
		// NO

		// Nama Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('B'.$row.':B'.$row_nama_dokumen);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row.':B'.$row_nama_dokumen)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);

			$sheet->setCellValue('B'.$row, $dbq['nama_dokumen']);
		// Nama Dokumen

		// No Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row_no_dokumen)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('B'.$row_no_dokumen)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$sheet->setCellValue('B'.$row_no_dokumen, $dbq['no_dokumen']);
		// No Dokumen

		// Jumlah
			$spreadsheet->getActiveSheet()->getStyle("C".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('C'.$row.':C'.$row_jumlah);		
			$spreadsheet->getActiveSheet()->getStyle('C'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('C'.$row.':C'.$row_jumlah)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

			$sheet->setCellValue('C'.$row, $dbq['total1'].'x'.$dbq['total2']);
		// Jumlah		

		// Ukuran
			$spreadsheet->getActiveSheet()->getStyle("C".$row_ukuran)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
		// Ukuran		

			$sheet->setCellValue('C'.$row_ukuran, $dbq['ukuran']);

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("D".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('D'.$row.':D'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row.':D'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('D'.$row, $dbq['nama_revisi'].'/'.$dbq['nama_edisi']);
		// Rev./Ed.		

			// PPC
			$spreadsheet->getActiveSheet()->getStyle("E".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('E'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['ppc'] != 0) {
				$sheet->setCellValue('E'.$row, $disdok['ppc'].'x1');
			}else{
				$sheet->setCellValue('E'.$row, '');
			}
			// PPC
			// QA
			$spreadsheet->getActiveSheet()->getStyle("F".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('F'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['qa'] != 0) {
				$sheet->setCellValue('F'.$row, $disdok['qa'].'x1');
			}else{
				$sheet->setCellValue('F'.$row, '');
			}
			// QA
			// QC
			$spreadsheet->getActiveSheet()->getStyle("G".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('G'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['qc'] != 0) {
				$sheet->setCellValue('G'.$row, $disdok['qc'].'x1');
			}else{
				$sheet->setCellValue('G'.$row, '');
			}
			// QC
			// FAB
			$spreadsheet->getActiveSheet()->getStyle("H".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('H'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['fab'] != 0) {
				$sheet->setCellValue('H'.$row, $disdok['fab'].'x1');
			}else{
				$sheet->setCellValue('H'.$row, '');
			}
			// FAB
			// MM
			$spreadsheet->getActiveSheet()->getStyle("I".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('I'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['mm'] != 0) {
				$sheet->setCellValue('I'.$row, $disdok['mm'].'x1');
			}else{
				$sheet->setCellValue('I'.$row, '');
			}
			// MM
			// LOG
			$spreadsheet->getActiveSheet()->getStyle("J".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('J'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['log'] != 0) {
				$sheet->setCellValue('J'.$row, $disdok['log'].'x1');
			}else{
				$sheet->setCellValue('J'.$row, '');
			}
			// LOG
			// KEU
			$spreadsheet->getActiveSheet()->getStyle("K".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('K'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['keu'] != 0) {
				$sheet->setCellValue('K'.$row, $disdok['keu'].'x1');
			}else{
				$sheet->setCellValue('K'.$row, '');
			}
			// KEU
			// ENG
			$spreadsheet->getActiveSheet()->getStyle("L".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('L'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['eng'] != 0) {
				$sheet->setCellValue('L'.$row, $disdok['eng'].'x1');
			}else{
				$sheet->setCellValue('L'.$row, '');
			}
			// ENG

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("M".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('M'.$row.':M'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row.':M'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			if ($r_bq == NULL) {

				$sheet->setCellValue('M'.$row, '');
				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('N'.$row, '');
				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('O'.$row, '');
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('P'.$row, '');
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('Q'.$row, '');
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('R'.$row, '');	
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('S'.$row, '');	
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('T'.$row, '');	
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('U'.$row, '');	
				// ENG


			} else {

				$sheet->setCellValue('M'.$row, $r_bq['nama_revisi'].'/'.$r_bq['nama_edisi']);
				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

				if ($disdok['ppc'] != 0) {
					$sheet->setCellValue('N'.$row, $disdok['ppc'].'x1');
				}else{
					$sheet->setCellValue('N'.$row, '');
				}

				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['qa'] != 0) {
					$sheet->setCellValue('O'.$row, $disdok['qa'].'x1');
				}else{
					$sheet->setCellValue('O'.$row, '');
				}
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['qc'] != 0) {
					$sheet->setCellValue('P'.$row, $disdok['qc'].'x1');
				}else{
					$sheet->setCellValue('P'.$row, '');
				}
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['fab'] != 0) {
					$sheet->setCellValue('Q'.$row, $disdok['fab'].'x1');
				}else{
					$sheet->setCellValue('Q'.$row, '');
				}
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['mm'] != 0) {
					$sheet->setCellValue('R'.$row, $disdok['mm'].'x1');
				}else{
					$sheet->setCellValue('R'.$row, '');
				}
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['log'] != 0) {
					$sheet->setCellValue('S'.$row, $disdok['log'].'x1');
				}else{
					$sheet->setCellValue('S'.$row, '');
				}
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['keu'] != 0) {
					$sheet->setCellValue('T'.$row, '');
				}else{
					$sheet->setCellValue('T'.$row, '');
				}
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['eng'] != 0) {
					$sheet->setCellValue('U'.$row, '');
				}else{
					$sheet->setCellValue('U'.$row, '');
				}
				// ENG


			}

		// Rev./Ed.

			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':U'.$row_border)
			->getBorders()->getAllborders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


			$row += 3;
			$no ++;

		}
// ======================================================== looping BQ ==============================================================

// ======================================================= looping EIS ==============================================================
		foreach ($eis as $dei) {

			$row_no = $row + 2;
			$row_nama_dokumen = $row + 1;
			$row_no_dokumen = $row + 2;
			$row_jumlah = $row + 1;
			$row_ukuran = $row + 2;
			$row_revisi = $row + 2;			
			$row_border = $row + 2;

		// ambil dokumen terakhir sebelum di revisi, where no sp, status = 0, order by tgl dokumen, desc
			$this->db->select('dokumen_eis.*, nama_status, nama_edisi, nama_revisi');
			$this->db->from('dokumen_eis');
			$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_eis.status_dokumen','left');
			$this->db->join('edisi','edisi.id_edisi = dokumen_eis.edisi','left');
			$this->db->join('revisi','revisi.id_revisi = dokumen_eis.revisi','left');		
			$this->db->where('no_dokumen =', $dei['no_dokumen']);
			$this->db->where('status =', 0);

			if ($dei['status'] == 0) {

				$this->db->where('revisi !=', $dei['revisi']);
			}

			$this->db->order_by('tgl_dokumen','DESC');
			$r_eis = $this->db->get()->row_array();

			// ambil distribusi dokumen
			$disdok = $this->db->get_where('distribusi_dokumen',['id_dd'=>$dei['id_dd']])->row_array();

		// NO
			$spreadsheet->getActiveSheet()->getStyle("A".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('A'.$row.':A'.$row_no);
			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':A'.$row_no)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('A'.$row, $no);
		// NO

		// Nama Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('B'.$row.':B'.$row_nama_dokumen);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row.':B'.$row_nama_dokumen)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);

			$sheet->setCellValue('B'.$row, $dei['nama_dokumen']);
		// Nama Dokumen

		// No Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row_no_dokumen)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('B'.$row_no_dokumen)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$sheet->setCellValue('B'.$row_no_dokumen, $dei['no_dokumen']);
		// No Dokumen

		// Jumlah
			$spreadsheet->getActiveSheet()->getStyle("C".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('C'.$row.':C'.$row_jumlah);		
			$spreadsheet->getActiveSheet()->getStyle('C'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('C'.$row.':C'.$row_jumlah)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

			$sheet->setCellValue('C'.$row, $dei['total1'].'x'.$dei['total2']);
		// Jumlah		

		// Ukuran
			$spreadsheet->getActiveSheet()->getStyle("C".$row_ukuran)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
		// Ukuran		

			$sheet->setCellValue('C'.$row_ukuran, $dei['ukuran']);

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("D".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('D'.$row.':D'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row.':D'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('D'.$row, $dei['nama_revisi'].'/'.$dei['nama_edisi']);
		// Rev./Ed.		

			// PPC
			$spreadsheet->getActiveSheet()->getStyle("E".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('E'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['ppc'] != 0) {
				$sheet->setCellValue('E'.$row, $disdok['ppc'].'x1');
			}else{
				$sheet->setCellValue('E'.$row, '');
			}
			// PPC
			// QA
			$spreadsheet->getActiveSheet()->getStyle("F".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('F'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['qa'] != 0) {
				$sheet->setCellValue('F'.$row, $disdok['qa'].'x1');
			}else{
				$sheet->setCellValue('F'.$row, '');
			}
			// QA
			// QC
			$spreadsheet->getActiveSheet()->getStyle("G".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('G'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['qc'] != 0) {
				$sheet->setCellValue('G'.$row, $disdok['qc'].'x1');
			}else{
				$sheet->setCellValue('G'.$row, '');
			}
			// QC
			// FAB
			$spreadsheet->getActiveSheet()->getStyle("H".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('H'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['fab'] != 0) {
				$sheet->setCellValue('H'.$row, $disdok['fab'].'x1');
			}else{
				$sheet->setCellValue('H'.$row, '');
			}
			// FAB
			// MM
			$spreadsheet->getActiveSheet()->getStyle("I".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('I'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['mm'] != 0) {
				$sheet->setCellValue('I'.$row, $disdok['mm'].'x1');
			}else{
				$sheet->setCellValue('I'.$row, '');
			}
			// MM
			// LOG
			$spreadsheet->getActiveSheet()->getStyle("J".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('J'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['log'] != 0) {
				$sheet->setCellValue('J'.$row, $disdok['log'].'x1');
			}else{
				$sheet->setCellValue('J'.$row, '');
			}
			// LOG
			// KEU
			$spreadsheet->getActiveSheet()->getStyle("K".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('K'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['keu'] != 0) {
				$sheet->setCellValue('K'.$row, '');
			}else{
				$sheet->setCellValue('K'.$row, '');
			}	
			// KEU
			// ENG
			$spreadsheet->getActiveSheet()->getStyle("L".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('L'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['eng'] != 0) {
				$sheet->setCellValue('L'.$row, '');
			}else{
				$sheet->setCellValue('L'.$row, '');
			}
			// ENG

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("M".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('M'.$row.':M'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row.':M'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			if ($r_eis == NULL) {

				$sheet->setCellValue('M'.$row, '');
				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('N'.$row, '');
				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('O'.$row, '');
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('P'.$row, '');
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('Q'.$row, '');
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('R'.$row, '');	
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('S'.$row, '');	
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('T'.$row, '');	
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('U'.$row, '');	
				// ENG				

			} else {

				$sheet->setCellValue('M'.$row, $r_eis['nama_revisi'].'/'.$r_eis['nama_edisi']);
				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['ppc'] != 0) {
					$sheet->setCellValue('N'.$row, $disdok['ppc'].'x1');
				}else{
					$sheet->setCellValue('N'.$row, '');
				}
				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['qa'] != 0) {
					$sheet->setCellValue('O'.$row, $disdok['qa'].'x1');
				}else{
					$sheet->setCellValue('O'.$row, '');
				}
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['qc'] != 0) {
					$sheet->setCellValue('P'.$row, $disdok['qc'].'x1');
				}else{
					$sheet->setCellValue('P'.$row, '');
				}
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['fab'] != 0) {
					$sheet->setCellValue('Q'.$row, $disdok['fab'].'x1');
				}else{
					$sheet->setCellValue('Q'.$row, '');
				}
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['mm'] != 0) {
					$sheet->setCellValue('R'.$row, $disdok['mm'].'x1');
				}else{
					$sheet->setCellValue('R'.$row, '');
				}
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['log'] != 0) {
					$sheet->setCellValue('S'.$row, $disdok['log'].'x1');
				}else{
					$sheet->setCellValue('S'.$row, '');
				}
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['keu'] != 0) {
					$sheet->setCellValue('T'.$row, '');
				}else{
					$sheet->setCellValue('T'.$row, '');
				}
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['eng'] != 0) {
					$sheet->setCellValue('U'.$row, '');
				}else{
					$sheet->setCellValue('U'.$row, '');
				}
				// ENG

			}

		// Rev./Ed.

			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':U'.$row_border)
			->getBorders()->getAllborders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


			$row += 3;
			$no ++;

		}
// ======================================================= looping EIS ==============================================================

// ======================================================= looping MP ===============================================================
		foreach ($mp as $dmp) {

			$row_no = $row + 2;
			$row_nama_dokumen = $row + 1;
			$row_no_dokumen = $row + 2;
			$row_jumlah = $row + 1;
			$row_ukuran = $row + 2;
			$row_revisi = $row + 2;			
			$row_border = $row + 2;

		// ambil dokumen terakhir sebelum di revisi, where no sp, status = 0, order by tgl dokumen, desc
			$this->db->select('dokumen_mp.*, nama_status, nama_edisi, nama_revisi');
			$this->db->from('dokumen_mp');
			$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_mp.status_dokumen','left');
			$this->db->join('edisi','edisi.id_edisi = dokumen_mp.edisi','left');
			$this->db->join('revisi','revisi.id_revisi = dokumen_mp.revisi','left');		
			$this->db->where('no_dokumen =', $dmp['no_dokumen']);
			$this->db->where('status =', 0);

			if ($dmp['status'] == 0) {

				$this->db->where('revisi !=', $dmp['revisi']);
			}

			$this->db->order_by('tgl_dokumen','DESC');
			$r_mp = $this->db->get()->row_array();

			// ambil distribusi dokumen
			$disdok = $this->db->get_where('distribusi_dokumen',['id_dd'=>$dmp['id_dd']])->row_array();

		// NO
			$spreadsheet->getActiveSheet()->getStyle("A".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('A'.$row.':A'.$row_no);
			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':A'.$row_no)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('A'.$row, $no);
		// NO

		// Nama Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('B'.$row.':B'.$row_nama_dokumen);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row.':B'.$row_nama_dokumen)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);

			$sheet->setCellValue('B'.$row, $dmp['nama_dokumen']);
		// Nama Dokumen

		// No Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row_no_dokumen)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('B'.$row_no_dokumen)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$sheet->setCellValue('B'.$row_no_dokumen, $dmp['no_dokumen']);
		// No Dokumen

		// Jumlah
			$spreadsheet->getActiveSheet()->getStyle("C".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('C'.$row.':C'.$row_jumlah);		
			$spreadsheet->getActiveSheet()->getStyle('C'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('C'.$row.':C'.$row_jumlah)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

			$sheet->setCellValue('C'.$row, $dmp['total1'].'x'.$dmp['total2']);
		// Jumlah		

		// Ukuran
			$spreadsheet->getActiveSheet()->getStyle("C".$row_ukuran)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
		// Ukuran		

			$sheet->setCellValue('C'.$row_ukuran, $dmp['ukuran']);

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("D".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('D'.$row.':D'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row.':D'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('D'.$row, $dmp['nama_revisi'].'/'.$dmp['nama_edisi']);
			// Rev./Ed.		
			// PPC
			$spreadsheet->getActiveSheet()->getStyle("E".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('E'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['ppc'] != 0) {
				$sheet->setCellValue('E'.$row, $disdok['ppc'].'x1');
			}else{
				$sheet->setCellValue('E'.$row, '');
			}
			// PPC
			// QA
			$spreadsheet->getActiveSheet()->getStyle("F".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('F'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['qa'] != 0) {
				$sheet->setCellValue('F'.$row, $disdok['qa'].'x1');
			}else{
				$sheet->setCellValue('F'.$row, '');
			}
			// QA
			// QC
			$spreadsheet->getActiveSheet()->getStyle("G".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('G'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['qc'] != 0) {
				$sheet->setCellValue('G'.$row, $disdok['qc'].'x1');
			}else{
				$sheet->setCellValue('G'.$row, '');
			}
			// QC
			// FAB
			$spreadsheet->getActiveSheet()->getStyle("H".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('H'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['fab'] != 0) {
				$sheet->setCellValue('H'.$row, $disdok['fab'].'x1');
			}else{
				$sheet->setCellValue('H'.$row, '');
			}
			// FAB
			// MM
			$spreadsheet->getActiveSheet()->getStyle("I".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('I'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['mm'] != 0) {
				$sheet->setCellValue('I'.$row, $disdok['mm'].'x1');
			}else{
				$sheet->setCellValue('I'.$row, '');
			}
			// MM
			// LOG
			$spreadsheet->getActiveSheet()->getStyle("J".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('J'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['log'] != 0) {
				$sheet->setCellValue('J'.$row, $disdok['log'].'x1');
			}else{
				$sheet->setCellValue('J'.$row, '');
			}
			// LOG
			// KEU
			$spreadsheet->getActiveSheet()->getStyle("K".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('K'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['keu'] != 0) {
				$sheet->setCellValue('K'.$row, '');
			}else{
				$sheet->setCellValue('K'.$row, '');
			}
			// KEU
			// ENG
			$spreadsheet->getActiveSheet()->getStyle("L".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('L'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['eng'] != 0) {
				$sheet->setCellValue('L'.$row, '');
			}else{
				$sheet->setCellValue('L'.$row, '');
			}
			// ENG

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("M".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('M'.$row.':M'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row.':M'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			if ($r_mp == NULL) {

				$sheet->setCellValue('M'.$row, '');

				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('N'.$row, '');
				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('O'.$row, '');
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('P'.$row, '');
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('Q'.$row, '');
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('R'.$row, '');	
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('S'.$row, '');	
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('T'.$row, '');	
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('U'.$row, '');	
				// ENG

			} else {

				$sheet->setCellValue('M'.$row, $r_mp['nama_revisi'].'/'.$r_mp['nama_edisi']);
				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['ppc'] != 0) {
					$sheet->setCellValue('N'.$row, $disdok['ppc'].'x1');
				}else{
					$sheet->setCellValue('N'.$row, '');
				}
				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['qa'] != 0) {
					$sheet->setCellValue('O'.$row, $disdok['qa'].'x1');
				}else{
					$sheet->setCellValue('O'.$row, '');
				}
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['qc'] != 0) {
					$sheet->setCellValue('P'.$row, $disdok['qc'].'x1');
				}else{
					$sheet->setCellValue('P'.$row, '');
				}
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['fab'] != 0) {
					$sheet->setCellValue('Q'.$row, $disdok['fab'].'x1');
				}else{
					$sheet->setCellValue('Q'.$row, '');
				}
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['mm'] != 0) {
					$sheet->setCellValue('R'.$row, $disdok['mm'].'x1');
				}else{
					$sheet->setCellValue('R'.$row, '');
				}
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['log'] != 0) {
					$sheet->setCellValue('S'.$row, $disdok['log'].'x1');
				}else{
					$sheet->setCellValue('S'.$row, '');
				}
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['keu'] != 0) {
					$sheet->setCellValue('T'.$row, '');
				}else{
					$sheet->setCellValue('T'.$row, '');
				}
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['eng'] != 0) {
					$sheet->setCellValue('U'.$row, '');
				}else{
					$sheet->setCellValue('U'.$row, '');
				}
				// ENG

			}

		// Rev./Ed.

			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':U'.$row_border)
			->getBorders()->getAllborders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


			$row += 3;
			$no ++;

		}
// ======================================================= looping MP ===============================================================

// ====================================================== looping CLO ===============================================================
		foreach ($clo as $dcl) {

			$row_no = $row + 2;
			$row_nama_dokumen = $row + 1;
			$row_no_dokumen = $row + 2;
			$row_jumlah = $row + 1;
			$row_ukuran = $row + 2;
			$row_revisi = $row + 2;			
			$row_border = $row + 2;

		// ambil dokumen terakhir sebelum di revisi, where no sp, status = 0, order by tgl dokumen, desc
			$this->db->select('dokumen_clo.*, nama_status, nama_edisi, nama_revisi');
			$this->db->from('dokumen_clo');
			$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_clo.status_dokumen','left');
			$this->db->join('edisi','edisi.id_edisi = dokumen_clo.edisi','left');
			$this->db->join('revisi','revisi.id_revisi = dokumen_clo.revisi','left');		
			$this->db->where('no_dokumen =', $dcl['no_dokumen']);
			$this->db->where('status =', 0);

			if ($dcl['status'] == 0) {

				$this->db->where('revisi !=', $dcl['revisi']);
			}

			$this->db->order_by('tgl_dokumen','DESC');
			$r_clo = $this->db->get()->row_array();			

			// ambil distribusi dokumen
			$disdok = $this->db->get_where('distribusi_dokumen',['id_dd'=>$dcl['id_dd']])->row_array();

		// NO
			$spreadsheet->getActiveSheet()->getStyle("A".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('A'.$row.':A'.$row_no);
			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':A'.$row_no)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('A'.$row, $no);
		// NO

		// Nama Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('B'.$row.':B'.$row_nama_dokumen);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row.':B'.$row_nama_dokumen)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);

			$sheet->setCellValue('B'.$row, $dcl['nama_dokumen']);
		// Nama Dokumen

		// No Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row_no_dokumen)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('B'.$row_no_dokumen)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$sheet->setCellValue('B'.$row_no_dokumen, $dcl['no_dokumen']);
		// No Dokumen

		// Jumlah
			$spreadsheet->getActiveSheet()->getStyle("C".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('C'.$row.':C'.$row_jumlah);		
			$spreadsheet->getActiveSheet()->getStyle('C'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('C'.$row.':C'.$row_jumlah)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

			$sheet->setCellValue('C'.$row, $dcl['total1'].'x'.$dcl['total2']);
		// Jumlah		

		// Ukuran
			$spreadsheet->getActiveSheet()->getStyle("C".$row_ukuran)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
		// Ukuran		

			$sheet->setCellValue('C'.$row_ukuran, $dcl['ukuran']);

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("D".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('D'.$row.':D'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row.':D'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('D'.$row, $dcl['nama_revisi'].'/'.$dcl['nama_edisi']);
		// Rev./Ed.		

			// PPC
			$spreadsheet->getActiveSheet()->getStyle("E".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('E'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['ppc'] != 0) {
				$sheet->setCellValue('E'.$row, $disdok['ppc'].'x1');
			}else{
				$sheet->setCellValue('E'.$row, '');
			}
			// PPC
			// QA
			$spreadsheet->getActiveSheet()->getStyle("F".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('F'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['qa'] != 0) {
				$sheet->setCellValue('F'.$row, $disdok['qa'].'x1');
			}else{
				$sheet->setCellValue('F'.$row, '');
			}
			// QA
			// QC
			$spreadsheet->getActiveSheet()->getStyle("G".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('G'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['qc'] != 0) {
				$sheet->setCellValue('G'.$row, $disdok['qc'].'x1');
			}else{
				$sheet->setCellValue('G'.$row, '');
			}
			// QC
			// FAB
			$spreadsheet->getActiveSheet()->getStyle("H".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('H'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['fab'] != 0) {
				$sheet->setCellValue('H'.$row, $disdok['fab'].'x1');
			}else{
				$sheet->setCellValue('H'.$row, '');
			}
			// FAB
			// MM
			$spreadsheet->getActiveSheet()->getStyle("I".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('I'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['mm'] != 0) {
				$sheet->setCellValue('I'.$row, $disdok['mm'].'x1');
			}else{
				$sheet->setCellValue('I'.$row, '');
			}
			// MM
			// LOG
			$spreadsheet->getActiveSheet()->getStyle("J".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('J'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['log'] != 0) {
				$sheet->setCellValue('J'.$row, $disdok['log'].'x1');
			}else{
				$sheet->setCellValue('J'.$row, '');
			}
			// LOG
			// KEU
			$spreadsheet->getActiveSheet()->getStyle("K".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('K'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['keu'] != 0) {
				$sheet->setCellValue('K'.$row, '');
			}else{
				$sheet->setCellValue('K'.$row, '');
			}
			// KEU
			// ENG
			$spreadsheet->getActiveSheet()->getStyle("L".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('L'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if ($disdok['eng'] != 0) {
				$sheet->setCellValue('L'.$row, '');
			}else{
				$sheet->setCellValue('L'.$row, '');
			}
			// ENG

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("M".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('M'.$row.':M'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row.':M'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			if ($r_clo == NULL) {

				$sheet->setCellValue('M'.$row, '');
				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('N'.$row, '');
				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('O'.$row, '');
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('P'.$row, '');
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('Q'.$row, '');
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('R'.$row, '');	
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('S'.$row, '');	
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('T'.$row, '');	
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('U'.$row, '');	
				// ENG				

			} else {

				$sheet->setCellValue('M'.$row, $r_clo['nama_revisi'].'/'.$r_clo['nama_edisi']);
				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['ppc'] != 0) {
					$sheet->setCellValue('N'.$row, $disdok['ppc'].'x1');
				}else{
					$sheet->setCellValue('N'.$row, '');
				}
				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['qa'] != 0) {
					$sheet->setCellValue('O'.$row, $disdok['qa'].'x1');
				}else{
					$sheet->setCellValue('O'.$row, '');
				}
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['qc'] != 0) {
					$sheet->setCellValue('P'.$row, $disdok['qc'].'x1');
				}else{
					$sheet->setCellValue('P'.$row, '');
				}
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['fab'] != 0) {
					$sheet->setCellValue('Q'.$row, $disdok['fab'].'x1');
				}else{
					$sheet->setCellValue('Q'.$row, '');
				}
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['mm'] != 0) {
					$sheet->setCellValue('R'.$row, $disdok['mm'].'x1');
				}else{
					$sheet->setCellValue('R'.$row, '');
				}
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['log'] != 0) {
					$sheet->setCellValue('S'.$row, $disdok['log'].'x1');
				}else{
					$sheet->setCellValue('S'.$row, '');
				}
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['keu'] != 0) {
					$sheet->setCellValue('T'.$row, '');
				}else{
					$sheet->setCellValue('T'.$row, '');
				}
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['eng'] != 0) {
					$sheet->setCellValue('U'.$row, '');
				}else{
					$sheet->setCellValue('U'.$row, '');
				}
				// ENG

			}

		// Rev./Ed.

			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':U'.$row_border)
			->getBorders()->getAllborders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


			$row += 3;
			$no ++;

		}
// ====================================================== looping CLO ===============================================================

// ====================================================== looping MRS ===============================================================
		foreach ($mrs as $dmr) {

			$row_no = $row + 2;
			$row_nama_dokumen = $row + 1;
			$row_no_dokumen = $row + 2;
			$row_jumlah = $row + 1;
			$row_ukuran = $row + 2;
			$row_revisi = $row + 2;			
			$row_border = $row + 2;

		// ambil dokumen terakhir sebelum di revisi, where no sp, status = 0, order by tgl dokumen, desc
			$this->db->select('dokumen_mrs.*, nama_status, nama_edisi, nama_revisi');
			$this->db->from('dokumen_mrs');
			$this->db->join('status_dokumen','status_dokumen.id_status = dokumen_mrs.status_dokumen','left');
			$this->db->join('edisi','edisi.id_edisi = dokumen_mrs.edisi','left');
			$this->db->join('revisi','revisi.id_revisi = dokumen_mrs.revisi','left');		
			$this->db->where('no_dokumen =', $dmr['no_dokumen']);
			$this->db->where('status =', 0);

			if ($dmr['status'] == 0) {

				$this->db->where('revisi !=', $dmr['revisi']);
			}

			$this->db->order_by('tgl_dokumen','DESC');
			$r_mrs = $this->db->get()->row_array();	

			// ambil distribusi dokumen
			$disdok = $this->db->get_where('distribusi_dokumen',['id_dd'=>$dcl['id_dd']])->row_array();		

		// NO
			$spreadsheet->getActiveSheet()->getStyle("A".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('A'.$row.':A'.$row_no);
			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':A'.$row_no)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('A'.$row, $no);
		// NO

		// Nama Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('B'.$row.':B'.$row_nama_dokumen);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row.':B'.$row_nama_dokumen)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);

			$sheet->setCellValue('B'.$row, $dmr['nama_dokumen']);
		// Nama Dokumen

		// No Dokumen
			$spreadsheet->getActiveSheet()->getStyle("B".$row_no_dokumen)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('B'.$row_no_dokumen)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$sheet->setCellValue('B'.$row_no_dokumen, $dmr['no_dokumen']);
		// No Dokumen

		// Jumlah
			$spreadsheet->getActiveSheet()->getStyle("C".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('C'.$row.':C'.$row_jumlah);		
			$spreadsheet->getActiveSheet()->getStyle('C'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('C'.$row.':C'.$row_jumlah)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

			$sheet->setCellValue('C'.$row, $dmr['total1'].'x'.$dmr['total2']);
		// Jumlah		

		// Ukuran
			$spreadsheet->getActiveSheet()->getStyle("C".$row_ukuran)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// $spreadsheet->getActiveSheet()->getStyle('C'.$row_ukuran)
			// ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
		// Ukuran		

			$sheet->setCellValue('C'.$row_ukuran, $dmr['ukuran']);

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("D".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('D'.$row.':D'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('D'.$row.':D'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('D'.$row, $dmr['nama_revisi'].'/'.$dmr['nama_edisi']);
		// Rev./Ed.		

		// PPC
			$spreadsheet->getActiveSheet()->getStyle("E".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('E'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


			if ($disdok['ppc'] != 0) {
				$sheet->setCellValue('E'.$row, $disdok['ppc'].'x1');
			}else{
				$sheet->setCellValue('E'.$row, '');
			}
		// PPC

		// QA
			$spreadsheet->getActiveSheet()->getStyle("F".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('F'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			if ($disdok['qa'] != 0) {
				$sheet->setCellValue('F'.$row, $disdok['qa'].'x1');
			}else{
				$sheet->setCellValue('F'.$row, '');
			}
		// QA

		// QC
			$spreadsheet->getActiveSheet()->getStyle("G".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('G'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


			if ($disdok['qc'] != 0) {
				$sheet->setCellValue('G'.$row, $disdok['qc'].'x1');
			}else{
				$sheet->setCellValue('G'.$row, '');
			}
		// QC

		// FAB
			$spreadsheet->getActiveSheet()->getStyle("H".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('H'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			if ($disdok['fab'] != 0) {
				$sheet->setCellValue('H'.$row, $disdok['fab'].'x1');
			}else{
				$sheet->setCellValue('H'.$row, '');
			}
		// FAB

		// MM
			$spreadsheet->getActiveSheet()->getStyle("I".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('I'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


			if ($disdok['mm'] != 0) {
				$sheet->setCellValue('I'.$row, $disdok['mm'].'x1');
			}else{
				$sheet->setCellValue('I'.$row, '');
			}
		// MM

		// LOG
			$spreadsheet->getActiveSheet()->getStyle("J".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('J'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


			if ($disdok['log'] != 0) {
				$sheet->setCellValue('J'.$row, $disdok['log'].'x1');
			}else{
				$sheet->setCellValue('J'.$row, '');
			}
		// LOG

		// KEU
			$spreadsheet->getActiveSheet()->getStyle("K".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('K'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


			if ($disdok['keu'] != 0) {
				$sheet->setCellValue('K'.$row, '');
			}else{
				$sheet->setCellValue('K'.$row, '');
			}
		// KEU

		// Engineering
			$spreadsheet->getActiveSheet()->getStyle("L".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->getStyle('L'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


			if ($disdok['eng'] != 0) {
				$sheet->setCellValue('L'.$row, '');
			}else{
				$sheet->setCellValue('L'.$row, '');
			}
		// Engineering

		// Rev./Ed.
			$spreadsheet->getActiveSheet()->getStyle("M".$row)->getFont()->setSize( 9 );
			$spreadsheet->getActiveSheet()->mergeCells('M'.$row.':M'.$row_revisi);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('M'.$row.':M'.$row_revisi)
			->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			if ($r_mrs == NULL) {

				$sheet->setCellValue('M'.$row, '');
				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('N'.$row, '');
				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('O'.$row, '');
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('P'.$row, '');
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('Q'.$row, '');
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('R'.$row, '');	
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('S'.$row, '');	
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('T'.$row, '');	
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('U'.$row, '');	
				// ENG				

			} else {

				$sheet->setCellValue('M'.$row, $r_mrs['nama_revisi'].'/'.$r_mrs['nama_edisi']);
				// PPC
				$spreadsheet->getActiveSheet()->getStyle("N".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('N'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['ppc'] != 0) {
					$sheet->setCellValue('N'.$row, $disdok['ppc'].'x1');
				}else{
					$sheet->setCellValue('N'.$row, '');
				}
				// PPC
				// QA
				$spreadsheet->getActiveSheet()->getStyle("O".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('O'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['qa'] != 0) {
					$sheet->setCellValue('O'.$row, $disdok['qa'].'x1');
				}else{
					$sheet->setCellValue('O'.$row, '');
				}
				// QA
				// QC
				$spreadsheet->getActiveSheet()->getStyle("P".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('P'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['qc'] != 0) {
					$sheet->setCellValue('P'.$row, $disdok['qc'].'x1');
				}else{
					$sheet->setCellValue('P'.$row, '');
				}
				// QC
				// FAB
				$spreadsheet->getActiveSheet()->getStyle("Q".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('Q'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['fab'] != 0) {
					$sheet->setCellValue('Q'.$row, $disdok['fab'].'x1');
				}else{
					$sheet->setCellValue('Q'.$row, '');
				}
				// FAB
				// MM
				$spreadsheet->getActiveSheet()->getStyle("R".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('R'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['mm'] != 0) {
					$sheet->setCellValue('R'.$row, $disdok['mm'].'x1');
				}else{
					$sheet->setCellValue('R'.$row, '');
				}
				// MM
				// LOG
				$spreadsheet->getActiveSheet()->getStyle("S".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('S'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['log'] != 0) {
					$sheet->setCellValue('S'.$row, $disdok['log'].'x1');
				}else{
					$sheet->setCellValue('S'.$row, '');
				}
				// LOG
				// KEU
				$spreadsheet->getActiveSheet()->getStyle("T".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('T'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['keu'] != 0) {
					$sheet->setCellValue('T'.$row, '');
				}else{
					$sheet->setCellValue('T'.$row, '');
				}
				// KEU
				// ENG
				$spreadsheet->getActiveSheet()->getStyle("U".$row)->getFont()->setSize( 9 );
				$spreadsheet->getActiveSheet()->getStyle('U'.$row)
				->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if ($disdok['eng'] != 0) {
					$sheet->setCellValue('U'.$row, '');
				}else{
					$sheet->setCellValue('U'.$row, '');
				}
				// ENG

			}

		// Rev./Ed.

			$spreadsheet->getActiveSheet()->getStyle('A'.$row.':U'.$row_border)
			->getBorders()->getAllborders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


			$row += 3;
			$no ++;

		}
// ====================================================== looping MRS ===============================================================

// ======================================================= looping =================================================================

// ======================================================= footer ===================================================================

		// keterangan 
		$spreadsheet->getActiveSheet()->getStyle("A".$row)->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('A'.$row.':U'.$row);

		$sheet->setCellValue('A'.$row, 'KETERANGAN (Remark): DOKUMEN LAMA DIKEMBALIKAN KEPADA PEMBUAT DOKUMEN BILA ADA REVISI TERBARU (OLD  REVISION MUST BE RETURN TO ORIGINATOR WHEN RECEIVE NEW REVISION)');
		// keterangan

		// 1
		$row_f1 = $row + 1;
		$spreadsheet->getActiveSheet()->getStyle("B".$row_f1)->getFont()->setSize( 9 );

		$sheet->setCellValue('B'.$row_f1, '1: Jumlah (Qty)');
		// 1

		// 2
		$row_f2 = $row + 2;
		$spreadsheet->getActiveSheet()->getStyle("B".$row_f2)->getFont()->setSize( 9 );

		$sheet->setCellValue('B'.$row_f2, '2: Paraf (Sign)');
		// 2

		// 3
		$row_f3 = $row + 3;		
		$spreadsheet->getActiveSheet()->getStyle("B".$row_f3)->getFont()->setSize( 9 );

		$sheet->setCellValue('B'.$row_f3, '3: Tanggal (Date)');
		// 3

		// original issue date
		$row_issue = $row + 1;
		$spreadsheet->getActiveSheet()->getStyle("C".$row_issue)->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('C'.$row_issue.':E'.$row_issue);
		$sheet->setCellValue('C'.$row_issue, 'Original Issue Date');
		// original issue date

		// tgl transmital
		$row_tgl = $row + 1;		
		$spreadsheet->getActiveSheet()->getStyle("F".$row_tgl)->getFont()->setSize( 9 );
		$spreadsheet->getActiveSheet()->mergeCells('F'.$row_tgl.':I'.$row_tgl);
		$spreadsheet->getActiveSheet()->getStyle('F'.$row_tgl)
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);		
		$sheet->setCellValue('F'.$row_tgl, $transmittal['tgl_transmittal']);
		$spreadsheet->getActiveSheet()->getStyle('F'.$row_tgl.':I'.$row_tgl)
		->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// tgl transmital


		$row_fb = $row + 3;
		$spreadsheet->getActiveSheet()->getStyle('A'.$row.':U'.$row_fb)
		->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

// ========================================================== footer ===============================================================


		if($extension == 'csv'){          
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
			$fileName = $fileName.'.csv';
		} elseif($extension == 'xlsx') {
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
			$fileName = $fileName.'.xlsx';
		} else {
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
			$fileName = $fileName.'.xls';
		}

		$spreadsheet->getActiveSheet()->setTitle('Dokumen Order '.$no_order);

		// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='.$fileName);
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit;
		// End Coba Download

// ========================================================= export excell ========================================================




	}
// //////////////////////////////////////////////////// export excel transmittal //////////////////////////////////////////////////






// ///////////////////////////////////////////// export form import distribusi dokumen ////////////////////////////////////////////
	public function formDd()
	{
		
// ========================================================== data ===============================================================

		// ambil data distribusi dokumen
		$distribusi_dokumen = $this->db->get('distribusi_dokumen')->result_array();

// ========================================================== data ===============================================================

// ====================================================== export excell ==========================================================
		
		$extension = 'xlsx';

		$fileName = 'Form Import Data Distribusi Dokumen';

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);		
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);		
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);			
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);		
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);					

		$from = "A1";
		$to = "P1";
		$spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold( true );
		$spreadsheet->getActiveSheet()->getStyle("A2:P2")->getFont()->setBold( true );
		$spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize( 16 );

		$spreadsheet->getActiveSheet()->mergeCells('A1:P1');

		$spreadsheet->getActiveSheet()->getStyle('A1')
		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$sheet->setCellValue('A1', 'Form Import Data Distribusi Dokumen');

		$sheet->setCellValue('A2', 'No');
		$sheet->setCellValue('B2', 'Judul Dokumen');
		$sheet->setCellValue('C2', 'Jumlah');
		$sheet->setCellValue('D2', 'PPC');
		$sheet->setCellValue('E2', 'QA');
		$sheet->setCellValue('F2', 'QC');
		$sheet->setCellValue('G2', 'FAB');
		$sheet->setCellValue('H2', 'MM');
		$sheet->setCellValue('I2', 'LOG');
		$sheet->setCellValue('J2', 'KEU');
		$sheet->setCellValue('K2', 'ENG');		
		$sheet->setCellValue('L2', 'PROD');
		$sheet->setCellValue('M2', 'HRD');
		$sheet->setCellValue('N2', 'SALES');
		$sheet->setCellValue('O2', 'MPI');		
		$sheet->setCellValue('P2', 'EXP');		

		// cetak mulai baris ke-3
		$rowCount = 3;
		$no = 1;

		// looping data
		foreach ($distribusi_dokumen as $dd) {
			$sheet->setCellValue('A' . $rowCount, $no);
			$sheet->setCellValue('B' . $rowCount, $dd['judul_dokumen']);
			$sheet->setCellValue('C' . $rowCount, $dd['jml_dokumen']);			
			$sheet->setCellValue('D' . $rowCount, $dd['ppc']);
			$sheet->setCellValue('E' . $rowCount, $dd['qa']);
			$sheet->setCellValue('F' . $rowCount, $dd['qc']);
			$sheet->setCellValue('G' . $rowCount, $dd['fab']);
			$sheet->setCellValue('H' . $rowCount, $dd['mm']);			
			$sheet->setCellValue('I' . $rowCount, $dd['log']);
			$sheet->setCellValue('J' . $rowCount, $dd['keu']);
			$sheet->setCellValue('K' . $rowCount, $dd['eng']);			
			$sheet->setCellValue('L' . $rowCount, $dd['prod']);			
			$sheet->setCellValue('M' . $rowCount, $dd['hrd']);
			$sheet->setCellValue('N' . $rowCount, $dd['sales']);
			$sheet->setCellValue('O' . $rowCount, $dd['mpi']);			
			$sheet->setCellValue('P' . $rowCount, $dd['exp_dokumen']);						

			$rowCount++;
			$no++;
		}
		// looping data

		if($extension == 'csv'){          
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
			$fileName = $fileName.'.csv';
		} elseif($extension == 'xlsx') {
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
			$fileName = $fileName.'.xlsx';
		} else {
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
			$fileName = $fileName.'.xls';
		}

		$spreadsheet->getActiveSheet()->setTitle('Data Distribusi Dokumen');

		// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='.$fileName);
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit;
		// End Coba Download

// ====================================================== export excell ==========================================================

	}
// ///////////////////////////////////////////// export form import distribusi dokumen ////////////////////////////////////////////






}