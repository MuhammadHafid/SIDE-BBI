<?php
$CI =& get_instance();
$CI->load->library('secure'); 
?>
<!-- content -->

<!-- halaman -->
<div class="content-wrapper">

  <!-- judul -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col">
          <h1 class="m-0 text-center">Dokumen Order</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- judul -->

  <!-- alert -->
  <?=  
  $this->session->flashdata('messageDokumen');
  ?>

  <!-- $this->session->flashdata('messageTransmittal'); -->

  <!-- end alert -->

  <!-- content -->
  <section class="content">
    <div class="container-fluid">

      <!-- no order -->
      <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2">
          <h6>No. Order</h6>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10">
          <h6><?= ': '.$order['id_cc_ord'] ?></h6>
        </div>
      </div>
      <!-- no order -->

      <!-- nama order -->
      <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2">
          <h6>Nama Order</h6>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10">
          <h6><?= ': '.$order['nama_order'] ?></h6>
        </div>
      </div>
      <!-- nama order -->

      <!-- nama customer -->
      <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2">
          <h6>Nama Customer</h6>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10">
          <h6><?= ': '.$order['nama_customer'] ?></h6>
        </div>
      </div>
      <!-- nama customer -->

      <!-- export excel -->
      <div class="row d-flex justify-content-end mb-1">

        <div class="col-lg-2 col-md-2 text-right">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <a data-toggle="tooltip" data-placement="top" title="Export Dokumen Order" target="_blank" href="<?= base_url('export/dokumenOrder/'.$order['id']) ?>" class="btn btn-success btn-md btn-block">
                <i class="far fa-file-excel"></i>
              </a>                
            </div>
            <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>
            <div class="col-lg-6 col-md-6">
              <a data-toggle="tooltip" data-placement="top" title="Buat Transmittal" target="_blank" href="<?= base_url('transmittal/create/'.$order['id_cc_ord']) ?>" class="btn btn-dark btn-md btn-block"><i class="fas fa-file-medical"></i></a>
            </div>
          <?php endif ?>
        </div>
      </div>

    </div>
    <!-- export excel -->

    <!-- drawing -->
    <div class="card">
      <div class="card-header text-center h5" style="background-color: #e3e2de;">
       <b>Drawing</b>
     </div>
     <div class="card-body">

      <!-- tabel dokumen drawing -->
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

          <div class="table-responsive">
            <table id="datatable" class="table table-sm table-striped table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Dokumen</th>
                  <th>Nama Dokumen</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                  <th>Edisi</th>
                  <th>Revisi</th>
                  <th>Transmit</th>
                  <th>No. SP</th>                     
                  <th>Valid</th>                        
                  <th>Aksi</th>                       
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php foreach ($dokumen_drawing as $dd): ?>
                  <tr>

                    <td style="font-size: 14px;"><?= $no ?></td>
                    <td style="font-size: 14px;"><?= $dd['no_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $dd['nama_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $dd['tgl_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $dd['nama_status']; ?></td>
                    <td style="font-size: 14px;"><?= $dd['nama_edisi']; ?></td>
                    <td style="font-size: 14px;"><?= $dd['nama_revisi']; ?></td>

                    <!-- transmit -->
                    <?php if ($dd['no_sp'] != NULL): ?>
                      <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                      <?php else: ?>
                        <td class="text-center"></td>
                      <?php endif ?>
                      <!-- transmit -->

                      <?php 
                      $string = explode("/", $dd['no_sp'], 2);
                      $no_sp = $string[0];
                      ?>

                      <!-- no sp -->
                      <td style="font-size: 14px;"><?= $no_sp; ?></td>
                      <!-- no sp -->

                      <!-- status valid -->
                      <?php if ($dd['status'] == 1): ?>
                        <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                      <?php endif ?>
                      <?php if ($dd['status'] == 0): ?>
                        <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                      <?php endif ?>
                      <!-- status valid -->

                      <!-- Aksi -->
                      <td>

                        <!-- jika belum transmit admin bisa lihat -->
                        <?php if ($dd['no_sp'] == NULL): ?>

                          <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                          <div class="dropdown">
                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Pilih
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                              <!-- view -->
                              <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/view/').$dd['nama_file'] ?>">View</a>
                              <!-- view -->

                              <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                              <!-- edit -->
                              <a class="dropdown-item" href="<?= base_url('drawing/edit/') . $dd['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#edrawing'.$dd['id_dokumen'] ?>">Edit</a>
                              <!-- edit -->
                              <!-- revisi -->
                              <?php if ($dd['status'] == 1): ?>
                                <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/revisi/') . $dd['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                              <?php endif ?>
                              <!-- revisi -->
                              <!-- hapus -->
                              <a href="<?= base_url('drawing/hapus/') . $dd['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$dd['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                              <!-- hapus -->

                            <?php endif ?>

                            <!-- history -->
                            <?php if ($dd['status'] == 1): ?>
                              <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/history/') . $dd['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                            <?php endif ?>
                            <!-- history -->                                

                          </div>
                        </div>

                      <?php endif ?>

                    <?php endif ?>
                    <!-- jika belum transmit admin bisa lihat -->

                    <!-- jika sudah transmit bisa lihat semua -->
                    <?php if ($dd['no_sp'] != NULL): ?>

                      <div class="dropdown">
                        <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Pilih
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                          <!-- view -->
                          <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/view/').$dd['nama_file'] ?>">View</a>
                          <!-- view -->

                          <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                          <!-- edit -->
                          <a class="dropdown-item" href="<?= base_url('drawing/edit/') . $dd['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#edrawing'.$dd['id_dokumen'] ?>">Edit</a>
                          <!-- edit -->
                          <!-- revisi -->
                          <?php if ($dd['status'] == 1): ?>
                            <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/revisi/') . $dd['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                          <?php endif ?>
                          <!-- revisi -->
                          <!-- hapus -->
                          <a href="<?= base_url('drawing/hapus/') . $dd['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$dd['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                          <!-- hapus -->

                        <?php endif ?>

                        <!-- history -->
                        <?php if ($dd['status'] == 1): ?>
                          <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/history/') . $dd['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                        <?php endif ?>
                        <!-- history -->                                

                      </div>
                    </div>

                  <?php endif ?>
                  <!-- jika belum transmit admin bisa lihat -->


                </td>
                <!-- aksi -->

              </tr>



              <!-- modal edit dokumen drawing -->
              <div class="modal hide fade" id="<?= 'edrawing'.$dd['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="edrawing" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                      <div class="col text-center">
                        <h5 class="modal-title" id="edrawing">Edit Dokumen Drawing</h5>                
                      </div>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>


                    <form action="<?= base_url('drawing/edit/').$dd['id_dokumen']; ?>" method="post" enctype="multipart/form-data">
                      <div class="modal-body">
                        <div class="container-fluid">

                          <div class="row mb-2">
                            <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $dd['no_dokumen'] ?>">
                            </div>
                          </div>
                          <div class="row mb-2">
                            <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $dd['nama_dokumen'] ?>">
                            </div>
                          </div>
                          <div class="row mb-2">
                            <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $dd['tgl_dokumen'] ?>">
                            </div>
                          </div>
                          <div class="row mb-2">
                            <label class="col-lg-12 col-md-12 col-sm-12" for="status_dokumen">Status Dokumen</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                                <option value="<?= $dd['status_dokumen'] ?>"><?= $dd['nama_status'] ?></option>
                                <?php foreach ($status_dokumen as $sd): ?>
                                  <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                                <?php endforeach ?>
                              </select>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <select name="revisi" id="revisi" class="form-control" required>
                                <option value="<?= $dd['revisi'] ?>"><?= $dd['nama_revisi'] ?></option>
                                <?php foreach ($revisi as $r): ?>
                                  <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                                <?php endforeach ?>
                              </select>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <select name="edisi" id="edisi" class="form-control" required>
                                <option value="<?= $dd['edisi'] ?>"><?= $dd['nama_edisi'] ?></option>
                                <?php foreach ($edisi as $e): ?>
                                  <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                                <?php endforeach ?>
                              </select>
                            </div>
                          </div>

                          <!-- total -->
                          <div class="row mb-2">
                            <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Copy x Page</label>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                              <input type="text" class="form-control" value="<?= $dd['total1'] ?>" name="total1" placeholder="0" required>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1">
                              <h5 class="text-center">x</h5>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                              <input type="text" class="form-control" value="<?= $dd['total2'] ?>" name="total2" placeholder="0" required>
                            </div>                                  
                          </div>
                          <!-- total -->

                          <!-- ukuran -->
                          <div class="row mb-2">
                            <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Ukuran Kertas</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <select class="form-control" name="ukuran" id="ukuran">
                                <option value="<?= $dd['ukuran'] ?>"><?= $dd['ukuran'] ?></option>
                                <option value="A3">A3</option>
                                <option value="A4">A4</option>
                              </select>
                            </div>                            
                          </div>
                          <!-- ukuran -->

                          <!-- distribusi dokumen -->
                          <div class="row mb-2">
                            <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Distribusi Dokumen</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                                <option value="<?= $dd['id_dd'] ?>"><?= $dd['judul_dokumen'] ?></option>
                              </select>
                            </div>                            
                          </div>
                          <!-- distribusi dokumen -->

                          <div class="row mb-2">
                            <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <select name="status" id="status" class="form-control">
                                <?php if ($dd['status_dokumen'] == 1): ?>
                                  <option value="<?= $dd['status_dokumen'] ?>">Valid</option>
                                <?php endif ?>
                                <?php if ($dd['status_dokumen'] == 0): ?>
                                  <option value="<?= $dd['status_dokumen'] ?>">Tidak Valid</option>
                                <?php endif ?>
                                <option value="1">Valid</option>
                                <option value="0">Tidak Valid</option>                                          
                              </select>
                            </div>
                          </div>

                          <div class="row mb-2">
                            <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <input type="file" name="file_drawing" id="file_drawing" class="form-control" placeholder="File Dokumen (Format pdf / xlsx)">
                            </div>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                            <button type="submit" name="edit" class="btn btn-sm btn-primary">Edit</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!-- modal edit dokumen drawing -->

                  <?php $no++ ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
      <!-- tabel dokumen drawing -->

      <!-- tambah dokumen drawing -->

      <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#drawing">
            <i class="fa fa-plus"></i> Dokumen Drawing
          </button>
        </div>
      </div>
    <?php endif ?>


    <!-- modal tambah drawing -->
    <div class="modal fade" id="drawing" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
            <div class="col text-center">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Drawing</h5>                
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <?php $id_drawing = $CI->secure->encrypt_url($order['id_cc_ord']); ?>

          <form action="<?= base_url('drawing/tambah/').$id_drawing ?>" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col">
                    <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen">
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col">
                    <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen">
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col">
                    <input type="text" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" placeholder="Tgl dokumen" onfocus="(this.type='date')">
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col">
                    <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                      <option value="">Status dokumen</option>
                      <?php foreach ($status_dokumen as $sd): ?>
                        <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col">
                    <select name="revisi" id="revisi" class="form-control" required>
                      <option value="">Revisi</option>
                      <?php foreach ($revisi as $r): ?>
                        <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col">
                    <select name="edisi" id="edisi" class="form-control" required>
                      <option value="">Edisi</option>
                      <?php foreach ($edisi as $e): ?>
                        <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>

                <!-- total -->
                <div class="row mb-2">
                  <label class="col-lg-3 col-md-3 col-sm-3" for="issue_sheet">Copy x Page</label>
                  <div class="col-lg-2 col-md-2 col-sm-2">
                    <input type="text" class="form-control" name="total1" placeholder="0" required>
                  </div>
                  <div class="col-lg-1 col-md-1 col-sm-1">
                    <h5 class="text-center">x</h5>
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2">
                    <input type="text" class="form-control" name="total2" placeholder="0" required>
                  </div>                                  
                </div>
                <!-- total -->

                <!-- ukuran -->
                <div class="row mb-2">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <select class="form-control" name="ukuran" id="ukuran" required>
                      <option value="">Ukuran Kertas</option>
                      <option value="A3">A3</option>
                      <option value="A4">A4</option>
                    </select>
                  </div>                            
                </div>
                <!-- ukuran -->

                <!-- distribusi dokumen -->
                <div class="row mb-2">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                      <option value="">Distribusi Dokumen</option>
                      <?php foreach ($disdok as $disd): ?>
                        <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>                            
                </div>
                <!-- distribusi dokumen -->

                <div class="row mb-2">
                  <div class="col">
                    <input required name="file_drawing" id="file_drawing" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
                  </div>
                </div>                                                


              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
              <button type="submit" name="tambah" class="btn btn-sm btn-primary">Tambah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- modal tambah drawing -->

    <!-- tambah dokumen drawing -->

  </div>
</div>
<!-- drawing -->


<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- BQ -->
<div class="card">
  <div class="card-header text-center h5" style="background-color: #e3e2de;">
    <b>BQ</b>
  </div>
  <div class="card-body">

    <!-- tabel dokumen BQ -->
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

        <div class="table-responsive">
          <table id="datatableBq" class="table table-sm table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>No Dokumen</th>
                <th>Nama Dokumen</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Edisi</th>
                <th>Revisi</th>
                <th>Transmit</th>
                <th>No. SP</th>                  
                <th>Valid</th>                        
                <th>Aksi</th>                       
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach ($dokumen_bq as $db): ?>
                <tr>
                  <td style="font-size: 14px;"><?= $no ?></td>
                  <td style="font-size: 14px;"><?= $db['no_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $db['nama_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $db['tgl_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $db['nama_status']; ?></td>
                  <td style="font-size: 14px;"><?= $db['nama_edisi']; ?></td>
                  <td style="font-size: 14px;"><?= $db['nama_revisi']; ?></td>

                  <!-- transmit -->
                  <?php if ($db['no_sp'] != NULL): ?>
                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                    <?php else: ?>
                      <td class="text-center"></td>
                    <?php endif ?>
                    <!-- transmit -->

                    <?php 
                    $string = explode("/", $db['no_sp'], 2);
                    $no_sp = $string[0];
                    ?>

                    <!-- no sp -->
                    <td style="font-size: 14px;"><?= $no_sp; ?></td>
                    <!-- no sp -->

                    <!-- status valid -->
                    <?php if ($db['status'] == 1): ?>
                      <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                    <?php endif ?>
                    <?php if ($db['status'] == 0): ?>
                      <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                    <?php endif ?>
                    <!-- status valid -->

                    <!-- Aksi -->
                    <td>


                      <!-- jika belum transmit admin bisa lihat -->
                      <?php if ($db['no_sp'] == NULL): ?>

                        <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                        <div class="dropdown">
                          <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                            <!-- view -->
                            <a class="dropdown-item" target="_blank" href="<?= base_url('bq/view/').$db['nama_file'] ?>">View</a>
                            <!-- view -->

                            <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                            <!-- edit -->
                            <a class="dropdown-item" href="<?= base_url('bq/edit/') . $db['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#ebq'.$db['id_dokumen'] ?>">Edit</a>
                            <!-- edit -->
                            <!-- revisi -->
                            <?php if ($db['status'] == 1): ?>
                              <a class="dropdown-item" target="_blank" href="<?= base_url('bq/revisi/') . $db['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                            <?php endif ?>
                            <!-- revisi -->
                            <!-- hapus -->
                            <a href="<?= base_url('bq/hapus/') . $db['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$db['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                            <!-- hapus -->

                          <?php endif ?>

                          <!-- history -->
                          <?php if ($db['status'] == 1): ?>
                            <a class="dropdown-item" target="_blank" href="<?= base_url('bq/history/') . $db['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                          <?php endif ?>
                          <!-- history -->                                

                        </div>
                      </div>

                    <?php endif ?>

                  <?php endif ?>
                  <!-- jika belum transmit admin bisa lihat -->

                  <!-- jika sudah transmit bisa lihat semua -->
                  <?php if ($db['no_sp'] != NULL): ?>

                    <div class="dropdown">
                      <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pilih
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                        <!-- view -->
                        <a class="dropdown-item" target="_blank" href="<?= base_url('bq/view/').$db['nama_file'] ?>">View</a>
                        <!-- view -->

                        <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                        <!-- edit -->
                        <a class="dropdown-item" href="<?= base_url('bq/edit/') . $db['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#ebq'.$db['id_dokumen'] ?>">Edit</a>
                        <!-- edit -->
                        <!-- revisi -->
                        <?php if ($db['status'] == 1): ?>
                          <a class="dropdown-item" target="_blank" href="<?= base_url('bq/revisi/') . $db['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                        <?php endif ?>
                        <!-- revisi -->
                        <!-- hapus -->
                        <a href="<?= base_url('bq/hapus/') . $db['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$db['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                        <!-- hapus -->

                      <?php endif ?>

                      <!-- history -->
                      <?php if ($db['status'] == 1): ?>
                        <a class="dropdown-item" target="_blank" href="<?= base_url('bq/history/') . $db['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                      <?php endif ?>
                      <!-- history -->                                

                    </div>
                  </div>

                <?php endif ?>
                <!-- jika belum transmit admin bisa lihat -->


              </td>
              <!-- aksi -->

            </tr>



            <!-- modal edit dokumen BQ -->
            <div class="modal hide fade" id="<?= 'ebq'.$db['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="edrawing" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                    <div class="col text-center">
                      <h5 class="modal-title" id="edrawing">Edit Dokumen BQ</h5>                
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>


                  <form action="<?= base_url('bq/edit/').$db['id_dokumen']; ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="container-fluid">

                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $db['no_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $db['nama_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $db['tgl_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="status_dokumen">Status Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                              <option value="<?= $db['status_dokumen'] ?>"><?= $db['nama_status'] ?></option>
                              <?php foreach ($status_dokumen as $sd): ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="<?= $db['revisi'] ?>"><?= $db['nama_revisi'] ?></option>
                              <?php foreach ($revisi as $r): ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="<?= $db['edisi'] ?>"><?= $db['nama_edisi'] ?></option>
                              <?php foreach ($edisi as $e): ?>
                                <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>

                        <!-- total -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Copy x Page</label>
                          <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" class="form-control" value="<?= $db['total1'] ?>" name="total1" placeholder="0" required>
                          </div>
                          <div class="col-lg-1 col-md-1 col-sm-1">
                            <h5 class="text-center">x</h5>
                          </div>
                          <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" class="form-control" value="<?= $db['total2'] ?>" name="total2" placeholder="0" required>
                          </div>                                  
                        </div>
                        <!-- total -->

                        <!-- ukuran -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Ukuran Kertas</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="form-control" name="ukuran" id="ukuran">
                              <option value="<?= $db['ukuran'] ?>"><?= $db['ukuran'] ?></option>
                              <option value="A3">A3</option>
                              <option value="A4">A4</option>
                            </select>
                          </div>                            
                        </div>
                        <!-- ukuran -->

                        <!-- distribusi dokumen -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Distribusi Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                              <option value="<?= $db['id_dd'] ?>"><?= $db['judul_dokumen'] ?></option>
                            </select>
                          </div>                            
                        </div>
                        <!-- distribusi dokumen -->

                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="status" id="status" class="form-control">
                              <?php if ($db['status_dokumen'] == 1): ?>
                                <option value="<?= $db['status_dokumen'] ?>">Valid</option>
                              <?php endif ?>
                              <?php if ($db['status_dokumen'] == 0): ?>
                                <option value="<?= $db['status_dokumen'] ?>">Tidak Valid</option>
                              <?php endif ?>
                              <option value="1">Valid</option>
                              <option value="0">Tidak Valid</option>                                          
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input type="file" name="file_bq" id="file_bq" class="form-control" placeholder="File Dokumen (format pdf / xlsx)">
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                          <button type="submit" name="edit" class="btn btn-sm btn-primary">Edit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- modal edit dokumen BQ -->

                <?php $no++ ?>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- tabel dokumen BQ -->

    <!-- tambah dokumen BQ -->
    <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bq">
          <i class="fa fa-plus"></i> Dokumen BQ
        </button>
      </div>
    </div>
  <?php endif ?>


  <!-- modal tambah BQ -->
  <div class="modal fade" id="bq" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
          <div class="col text-center">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen BQ</h5>                
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="<?= base_url('bq/tambah/').$order['id_cc_ord'] ?>" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col">
                  <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input type="text" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" placeholder="Tgl dokumen" onfocus="(this.type='date')">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                    <option value="">Status dokumen</option>
                    <?php foreach ($status_dokumen as $sd): ?>
                      <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="revisi" id="revisi" class="form-control" required>
                    <option value="">Revisi</option>
                    <?php foreach ($revisi as $r): ?>
                      <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="edisi" id="edisi" class="form-control" required>
                    <option value="">Edisi</option>
                    <?php foreach ($edisi as $e): ?>
                      <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <!-- total -->
              <div class="row mb-2">
                <label class="col-lg-3 col-md-3 col-sm-3" for="issue_sheet">Copy x Page</label>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="text" class="form-control" name="total1" placeholder="0" required>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1">
                  <h5 class="text-center">x</h5>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="text" class="form-control" name="total2" placeholder="0" required>
                </div>                                  
              </div>
              <!-- total -->

              <!-- ukuran -->
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <select class="form-control" name="ukuran" id="ukuran" required>
                    <option value="">Ukuran Kertas</option>
                    <option value="A3">A3</option>
                    <option value="A4">A4</option>
                  </select>
                </div>                            
              </div>
              <!-- ukuran -->

              <!-- distribusi dokumen -->
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                    <option value="">Distribusi Dokumen</option>
                    <?php foreach ($disdok as $disd): ?>
                      <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>                            
              </div>
              <!-- distribusi dokumen -->

              <div class="row mb-2">
                <div class="col">
                  <input required name="file_bq" id="file_bq" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
                </div>
              </div>                                                


            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" name="tambah" class="btn btn-sm btn-primary">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal tambah BQ -->

  <!-- tambah dokumen BQ -->

</div>
</div>
<!-- BQ -->


<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- EIS -->
<div class="card">
  <div class="card-header text-center h5" style="background-color: #e3e2de;">
    <b>EIS</b>
  </div>
  <div class="card-body">

    <!-- tabel dokumen EIS -->
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

        <div class="table-responsive">
          <table id="datatableBq" class="table table-sm table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>No Dokumen</th>
                <th>Nama Dokumen</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Edisi</th>
                <th>Revisi</th>
                <th>Transmit</th>
                <th>No. SP</th>                
                <th>Valid</th>                        
                <th>Aksi</th>                       
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach ($dokumen_eis as $eis): ?>
                <tr>
                  <td style="font-size: 14px;"><?= $no ?></td>
                  <td style="font-size: 14px;"><?= $eis['no_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $eis['nama_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $eis['tgl_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $eis['nama_status']; ?></td>
                  <td style="font-size: 14px;"><?= $eis['nama_edisi']; ?></td>
                  <td style="font-size: 14px;"><?= $eis['nama_revisi']; ?></td>

                  <!-- transmit -->
                  <?php if ($eis['no_sp'] != NULL): ?>
                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                    <?php else: ?>
                      <td class="text-center"></td>
                    <?php endif ?>
                    <!-- transmit -->

                    <?php 
                    $string = explode("/", $eis['no_sp'], 2);
                    $no_sp = $string[0];
                    ?>

                    <!-- no sp -->
                    <td style="font-size: 14px;"><?= $no_sp; ?></td>
                    <!-- no sp -->

                    <!-- status valid -->
                    <?php if ($eis['status'] == 1): ?>
                      <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                    <?php endif ?>
                    <?php if ($eis['status'] == 0): ?>
                      <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                    <?php endif ?>
                    <!-- status valid -->

                    <!-- Aksi -->
                    <td>

                      <!-- jika belum transmit admin bisa lihat -->
                      <?php if ($eis['no_sp'] == NULL): ?>

                        <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                        <div class="dropdown">
                          <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                            <!-- view -->
                            <a class="dropdown-item" target="_blank" href="<?= base_url('eis/view/').$eis['nama_file'] ?>">View</a>
                            <!-- view -->

                            <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                            <!-- edit -->
                            <a class="dropdown-item" href="<?= base_url('eis/edit/') . $eis['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eeis'.$eis['id_dokumen'] ?>">Edit</a>
                            <!-- edit -->
                            <!-- revisi -->
                            <?php if ($eis['status'] == 1): ?>
                              <a class="dropdown-item" target="_blank" href="<?= base_url('eis/revisi/') . $eis['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                            <?php endif ?>
                            <!-- revisi -->
                            <!-- hapus -->
                            <a href="<?= base_url('eis/hapus/') . $eis['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$eis['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                            <!-- hapus -->

                          <?php endif ?>

                          <!-- history -->
                          <?php if ($eis['status'] == 1): ?>
                            <a class="dropdown-item" target="_blank" href="<?= base_url('eis/history/') . $eis['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                          <?php endif ?>
                          <!-- history -->                                

                        </div>
                      </div>

                    <?php endif ?>

                  <?php endif ?>
                  <!-- jika belum transmit admin bisa lihat -->

                  <!-- jika sudah transmit bisa lihat semua -->
                  <?php if ($eis['no_sp'] != NULL): ?>

                    <div class="dropdown">
                      <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pilih
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                        <!-- view -->
                        <a class="dropdown-item" target="_blank" href="<?= base_url('eis/view/').$eis['nama_file'] ?>">View</a>
                        <!-- view -->

                        <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                        <!-- edit -->
                        <a class="dropdown-item" href="<?= base_url('eis/edit/') . $eis['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eeis'.$eis['id_dokumen'] ?>">Edit</a>
                        <!-- edit -->
                        <!-- revisi -->
                        <?php if ($eis['status'] == 1): ?>
                          <a class="dropdown-item" target="_blank" href="<?= base_url('eis/revisi/') . $eis['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                        <?php endif ?>
                        <!-- revisi -->
                        <!-- hapus -->
                        <a href="<?= base_url('eis/hapus/') . $eis['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$eis['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                        <!-- hapus -->

                      <?php endif ?>

                      <!-- history -->
                      <?php if ($eis['status'] == 1): ?>
                        <a class="dropdown-item" target="_blank" href="<?= base_url('eis/history/') . $eis['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                      <?php endif ?>
                      <!-- history -->                                

                    </div>
                  </div>

                <?php endif ?>
                <!-- jika belum transmit admin bisa lihat -->


              </td>
              <!-- aksi -->

            </tr>



            <!-- modal edit dokumen EIS -->
            <div class="modal hide fade" id="<?= 'eeis'.$eis['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="eeis" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                    <div class="col text-center">
                      <h5 class="modal-title" id="edrawing">Edit Dokumen EIS</h5>                
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>


                  <form action="<?= base_url('eis/edit/').$eis['id_dokumen']; ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="container-fluid">

                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $eis['no_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $eis['nama_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $eis['tgl_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="status_dokumen">Status Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                              <option value="<?= $eis['status_dokumen'] ?>"><?= $eis['nama_status'] ?></option>
                              <?php foreach ($status_dokumen as $sd): ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="<?= $eis['revisi'] ?>"><?= $eis['nama_revisi'] ?></option>
                              <?php foreach ($revisi as $r): ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="<?= $eis['edisi'] ?>"><?= $eis['nama_edisi'] ?></option>
                              <?php foreach ($edisi as $e): ?>
                                <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>

                        <!-- total -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Copy x Page</label>
                          <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" class="form-control" value="<?= $eis['total1'] ?>" name="total1" placeholder="0" required>
                          </div>
                          <div class="col-lg-1 col-md-1 col-sm-1">
                            <h5 class="text-center">x</h5>
                          </div>
                          <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" class="form-control" value="<?= $eis['total2'] ?>" name="total2" placeholder="0" required>
                          </div>                                  
                        </div>
                        <!-- total -->

                        <!-- ukuran -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Ukuran Kertas</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="form-control" name="ukuran" id="ukuran">
                              <option value="<?= $eis['ukuran'] ?>"><?= $eis['ukuran'] ?></option>
                              <option value="A3">A3</option>
                              <option value="A4">A4</option>
                            </select>
                          </div>                            
                        </div>
                        <!-- ukuran -->

                        <!-- distribusi dokumen -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Distribusi Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                              <option value="<?= $eis['id_dd'] ?>"><?= $eis['judul_dokumen'] ?></option>
                            </select>
                          </div>                            
                        </div>
                        <!-- distribusi dokumen -->

                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="status" id="status" class="form-control">
                              <?php if ($eis['status_dokumen'] == 1): ?>
                                <option value="<?= $eis['status_dokumen'] ?>">Valid</option>
                              <?php endif ?>
                              <?php if ($eis['status_dokumen'] == 0): ?>
                                <option value="<?= $eis['status_dokumen'] ?>">Tidak Valid</option>
                              <?php endif ?>
                              <option value="1">Valid</option>
                              <option value="0">Tidak Valid</option>                                          
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input type="file" name="file_eis" id="file_eis" class="form-control" placeholder="File Dokumen (format pdf / xlsx)">
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                          <button type="submit" name="edit" class="btn btn-sm btn-primary">Edit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- modal edit dokumen EIS -->

                <?php $no++ ?>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- tabel dokumen EIS -->

    <!-- tambah dokumen EIS -->
    <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#eis">
          <i class="fa fa-plus"></i> Dokumen EIS
        </button>
      </div>
    </div>
  <?php endif ?>


  <!-- modal tambah EIS -->
  <div class="modal fade" id="eis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
          <div class="col text-center">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen EIS</h5>                
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="<?= base_url('eis/tambah/').$order['id_cc_ord'] ?>" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col">
                  <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input type="text" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" placeholder="Tgl dokumen" onfocus="(this.type='date')">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                    <option value="">Status dokumen</option>
                    <?php foreach ($status_dokumen as $sd): ?>
                      <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="revisi" id="revisi" class="form-control" required>
                    <option value="">Revisi</option>
                    <?php foreach ($revisi as $r): ?>
                      <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="edisi" id="edisi" class="form-control" required>
                    <option value="">Edisi</option>
                    <?php foreach ($edisi as $e): ?>
                      <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <!-- total -->
              <div class="row mb-2">
                <label class="col-lg-3 col-md-3 col-sm-3" for="issue_sheet">Copy x Page</label>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="text" class="form-control" name="total1" placeholder="0" required>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1">
                  <h5 class="text-center">x</h5>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="text" class="form-control" name="total2" placeholder="0" required>
                </div>                                  
              </div>
              <!-- total -->

              <!-- ukuran -->
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <select class="form-control" name="ukuran" id="ukuran" required>
                    <option value="">Ukuran Kertas</option>
                    <option value="A3">A3</option>
                    <option value="A4">A4</option>
                  </select>
                </div>                            
              </div>
              <!-- ukuran -->

              <!-- distribusi dokumen -->
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                    <option value="">Distribusi Dokumen</option>
                    <?php foreach ($disdok as $disd): ?>
                      <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>                            
              </div>
              <!-- distribusi dokumen -->

              <div class="row mb-2">
                <div class="col">
                  <input required name="file_eis" id="file_eis" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
                </div>
              </div>                                                

            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" name="tambah" class="btn btn-sm btn-primary">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal tambah EIS -->

  <!-- tambah dokumen EIS -->

</div>
</div>
<!-- EIS -->



<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- MP -->
<div class="card">
  <div class="card-header text-center h5" style="background-color: #e3e2de;">
    <b>MP</b>
  </div>
  <div class="card-body">

    <!-- tabel dokumen MP -->
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

        <div class="table-responsive">
          <table id="datatableBq" class="table table-sm table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>No Dokumen</th>
                <th>Nama Dokumen</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Edisi</th>
                <th>Revisi</th>
                <th>Transmit</th>
                <th>No. SP</th>                
                <th>Valid</th>                        
                <th>Aksi</th>                       
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach ($dokumen_mp as $mp): ?>
                <tr>
                  <td style="font-size: 14px;"><?= $no ?></td>
                  <td style="font-size: 14px;"><?= $mp['no_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $mp['nama_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $mp['tgl_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $mp['nama_status']; ?></td>
                  <td style="font-size: 14px;"><?= $mp['nama_edisi']; ?></td>
                  <td style="font-size: 14px;"><?= $mp['nama_revisi']; ?></td>

                  <!-- transmit -->
                  <?php if ($mp['no_sp'] != NULL): ?>
                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                    <?php else: ?>
                      <td class="text-center"></td>
                    <?php endif ?>
                    <!-- transmit -->

                    <?php 
                    $string = explode("/", $mp['no_sp'], 2);
                    $no_sp = $string[0];
                    ?>

                    <!-- no sp -->
                    <td style="font-size: 14px;"><?= $no_sp; ?></td>
                    <!-- no sp -->

                    <!-- status valid -->
                    <?php if ($mp['status'] == 1): ?>
                      <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                    <?php endif ?>
                    <?php if ($mp['status'] == 0): ?>
                      <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                    <?php endif ?>
                    <!-- status valid -->

                    <!-- Aksi -->
                    <td>


                      <!-- jika belum transmit admin bisa lihat -->
                      <?php if ($mp['no_sp'] == NULL): ?>

                        <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                        <div class="dropdown">
                          <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                            <!-- view -->
                            <a class="dropdown-item" target="_blank" href="<?= base_url('mp/view/').$mp['nama_file'] ?>">View</a>
                            <!-- view -->

                            <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                            <!-- edit -->
                            <a class="dropdown-item" href="<?= base_url('mp/edit/') . $mp['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#emp'.$mp['id_dokumen'] ?>">Edit</a>
                            <!-- edit -->
                            <!-- revisi -->
                            <?php if ($mp['status'] == 1): ?>
                              <a class="dropdown-item" target="_blank" href="<?= base_url('mp/revisi/') . $mp['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                            <?php endif ?>
                            <!-- revisi -->
                            <!-- hapus -->
                            <a href="<?= base_url('mp/hapus/') . $mp['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$mp['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                            <!-- hapus -->

                          <?php endif ?>

                          <!-- history -->
                          <?php if ($mp['status'] == 1): ?>
                            <a class="dropdown-item" target="_blank" href="<?= base_url('mp/history/') . $mp['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                          <?php endif ?>
                          <!-- history -->                                

                        </div>
                      </div>

                    <?php endif ?>

                  <?php endif ?>
                  <!-- jika belum transmit admin bisa lihat -->

                  <!-- jika sudah transmit bisa lihat semua -->
                  <?php if ($mp['no_sp'] != NULL): ?>

                    <div class="dropdown">
                      <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pilih
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                        <!-- view -->
                        <a class="dropdown-item" target="_blank" href="<?= base_url('mp/view/').$mp['nama_file'] ?>">View</a>
                        <!-- view -->

                        <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                        <!-- edit -->
                        <a class="dropdown-item" href="<?= base_url('mp/edit/') . $mp['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#emp'.$mp['id_dokumen'] ?>">Edit</a>
                        <!-- edit -->
                        <!-- revisi -->
                        <?php if ($mp['status'] == 1): ?>
                          <a class="dropdown-item" target="_blank" href="<?= base_url('mp/revisi/') . $mp['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                        <?php endif ?>
                        <!-- revisi -->
                        <!-- hapus -->
                        <a href="<?= base_url('mp/hapus/') . $mp['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$mp['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                        <!-- hapus -->

                      <?php endif ?>

                      <!-- history -->
                      <?php if ($mp['status'] == 1): ?>
                        <a class="dropdown-item" target="_blank" href="<?= base_url('mp/history/') . $mp['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                      <?php endif ?>
                      <!-- history -->                                

                    </div>
                  </div>

                <?php endif ?>
                <!-- jika belum transmit admin bisa lihat -->


              </td>
              <!-- aksi -->

            </tr>



            <!-- modal edit dokumen MP -->
            <div class="modal hide fade" id="<?= 'emp'.$mp['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="eeis" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                    <div class="col text-center">
                      <h5 class="modal-title" id="edrawing">Edit Dokumen EIS</h5>                
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>


                  <form action="<?= base_url('mp/edit/').$mp['id_dokumen']; ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="container-fluid">

                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $mp['no_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $mp['nama_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $mp['tgl_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="status_dokumen">Status Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                              <option value="<?= $mp['status_dokumen'] ?>"><?= $mp['nama_status'] ?></option>
                              <?php foreach ($status_dokumen as $sd): ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="<?= $mp['revisi'] ?>"><?= $mp['nama_revisi'] ?></option>
                              <?php foreach ($revisi as $r): ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="<?= $mp['edisi'] ?>"><?= $mp['nama_edisi'] ?></option>
                              <?php foreach ($edisi as $e): ?>
                                <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>

                        <!-- total -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Copy x Page</label>
                          <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" class="form-control" value="<?= $mp['total1'] ?>" name="total1" placeholder="0" required>
                          </div>
                          <div class="col-lg-1 col-md-1 col-sm-1">
                            <h5 class="text-center">x</h5>
                          </div>
                          <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" class="form-control" value="<?= $mp['total2'] ?>" name="total2" placeholder="0" required>
                          </div>                                  
                        </div>
                        <!-- total -->

                        <!-- ukuran -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Ukuran Kertas</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="form-control" name="ukuran" id="ukuran">
                              <option value="<?= $mp['ukuran'] ?>"><?= $mp['ukuran'] ?></option>
                              <option value="A3">A3</option>
                              <option value="A4">A4</option>
                            </select>
                          </div>                            
                        </div>
                        <!-- ukuran -->

                        <!-- distribusi dokumen -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Distribusi Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                              <option value="<?= $mp['id_dd'] ?>"><?= $mp['judul_dokumen'] ?></option>
                            </select>
                          </div>                            
                        </div>
                        <!-- distribusi dokumen -->

                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="status" id="status" class="form-control">
                              <?php if ($mp['status_dokumen'] == 1): ?>
                                <option value="<?= $mp['status_dokumen'] ?>">Valid</option>
                              <?php endif ?>
                              <?php if ($mp['status_dokumen'] == 0): ?>
                                <option value="<?= $mp['status_dokumen'] ?>">Tidak Valid</option>
                              <?php endif ?>
                              <option value="1">Valid</option>
                              <option value="0">Tidak Valid</option>                                          
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input type="file" name="file_mp" id="file_mp" class="form-control" placeholder="File Dokumen (format pdf / xlsx)">
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                          <button type="submit" name="edit" class="btn btn-sm btn-primary">Edit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- modal edit dokumen MP -->

                <?php $no++ ?>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- tabel dokumen MP -->

    <!-- tambah dokumen MP -->
    <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mp">
          <i class="fa fa-plus"></i> Dokumen MP
        </button>
      </div>
    </div>
  <?php endif ?>


  <!-- modal tambah MP -->
  <div class="modal fade" id="mp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
          <div class="col text-center">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen MP</h5>                
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="<?= base_url('mp/tambah/').$order['id_cc_ord'] ?>" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col">
                  <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input type="text" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" placeholder="Tgl dokumen" onfocus="(this.type='date')">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                    <option value="">Status dokumen</option>
                    <?php foreach ($status_dokumen as $sd): ?>
                      <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="revisi" id="revisi" class="form-control" required>
                    <option value="">Revisi</option>
                    <?php foreach ($revisi as $r): ?>
                      <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="edisi" id="edisi" class="form-control" required>
                    <option value="">Edisi</option>
                    <?php foreach ($edisi as $e): ?>
                      <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <!-- total -->
              <div class="row mb-2">
                <label class="col-lg-3 col-md-3 col-sm-3" for="issue_sheet">Copy x Page</label>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="text" class="form-control" name="total1" placeholder="0" required>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1">
                  <h5 class="text-center">x</h5>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="text" class="form-control" name="total2" placeholder="0" required>
                </div>                                  
              </div>
              <!-- total -->

              <!-- ukuran -->
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <select class="form-control" name="ukuran" id="ukuran" required>
                    <option value="">Ukuran Kertas</option>
                    <option value="A3">A3</option>
                    <option value="A4">A4</option>
                  </select>
                </div>                            
              </div>
              <!-- ukuran -->

              <!-- distribusi dokumen -->
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                    <option value="">Distribusi Dokumen</option>
                    <?php foreach ($disdok as $disd): ?>
                      <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>                            
              </div>
              <!-- distribusi dokumen -->

              <div class="row mb-2">
                <div class="col">
                  <input required name="file_mp" id="file_mp" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
                </div>
              </div>                                                


            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" name="tambah" class="btn btn-sm btn-primary">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal tambah MP -->

  <!-- tambah dokumen MP -->

</div>
</div>
<!-- MP -->





<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- CLO -->
<div class="card">
  <div class="card-header text-center h5" style="background-color: #e3e2de;">
    <b>CLO</b>
  </div>
  <div class="card-body">

    <!-- tabel dokumen CLO -->
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

        <div class="table-responsive">
          <table id="datatableBq" class="table table-sm table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>No Dokumen</th>
                <th>Nama Dokumen</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Edisi</th>
                <th>Revisi</th>
                <th>Transmit</th>
                <th>No. SP</th>                
                <th>Valid</th>                        
                <th>Aksi</th>                       
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach ($dokumen_clo as $clo): ?>
                <tr>
                  <td style="font-size: 14px;"><?= $no ?></td>
                  <td style="font-size: 14px;"><?= $clo['no_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $clo['nama_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $clo['tgl_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $clo['nama_status']; ?></td>
                  <td style="font-size: 14px;"><?= $clo['nama_edisi']; ?></td>
                  <td style="font-size: 14px;"><?= $clo['nama_revisi']; ?></td>

                  <!-- transmit -->
                  <?php if ($clo['no_sp'] != NULL): ?>
                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                    <?php else: ?>
                      <td class="text-center"></td>
                    <?php endif ?>
                    <!-- transmit -->

                    <?php 
                    $string = explode("/", $clo['no_sp'], 2);
                    $no_sp = $string[0];
                    ?>

                    <!-- no sp -->
                    <td style="font-size: 14px;"><?= $no_sp; ?></td>
                    <!-- no sp -->

                    <!-- status valid -->
                    <?php if ($clo['status'] == 1): ?>
                      <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                    <?php endif ?>
                    <?php if ($clo['status'] == 0): ?>
                      <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                    <?php endif ?>
                    <!-- status valid -->

                    <!-- Aksi -->
                    <td>


                      <!-- jika belum transmit admin bisa lihat -->
                      <?php if ($clo['no_sp'] == NULL): ?>

                        <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                        <div class="dropdown">
                          <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                            <!-- view -->
                            <a class="dropdown-item" target="_blank" href="<?= base_url('clo/view/').$clo['nama_file'] ?>">View</a>
                            <!-- view -->

                            <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                            <!-- edit -->
                            <a class="dropdown-item" href="<?= base_url('clo/edit/') . $clo['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eclo'.$clo['id_dokumen'] ?>">Edit</a>
                            <!-- edit -->
                            <!-- revisi -->
                            <?php if ($clo['status'] == 1): ?>
                              <a class="dropdown-item" target="_blank" href="<?= base_url('clo/revisi/') . $clo['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                            <?php endif ?>
                            <!-- revisi -->
                            <!-- hapus -->
                            <a href="<?= base_url('clo/hapus/') . $clo['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$clo['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                            <!-- hapus -->

                          <?php endif ?>

                          <!-- history -->
                          <?php if ($clo['status'] == 1): ?>
                            <a class="dropdown-item" target="_blank" href="<?= base_url('clo/history/') . $clo['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                          <?php endif ?>
                          <!-- history -->                                

                        </div>
                      </div>

                    <?php endif ?>

                  <?php endif ?>
                  <!-- jika belum transmit admin bisa lihat -->

                  <!-- jika sudah transmit bisa lihat semua -->
                  <?php if ($clo['no_sp'] != NULL): ?>

                    <div class="dropdown">
                      <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pilih
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                        <!-- view -->
                        <a class="dropdown-item" target="_blank" href="<?= base_url('clo/view/').$clo['nama_file'] ?>">View</a>
                        <!-- view -->

                        <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                        <!-- edit -->
                        <a class="dropdown-item" href="<?= base_url('clo/edit/') . $clo['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eclo'.$clo['id_dokumen'] ?>">Edit</a>
                        <!-- edit -->
                        <!-- revisi -->
                        <?php if ($clo['status'] == 1): ?>
                          <a class="dropdown-item" target="_blank" href="<?= base_url('clo/revisi/') . $clo['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                        <?php endif ?>
                        <!-- revisi -->
                        <!-- hapus -->
                        <a href="<?= base_url('clo/hapus/') . $clo['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$clo['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                        <!-- hapus -->

                      <?php endif ?>

                      <!-- history -->
                      <?php if ($clo['status'] == 1): ?>
                        <a class="dropdown-item" target="_blank" href="<?= base_url('clo/history/') . $clo['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                      <?php endif ?>
                      <!-- history -->                                

                    </div>
                  </div>

                <?php endif ?>
                <!-- jika belum transmit admin bisa lihat -->


              </td>
              <!-- aksi -->

            </tr>



            <!-- modal edit dokumen CLO -->
            <div class="modal hide fade" id="<?= 'eclo'.$clo['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="eclo" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                    <div class="col text-center">
                      <h5 class="modal-title" id="edrawing">Edit Dokumen CLO</h5>                
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>


                  <form action="<?= base_url('clo/edit/').$clo['id_dokumen']; ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="container-fluid">

                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $clo['no_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $clo['nama_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $clo['tgl_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="status_dokumen">Status Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                              <option value="<?= $clo['status_dokumen'] ?>"><?= $clo['nama_status'] ?></option>
                              <?php foreach ($status_dokumen as $sd): ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="<?= $clo['revisi'] ?>"><?= $clo['nama_revisi'] ?></option>
                              <?php foreach ($revisi as $r): ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="<?= $clo['edisi'] ?>"><?= $clo['nama_edisi'] ?></option>
                              <?php foreach ($edisi as $e): ?>
                                <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>

                        <!-- total -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Copy x Page</label>
                          <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" class="form-control" value="<?= $clo['total1'] ?>" name="total1" placeholder="0" required>
                          </div>
                          <div class="col-lg-1 col-md-1 col-sm-1">
                            <h5 class="text-center">x</h5>
                          </div>
                          <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" class="form-control" value="<?= $clo['total2'] ?>" name="total2" placeholder="0" required>
                          </div>                                  
                        </div>
                        <!-- total -->

                        <!-- ukuran -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Ukuran Kertas</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="form-control" name="ukuran" id="ukuran">
                              <option value="<?= $clo['ukuran'] ?>"><?= $clo['ukuran'] ?></option>
                              <option value="A3">A3</option>
                              <option value="A4">A4</option>
                            </select>
                          </div>                            
                        </div>
                        <!-- ukuran -->

                        <!-- distribusi dokumen -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Distribusi Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                              <option value="<?= $clo['id_dd'] ?>"><?= $clo['judul_dokumen'] ?></option>
                            </select>
                          </div>                            
                        </div>
                        <!-- distribusi dokumen -->

                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="status" id="status" class="form-control">
                              <?php if ($clo['status_dokumen'] == 1): ?>
                                <option value="<?= $clo['status_dokumen'] ?>">Valid</option>
                              <?php endif ?>
                              <?php if ($clo['status_dokumen'] == 0): ?>
                                <option value="<?= $clo['status_dokumen'] ?>">Tidak Valid</option>
                              <?php endif ?>
                              <option value="1">Valid</option>
                              <option value="0">Tidak Valid</option>                                          
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input type="file" name="file_clo" id="file_clo" class="form-control" placeholder="File Dokumen (format pdf / xlsx)">
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                          <button type="submit" name="edit" class="btn btn-sm btn-primary">Edit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- modal edit dokumen CLO -->

                <?php $no++ ?>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- tabel dokumen CLO -->

    <!-- tambah dokumen CLO -->
    <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#clo">
          <i class="fa fa-plus"></i> Dokumen CLO
        </button>
      </div>
    </div>
  <?php endif ?>


  <!-- modal tambah CLO -->
  <div class="modal fade" id="clo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
          <div class="col text-center">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen CLO</h5>                
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="<?= base_url('clo/tambah/').$order['id_cc_ord'] ?>" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col">
                  <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input type="text" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" placeholder="Tgl dokumen" onfocus="(this.type='date')">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                    <option value="">Status dokumen</option>
                    <?php foreach ($status_dokumen as $sd): ?>
                      <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="revisi" id="revisi" class="form-control" required>
                    <option value="">Revisi</option>
                    <?php foreach ($revisi as $r): ?>
                      <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="edisi" id="edisi" class="form-control" required>
                    <option value="">Edisi</option>
                    <?php foreach ($edisi as $e): ?>
                      <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <!-- total -->
              <div class="row mb-2">
                <label class="col-lg-3 col-md-3 col-sm-3" for="issue_sheet">Copy x Page</label>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="text" class="form-control" name="total1" placeholder="0" required>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1">
                  <h5 class="text-center">x</h5>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="text" class="form-control" name="total2" placeholder="0" required>
                </div>                                  
              </div>
              <!-- total -->

              <!-- ukuran -->
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <select class="form-control" name="ukuran" id="ukuran" required>
                    <option value="">Ukuran Kertas</option>
                    <option value="A3">A3</option>
                    <option value="A4">A4</option>
                  </select>
                </div>                            
              </div>
              <!-- ukuran -->

              <!-- distribusi dokumen -->
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                    <option value="">Distribusi Dokumen</option>
                    <?php foreach ($disdok as $disd): ?>
                      <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>                            
              </div>
              <!-- distribusi dokumen -->

              <div class="row mb-2">
                <div class="col">
                  <input required name="file_clo" id="file_clo" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
                </div>
              </div>                                                


            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" name="tambah" class="btn btn-sm btn-primary">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal tambah CLO -->

  <!-- tambah dokumen CLO -->

</div>
</div>
<!-- CLO -->




<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- MRS -->
<div class="card">
  <div class="card-header text-center h5" style="background-color: #e3e2de;">
    <b>MRS</b> 
  </div>
  <div class="card-body">

    <!-- tabel dokumen MRS -->
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

        <div class="table-responsive">
          <table id="datatableBq" class="table table-sm table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>No Dokumen</th>
                <th>Nama Dokumen</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Edisi</th>
                <th>Revisi</th>
                <th>Transmit</th>
                <th>No. SP</th>                
                <th>Valid</th>                        
                <th>Aksi</th>                       
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach ($dokumen_mrs as $mrs): ?>
                <tr>
                  <td style="font-size: 14px;"><?= $no ?></td>
                  <td style="font-size: 14px;"><?= $mrs['no_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $mrs['nama_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $mrs['tgl_dokumen']; ?></td>
                  <td style="font-size: 14px;"><?= $mrs['nama_status']; ?></td>
                  <td style="font-size: 14px;"><?= $mrs['nama_edisi']; ?></td>
                  <td style="font-size: 14px;"><?= $mrs['nama_revisi']; ?></td>

                  <!-- transmit -->
                  <?php if ($mrs['no_sp'] != NULL): ?>
                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                    <?php else: ?>
                      <td class="text-center"></td>
                    <?php endif ?>
                    <!-- transmit -->

                    <?php 
                    $string = explode("/", $mrs['no_sp'], 2);
                    $no_sp = $string[0];
                    ?>

                    <!-- no sp -->
                    <td style="font-size: 14px;"><?= $no_sp; ?></td>
                    <!-- no sp -->

                    <!-- status valid -->
                    <?php if ($mrs['status'] == 1): ?>
                      <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                    <?php endif ?>
                    <?php if ($mrs['status'] == 0): ?>
                      <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                    <?php endif ?>
                    <!-- status valid -->

                    <!-- Aksi -->
                    <td>


                      <!-- jika belum transmit admin bisa lihat -->
                      <?php if ($mrs['no_sp'] == NULL): ?>

                        <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                        <div class="dropdown">
                          <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                            <!-- view -->
                            <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/view/').$mrs['nama_file'] ?>">View</a>
                            <!-- view -->

                            <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                            <!-- edit -->
                            <a class="dropdown-item" href="<?= base_url('mrs/edit/') . $mrs['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#emrs'.$mrs['id_dokumen'] ?>">Edit</a>
                            <!-- edit -->
                            <!-- revisi -->
                            <?php if ($mrs['status'] == 1): ?>
                              <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/revisi/') . $mrs['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                            <?php endif ?>
                            <!-- revisi -->
                            <!-- hapus -->
                            <a href="<?= base_url('mrs/hapus/') . $mrs['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$mrs['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                            <!-- hapus -->

                          <?php endif ?>

                          <!-- history -->
                          <?php if ($mrs['status'] == 1): ?>
                            <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/history/') . $mrs['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                          <?php endif ?>
                          <!-- history -->                                

                        </div>
                      </div>

                    <?php endif ?>

                  <?php endif ?>
                  <!-- jika belum transmit admin bisa lihat -->

                  <!-- jika sudah transmit bisa lihat semua -->
                  <?php if ($mrs['no_sp'] != NULL): ?>

                    <div class="dropdown">
                      <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pilih
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                        <!-- view -->
                        <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/view/').$mrs['nama_file'] ?>">View</a>
                        <!-- view -->

                        <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                        <!-- edit -->
                        <a class="dropdown-item" href="<?= base_url('mrs/edit/') . $mrs['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#emrs'.$mrs['id_dokumen'] ?>">Edit</a>
                        <!-- edit -->
                        <!-- revisi -->
                        <?php if ($mrs['status'] == 1): ?>
                          <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/revisi/') . $mrs['kode_unik'].'/'.$order['id_cc_ord']; ?>">Revisi</a>                                  
                        <?php endif ?>
                        <!-- revisi -->
                        <!-- hapus -->
                        <a href="<?= base_url('mrs/hapus/') . $mrs['id_dokumen'].'/'.$order['id_cc_ord'].'/'.$mrs['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                        <!-- hapus -->

                      <?php endif ?>

                      <!-- history -->
                      <?php if ($mrs['status'] == 1): ?>
                        <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/history/') . $mrs['kode_unik'].'/'.$order['id_cc_ord']; ?>">History</a>                                  
                      <?php endif ?>
                      <!-- history -->                                

                    </div>
                  </div>

                <?php endif ?>
                <!-- jika belum transmit admin bisa lihat -->

              </td>
              <!-- aksi -->

            </tr>



            <!-- modal edit dokumen MRS -->
            <div class="modal hide fade" id="<?= 'emrs'.$mrs['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="emrs" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                    <div class="col text-center">
                      <h5 class="modal-title" id="emrs">Edit Dokumen MRS</h5>                
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>


                  <form action="<?= base_url('mrs/edit/').$mrs['id_dokumen']; ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="container-fluid">

                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $mrs['no_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $mrs['nama_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $mrs['tgl_dokumen'] ?>">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="status_dokumen">Status Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                              <option value="<?= $mrs['status_dokumen'] ?>"><?= $mrs['nama_status'] ?></option>
                              <?php foreach ($status_dokumen as $sd): ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="<?= $mrs['revisi'] ?>"><?= $mrs['nama_revisi'] ?></option>
                              <?php foreach ($revisi as $r): ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="<?= $mrs['edisi'] ?>"><?= $mrs['nama_edisi'] ?></option>
                              <?php foreach ($edisi as $e): ?>
                                <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>

                        <!-- total -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Copy x Page</label>
                          <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" class="form-control" value="<?= $mrs['total1'] ?>" name="total1" placeholder="0" required>
                          </div>
                          <div class="col-lg-1 col-md-1 col-sm-1">
                            <h5 class="text-center">x</h5>
                          </div>
                          <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" class="form-control" value="<?= $mrs['total2'] ?>" name="total2" placeholder="0" required>
                          </div>                                  
                        </div>
                        <!-- total -->

                        <!-- ukuran -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Ukuran Kertas</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="form-control" name="ukuran" id="ukuran">
                              <option value="<?= $mrs['ukuran'] ?>"><?= $mrs['ukuran'] ?></option>
                              <option value="A3">A3</option>
                              <option value="A4">A4</option>
                            </select>
                          </div>                            
                        </div>
                        <!-- ukuran -->

                        <!-- distribusi dokumen -->
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Distribusi Dokumen</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                              <option value="<?= $mrs['id_dd'] ?>"><?= $mrs['judul_dokumen'] ?></option>
                            </select>
                          </div>                            
                        </div>
                        <!-- distribusi dokumen -->

                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <select name="status" id="status" class="form-control">
                              <?php if ($mrs['status_dokumen'] == 1): ?>
                                <option value="<?= $mrs['status_dokumen'] ?>">Valid</option>
                              <?php endif ?>
                              <?php if ($mrs['status_dokumen'] == 0): ?>
                                <option value="<?= $mrs['status_dokumen'] ?>">Tidak Valid</option>
                              <?php endif ?>
                              <option value="1">Valid</option>
                              <option value="0">Tidak Valid</option>                                          
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <input type="file" name="file_mrs" id="file_mrs" class="form-control" placeholder="File Dokumen (format pdf / xlsx)">
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                          <button type="submit" name="edit" class="btn btn-sm btn-primary">Edit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- modal edit dokumen MRS -->

                <?php $no++ ?>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- tabel dokumen MRS -->

    <!-- tambah dokumen MRS -->
    <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mrs">
          <i class="fa fa-plus"></i> Dokumen MRS
        </button>
      </div>
    </div>
  <?php endif ?>

  <!-- modal tambah MRS -->
  <div class="modal fade" id="mrs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
          <div class="col text-center">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen MRS</h5>                
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="<?= base_url('mrs/tambah/').$order['id_cc_ord'] ?>" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col">
                  <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <input type="text" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" placeholder="Tgl dokumen" onfocus="(this.type='date')">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                    <option value="">Status dokumen</option>
                    <?php foreach ($status_dokumen as $sd): ?>
                      <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="revisi" id="revisi" class="form-control" required>
                    <option value="">Revisi</option>
                    <?php foreach ($revisi as $r): ?>
                      <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option> 
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <select name="edisi" id="edisi" class="form-control" required>
                    <option value="">Edisi</option>
                    <?php foreach ($edisi as $e): ?>
                      <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option> 
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <!-- total -->
              <div class="row mb-2">
                <label class="col-lg-3 col-md-3 col-sm-3" for="issue_sheet">Copy x Page</label>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="text" class="form-control" name="total1" placeholder="0" required>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1">
                  <h5 class="text-center">x</h5>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="text" class="form-control" name="total2" placeholder="0" required>
                </div>                                  
              </div>
              <!-- total -->

              <!-- ukuran -->
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <select class="form-control" name="ukuran" id="ukuran" required>
                    <option value="">Ukuran Kertas</option>
                    <option value="A3">A3</option>
                    <option value="A4">A4</option>
                  </select>
                </div>                            
              </div>
              <!-- ukuran -->

              <!-- distribusi dokumen -->
              <div class="row mb-2">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">
                    <option value="">Distribusi Dokumen</option>
                    <?php foreach ($disdok as $disd): ?>
                      <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>                            
              </div>
              <!-- distribusi dokumen -->

              <div class="row mb-2">
                <div class="col">
                  <input required name="file_mrs" id="file_mrs" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
                </div>
              </div>                                                


            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" name="tambah" class="btn btn-sm btn-primary">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal tambah MRS -->

  <!-- tambah dokumen MRS -->

</div>
</div>
<!-- MRS -->






<div style="margin-bottom: 100px;"></div>

</div>
</section>
<!-- content -->

</div>
<!-- halaman -->

<!-- content -->