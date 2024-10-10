  <!-- content -->

  <!-- halaman -->
  <div class="content-wrapper">

    <!-- judul -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-center">Buat Transmittal</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- judul -->

    <!-- content -->
    <section class="content">
      <div class="container-fluid">



        <!-- buat dokumen transmittal -->
        <div class="card">
          <div class="card-header text-center h5" style="background-color: #e3e2de;">
            <b>Pilih Dokumen</b>
          </div>
          <div class="card-body">

            <form action="<?= base_url('transmittal/create/'.$no_order) ?>" method="post">

              <input type="hidden" value="<?= $no_order ?>" name="no_order" id="no_order">

              <!-- pilih dokumen transmittal -->
              <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                  <!-- tab -->
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="drawing-tab" data-toggle="tab" href="#drawing" role="tab" aria-controls="drawing" aria-selected="true">Drawing</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="bq-tab" data-toggle="tab" href="#bq" role="tab" aria-controls="bq" aria-selected="false">BQ</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="eis-tab" data-toggle="tab" href="#eis" role="tab" aria-controls="eis" aria-selected="false">EIS</a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" id="mp-tab" data-toggle="tab" href="#mp" role="tab" aria-controls="mp" aria-selected="true">MP</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="clo-tab" data-toggle="tab" href="#clo" role="tab" aria-controls="clo" aria-selected="false">CLO</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="mrs-tab" data-toggle="tab" href="#mrs" role="tab" aria-controls="mrs" aria-selected="false">MRS</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="drawing" role="tabpanel" aria-labelledby="drawing-tab">
                      <!-- tabel drawing -->
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
                              <th>Issue Sheet</th>
                              <th>Valid</th>                        
                              <th>Ambil</th>                       
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
                                <td style="font-size: 14px;"><?= $dd['edisi']; ?></td>
                                <td style="font-size: 14px;"><?= $dd['revisi']; ?></td>
                                <td style="font-size: 14px;"><?= $dd['issue_sheet']; ?></td>

                                <?php if ($dd['status'] == 1): ?>
                                  <td class="text-center"><a class="badge badge-success">Valid</a></td>
                                <?php endif ?>

                                <?php if ($dd['status'] == 0): ?>
                                  <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                                <?php endif ?>

                                <!-- Aksi -->
                                <td class="text-center">
                                  <input class="form-check-input" type="checkbox" value="<?= 'd '.$dd['kode_unik'] ?>" name="ambil[]" id="ambil">
                                </td>
                                <!-- aksi -->

                              </tr>

                              <?php $no++ ?>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- tabel drawing -->
                    </div>
                    <div class="tab-pane fade" id="bq" role="tabpanel" aria-labelledby="bq-tab">

                      <!-- tabel BQ -->
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
                              <th>Issue Sheet</th>
                              <th>Valid</th>                        
                              <th>Ambil</th>                       
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
                                <td style="font-size: 14px;"><?= $db['edisi']; ?></td>
                                <td style="font-size: 14px;"><?= $db['revisi']; ?></td>
                                <td style="font-size: 14px;"><?= $db['issue_sheet']; ?></td>

                                <?php if ($db['status'] == 1): ?>
                                  <td class="text-center"><a class="badge badge-success">Valid</a></td>
                                <?php endif ?>

                                <?php if ($db['status'] == 0): ?>
                                  <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                                <?php endif ?>

                                <!-- Aksi -->
                                <td class="text-center">
                                  <input class="form-check-input" type="checkbox" value="<?= 'b '.$db['kode_unik'] ?>" name="ambil[]" id="ambil">
                                </td>
                                <!-- aksi -->

                              </tr>

                              <?php $no++ ?>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- tabel BQ -->

                    </div>
                    <div class="tab-pane fade" id="eis" role="tabpanel" aria-labelledby="eis-tab">

                      <!-- tabel EIS -->
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
                              <th>Issue Sheet</th>
                              <th>Valid</th>                        
                              <th>Ambil</th>                       
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($dokumen_eis as $de): ?>
                              <tr>
                                <td style="font-size: 14px;"><?= $no ?></td>
                                <td style="font-size: 14px;"><?= $de['no_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $de['nama_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $de['tgl_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $de['nama_status']; ?></td>
                                <td style="font-size: 14px;"><?= $de['edisi']; ?></td>
                                <td style="font-size: 14px;"><?= $de['revisi']; ?></td>
                                <td style="font-size: 14px;"><?= $de['issue_sheet']; ?></td>

                                <?php if ($de['status'] == 1): ?>
                                  <td class="text-center"><a class="badge badge-success">Valid</a></td>
                                <?php endif ?>

                                <?php if ($de['status'] == 0): ?>
                                  <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                                <?php endif ?>

                                <!-- Aksi -->
                                <td class="text-center">
                                  <input class="form-check-input" type="checkbox" value="<?= 'e '.$de['kode_unik'] ?>" name="ambil[]" id="ambil">
                                </td>
                                <!-- aksi -->

                              </tr>

                              <?php $no++ ?>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- tabel EIS -->

                    </div>
                    <div class="tab-pane fade" id="mp" role="tabpanel" aria-labelledby="mp-tab">

                      <!-- tabel EIS -->
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
                              <th>Issue Sheet</th>
                              <th>Valid</th>                        
                              <th>Ambil</th>                       
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($dokumen_mp as $dm): ?>
                              <tr>
                                <td style="font-size: 14px;"><?= $no ?></td>
                                <td style="font-size: 14px;"><?= $dm['no_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $dm['nama_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $dm['tgl_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $dm['nama_status']; ?></td>
                                <td style="font-size: 14px;"><?= $dm['edisi']; ?></td>
                                <td style="font-size: 14px;"><?= $dm['revisi']; ?></td>
                                <td style="font-size: 14px;"><?= $dm['issue_sheet']; ?></td>

                                <?php if ($dm['status'] == 1): ?>
                                  <td class="text-center"><a class="badge badge-success">Valid</a></td>
                                <?php endif ?>

                                <?php if ($dm['status'] == 0): ?>
                                  <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                                <?php endif ?>

                                <!-- Aksi -->
                                <td class="text-center">
                                  <input class="form-check-input" type="checkbox" value="<?= 'm '.$dm['kode_unik'] ?>" name="ambil[]" id="ambil">
                                </td>
                                <!-- aksi -->

                              </tr>

                              <?php $no++ ?>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- tabel EIS -->

                    </div>
                    <div class="tab-pane fade" id="clo" role="tabpanel" aria-labelledby="clo-tab">

                      <!-- tabel CLO -->
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
                              <th>Issue Sheet</th>
                              <th>Valid</th>                        
                              <th>Ambil</th>                       
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($dokumen_clo as $dc): ?>
                              <tr>
                                <td style="font-size: 14px;"><?= $no ?></td>
                                <td style="font-size: 14px;"><?= $dc['no_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $dc['nama_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $dc['tgl_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $dc['nama_status']; ?></td>
                                <td style="font-size: 14px;"><?= $dc['edisi']; ?></td>
                                <td style="font-size: 14px;"><?= $dc['revisi']; ?></td>
                                <td style="font-size: 14px;"><?= $dc['issue_sheet']; ?></td>

                                <?php if ($dc['status'] == 1): ?>
                                  <td class="text-center"><a class="badge badge-success">Valid</a></td>
                                <?php endif ?>

                                <?php if ($dc['status'] == 0): ?>
                                  <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                                <?php endif ?>

                                <!-- Aksi -->
                                <td class="text-center">
                                  <input class="form-check-input" type="checkbox" value="<?= 'c '.$dc['kode_unik'] ?>" name="ambil[]" id="ambil">
                                </td>
                                <!-- aksi -->

                              </tr>

                              <?php $no++ ?>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- tabel CLO -->

                    </div>
                    <div class="tab-pane fade" id="mrs" role="tabpanel" aria-labelledby="mrs-tab">

                      <!-- tabel MRS -->
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
                              <th>Issue Sheet</th>
                              <th>Valid</th>                        
                              <th>Ambil</th>                       
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($dokumen_mrs as $dmr): ?>
                              <tr>
                                <td style="font-size: 14px;"><?= $no ?></td>
                                <td style="font-size: 14px;"><?= $dmr['no_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $dmr['nama_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $dmr['tgl_dokumen']; ?></td>
                                <td style="font-size: 14px;"><?= $dmr['nama_status']; ?></td>
                                <td style="font-size: 14px;"><?= $dmr['edisi']; ?></td>
                                <td style="font-size: 14px;"><?= $dmr['revisi']; ?></td>
                                <td style="font-size: 14px;"><?= $dmr['issue_sheet']; ?></td>

                                <?php if ($dmr['status'] == 1): ?>
                                  <td class="text-center"><a class="badge badge-success">Valid</a></td>
                                <?php endif ?>

                                <?php if ($dmr['status'] == 0): ?>
                                  <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                                <?php endif ?>

                                <!-- Aksi -->
                                <td class="text-center">
                                  <input class="form-check-input" type="checkbox" value="<?= 'r '.$dmr['kode_unik'] ?>" name="ambil[]" id="ambil">
                                </td>
                                <!-- aksi -->

                              </tr>

                              <?php $no++ ?>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- tabel MRS -->

                    </div>                  
                  </div>
                  <!-- tab -->

                </div>
              </div>
              <!-- pilih dokumen transmittal -->

              <!-- eksekusi transmittal -->
              <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <input type="text" onfocus="(this.type='date')" id="tgl_transmittal" name="tgl_transmittal" required="required" class="form-control" placeholder="Tgl Transmittal" required>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <input type="text" class="form-control" name="no_sp" id="no_sp" placeholder="No. SP (Issue No)" required>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <button class="btn btn-md btn-success btn-block" type="submit" name="buat"><i class="fas fa-plus"></i>  Buat Transmittal</button>
                </div>
              </div>
              <!-- eksekusi transmittal -->

            </form>

          </div>
        </div>
        <!-- buat dokumen transmittal -->



      </div>
    </section>
    <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->



