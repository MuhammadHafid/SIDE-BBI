<?php
Class Pdftransmittal extends CI_Controller{

	function __construct() {
		parent::__construct();
		$this->load->library('pdftransmit');
		$this->db_keuangan = $this->load->database('keuangan', TRUE);
	}

	function index($id_transmittal, $no_order){

		$data['title'] = 'Transmittal | SIDE-BBI';

		// ============================================== data transmittal ===========================================================

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
		// $this->db->join('dokumen_view','dokumen_view.nama_file = dokumen_drawing.nama_file','left');		
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
		// =================================================== data transmittal ======================================================

		// ================================================== cetak transmittal ======================================================		
		$pdf = new pdftransmit('l','mm','A4');
	    // membuat halaman baru
		$pdf->AddPage();

		$pdf->SetFont('Times','B',10);
		// ======================================================= header ============================================================
		// $pdf->Image(base_url('assets/img/bbi.png'),10,8,8);
		// $pdf->Cell(10);
		// setting properti font
		$pdf->SetFont('Times','',10);

		// $pdf->Image(base_url('assets/img/bbi.png'),10,15,15);
		$pdf->Ln(10);

		$pdf->Cell(276,5,'Form : QP-2110-04-01','',1,'R');
		// menulis header
		$pdf->Cell(117,10,'PEMBUAT DOKUMEN (ORIGINATOR) : ENGINEERING',1,0,'C');
		$pdf->SetFont('Times','B',9);
		$pdf->Cell(95,10,'LEMBAR PENGIRIMAN DAN PEMBATALAN DOKUMEN','T',0,'C');
		$pdf->SetFont('Times','',10);
		$pdf->Cell(15,5,'No. Order','LT',0,'L');
		$pdf->Cell(49,5,': '.$no_order,'RT',1,'L');
		$pdf->Cell(212);
		$pdf->Cell(15,5,'Customer','LT',0,'L');
		$pdf->Cell(49,5,': '.$order['nama_cc_ord'],'RT',1,'L');
		$pdf->Cell(58,10,'No. SP (ISSUE NO)','BL',0,'C');
		$pdf->Cell(59,10,': '.$transmittal['no_sp'],'BR',0,'L');
		$pdf->SetFont('Times','B',9);
		$pdf->Cell(95,5,'ISSUE AND CANCELATION SHEET','R',0,'C');
		$pdf->SetFont('Times','',10);
		$pdf->Cell(15,5,'Project','BLT',0,'L');
		$pdf->Cell(49,5,': '.$order['nama_order'],'BRT',1,'L');
		$pdf->Cell(100);
		$pdf->Cell(112,5,'','BR',0,'C');
		$pdf->SetFont('Times','',10);
		$pdf->Cell(15,5,'Halaman','BLT',0,'L');
		$pdf->Cell(49,5,': 1','BRT',1,'L');
		$pdf->Cell(7,15,'NO',1,0,'C');
		$pdf->Cell(95,10,'NAMA DOKUMEN (Document Title)','BR',0,'C');
		$pdf->Cell(15,5,'TOTAL','RB',0,'C');
		$pdf->Cell(80,5,'PENGIRIMAN (ISSUE)',1,0,'C');
		$pdf->Cell(79,5,'PEMBATALAN (CANCELATION)','BR',1,'C');
		$pdf->Cell(102);
		$pdf->SetFont('Times','',8);
		$pdf->Cell(15,5,'UKURAN','R',0,'C');
		$pdf->SetFont('Times','',10);
		$pdf->Cell(15,10,'Rev./Ed.','BR',0,'C');
		$pdf->Cell(65,5,'KEPADA (to)','BR',0,'C');
		$pdf->Cell(15,10,'Rev./Ed.','BR',0,'C');
		$pdf->Cell(64,5,'DARI (from)','BR',1,'C');
		$pdf->Cell(7);
		$pdf->SetFont('Times','',9);
		$pdf->Cell(95,5,'NO. DOCUMENT (Doc. No.)','BR',0,'C');
		$pdf->SetFont('Times','',8);
		$pdf->Cell(15,5,'SIZE','BR',0,'C');
		$pdf->Cell(15);
		$pdf->Cell(8,5,'PPC','BR',0,'C');
		$pdf->Cell(8,5,'QA','BR',0,'C');
		$pdf->Cell(8,5,'QC','BR',0,'C');
		$pdf->Cell(8,5,'FAB','BR',0,'C');
		$pdf->Cell(8,5,'MM','BR',0,'C');
		$pdf->Cell(8,5,'LOG','BR',0,'C');
		$pdf->Cell(8,5,'KEU','BR',0,'C');
		$pdf->Cell(9,5,'ENG','BR',0,'C');
		$pdf->Cell(15);
		$pdf->Cell(8,5,'PPC','BR',0,'C');
		$pdf->Cell(8,5,'QA','BR',0,'C');
		$pdf->Cell(8,5,'QC','BR',0,'C');
		$pdf->Cell(8,5,'FAB','BR',0,'C');
		$pdf->Cell(8,5,'MM','BR',0,'C');
		$pdf->Cell(8,5,'LOG','BR',0,'C');
		$pdf->Cell(8,5,'KEU','BR',0,'C');
		$pdf->Cell(8,5,'ENG','BR',1,'C');
		$pdf->SetFont('Times','',10);

		// isi transmittal (looping)

		$no = 1;

		// drawing
		foreach ($drawing as $dr) {

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

			$t = $dr['nama_dokumen'];
			$pND = $pdf->GetStringWidth($t);

			if ($pND > 95) {

				$start_x=$pdf->GetX(); //initial x (start of column position)
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$cell_width = 95;  //define cell width
				$cell_height= 5;    //define cell height

				$pdf->Cell(7,15,$no,1,0,'C');

				$pdf->SetFont('Times','',8);

				$current_y = $pdf->GetY();

				$pdf->MultiCell($cell_width,$cell_height,$t,1,'C'); //print one cell value
				$current_x+=$cell_width + 7;                     //calculate position for next cell
				$pdf->SetXY($current_x, $current_y);    

				$pdf->SetFont('Times','',10);

			} else {

				$pdf->Cell(7,15,$no,1,0,'C');			
				$pdf->Cell(95,10,$t,'BRT',0,'C');

			}

			$pdf->Cell(15,10,$dr['total1'].'x'.$dr['total2'],1,0,'C');
			$pdf->Cell(15,15,$dr['nama_revisi'].'/'.$dr['nama_edisi'],1,0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(9,5,'1x1','BRT',0,'C');

			if ($r_drawing == NULL) {
				$pdf->Cell(15,15,'',1,0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',1,'C');
				$pdf->Cell(132);
			} else {
				$pdf->Cell(15,15,$r_drawing['nama_revisi'].'/'.$r_drawing['nama_edisi'],1,0,'C');				
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',1,'C');
				$pdf->Cell(132);
			}

			$pdf->SetFont('Times','',8);

			// viewer dari PPC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dr['nama_file']);
			$this->db->where('role =', 'PPC');
			$this->db->limit(1, 'DESC');
			$ppc = $this->db->get();		
			
			$vPPC = $ppc->row_array();
			$cekPPC = $ppc->num_rows();

			if ($cekPPC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari PPC

			// viewer dari QA
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dr['nama_file']);
			$this->db->where('role =', 'QA');
			$this->db->limit(1, 'DESC');
			$qa = $this->db->get();		
			
			$vQA = $qa->row_array();
			$cekQA = $qa->num_rows();

			if ($cekQA > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QA

			// viewer dari QC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dr['nama_file']);
			$this->db->where('role =', 'QC');
			$this->db->limit(1, 'DESC');
			$qc = $this->db->get();		
			
			$vQC = $qc->row_array();
			$cekQC = $qc->num_rows();

			if ($cekQC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QC

			// viewer dari FAB
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dr['nama_file']);
			$this->db->where('role =', 'FAB');
			$this->db->limit(1, 'DESC');
			$fab = $this->db->get();		
			
			$vFAB = $fab->row_array();
			$cekFAB = $fab->num_rows();

			if ($cekFAB > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari FAB

			// viewer dari MM
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dr['nama_file']);
			$this->db->where('role =', 'MM');
			$this->db->limit(1, 'DESC');
			$mm = $this->db->get();		
			
			$vMM = $mm->row_array();
			$cekMM = $mm->num_rows();

			if ($cekMM > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari MM

			// viewer dari Logistik
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dr['nama_file']);
			$this->db->where('role =', 'Logistik');
			$this->db->limit(1, 'DESC');
			$log = $this->db->get();		
			
			$vLOG = $log->row_array();
			$cekLOG = $log->num_rows();

			if ($cekLOG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Logistik

			// viewer dari Keuangan
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dr['nama_file']);
			$this->db->where('role =', 'KEU');
			$this->db->limit(1, 'DESC');
			$keu = $this->db->get();		
			
			$vKEU = $keu->row_array();
			$cekKEU = $keu->num_rows();

			if ($cekKEU > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Keuangan

			// viewer dari Engineering
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dr['nama_file']);
			$this->db->where('role =', 'Engineering');
			$this->db->limit(1, 'DESC');
			$eng = $this->db->get();		
			
			$vENG = $eng->row_array();
			$cekENG = $eng->num_rows();

			if ($cekENG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(9,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}
			// viewer dari Engineering

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');

			$pdf->Cell(7);
			$pdf->Cell(95,5,$dr['no_dokumen'],'BR',0,'C');
			$pdf->Cell(15,5,$dr['ukuran'],1,0,'C');
			$pdf->Cell(15);

			$pdf->SetFont('Times','',8);

			if ($cekPPC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vPPC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQA > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQA['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekFAB > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vFAB['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekMM > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vMM['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vLOG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vKEU['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekENG > 0) {
				$pdf->Cell(9,5,date('d/m', strtotime($vENG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');

			$no += 1;

		}
		// drawing

		// BQ
		foreach ($bq as $dbq) {

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

			$t = $dbq['nama_dokumen'];
			$pND = $pdf->GetStringWidth($t);

			if ($pND > 95) {

				$start_x=$pdf->GetX(); //initial x (start of column position)
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$cell_width = 95;  //define cell width
				$cell_height= 5;    //define cell height

				$pdf->Cell(7,15,$no,1,0,'C');

				$pdf->SetFont('Times','',8);

				$current_y = $pdf->GetY();

				$pdf->MultiCell($cell_width,$cell_height,$t,1,'C'); //print one cell value
				$current_x+=$cell_width + 7;                     //calculate position for next cell
				$pdf->SetXY($current_x, $current_y);    

				$pdf->SetFont('Times','',10);

			} else {

				$pdf->Cell(7,15,$no,1,0,'C');			
				$pdf->Cell(95,10,$t,'BRT',0,'C');

			}

			$pdf->Cell(15,10,$dbq['total1'].'x'.$dbq['total2'],1,0,'C');
			$pdf->Cell(15,15,$dbq['nama_revisi'].'/'.$dbq['nama_edisi'],1,0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(9,5,'1x1','BRT',0,'C');

			if ($r_bq == NULL) {
				$pdf->Cell(15,15,'',1,0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',1,'C');
				$pdf->Cell(132);
			} else {
				$pdf->Cell(15,15,$r_bq['nama_revisi'].'/'.$r_bq['nama_edisi'],1,0,'C');				
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',1,'C');
				$pdf->Cell(132);
			}

			$pdf->SetFont('Times','',8);

			// viewer dari PPC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dbq['nama_file']);
			$this->db->where('role =', 'PPC');
			$this->db->limit(1, 'DESC');
			$ppc = $this->db->get();		
			
			$vPPC = $ppc->row_array();
			$cekPPC = $ppc->num_rows();

			if ($cekPPC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari PPC

			// viewer dari QA
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dbq['nama_file']);
			$this->db->where('role =', 'QA');
			$this->db->limit(1, 'DESC');
			$qa = $this->db->get();		
			
			$vQA = $qa->row_array();
			$cekQA = $qa->num_rows();

			if ($cekQA > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QA

			// viewer dari QC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dbq['nama_file']);
			$this->db->where('role =', 'QC');
			$this->db->limit(1, 'DESC');
			$qc = $this->db->get();		
			
			$vQC = $qc->row_array();
			$cekQC = $qc->num_rows();

			if ($cekQC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QC

			// viewer dari FAB
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dbq['nama_file']);
			$this->db->where('role =', 'FAB');
			$this->db->limit(1, 'DESC');
			$fab = $this->db->get();		
			
			$vFAB = $fab->row_array();
			$cekFAB = $fab->num_rows();

			if ($cekFAB > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari FAB

			// viewer dari MM
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dbq['nama_file']);
			$this->db->where('role =', 'MM');
			$this->db->limit(1, 'DESC');
			$mm = $this->db->get();		
			
			$vMM = $mm->row_array();
			$cekMM = $mm->num_rows();

			if ($cekMM > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari MM

			// viewer dari Logistik
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dbq['nama_file']);
			$this->db->where('role =', 'Logistik');
			$this->db->limit(1, 'DESC');
			$log = $this->db->get();		
			
			$vLOG = $log->row_array();
			$cekLOG = $log->num_rows();

			if ($cekLOG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Logistik

			// viewer dari Keuangan
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dbq['nama_file']);
			$this->db->where('role =', 'KEU');
			$this->db->limit(1, 'DESC');
			$keu = $this->db->get();		
			
			$vKEU = $keu->row_array();
			$cekKEU = $keu->num_rows();

			if ($cekKEU > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Keuangan

			// viewer dari Engineering
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dbq['nama_file']);
			$this->db->where('role =', 'Engineering');
			$this->db->limit(1, 'DESC');
			$eng = $this->db->get();		
			
			$vENG = $eng->row_array();
			$cekENG = $eng->num_rows();

			if ($cekENG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(9,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}
			// viewer dari Engineering

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');
			$pdf->Cell(7);
			$pdf->Cell(95,5,$dbq['no_dokumen'],'BR',0,'C');
			$pdf->Cell(15,5,$dbq['ukuran'],1,0,'C');
			$pdf->Cell(15);

			$pdf->SetFont('Times','',8);

			if ($cekPPC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vPPC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQA > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQA['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekFAB > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vFAB['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekMM > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vMM['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vLOG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vKEU['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekENG > 0) {
				$pdf->Cell(9,5,date('d/m', strtotime($vENG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');

			$no += 1;

		}
		// BQ

		// EIS
		foreach ($eis as $dei) {

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

			$t = $dei['nama_dokumen'];
			$pND = $pdf->GetStringWidth($t);

			if ($pND > 95) {

				$start_x=$pdf->GetX(); //initial x (start of column position)
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$cell_width = 95;  //define cell width
				$cell_height= 5;    //define cell height

				$pdf->Cell(7,15,$no,1,0,'C');

				$pdf->SetFont('Times','',8);

				$current_y = $pdf->GetY();

				$pdf->MultiCell($cell_width,$cell_height,$t,1,'C'); //print one cell value
				$current_x+=$cell_width + 7;                     //calculate position for next cell
				$pdf->SetXY($current_x, $current_y);    

				$pdf->SetFont('Times','',10);

			} else {

				$pdf->Cell(7,15,$no,1,0,'C');			
				$pdf->Cell(95,10,$t,'BRT',0,'C');

			}

			$pdf->Cell(15,10,$dei['total1'].'x'.$dei['total2'],1,0,'C');
			$pdf->Cell(15,15,$dei['nama_revisi'].'/'.$dei['nama_edisi'],1,0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(9,5,'1x1','BRT',0,'C');

			if ($r_eis == NULL) {
				$pdf->Cell(15,15,'',1,0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',1,'C');
				$pdf->Cell(132);
			} else {
				$pdf->Cell(15,15,$r_eis['nama_revisi'].'/'.$r_eis['nama_edisi'],1,0,'C');				
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',1,'C');
				$pdf->Cell(132);
			}

			$pdf->SetFont('Times','',8);

			// viewer dari PPC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dei['nama_file']);
			$this->db->where('role =', 'PPC');
			$this->db->limit(1, 'DESC');
			$ppc = $this->db->get();		
			
			$vPPC = $ppc->row_array();
			$cekPPC = $ppc->num_rows();

			if ($cekPPC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari PPC

			// viewer dari QA
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dei['nama_file']);
			$this->db->where('role =', 'QA');
			$this->db->limit(1, 'DESC');
			$qa = $this->db->get();		
			
			$vQA = $qa->row_array();
			$cekQA = $qa->num_rows();

			if ($cekQA > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QA

			// viewer dari QC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dei['nama_file']);
			$this->db->where('role =', 'QC');
			$this->db->limit(1, 'DESC');
			$qc = $this->db->get();		
			
			$vQC = $qc->row_array();
			$cekQC = $qc->num_rows();

			if ($cekQC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QC

			// viewer dari FAB
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dei['nama_file']);
			$this->db->where('role =', 'FAB');
			$this->db->limit(1, 'DESC');
			$fab = $this->db->get();		
			
			$vFAB = $fab->row_array();
			$cekFAB = $fab->num_rows();

			if ($cekFAB > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari FAB

			// viewer dari MM
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dei['nama_file']);
			$this->db->where('role =', 'MM');
			$this->db->limit(1, 'DESC');
			$mm = $this->db->get();		
			
			$vMM = $mm->row_array();
			$cekMM = $mm->num_rows();

			if ($cekMM > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari MM

			// viewer dari Logistik
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dei['nama_file']);
			$this->db->where('role =', 'Logistik');
			$this->db->limit(1, 'DESC');
			$log = $this->db->get();		
			
			$vLOG = $log->row_array();
			$cekLOG = $log->num_rows();

			if ($cekLOG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Logistik

			// viewer dari Keuangan
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dei['nama_file']);
			$this->db->where('role =', 'KEU');
			$this->db->limit(1, 'DESC');
			$keu = $this->db->get();		
			
			$vKEU = $keu->row_array();
			$cekKEU = $keu->num_rows();

			if ($cekKEU > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Keuangan

			// viewer dari Engineering
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dei['nama_file']);
			$this->db->where('role =', 'Engineering');
			$this->db->limit(1, 'DESC');
			$eng = $this->db->get();		
			
			$vENG = $eng->row_array();
			$cekENG = $eng->num_rows();

			if ($cekENG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(9,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}
			// viewer dari Engineering

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');
			$pdf->Cell(7);
			$pdf->Cell(95,5,$dei['no_dokumen'],'BR',0,'C');
			$pdf->Cell(15,5,$dei['ukuran'],1,0,'C');
			$pdf->Cell(15);

			$pdf->SetFont('Times','',8);

			if ($cekPPC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vPPC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQA > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQA['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekFAB > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vFAB['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekMM > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vMM['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vLOG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vKEU['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekENG > 0) {
				$pdf->Cell(9,5,date('d/m', strtotime($vENG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');

			$no += 1;

		}
		// EIS

		// MP
		foreach ($mp as $dmp) {

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

			$t = $dmp['nama_dokumen'];
			$pND = $pdf->GetStringWidth($t);

			if ($pND > 95) {

				$start_x=$pdf->GetX(); //initial x (start of column position)
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$cell_width = 95;  //define cell width
				$cell_height= 5;    //define cell height

				$pdf->Cell(7,15,$no,1,0,'C');

				$pdf->SetFont('Times','',8);

				$current_y = $pdf->GetY();

				$pdf->MultiCell($cell_width,$cell_height,$t,1,'C'); //print one cell value
				$current_x+=$cell_width + 7;                     //calculate position for next cell
				$pdf->SetXY($current_x, $current_y);    

				$pdf->SetFont('Times','',10);

			} else {

				$pdf->Cell(7,15,$no,1,0,'C');			
				$pdf->Cell(95,10,$t,'BRT',0,'C');

			}

			$pdf->Cell(15,10,$dmp['total1'].'x'.$dmp['total2'],1,0,'C');
			$pdf->Cell(15,15,$dmp['nama_revisi'].'/'.$dmp['nama_edisi'],1,0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(9,5,'1x1','BRT',0,'C');

			if ($r_mp == NULL) {
				$pdf->Cell(15,15,'',1,0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',1,'C');
				$pdf->Cell(132);
			} else {
				$pdf->Cell(15,15,$r_mp['nama_revisi'].'/'.$r_mp['nama_edisi'],1,0,'C');				
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',1,'C');
				$pdf->Cell(132);
			}

			$pdf->SetFont('Times','',8);

			// viewer dari PPC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmp['nama_file']);
			$this->db->where('role =', 'PPC');
			$this->db->limit(1, 'DESC');
			$ppc = $this->db->get();		
			
			$vPPC = $ppc->row_array();
			$cekPPC = $ppc->num_rows();

			if ($cekPPC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari PPC

			// viewer dari QA
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmp['nama_file']);
			$this->db->where('role =', 'QA');
			$this->db->limit(1, 'DESC');
			$qa = $this->db->get();		
			
			$vQA = $qa->row_array();
			$cekQA = $qa->num_rows();

			if ($cekQA > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QA

			// viewer dari QC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmp['nama_file']);
			$this->db->where('role =', 'QC');
			$this->db->limit(1, 'DESC');
			$qc = $this->db->get();		
			
			$vQC = $qc->row_array();
			$cekQC = $qc->num_rows();

			if ($cekQC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QC

			// viewer dari FAB
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmp['nama_file']);
			$this->db->where('role =', 'FAB');
			$this->db->limit(1, 'DESC');
			$fab = $this->db->get();		
			
			$vFAB = $fab->row_array();
			$cekFAB = $fab->num_rows();

			if ($cekFAB > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari FAB

			// viewer dari MM
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmp['nama_file']);
			$this->db->where('role =', 'MM');
			$this->db->limit(1, 'DESC');
			$mm = $this->db->get();		
			
			$vMM = $mm->row_array();
			$cekMM = $mm->num_rows();

			if ($cekMM > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari MM

			// viewer dari Logistik
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmp['nama_file']);
			$this->db->where('role =', 'Logistik');
			$this->db->limit(1, 'DESC');
			$log = $this->db->get();		
			
			$vLOG = $log->row_array();
			$cekLOG = $log->num_rows();

			if ($cekLOG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Logistik

			// viewer dari Keuangan
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmp['nama_file']);
			$this->db->where('role =', 'KEU');
			$this->db->limit(1, 'DESC');
			$keu = $this->db->get();		
			
			$vKEU = $keu->row_array();
			$cekKEU = $keu->num_rows();

			if ($cekKEU > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Keuangan

			// viewer dari Engineering
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmp['nama_file']);
			$this->db->where('role =', 'Engineering');
			$this->db->limit(1, 'DESC');
			$eng = $this->db->get();		
			
			$vENG = $eng->row_array();
			$cekENG = $eng->num_rows();

			if ($cekENG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(9,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}
			// viewer dari Engineering

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');
			$pdf->Cell(7);
			$pdf->Cell(95,5,$dmp['no_dokumen'],'BR',0,'C');
			$pdf->Cell(15,5,$dmp['ukuran'],1,0,'C');
			$pdf->Cell(15);

			$pdf->SetFont('Times','',8);

			if ($cekPPC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vPPC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQA > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQA['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekFAB > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vFAB['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekMM > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vMM['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vLOG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vKEU['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekENG > 0) {
				$pdf->Cell(9,5,date('d/m', strtotime($vENG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');

			$no += 1;

		}
		// MP

		// CLO
		foreach ($clo as $dcl) {

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

			$t = $dcl['nama_dokumen'];
			$pND = $pdf->GetStringWidth($t);

			if ($pND > 95) {

				$start_x=$pdf->GetX(); //initial x (start of column position)
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$cell_width = 95;  //define cell width
				$cell_height= 5;   //define cell height

				$pdf->Cell(7,15,$no,1,0,'C');

				$pdf->SetFont('Times','',8);

				$current_y = $pdf->GetY();

				$pdf->MultiCell($cell_width,$cell_height,$t,1,'C'); //print one cell value
				$current_x+=$cell_width + 7;                     //calculate position for next cell
				$pdf->SetXY($current_x, $current_y);    

				$pdf->SetFont('Times','',10);

			} else {

				$pdf->Cell(7,15,$no,1,0,'C');			
				$pdf->Cell(95,10,$t,'BRT',0,'C');

			}

			$pdf->Cell(15,10,$dcl['total1'].'x'.$dcl['total2'],1,0,'C');
			$pdf->Cell(15,15,$dcl['nama_revisi'].'/'.$dcl['nama_edisi'],1,0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(9,5,'1x1','BRT',0,'C');

			if ($r_clo == NULL) {
				$pdf->Cell(15,15,'',1,0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',1,'C');
				$pdf->Cell(132);
			} else {
				$pdf->Cell(15,15,$r_clo['nama_revisi'].'/'.$r_clo['nama_edisi'],1,0,'C');				
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',1,'C');
				$pdf->Cell(132);
			}

			$pdf->SetFont('Times','',8);

			// viewer dari PPC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dcl['nama_file']);
			$this->db->where('role =', 'PPC');
			$this->db->limit(1, 'DESC');
			$ppc = $this->db->get();		
			
			$vPPC = $ppc->row_array();
			$cekPPC = $ppc->num_rows();

			if ($cekPPC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari PPC

			// viewer dari QA
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dcl['nama_file']);
			$this->db->where('role =', 'QA');
			$this->db->limit(1, 'DESC');
			$qa = $this->db->get();		
			
			$vQA = $qa->row_array();
			$cekQA = $qa->num_rows();

			if ($cekQA > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QA

			// viewer dari QC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dcl['nama_file']);
			$this->db->where('role =', 'QC');
			$this->db->limit(1, 'DESC');
			$qc = $this->db->get();		
			
			$vQC = $qc->row_array();
			$cekQC = $qc->num_rows();

			if ($cekQC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QC

			// viewer dari FAB
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dcl['nama_file']);
			$this->db->where('role =', 'FAB');
			$this->db->limit(1, 'DESC');
			$fab = $this->db->get();		
			
			$vFAB = $fab->row_array();
			$cekFAB = $fab->num_rows();

			if ($cekFAB > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari FAB

			// viewer dari MM
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dcl['nama_file']);
			$this->db->where('role =', 'MM');
			$this->db->limit(1, 'DESC');
			$mm = $this->db->get();		
			
			$vMM = $mm->row_array();
			$cekMM = $mm->num_rows();

			if ($cekMM > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari MM

			// viewer dari Logistik
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dcl['nama_file']);
			$this->db->where('role =', 'Logistik');
			$this->db->limit(1, 'DESC');
			$log = $this->db->get();		
			
			$vLOG = $log->row_array();
			$cekLOG = $log->num_rows();

			if ($cekLOG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Logistik

			// viewer dari Keuangan
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dcl['nama_file']);
			$this->db->where('role =', 'KEU');
			$this->db->limit(1, 'DESC');
			$keu = $this->db->get();		
			
			$vKEU = $keu->row_array();
			$cekKEU = $keu->num_rows();

			if ($cekKEU > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Keuangan

			// viewer dari Engineering
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dcl['nama_file']);
			$this->db->where('role =', 'Engineering');
			$this->db->limit(1, 'DESC');
			$eng = $this->db->get();		
			
			$vENG = $eng->row_array();
			$cekENG = $eng->num_rows();

			if ($cekENG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(9,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}
			// viewer dari Engineering

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');
			$pdf->Cell(7);
			$pdf->Cell(95,5,$dcl['no_dokumen'],'BR',0,'C');
			$pdf->Cell(15,5,$dcl['ukuran'],1,0,'C');
			$pdf->Cell(15);

			$pdf->SetFont('Times','',8);

			if ($cekPPC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vPPC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQA > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQA['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekFAB > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vFAB['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekMM > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vMM['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vLOG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vKEU['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekENG > 0) {
				$pdf->Cell(9,5,date('d/m', strtotime($vENG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');

			$no += 1;

		}
		// CLO

		// MRS
		foreach ($mrs as $dmr) {

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

			$t = $dmr['nama_dokumen'];
			$pND = $pdf->GetStringWidth($t);

			if ($pND > 95) {

				$start_x=$pdf->GetX(); //initial x (start of column position)
				$current_y = $pdf->GetY();
				$current_x = $pdf->GetX();

				$cell_width = 95;  //define cell width
				$cell_height= 5;   //define cell height

				$pdf->Cell(7,15,$no,1,0,'C');

				$pdf->SetFont('Times','',8);

				$current_y = $pdf->GetY();

				$pdf->MultiCell($cell_width,$cell_height,$t,1,'C'); //print one cell value
				$current_x+=$cell_width + 7;                     //calculate position for next cell
				$pdf->SetXY($current_x, $current_y);    

				// var_dump($current_y); die;

				$pdf->SetFont('Times','',10);

			} else {

				$pdf->Cell(7,15,$no,1,0,'C');			
				$pdf->Cell(95,10,$t,'BRT',0,'C');

			}

			$pdf->Cell(15,10,$dmr['total1'].'x'.$dmr['total2'],1,0,'C');
			$pdf->Cell(15,15,$dmr['nama_revisi'].'/'.$dmr['nama_edisi'],1,0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(8,5,'1x1','BRT',0,'C');
			$pdf->Cell(9,5,'1x1','BRT',0,'C');

			if ($r_mrs == NULL) {
				$pdf->Cell(15,15,'',1,0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',0,'C');
				$pdf->Cell(8,5,'','BRT',1,'C');
				$pdf->Cell(132);
			} else {
				$pdf->Cell(15,15,$r_mrs['nama_revisi'].'/'.$r_mrs['nama_edisi'],1,0,'C');				
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',0,'C');
				$pdf->Cell(8,5,'1x1','BRT',1,'C');
				$pdf->Cell(132);
			}

			$pdf->SetFont('Times','',8);

			// viewer dari PPC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmr['nama_file']);
			$this->db->where('role =', 'PPC');
			$this->db->limit(1, 'DESC');
			$ppc = $this->db->get();		
			
			$vPPC = $ppc->row_array();
			$cekPPC = $ppc->num_rows();

			if ($cekPPC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari PPC

			// viewer dari QA
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmr['nama_file']);
			$this->db->where('role =', 'QA');
			$this->db->limit(1, 'DESC');
			$qa = $this->db->get();		
			
			$vQA = $qa->row_array();
			$cekQA = $qa->num_rows();

			if ($cekQA > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QA

			// viewer dari QC
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmr['nama_file']);
			$this->db->where('role =', 'QC');
			$this->db->limit(1, 'DESC');
			$qc = $this->db->get();		
			
			$vQC = $qc->row_array();
			$cekQC = $qc->num_rows();

			if ($cekQC > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari QC

			// viewer dari FAB
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmr['nama_file']);
			$this->db->where('role =', 'FAB');
			$this->db->limit(1, 'DESC');
			$fab = $this->db->get();		
			
			$vFAB = $fab->row_array();
			$cekFAB = $fab->num_rows();

			if ($cekFAB > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari FAB

			// viewer dari MM
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmr['nama_file']);
			$this->db->where('role =', 'MM');
			$this->db->limit(1, 'DESC');
			$mm = $this->db->get();		
			
			$vMM = $mm->row_array();
			$cekMM = $mm->num_rows();

			if ($cekMM > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari MM

			// viewer dari Logistik
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmr['nama_file']);
			$this->db->where('role =', 'Logistik');
			$this->db->limit(1, 'DESC');
			$log = $this->db->get();		
			
			$vLOG = $log->row_array();
			$cekLOG = $log->num_rows();

			if ($cekLOG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Logistik

			// viewer dari Keuangan
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmr['nama_file']);
			$this->db->where('role =', 'KEU');
			$this->db->limit(1, 'DESC');
			$keu = $this->db->get();		
			
			$vKEU = $keu->row_array();
			$cekKEU = $keu->num_rows();

			if ($cekKEU > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}
			// viewer dari Keuangan

			// viewer dari Engineering
			$this->db->select('*');
			$this->db->from('dokumen_view');
			$this->db->where('nama_file =', $dmr['nama_file']);
			$this->db->where('role =', 'Engineering');
			$this->db->limit(1, 'DESC');
			$eng = $this->db->get();		
			
			$vENG = $eng->row_array();
			$cekENG = $eng->num_rows();

			if ($cekENG > 0) {
				$pdf->SetFont('ZapfDingbats','', 10);
				$pdf->Cell(8,5,3,'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}
			// viewer dari Engineering

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');
			$pdf->Cell(7);
			$pdf->Cell(95,5,$dmr['no_dokumen'],'BR',0,'C');
			$pdf->Cell(15,5,$dmr['ukuran'],1,0,'C');
			$pdf->Cell(15);

			$pdf->SetFont('Times','',8);

			if ($cekPPC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vPPC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQA > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQA['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekQC > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vQC['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekFAB > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vFAB['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekMM > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vMM['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vLOG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekLOG > 0) {
				$pdf->Cell(8,5,date('d/m', strtotime($vKEU['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(8,5,'','BRT',0,'C');
			}

			if ($cekENG > 0) {
				$pdf->Cell(9,5,date('d/m', strtotime($vENG['tgl_view'])),'BRT',0,'C');
			} else {
				$pdf->Cell(9,5,'','BRT',0,'C');
			}

			$pdf->SetFont('Times','',10);

			$pdf->Cell(15);
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',0,'C');
			$pdf->Cell(8,5,'','BRT',1,'C');

			$no += 1;

		}
		// MRS
		// isi transmittal

		// footer
		$pdf->SetFont('Times','',8);
		$pdf->Cell(276,6,'KETERANGAN (Remark): DOKUMEN LAMA DIKEMBALIKAN KEPADA PEMBUAT DOKUMEN BILA ADA REVISI TERBARU (OLD  REVISION MUST BE RETURN TO ORIGINATOR WHEN RECEIVE NEW REVISION)','LRT',1,'L');
		// $pdf->Cell(30);
		$pdf->SetFont('Times','',9);
		$pdf->Cell(30,6,'','L',0,'L');
		$pdf->Cell(15,6,'1',1,0,'C');
		$pdf->Cell(30,6,': Jumlah (Qty)',0,0,'L');
		$pdf->Cell(42,6,'Original Issue Date :',0,0,'C');

		$this->load->model('Dokumen_model', 'dokumen');
		$tgl = $this->dokumen->tgl_indo($transmittal['tgl_transmittal']);

		$pdf->Cell(31,6,$tgl,1,0,'C');
		$pdf->Cell(128,6,'','R',1,'C');		
		$pdf->Cell(30,6,'','L',0,'L');
		$pdf->Cell(15,6,'2',1,0,'C');		
		$pdf->Cell(30,6,': Paraf (Sign)',0,0,'L');
		$pdf->Cell(201,6,'','R',1,'C');				
		$pdf->Cell(30,6,'','L',0,'L');
		$pdf->Cell(15,6,'3',1,0,'C');		
		$pdf->Cell(30,6,': Tanggal (Date)',0,0,'L');
		$pdf->Cell(201,6,'','R',1,'C');
		$pdf->Cell(276,2,'','LRB',1,'L');						
		// footer



		// membuat space kosong antara header dengan teks konten
		$pdf->Ln(5);
		// ======================================================= header ============================================================









		$pdf->Output();

		// ================================================== cetak transmittal ======================================================

	}




}