  <!-- content -->

  <!-- halaman -->
  <div class="content-wrapper">

    <!-- judul -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-center">Detail Transmittal</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- judul -->

    <!-- content -->
    <section class="content">
      <div class="container-fluid">

        <!-- no sp -->
        <div class="row">
          <div class="col-lg-1 col-md-2 col-sm-2">
            <h6>No. SP</h6>
          </div>
          <div class="col-lg-11 col-md-10 col-sm-10">
            <h6><?= ': '.$no_sp ?> </h6>
          </div>
        </div>
        <!-- no sp -->

        <!-- no order -->
        <div class="row">
          <div class="col-lg-1 col-md-2 col-sm-2">
            <h6>No. Order</h6>
          </div>
          <div class="col-lg-11 col-md-10 col-sm-10">
            <h6><?= ': '.$order['id_cc_ord'] ?> </h6>
          </div>
        </div>
        <!-- no order -->

        <!-- pekerjaan -->
        <div class="row">
          <div class="col-lg-1 col-md-2 col-sm-2">
            <h6>Project</h6>
          </div>
          <div class="col-lg-11 col-md-10 col-sm-10">
            <h6><?= ': '.$order['pekerjaan'] ?> </h6>
          </div>
        </div>
        <!-- pekerjaan -->

        <!-- customer -->
        <div class="row">
          <div class="col-lg-1 col-md-2 col-sm-2">
            <h6>Customer</h6>
          </div>
          <div class="col-lg-11 col-md-10 col-sm-10">
            <h6><?= ': '.$order['nama_customer'] ?> </h6>
          </div>
        </div>
        <!-- customer -->

        <!-- export transmittal -->
        <div class="row justify-content-end mb-2">

          <div class="col-lg-2 col-md-3 col-sm-6">
            <a href="<?= base_url('export/transmittal/').$id_transmittal.'/'.$order['id_cc_ord'] ?>" class="btn btn-md btn-success btn-block"><i class="far fa-file-excel"></i>  Export Transmittal</a>
          </div>
        </div>
        <!-- export transmittal -->

        <!-- buat dokumen transmittal -->
        <div class="card" style="margin-bottom: 75px;">
          <div class="card-header text-center h5" style="background-color: #e3e2de;">
            <b>Dokumen</b>
          </div>
          <div class="card-body">

            <form action="<?= base_url('export/transmittal/'.$no_sp) ?>" method="post">

              <!-- pilih dokumen transmittal -->
              <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                  <!-- tab -->
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">

                      <?php if ($jenis == 'drawing'): ?>
                        <a class="nav-link active" id="drawing-tab" data-toggle="tab" href="#drawing" role="tab" aria-controls="drawing" aria-selected="true">Drawing</a>
                        <?php else: ?>
                          <a class="nav-link" id="drawing-tab" data-toggle="tab" href="#drawing" role="tab" aria-controls="drawing" aria-selected="false">Drawing</a>
                        <?php endif ?>

                      </li>
                      <li class="nav-item">

                        <?php if ($jenis == 'bq'): ?>
                          <a class="nav-link active" id="bq-tab" data-toggle="tab" href="#bq" role="tab" aria-controls="bq" aria-selected="true">BQ</a>
                          <?php else: ?>
                            <a class="nav-link" id="bq-tab" data-toggle="tab" href="#bq" role="tab" aria-controls="bq" aria-selected="false">BQ</a>
                          <?php endif ?>


                        </li>
                        <li class="nav-item">

                          <?php if ($jenis == 'eis'): ?>
                            <a class="nav-link active" id="eis-tab" data-toggle="tab" href="#eis" role="tab" aria-controls="eis" aria-selected="true">EIS</a>
                            <?php else: ?>
                              <a class="nav-link" id="eis-tab" data-toggle="tab" href="#eis" role="tab" aria-controls="eis" aria-selected="false">EIS</a>
                            <?php endif ?>

                          </li>

                          <li class="nav-item">

                            <?php if ($jenis == 'mp'): ?>
                              <a class="nav-link active" id="mp-tab" data-toggle="tab" href="#mp" role="tab" aria-controls="mp" aria-selected="true">MP</a>
                              <?php else: ?>
                                <a class="nav-link" id="mp-tab" data-toggle="tab" href="#mp" role="tab" aria-controls="mp" aria-selected="false">MP</a>
                              <?php endif ?>

                            </li>
                            <li class="nav-item">

                              <?php if ($jenis == 'clo'): ?>
                                <a class="nav-link active" id="clo-tab" data-toggle="tab" href="#clo" role="tab" aria-controls="clo" aria-selected="true">CLO</a>
                                <?php else: ?>
                                  <a class="nav-link" id="clo-tab" data-toggle="tab" href="#clo" role="tab" aria-controls="clo" aria-selected="false">CLO</a>
                                <?php endif ?>

                              </li>
                              <li class="nav-item">

                                <?php if ($jenis == 'mrs'): ?>
                                  <a class="nav-link active" id="mrs-tab" data-toggle="tab" href="#mrs" role="tab" aria-controls="mrs" aria-selected="true">MRS</a>
                                  <?php else: ?>
                                    <a class="nav-link" id="mrs-tab" data-toggle="tab" href="#mrs" role="tab" aria-controls="mrs" aria-selected="false">MRS</a>
                                  <?php endif ?>

                                </li>
                              </ul>
                              <div class="tab-content" id="myTabContent">
                                <?php if ($jenis == 'drawing'): ?>
                                  <div class="tab-pane fade show active" id="drawing" role="tabpanel" aria-labelledby="drawing-tab">
                                    <?php else: ?>
                                      <div class="tab-pane fade" id="drawing" role="tabpanel" aria-labelledby="drawing-tab">
                                      <?php endif ?>

                                      <!-- alert -->
                                      <?=  
                                      $this->session->flashdata('messageTransmittalDrawing');
                                      ?>
                                      <!-- end alert -->

                                      <?php if ($transmittal['submit'] == 0): ?>

                                        <div class="row justify-content-end">
                                          <div class="col-lg-2 col-md-2 col-sm-3">
                                            <a href="<?= base_url('transmittal/edit/').$no_sp.'/'.$order['id_cc_ord'] ?>" data-toggle="modal" data-target="#edrawing" class="btn btn-md btn-warning btn-block"><i class="far fa-edit"></i>  Edit Drawing</a>
                                          </div>
                                        </div>

                                      <?php endif ?>

                                      <!-- tabel drawing -->
                                      <div class="table-responsive mt-2">
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
                                                <td>
                                                  <div class="dropdown">
                                                    <button class="btn btn-xs btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Pilih
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                      <!-- lihat viewer -->
                                                      <a target="_blank" href="<?= base_url('drawing/viewer/') . $dd['nama_file'] ?>" class="dropdown-item">Viewer</a>
                                                      <!-- lihat viewer -->

                                                      <!-- view -->
                                                      <a target="_blank" class="dropdown-item" href="<?= base_url('drawing/view/').$dd['nama_file'] ?>">View doc.</a>
                                                      <!-- view -->

                                                    </div>
                                                  </div>

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

                                    <?php if ($jenis == 'bq'): ?>
                                      <div class="tab-pane fade show active" id="bq" role="tabpanel" aria-labelledby="bq-tab">
                                        <?php else: ?>
                                          <div class="tab-pane fade" id="bq" role="tabpanel" aria-labelledby="bq-tab">
                                          <?php endif ?>

                                          <!-- alert -->
                                          <?=  
                                          $this->session->flashdata('messageTransmittalBq');
                                          ?>
                                          <!-- end alert -->

                                          <?php if ($transmittal['submit'] == 0): ?>

                                            <div class="row justify-content-end">
                                              <div class="col-lg-2 col-md-2 col-sm-3">
                                                <a href="<?= base_url('transmittal/edit/').$no_sp.'/'.$order['id_cc_ord'] ?>" data-toggle="modal" data-target="#ebq" class="btn btn-md btn-warning btn-block"><i class="far fa-edit"></i>  Edit BQ</a>
                                              </div>
                                            </div>

                                          <?php endif ?>


                                          <!-- tabel BQ -->
                                          <div class="table-responsive mt-2">
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
                                                    <td>
                                                      <div class="dropdown">
                                                        <button class="btn btn-xs btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                          Pilih
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                          <!-- lihat viewer -->
                                                          <a target="_blank" href="<?= base_url('bq/viewer/') . $db['nama_file'] ?>" class="dropdown-item">Viewer</a>
                                                          <!-- lihat viewer -->

                                                          <!-- view -->
                                                          <a target="_blank" class="dropdown-item" href="<?= base_url('bq/view/').$db['nama_file'] ?>">View doc.</a>
                                                          <!-- view -->

                                                        </div>
                                                      </div>

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

                                        <?php if ($jenis == 'eis'): ?>
                                          <div class="tab-pane fade show active" id="eis" role="tabpanel" aria-labelledby="eis-tab">
                                            <?php else: ?>
                                              <div class="tab-pane fade" id="eis" role="tabpanel" aria-labelledby="eis-tab">
                                              <?php endif ?>

                                              <!-- alert -->
                                              <?=  
                                              $this->session->flashdata('messageTransmittalEis');
                                              ?>
                                              <!-- end alert -->

                                              <?php if ($transmittal['submit'] == 0): ?>

                                                <div class="row justify-content-end">
                                                  <div class="col-lg-2 col-md-2 col-sm-3">
                                                    <a href="<?= base_url('transmittal/edit/').$no_sp.'/'.$order['id_cc_ord'] ?>" data-toggle="modal" data-target="#eeis" class="btn btn-md btn-warning btn-block"><i class="far fa-edit"></i>  Edit EIS</a>
                                                  </div>
                                                </div>

                                              <?php endif ?>

                                              <!-- tabel EIS -->
                                              <div class="table-responsive mt-2">
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
                                                      <th>aksi</th>                       
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
                                                        <td>
                                                          <div class="dropdown">
                                                            <button class="btn btn-xs btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                              Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                              <!-- lihat viewer -->
                                                              <a target="_blank" href="<?= base_url('eis/viewer/') . $de['nama_file'] ?>" class="dropdown-item">Viewer</a>
                                                              <!-- lihat viewer -->

                                                              <!-- view -->
                                                              <a target="_blank" class="dropdown-item" href="<?= base_url('eis/view/').$de['nama_file'] ?>">View doc.</a>
                                                              <!-- view -->

                                                            </div>
                                                          </div>

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

                                            <?php if ($jenis == 'mp'): ?>
                                              <div class="tab-pane fade show active" id="mp" role="tabpanel" aria-labelledby="mp-tab">
                                                <?php else: ?>
                                                  <div class="tab-pane fade" id="mp" role="tabpanel" aria-labelledby="mp-tab">
                                                  <?php endif ?>

                                                  <!-- alert -->
                                                  <?=  
                                                  $this->session->flashdata('messageTransmittalMp');
                                                  ?>
                                                  <!-- end alert -->

                                                  <?php if ($transmittal['submit'] == 0): ?>

                                                    <div class="row justify-content-end">
                                                      <div class="col-lg-2 col-md-2 col-sm-3">
                                                        <a href="<?= base_url('transmittal/edit/').$no_sp.'/'.$order['id_cc_ord'] ?>" data-toggle="modal" data-target="#emp" class="btn btn-md btn-warning btn-block"><i class="far fa-edit"></i>  Edit MP</a>
                                                      </div>
                                                    </div>

                                                  <?php endif ?>

                                                  <!-- tabel MP -->
                                                  <div class="table-responsive mt-2">
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
                                                          <th>Aksi</th>                       
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
                                                            <td>
                                                              <div class="dropdown">
                                                                <button class="btn btn-xs btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                  Pilih
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                                  <!-- lihat viewer -->
                                                                  <a target="_blank" href="<?= base_url('mp/viewer/') . $dm['nama_file'] ?>" class="dropdown-item">Viewer</a>
                                                                  <!-- lihat viewer -->

                                                                  <!-- view -->
                                                                  <a target="_blank" class="dropdown-item" href="<?= base_url('mp/view/').$dm['nama_file'] ?>">View doc.</a>
                                                                  <!-- view -->

                                                                </div>
                                                              </div>

                                                            </td>
                                                            <!-- aksi -->

                                                          </tr>

                                                          <?php $no++ ?>
                                                        <?php endforeach ?>
                                                      </tbody>
                                                    </table>
                                                  </div>
                                                  <!-- tabel MP -->

                                                </div>

                                                <?php if ($jenis == 'clo'): ?>
                                                  <div class="tab-pane fade show active" id="clo" role="tabpanel" aria-labelledby="clo-tab">
                                                    <?php else: ?>
                                                      <div class="tab-pane fade" id="clo" role="tabpanel" aria-labelledby="clo-tab">
                                                      <?php endif ?>

                                                      <!-- alert -->
                                                      <?=  
                                                      $this->session->flashdata('messageTransmittalClo');
                                                      ?>
                                                      <!-- end alert -->

                                                      <?php if ($transmittal['submit'] == 0): ?>

                                                        <div class="row justify-content-end">
                                                          <div class="col-lg-2 col-md-2 col-sm-3">
                                                            <a href="<?= base_url('transmittal/edit/').$no_sp.'/'.$order['id_cc_ord'] ?>" data-toggle="modal" data-target="#eclo" class="btn btn-md btn-warning btn-block"><i class="far fa-edit"></i>  Edit CLO</a>
                                                          </div>
                                                        </div>

                                                      <?php endif ?>

                                                      <!-- tabel CLO -->
                                                      <div class="table-responsive mt-2">
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
                                                              <th>Aksi</th>                       
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
                                                                <td>
                                                                  <div class="dropdown">
                                                                    <button class="btn btn-xs btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                      Pilih
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                                      <!-- lihat viewer -->
                                                                      <a target="_blank" href="<?= base_url('clo/viewer/') . $dc['nama_file'] ?>" class="dropdown-item">Viewer</a>
                                                                      <!-- lihat viewer -->

                                                                      <!-- view -->
                                                                      <a target="_blank" class="dropdown-item" href="<?= base_url('clo/view/').$dc['nama_file'] ?>">View doc.</a>
                                                                      <!-- view -->

                                                                    </div>
                                                                  </div>

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

                                                    <?php if ($jenis == 'mrs'): ?>
                                                      <div class="tab-pane fade show active" id="mrs" role="tabpanel" aria-labelledby="mrs-tab">
                                                        <?php else: ?>
                                                         <div class="tab-pane fade" id="mrs" role="tabpanel" aria-labelledby="mrs-tab">
                                                         <?php endif ?>

                                                         <!-- alert -->
                                                         <?=  
                                                         $this->session->flashdata('messageTransmittalMrs');
                                                         ?>
                                                         <!-- end alert -->

                                                         <?php if ($transmittal['submit'] == 0): ?>
                                                           <div class="row justify-content-end">
                                                            <div class="col-lg-2 col-md-2 col-sm-3">
                                                              <a href="<?= base_url('transmittal/edit/').$no_sp.'/'.$order['id_cc_ord'] ?>" data-toggle="modal" data-target="#emrs" class="btn btn-md btn-warning btn-block"><i class="far fa-edit"></i>  Edit MRS</a>
                                                            </div>
                                                          </div>                                        
                                                        <?php endif ?>

                                                        <!-- tabel MRS -->
                                                        <div class="table-responsive mt-2">
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
                                                                <th>Aksi</th>                       
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
                                                                  <td>
                                                                    <div class="dropdown">
                                                                      <button class="btn btn-xs btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Pilih
                                                                      </button>
                                                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                                        <!-- lihat viewer -->
                                                                        <a target="_blank" href="<?= base_url('mrs/viewer/') . $dmr['nama_file'] ?>" class="dropdown-item">Viewer</a>
                                                                        <!-- lihat viewer -->

                                                                        <!-- view -->
                                                                        <a target="_blank" class="dropdown-item" href="<?= base_url('mrs/view/').$dmr['nama_file'] ?>">View doc.</a>
                                                                        <!-- view -->

                                                                      </div>
                                                                    </div>

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
<!--    <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12">
      <input type="text" onfocus="(this.type='date')" id="tgl_transmittal" name="tgl_transmittal" required="required" class="form-control" placeholder="Tgl Transmittal" required>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
      <input type="text" class="form-control" name="no_sp" id="no_sp" placeholder="No. SP (Issue No)" required>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
      <button class="btn btn-md btn-success btn-block" type="submit" name="buat"><i class="far fa-file-excel"></i> Buat Transmittal</button>
    </div>
  </div> -->
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


<!-- modal edit drawing -->
<div class="modal fade" id="edrawing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
        <div class="col text-center">
          <h5 class="modal-title" id="exampleModalLabel">Edit Drawing</h5>                
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form action="<?= base_url('transmittal/edrawing/'.$no_sp.'/'.$order['id_cc_ord']); ?>" method="post">
        <div class="modal-body">
          <div class="container-fluid">

           <!-- tabel drawing -->
           <div class="table-responsive mt-2">
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
                      <input class="form-check-input" type="checkbox" value="<?= $dd['kode_unik'] ?>" name="ambil[]" id="ambil" checked>
                    </td>
                    <!-- aksi -->

                  </tr>

                  <?php $no++ ?>
                <?php endforeach ?>

                <?php foreach ($edrawing as $ed): ?>
                  <tr>
                    <td style="font-size: 14px;"><?= $no ?></td>
                    <td style="font-size: 14px;"><?= $ed['no_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $ed['nama_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $ed['tgl_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $ed['nama_status']; ?></td>
                    <td style="font-size: 14px;"><?= $ed['edisi']; ?></td>
                    <td style="font-size: 14px;"><?= $ed['revisi']; ?></td>
                    <td style="font-size: 14px;"><?= $ed['issue_sheet']; ?></td>

                    <?php if ($ed['status'] == 1): ?>
                      <td class="text-center"><a class="badge badge-success">Valid</a></td>
                    <?php endif ?>

                    <?php if ($ed['status'] == 0): ?>
                      <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                    <?php endif ?>

                    <!-- Aksi -->
                    <td class="text-center">
                      <input class="form-check-input" type="checkbox" value="<?= $ed['kode_unik'] ?>" name="ambil[]" id="ambil">
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
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
        <button type="submit" name="simpan" class="btn btn-sm btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
</div>
<!-- modal edit drawing -->


<!-- modal edit BQ -->
<div class="modal fade" id="ebq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
        <div class="col text-center">
          <h5 class="modal-title" id="exampleModalLabel">Edit BQ</h5>                
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form action="<?= base_url('transmittal/ebq/'.$no_sp.'/'.$order['id_cc_ord']); ?>" method="post">
        <div class="modal-body">
          <div class="container-fluid">

           <!-- tabel BQ -->
           <div class="table-responsive mt-2">
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
                      <input class="form-check-input" type="checkbox" value="<?= $db['kode_unik'] ?>" name="ambil[]" id="ambil" checked>
                    </td>
                    <!-- aksi -->

                  </tr>

                  <?php $no++ ?>
                <?php endforeach ?>

                <?php foreach ($ebq as $eb): ?>
                  <tr>
                    <td style="font-size: 14px;"><?= $no ?></td>
                    <td style="font-size: 14px;"><?= $eb['no_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $eb['nama_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $eb['tgl_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $eb['nama_status']; ?></td>
                    <td style="font-size: 14px;"><?= $eb['edisi']; ?></td>
                    <td style="font-size: 14px;"><?= $eb['revisi']; ?></td>
                    <td style="font-size: 14px;"><?= $eb['issue_sheet']; ?></td>

                    <?php if ($eb['status'] == 1): ?>
                      <td class="text-center"><a class="badge badge-success">Valid</a></td>
                    <?php endif ?>

                    <?php if ($eb['status'] == 0): ?>
                      <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                    <?php endif ?>

                    <!-- Aksi -->
                    <td class="text-center">
                      <input class="form-check-input" type="checkbox" value="<?= $eb['kode_unik'] ?>" name="ambil[]" id="ambil">
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
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
        <button type="submit" name="simpan" class="btn btn-sm btn-primary">Simpan</button>
      </div>
    </form>


  </div>
</div>
</div>
<!-- modal edit BQ -->


<!-- modal edit EIS -->
<div class="modal fade" id="eeis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
        <div class="col text-center">
          <h5 class="modal-title" id="exampleModalLabel">Edit EIS</h5>                
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form action="<?= base_url('transmittal/eeis/'.$no_sp.'/'.$order['id_cc_ord']); ?>" method="post">
        <div class="modal-body">
          <div class="container-fluid">

           <!-- tabel EIS -->
           <div class="table-responsive mt-2">
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
                      <input class="form-check-input" type="checkbox" value="<?= $de['kode_unik'] ?>" name="ambil[]" id="ambil" checked>
                    </td>
                    <!-- aksi -->

                  </tr>

                  <?php $no++ ?>
                <?php endforeach ?>

                <?php foreach ($eeis as $ee): ?>
                  <tr>
                    <td style="font-size: 14px;"><?= $no ?></td>
                    <td style="font-size: 14px;"><?= $ee['no_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $ee['nama_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $ee['tgl_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $ee['nama_status']; ?></td>
                    <td style="font-size: 14px;"><?= $ee['edisi']; ?></td>
                    <td style="font-size: 14px;"><?= $ee['revisi']; ?></td>
                    <td style="font-size: 14px;"><?= $ee['issue_sheet']; ?></td>

                    <?php if ($ee['status'] == 1): ?>
                      <td class="text-center"><a class="badge badge-success">Valid</a></td>
                    <?php endif ?>

                    <?php if ($ee['status'] == 0): ?>
                      <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                    <?php endif ?>

                    <!-- Aksi -->
                    <td class="text-center">
                      <input class="form-check-input" type="checkbox" value="<?= $ee['kode_unik'] ?>" name="ambil[]" id="ambil">
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
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
        <button type="submit" name="simpan" class="btn btn-sm btn-primary">Simpan</button>
      </div>
    </form>



  </div>
</div>
</div>
<!-- modal edit EIS -->


<!-- modal edit MP -->
<div class="modal fade" id="emp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
        <div class="col text-center">
          <h5 class="modal-title" id="exampleModalLabel">Edit MP</h5>                
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form action="<?= base_url('transmittal/emp/'.$no_sp.'/'.$order['id_cc_ord']); ?>" method="post">
        <div class="modal-body">
          <div class="container-fluid">

           <!-- tabel MP -->
           <div class="table-responsive mt-2">
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
                      <input class="form-check-input" type="checkbox" value="<?= $dm['kode_unik'] ?>" name="ambil[]" id="ambil" checked>
                    </td>
                    <!-- aksi -->

                  </tr>

                  <?php $no++ ?>
                <?php endforeach ?>

                <?php foreach ($emp as $em): ?>
                  <tr>
                    <td style="font-size: 14px;"><?= $no ?></td>
                    <td style="font-size: 14px;"><?= $em['no_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $em['nama_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $em['tgl_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $em['nama_status']; ?></td>
                    <td style="font-size: 14px;"><?= $em['edisi']; ?></td>
                    <td style="font-size: 14px;"><?= $em['revisi']; ?></td>
                    <td style="font-size: 14px;"><?= $em['issue_sheet']; ?></td>

                    <?php if ($em['status'] == 1): ?>
                      <td class="text-center"><a class="badge badge-success">Valid</a></td>
                    <?php endif ?>

                    <?php if ($em['status'] == 0): ?>
                      <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                    <?php endif ?>

                    <!-- Aksi -->
                    <td class="text-center">
                      <input class="form-check-input" type="checkbox" value="<?= $em['kode_unik'] ?>" name="ambil[]" id="ambil">
                    </td>
                    <!-- aksi -->

                  </tr>

                  <?php $no++ ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <!-- tabel MP -->

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
        <button type="submit" name="simpan" class="btn btn-sm btn-primary">Simpan</button>
      </div>
    </form>


  </div>
</div>
</div>
<!-- modal edit MP -->


<!-- modal edit CLO -->
<div class="modal fade" id="eclo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
        <div class="col text-center">
          <h5 class="modal-title" id="exampleModalLabel">Edit CLO</h5>                
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form action="<?= base_url('transmittal/eclo/'.$no_sp.'/'.$order['id_cc_ord']); ?>" method="post">
        <div class="modal-body">
          <div class="container-fluid">

           <!-- tabel CLO -->
           <div class="table-responsive mt-2">
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
                      <input class="form-check-input" type="checkbox" value="<?= $dc['kode_unik'] ?>" name="ambil[]" id="ambil" checked>
                    </td>
                    <!-- aksi -->

                  </tr>

                  <?php $no++ ?>
                <?php endforeach ?>

                <?php foreach ($eclo as $ec): ?>
                  <tr>
                    <td style="font-size: 14px;"><?= $no ?></td>
                    <td style="font-size: 14px;"><?= $ec['no_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $ec['nama_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $ec['tgl_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $ec['nama_status']; ?></td>
                    <td style="font-size: 14px;"><?= $ec['edisi']; ?></td>
                    <td style="font-size: 14px;"><?= $ec['revisi']; ?></td>
                    <td style="font-size: 14px;"><?= $ec['issue_sheet']; ?></td>

                    <?php if ($ec['status'] == 1): ?>
                      <td class="text-center"><a class="badge badge-success">Valid</a></td>
                    <?php endif ?>

                    <?php if ($ec['status'] == 0): ?>
                      <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                    <?php endif ?>

                    <!-- Aksi -->
                    <td class="text-center">
                      <input class="form-check-input" type="checkbox" value="<?= $ec['kode_unik'] ?>" name="ambil[]" id="ambil">
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
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
        <button type="submit" name="simpan" class="btn btn-sm btn-primary">Simpan</button>
      </div>
    </form>


  </div>
</div>
</div>
<!-- modal edit CLO -->


<!-- modal edit MRS -->
<div class="modal fade" id="emrs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
        <div class="col text-center">
          <h5 class="modal-title" id="exampleModalLabel">Edit MRS</h5>                
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form action="<?= base_url('transmittal/emrs/'.$no_sp.'/'.$order['id_cc_ord']); ?>" method="post">
        <div class="modal-body">
          <div class="container-fluid">

           <!-- tabel MRS -->
           <div class="table-responsive mt-2">
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

                <?php foreach ($dokumen_mrs as $dr): ?>
                  <tr>
                    <td style="font-size: 14px;"><?= $no ?></td>
                    <td style="font-size: 14px;"><?= $dr['no_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $dr['nama_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $dr['tgl_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $dr['nama_status']; ?></td>
                    <td style="font-size: 14px;"><?= $dr['edisi']; ?></td>
                    <td style="font-size: 14px;"><?= $dr['revisi']; ?></td>
                    <td style="font-size: 14px;"><?= $dr['issue_sheet']; ?></td>

                    <?php if ($dr['status'] == 1): ?>
                      <td class="text-center"><a class="badge badge-success">Valid</a></td>
                    <?php endif ?>

                    <?php if ($dr['status'] == 0): ?>
                      <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                    <?php endif ?>

                    <!-- Aksi -->
                    <td class="text-center">
                      <input class="form-check-input" type="checkbox" value="<?= $dr['kode_unik'] ?>" name="ambil[]" id="ambil" checked>
                    </td>
                    <!-- aksi -->

                  </tr>

                  <?php $no++ ?>
                <?php endforeach ?>

                <?php foreach ($emrs as $er): ?>
                  <tr>
                    <td style="font-size: 14px;"><?= $no ?></td>
                    <td style="font-size: 14px;"><?= $er['no_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $er['nama_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $er['tgl_dokumen']; ?></td>
                    <td style="font-size: 14px;"><?= $er['nama_status']; ?></td>
                    <td style="font-size: 14px;"><?= $er['edisi']; ?></td>
                    <td style="font-size: 14px;"><?= $er['revisi']; ?></td>
                    <td style="font-size: 14px;"><?= $er['issue_sheet']; ?></td>

                    <?php if ($er['status'] == 1): ?>
                      <td class="text-center"><a class="badge badge-success">Valid</a></td>
                    <?php endif ?>

                    <?php if ($er['status'] == 0): ?>
                      <td class="text-center"><a class="badge badge-danger">Tidak Valid</a></td>
                    <?php endif ?>

                    <!-- Aksi -->
                    <td class="text-center">
                      <input class="form-check-input" type="checkbox" value="<?= $er['kode_unik'] ?>" name="ambil[]" id="ambil">
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

      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
        <button type="submit" name="simpan" class="btn btn-sm btn-primary">Simpan</button>
      </div>
    </form>


  </div>
</div>
</div>
<!-- modal edit MRS -->