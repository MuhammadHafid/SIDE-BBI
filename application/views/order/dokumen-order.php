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
          <h6><?= ': ' . $order['id_cc_ord'] ?></h6>
        </div>
      </div>
      <!-- no order -->

      <!-- nama order -->
      <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2">
          <h6>Nama Order</h6>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10">
          <h6><?= ': ' . $order['pekerjaan'] ?></h6>
        </div>
      </div>
      <!-- nama order -->

      <!-- nama customer -->
      <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2">
          <h6>Nama Customer</h6>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10">
          <h6><?= ': ' . $order['nama_customer'] ?></h6>
        </div>
      </div>
      <!-- nama customer -->

      <!-- export excel -->
      <div class="row d-flex justify-content-between mb-2 mt-1">
        <div class="col-lg-2 col-md-2">
          <select name="forma" class="col-lg-12 col-md-12 col-sm-12 col-xs-4 form-control" onchange="location = this.value;">
            <option value="">Pilih Fungsi</option>
            <?php
            foreach ($dokumen_akses as $da) {
            ?>
              <option value="<?= base_url('order/dokumen/') . $order['id_cc_ord'] . '/' . $da['nama_role'] ?>"><?= $da['nama_role'] ?></option>
            <?php
            }
            ?>
          </select>
        </div>
        <div class="col-lg-2 col-md-2 text-right">
          <div class="row">
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
              <div class="col-lg-6 col-md-6">
                <a data-toggle="tooltip" data-placement="top" title="Export Dokumen Order" target="_blank" href="<?= base_url('export/dokumenOrder/' . $order['id']) ?>" class="btn btn-success btn-md btn-block">
                  <i class="far fa-file-excel"></i>
                </a>
              </div>
              <div class="col-lg-6 col-md-6">
                <a data-toggle="tooltip" data-placement="top" title="Buat Transmittal" target="_blank" href="<?= base_url('transmittal/create/' . $order['id_cc_ord']) ?>" class="btn btn-dark btn-md btn-block"><i class="fas fa-file-medical"></i></a>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
      <!-- export excel -->

      <!-- tab user (sales, ppc, engineering, mm, logistik, qa & qc) -->
      <div class="row">
        <div class="col-md-12">

        </div>
      </div>
      <!-- tab user (sales, ppc, engineering, mm, logistik, qa & qc) -->

      <!-- pengkondisian dokumen berdasarkan fungsi -->
      <!-- //////////////////////////////////////////// dokumen engineering /////////////////////////////////////////// -->
      <?php
      if ($fungsi == 'Engineering') {
      ?>
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
                      <?php foreach ($dokumen_drawing as $dd) : ?>
                        <tr>
                          <td style="font-size: 14px;"><?= $no ?></td>
                          <td style="font-size: 14px;"><?= $dd['no_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $dd['nama_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $dd['tgl_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $dd['nama_status']; ?></td>
                          <td style="font-size: 14px;"><?= $dd['nama_edisi']; ?></td>
                          <td style="font-size: 14px;"><?= $dd['nama_revisi']; ?></td>
                          <!-- transmit -->
                          <?php if ($dd['no_sp'] != NULL) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php else : ?>
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
                          <?php if ($dd['status'] == 1) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php endif ?>
                          <?php if ($dd['status'] == 0) : ?>
                            <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                          <?php endif ?>
                          <!-- status valid -->
                          <!-- Aksi -->
                          <td>
                            <!-- jika belum transmit admin bisa lihat -->
                            <?php if ($dd['no_sp'] == NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/view/') . $dd['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('drawing/edit/') . $dd['id_dokumen'] ?>" data-toggle="modal" data-target="<?= '#edrawing' . $dd['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($dd['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/revisi/') . $dd['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('drawing/hapus/') . $dd['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $dd['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($dd['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/history/') . $dd['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                            <!-- jika sudah transmit bisa lihat semua -->
                            <?php if ($dd['no_sp'] != NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/view/') . $dd['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('drawing/edit/') . $dd['id_dokumen'] ?>" data-toggle="modal" data-target="<?= '#edrawing' . $dd['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($dd['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/revisi/') . $dd['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('drawing/hapus/') . $dd['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $dd['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($dd['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/history/') . $dd['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
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
                        <div class="modal hide fade" id="<?= 'edrawing' . $dd['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="edrawing" aria-hidden="true">
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
                              <form action="<?= base_url('drawing/edit/') . $dd['id_dokumen'] . '/' . $fungsi; ?>" method="post" enctype="multipart/form-data">
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
                                          <?php foreach ($status_dokumen as $sd) : ?>
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
                                          <?php foreach ($revisi as $r) : ?>
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
                                          <?php foreach ($edisi as $e) : ?>
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
                                          <?php if ($dd['status_dokumen'] == 1) : ?>
                                            <option value="<?= $dd['status_dokumen'] ?>">Valid</option>
                                          <?php endif ?>
                                          <?php if ($dd['status_dokumen'] == 0) : ?>
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
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
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
                  <form action="<?= base_url('drawing/tambah/') . $order['id_cc_ord'] . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">
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
                              <?php foreach ($status_dokumen as $sd) : ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="">Revisi</option>
                              <?php foreach ($revisi as $r) : ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="">Edisi</option>
                              <?php foreach ($edisi as $e) : ?>
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
                              <?php foreach ($disdok as $disd) : ?>
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
                      <?php foreach ($dokumen_bq as $db) : ?>
                        <tr>
                          <td style="font-size: 14px;"><?= $no ?></td>
                          <td style="font-size: 14px;"><?= $db['no_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $db['nama_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $db['tgl_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $db['nama_status']; ?></td>
                          <td style="font-size: 14px;"><?= $db['nama_edisi']; ?></td>
                          <td style="font-size: 14px;"><?= $db['nama_revisi']; ?></td>
                          <!-- transmit -->
                          <?php if ($db['no_sp'] != NULL) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php else : ?>
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
                          <?php if ($db['status'] == 1) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php endif ?>
                          <?php if ($db['status'] == 0) : ?>
                            <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                          <?php endif ?>
                          <!-- status valid -->
                          <!-- Aksi -->
                          <td>
                            <!-- jika belum transmit admin bisa lihat -->
                            <?php if ($db['no_sp'] == NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('bq/view/') . $db['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('bq/edit/') . $db['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#ebq' . $db['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($db['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('bq/revisi/') . $db['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('bq/hapus/') . $db['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $db['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($db['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('bq/history/') . $db['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                            <!-- jika sudah transmit bisa lihat semua -->
                            <?php if ($db['no_sp'] != NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('bq/view/') . $db['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('bq/edit/') . $db['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#ebq' . $db['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($db['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('bq/revisi/') . $db['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('bq/hapus/') . $db['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $db['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($db['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('bq/history/') . $db['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
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
                        <div class="modal hide fade" id="<?= 'ebq' . $db['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="edrawing" aria-hidden="true">
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
                              <form action="<?= base_url('bq/edit/') . $db['id_dokumen'] . '/' . $fungsi; ?>" method="post" enctype="multipart/form-data">
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
                                          <?php foreach ($status_dokumen as $sd) : ?>
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
                                          <?php foreach ($revisi as $r) : ?>
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
                                          <?php foreach ($edisi as $e) : ?>
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
                                          <?php if ($db['status_dokumen'] == 1) : ?>
                                            <option value="<?= $db['status_dokumen'] ?>">Valid</option>
                                          <?php endif ?>
                                          <?php if ($db['status_dokumen'] == 0) : ?>
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
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
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
                  <form action="<?= base_url('bq/tambah/') . $order['id_cc_ord'] . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">
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
                              <?php foreach ($status_dokumen as $sd) : ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="">Revisi</option>
                              <?php foreach ($revisi as $r) : ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="">Edisi</option>
                              <?php foreach ($edisi as $e) : ?>
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
                              <?php foreach ($disdok as $disd) : ?>
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
                      <?php foreach ($dokumen_eis as $eis) : ?>
                        <tr>
                          <td style="font-size: 14px;"><?= $no ?></td>
                          <td style="font-size: 14px;"><?= $eis['no_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $eis['nama_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $eis['tgl_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $eis['nama_status']; ?></td>
                          <td style="font-size: 14px;"><?= $eis['nama_edisi']; ?></td>
                          <td style="font-size: 14px;"><?= $eis['nama_revisi']; ?></td>
                          <!-- transmit -->
                          <?php if ($eis['no_sp'] != NULL) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php else : ?>
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
                          <?php if ($eis['status'] == 1) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php endif ?>
                          <?php if ($eis['status'] == 0) : ?>
                            <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                          <?php endif ?>
                          <!-- status valid -->
                          <!-- Aksi -->
                          <td>
                            <!-- jika belum transmit admin bisa lihat -->
                            <?php if ($eis['no_sp'] == NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('eis/view/') . $eis['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('eis/edit/') . $eis['id_dokumen'] . '/' . $fungsi; ?>" data-toggle="modal" data-target="<?= '#eeis' . $eis['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($eis['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('eis/revisi/') . $eis['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('eis/hapus/') . $eis['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $eis['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($eis['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('eis/history/') . $eis['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                            <!-- jika sudah transmit bisa lihat semua -->
                            <?php if ($eis['no_sp'] != NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('eis/view/') . $eis['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('eis/edit/') . $eis['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eeis' . $eis['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($eis['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('eis/revisi/') . $eis['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('eis/hapus/') . $eis['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $eis['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($eis['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('eis/history/') . $eis['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
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
                        <div class="modal hide fade" id="<?= 'eeis' . $eis['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="eeis" aria-hidden="true">
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
                              <form action="<?= base_url('eis/edit/') . $eis['id_dokumen'] . '/' . $fungsi; ?>" method="post" enctype="multipart/form-data">
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
                                          <?php foreach ($status_dokumen as $sd) : ?>
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
                                          <?php foreach ($revisi as $r) : ?>
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
                                          <?php foreach ($edisi as $e) : ?>
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
                                          <?php if ($eis['status_dokumen'] == 1) : ?>
                                            <option value="<?= $eis['status_dokumen'] ?>">Valid</option>
                                          <?php endif ?>
                                          <?php if ($eis['status_dokumen'] == 0) : ?>
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
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
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
                  <form action="<?= base_url('eis/tambah/') . $order['id_cc_ord'] . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">
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
                              <?php foreach ($status_dokumen as $sd) : ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="">Revisi</option>
                              <?php foreach ($revisi as $r) : ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="">Edisi</option>
                              <?php foreach ($edisi as $e) : ?>
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
                              <?php foreach ($disdok as $disd) : ?>
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
                      <?php foreach ($dokumen_mp as $mp) : ?>
                        <tr>
                          <td style="font-size: 14px;"><?= $no ?></td>
                          <td style="font-size: 14px;"><?= $mp['no_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $mp['nama_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $mp['tgl_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $mp['nama_status']; ?></td>
                          <td style="font-size: 14px;"><?= $mp['nama_edisi']; ?></td>
                          <td style="font-size: 14px;"><?= $mp['nama_revisi']; ?></td>
                          <!-- transmit -->
                          <?php if ($mp['no_sp'] != NULL) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php else : ?>
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
                          <?php if ($mp['status'] == 1) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php endif ?>
                          <?php if ($mp['status'] == 0) : ?>
                            <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                          <?php endif ?>
                          <!-- status valid -->
                          <!-- Aksi -->
                          <td>
                            <!-- jika belum transmit admin bisa lihat -->
                            <?php if ($mp['no_sp'] == NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('mp/view/') . $mp['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('mp/edit/') . $mp['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#emp' . $mp['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($mp['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('mp/revisi/') . $mp['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('mp/hapus/') . $mp['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $mp['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($mp['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('mp/history/') . $mp['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                            <!-- jika sudah transmit bisa lihat semua -->
                            <?php if ($mp['no_sp'] != NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('mp/view/') . $mp['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('mp/edit/') . $mp['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#emp' . $mp['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($mp['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('mp/revisi/') . $mp['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('mp/hapus/') . $mp['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $mp['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($mp['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('mp/history/') . $mp['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
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
                        <div class="modal hide fade" id="<?= 'emp' . $mp['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="eeis" aria-hidden="true">
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
                              <form action="<?= base_url('mp/edit/') . $mp['id_dokumen'] . '/' . $fungsi; ?>" method="post" enctype="multipart/form-data">
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
                                          <?php foreach ($status_dokumen as $sd) : ?>
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
                                          <?php foreach ($revisi as $r) : ?>
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
                                          <?php foreach ($edisi as $e) : ?>
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
                                          <?php if ($mp['status_dokumen'] == 1) : ?>
                                            <option value="<?= $mp['status_dokumen'] ?>">Valid</option>
                                          <?php endif ?>
                                          <?php if ($mp['status_dokumen'] == 0) : ?>
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
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
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
                  <form action="<?= base_url('mp/tambah/') . $order['id_cc_ord'] . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">
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
                              <?php foreach ($status_dokumen as $sd) : ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="">Revisi</option>
                              <?php foreach ($revisi as $r) : ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="">Edisi</option>
                              <?php foreach ($edisi as $e) : ?>
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
                              <?php foreach ($disdok as $disd) : ?>
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
                      <?php foreach ($dokumen_clo as $clo) : ?>
                        <tr>
                          <td style="font-size: 14px;"><?= $no ?></td>
                          <td style="font-size: 14px;"><?= $clo['no_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $clo['nama_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $clo['tgl_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $clo['nama_status']; ?></td>
                          <td style="font-size: 14px;"><?= $clo['nama_edisi']; ?></td>
                          <td style="font-size: 14px;"><?= $clo['nama_revisi']; ?></td>
                          <!-- transmit -->
                          <?php if ($clo['no_sp'] != NULL) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php else : ?>
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
                          <?php if ($clo['status'] == 1) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php endif ?>
                          <?php if ($clo['status'] == 0) : ?>
                            <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                          <?php endif ?>
                          <!-- status valid -->
                          <!-- Aksi -->
                          <td>
                            <!-- jika belum transmit admin bisa lihat -->
                            <?php if ($clo['no_sp'] == NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('clo/view/') . $clo['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('clo/edit/') . $clo['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eclo' . $clo['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($clo['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('clo/revisi/') . $clo['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('clo/hapus/') . $clo['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $clo['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($clo['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('clo/history/') . $clo['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                            <!-- jika sudah transmit bisa lihat semua -->
                            <?php if ($clo['no_sp'] != NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('clo/view/') . $clo['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('clo/edit/') . $clo['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eclo' . $clo['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($clo['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('clo/revisi/') . $clo['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('clo/hapus/') . $clo['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $clo['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($clo['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('clo/history/') . $clo['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
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
                        <div class="modal hide fade" id="<?= 'eclo' . $clo['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="eclo" aria-hidden="true">
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
                              <form action="<?= base_url('clo/edit/') . $clo['id_dokumen'] . '/' . $fungsi; ?>" method="post" enctype="multipart/form-data">
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
                                          <?php foreach ($status_dokumen as $sd) : ?>
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
                                          <?php foreach ($revisi as $r) : ?>
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
                                          <?php foreach ($edisi as $e) : ?>
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
                                          <?php if ($clo['status_dokumen'] == 1) : ?>
                                            <option value="<?= $clo['status_dokumen'] ?>">Valid</option>
                                          <?php endif ?>
                                          <?php if ($clo['status_dokumen'] == 0) : ?>
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
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
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
                  <form action="<?= base_url('clo/tambah/') . $order['id_cc_ord'] . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">
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
                              <?php foreach ($status_dokumen as $sd) : ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="">Revisi</option>
                              <?php foreach ($revisi as $r) : ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="">Edisi</option>
                              <?php foreach ($edisi as $e) : ?>
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
                              <?php foreach ($disdok as $disd) : ?>
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
                      <?php foreach ($dokumen_mrs as $mrs) : ?>
                        <tr>
                          <td style="font-size: 14px;"><?= $no ?></td>
                          <td style="font-size: 14px;"><?= $mrs['no_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $mrs['nama_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $mrs['tgl_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $mrs['nama_status']; ?></td>
                          <td style="font-size: 14px;"><?= $mrs['nama_edisi']; ?></td>
                          <td style="font-size: 14px;"><?= $mrs['nama_revisi']; ?></td>
                          <!-- transmit -->
                          <?php if ($mrs['no_sp'] != NULL) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php else : ?>
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
                          <?php if ($mrs['status'] == 1) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php endif ?>
                          <?php if ($mrs['status'] == 0) : ?>
                            <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                          <?php endif ?>
                          <!-- status valid -->
                          <!-- Aksi -->
                          <td>
                            <!-- jika belum transmit admin bisa lihat -->
                            <?php if ($mrs['no_sp'] == NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/view/') . $mrs['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('mrs/edit/') . $mrs['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#emrs' . $mrs['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($mrs['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/revisi/') . $mrs['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('mrs/hapus/') . $mrs['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $mrs['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($mrs['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/history/') . $mrs['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                            <!-- jika sudah transmit bisa lihat semua -->
                            <?php if ($mrs['no_sp'] != NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/view/') . $mrs['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('mrs/edit/') . $mrs['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#emrs' . $mrs['id_dokumen'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($mrs['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/revisi/') . $mrs['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('mrs/hapus/') . $mrs['id_dokumen'] . '/' . $order['id_cc_ord'] . '/' . $mrs['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($mrs['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/history/') . $mrs['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
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
                        <div class="modal hide fade" id="<?= 'emrs' . $mrs['id_dokumen'] ?>" tabindex="-1" role="dialog" aria-labelledby="emrs" aria-hidden="true">
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
                              <form action="<?= base_url('mrs/edit/') . $mrs['id_dokumen'] . '/' . $fungsi; ?>" method="post" enctype="multipart/form-data">
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
                                          <?php foreach ($status_dokumen as $sd) : ?>
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
                                          <?php foreach ($revisi as $r) : ?>
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
                                          <?php foreach ($edisi as $e) : ?>
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
                                          <?php if ($mrs['status_dokumen'] == 1) : ?>
                                            <option value="<?= $mrs['status_dokumen'] ?>">Valid</option>
                                          <?php endif ?>
                                          <?php if ($mrs['status_dokumen'] == 0) : ?>
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
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
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
                  <form action="<?= base_url('mrs/tambah/') . $order['id_cc_ord'] . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">
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
                              <?php foreach ($status_dokumen as $sd) : ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="">Revisi</option>
                              <?php foreach ($revisi as $r) : ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="">Edisi</option>
                              <?php foreach ($edisi as $e) : ?>
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
                              <?php foreach ($disdok as $disd) : ?>
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
                      <!-- tambah dokumen MRS -->
                      <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                      <button type="submit" name="tambah" class="btn btn-sm btn-primary">Tambah</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- modal tambah MRS -->
          </div>
        </div>
        <!-- MRS -->
      <?php
      }
      ?>
      <!-- //////////////////////////////////////////// dokumen engineering /////////////////////////////////////////// -->

      <!-- /////////////////////////////////////////////// dokumen sales ////////////////////////////////////////////// -->
      <!-- dokumen sales -->
      <?php if ($fungsi == 'Sales') {

        // var_dump($dokumen_spk);
        // die;

      ?>
        <!-- spk -->
        <div class="card">
          <div class="card-header text-center h5" style="background-color: #e3e2de;">
            <b>SPK</b>
          </div>
          <div class="card-body">
            <!-- tabel dokumen spk -->
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
                      <?php foreach ($dokumen_spk as $ds) : ?>
                        <tr>
                          <td style="font-size: 14px;"><?= $no ?></td>
                          <td style="font-size: 14px;"><?= $ds['no_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $ds['nama_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $ds['tgl_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $ds['nama_status']; ?></td>
                          <td style="font-size: 14px;"><?= $ds['nama_edisi']; ?></td>
                          <td style="font-size: 14px;"><?= $ds['nama_revisi']; ?></td>
                          <!-- transmit -->
                          <?php if ($ds['no_sp'] != NULL) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php else : ?>
                            <td class="text-center"></td>
                          <?php endif ?>
                          <!-- transmit -->
                          <?php
                          $string = explode("/", $ds['no_sp'], 2);
                          $no_sp = $string[0];
                          ?>
                          <!-- no sp -->
                          <td style="font-size: 14px;"><?= $no_sp; ?></td>
                          <!-- no sp -->
                          <!-- status valid -->
                          <?php if ($ds['status'] == 1) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php endif ?>
                          <?php if ($ds['status'] == 0) : ?>
                            <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                          <?php endif ?>
                          <!-- status valid -->
                          <!-- Aksi -->
                          <td>
                            <!-- jika belum transmit admin bisa lihat -->
                            <?php if ($ds['no_sp'] == NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('spk/view/') . $ds['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('spk/edit/') . $ds['id'] ?>" data-toggle="modal" data-target="<?= '#espk' . $ds['id'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($ds['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('spk/revisi/') . $ds['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('spk/hapus/') . $ds['id'] . '/' . $order['id_cc_ord'] . '/' . $ds['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($ds['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('spk/history/') . $ds['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                            <!-- jika sudah transmit bisa lihat semua -->
                            <?php if ($ds['no_sp'] != NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('spk/view/') . $ds['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('spk/edit/') . $ds['id'] ?>" data-toggle="modal" data-target="<?= '#espk' . $ds['id'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($ds['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('spk/revisi/') . $ds['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('spk/hapus/') . $ds['id'] . '/' . $order['id_cc_ord'] . '/' . $ds['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($ds['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('spk/history/') . $ds['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                          </td>
                          <!-- aksi -->
                        </tr>
                        <!-- modal edit dokumen spk -->
                        <div class="modal hide fade" id="<?= 'espk' . $ds['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="espk" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                                <div class="col text-center">
                                  <h5 class="modal-title" id="edrawing">Edit Dokumen SPK</h5>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="<?= base_url('spk/edit/') . $ds['id'] . '/' . $fungsi; ?>" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                  <div class="container-fluid">
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $ds['no_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $ds['nama_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $ds['tgl_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="status_dokumen">Status Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                                          <option value="<?= $ds['status_dokumen'] ?>"><?= $ds['nama_status'] ?></option>
                                          <?php foreach ($status_dokumen as $sd) : ?>
                                            <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="revisi" id="revisi" class="form-control" required>
                                          <option value="<?= $ds['revisi'] ?>"><?= $ds['nama_revisi'] ?></option>
                                          <?php foreach ($revisi as $r) : ?>
                                            <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="edisi" id="edisi" class="form-control" required>
                                          <option value="<?= $ds['edisi'] ?>"><?= $ds['nama_edisi'] ?></option>
                                          <?php foreach ($edisi as $e) : ?>
                                            <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <!-- total -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Copy x Page</label>
                                      <div class="col-lg-2 col-md-2 col-sm-2">
                                        <input type="text" class="form-control" value="<?= $ds['total1'] ?>" name="total1" placeholder="0" required>
                                      </div>
                                      <div class="col-lg-1 col-md-1 col-sm-1">
                                        <h5 class="text-center">x</h5>
                                      </div>
                                      <div class="col-lg-2 col-md-2 col-sm-2">
                                        <input type="text" class="form-control" value="<?= $ds['total2'] ?>" name="total2" placeholder="0" required>
                                      </div>
                                    </div>
                                    <!-- total -->
                                    <!-- ukuran -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Ukuran Kertas</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select class="form-control" name="ukuran" id="ukuran">
                                          <option value="<?= $ds['ukuran'] ?>"><?= $ds['ukuran'] ?></option>
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
                                          <option value="<?= $ds['id_dd'] ?>"><?= $ds['judul_dokumen'] ?></option>
                                        </select>
                                      </div>
                                    </div>
                                    <!-- distribusi dokumen -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="status" id="status" class="form-control">
                                          <?php if ($ds['status_dokumen'] == 1) : ?>
                                            <option value="<?= $ds['status_dokumen'] ?>">Valid</option>
                                          <?php endif ?>
                                          <?php if ($ds['status_dokumen'] == 0) : ?>
                                            <option value="<?= $ds['status_dokumen'] ?>">Tidak Valid</option>
                                          <?php endif ?>
                                          <option value="1">Valid</option>
                                          <option value="0">Tidak Valid</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="file" name="file_spk" id="file_spk" class="form-control" placeholder="File Dokumen (Format pdf / xlsx)">
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
                        <!-- modal edit dokumen spk -->
                        <?php $no++ ?>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- tabel dokumen spk -->
            <!-- tambah dokumen spk -->
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#spk">
                    <i class="fa fa-plus"></i> Dokumen SPK
                  </button>
                </div>
              </div>
            <?php endif ?>
            <!-- modal tambah spk -->
            <div class="modal fade" id="spk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                    <div class="col text-center">
                      <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen SPK</h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="<?= base_url('spk/tambah/') . $order['id_cc_ord'] . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">
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
                              <?php foreach ($status_dokumen as $sd) : ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="">Revisi</option>
                              <?php foreach ($revisi as $r) : ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="">Edisi</option>
                              <?php foreach ($edisi as $e) : ?>
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
                              <?php foreach ($disdok as $disd) : ?>
                                <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <!-- distribusi dokumen -->
                        <div class="row mb-2">
                          <div class="col">
                            <input required name="file_spk" id="file_spk" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
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
            <!-- modal tambah spk -->
            <!-- tambah dokumen spk -->
          </div>
        </div>
        <!-- spk -->
      <?php
      } ?>
      <!-- dokumen sales -->
      <!-- /////////////////////////////////////////////// dokumen sales ////////////////////////////////////////////// -->




      <!-- /////////////////////////////////////////////// dokumen ppc ////////////////////////////////////////////// -->
      <!-- dokumen ppc -->
      <?php if ($fungsi == 'PPC') {
      ?>
        <!-- mscurve -->
        <div class="card">
          <div class="card-header text-center h5" style="background-color: #e3e2de;">
            <b>Master Schedule "S" Curve</b>
          </div>
          <div class="card-body">
            <!-- tabel dokumen mscurve -->
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
                      <?php foreach ($dokumen_mscurve as $ds) : ?>
                        <tr>
                          <td style="font-size: 14px;"><?= $no ?></td>
                          <td style="font-size: 14px;"><?= $ds['no_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $ds['nama_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $ds['tgl_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $ds['nama_status']; ?></td>
                          <td style="font-size: 14px;"><?= $ds['nama_edisi']; ?></td>
                          <td style="font-size: 14px;"><?= $ds['nama_revisi']; ?></td>
                          <!-- transmit -->
                          <?php if ($ds['no_sp'] != NULL) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php else : ?>
                            <td class="text-center"></td>
                          <?php endif ?>
                          <!-- transmit -->
                          <?php
                          $string = explode("/", $ds['no_sp'], 2);
                          $no_sp = $string[0];
                          ?>
                          <!-- no sp -->
                          <td style="font-size: 14px;"><?= $no_sp; ?></td>
                          <!-- no sp -->
                          <!-- status valid -->
                          <?php if ($ds['status'] == 1) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php endif ?>
                          <?php if ($ds['status'] == 0) : ?>
                            <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                          <?php endif ?>
                          <!-- status valid -->
                          <!-- Aksi -->
                          <td>
                            <!-- jika belum transmit admin bisa lihat -->
                            <?php if ($ds['no_sp'] == NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('mscurve/view/') . $ds['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('mscurve/edit/') . $ds['id'] ?>" data-toggle="modal" data-target="<?= '#emscurve' . $ds['id'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($ds['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('mscurve/revisi/') . $ds['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('mscurve/hapus/') . $ds['id'] . '/' . $order['id_cc_ord'] . '/' . $ds['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($ds['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('mscurve/history/') . $ds['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                            <!-- jika sudah transmit bisa lihat semua -->
                            <?php if ($ds['no_sp'] != NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('mscurve/view/') . $ds['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('mscurve/edit/') . $ds['id'] ?>" data-toggle="modal" data-target="<?= '#emscurve' . $ds['id'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($ds['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('mscurve/revisi/') . $ds['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('mscurve/hapus/') . $ds['id'] . '/' . $order['id_cc_ord'] . '/' . $ds['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($ds['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('mscurve/history/') . $ds['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                          </td>
                          <!-- aksi -->
                        </tr>
                        <!-- modal edit dokumen mscurve -->
                        <div class="modal hide fade" id="<?= 'emscurve' . $ds['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="emscurve" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                                <div class="col text-center">
                                  <h5 class="modal-title" id="edrawing">Edit Dokumen Master Schedule "S" Curve</h5>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="<?= base_url('mscurve/edit/') . $ds['id'] . '/' . $fungsi; ?>" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                  <div class="container-fluid">
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $ds['no_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $ds['nama_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $ds['tgl_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="status_dokumen">Status Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                                          <option value="<?= $ds['status_dokumen'] ?>"><?= $ds['nama_status'] ?></option>
                                          <?php foreach ($status_dokumen as $sd) : ?>
                                            <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="revisi" id="revisi" class="form-control" required>
                                          <option value="<?= $ds['revisi'] ?>"><?= $ds['nama_revisi'] ?></option>
                                          <?php foreach ($revisi as $r) : ?>
                                            <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="edisi" id="edisi" class="form-control" required>
                                          <option value="<?= $ds['edisi'] ?>"><?= $ds['nama_edisi'] ?></option>
                                          <?php foreach ($edisi as $e) : ?>
                                            <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <!-- total -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Copy x Page</label>
                                      <div class="col-lg-2 col-md-2 col-sm-2">
                                        <input type="text" class="form-control" value="<?= $ds['total1'] ?>" name="total1" placeholder="0" required>
                                      </div>
                                      <div class="col-lg-1 col-md-1 col-sm-1">
                                        <h5 class="text-center">x</h5>
                                      </div>
                                      <div class="col-lg-2 col-md-2 col-sm-2">
                                        <input type="text" class="form-control" value="<?= $ds['total2'] ?>" name="total2" placeholder="0" required>
                                      </div>
                                    </div>
                                    <!-- total -->
                                    <!-- ukuran -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Ukuran Kertas</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select class="form-control" name="ukuran" id="ukuran">
                                          <option value="<?= $ds['ukuran'] ?>"><?= $ds['ukuran'] ?></option>
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
                                          <option value="<?= $ds['id_dd'] ?>"><?= $ds['judul_dokumen'] ?></option>
                                        </select>
                                      </div>
                                    </div>
                                    <!-- distribusi dokumen -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="status" id="status" class="form-control">
                                          <?php if ($ds['status_dokumen'] == 1) : ?>
                                            <option value="<?= $ds['status_dokumen'] ?>">Valid</option>
                                          <?php endif ?>
                                          <?php if ($ds['status_dokumen'] == 0) : ?>
                                            <option value="<?= $ds['status_dokumen'] ?>">Tidak Valid</option>
                                          <?php endif ?>
                                          <option value="1">Valid</option>
                                          <option value="0">Tidak Valid</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="file" name="file_mscurve" id="file_mscurve" class="form-control" placeholder="File Dokumen (Format pdf / xlsx)">
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
                        <!-- modal edit dokumen mscurve -->
                        <?php $no++ ?>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- tabel dokumen mscurve -->
            <!-- tambah dokumen mscurve -->
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mscurve">
                    <i class="fa fa-plus"></i> Dokumen Master Schedule "S Curve
                  </button>
                </div>
              </div>
            <?php endif ?>
            <!-- modal tambah mscurve -->
            <div class="modal fade" id="mscurve" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                    <div class="col text-center">
                      <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Master Schedule "S" Curve</h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="<?= base_url('mscurve/tambah/') . $order['id_cc_ord'] . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">
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
                              <?php foreach ($status_dokumen as $sd) : ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="">Revisi</option>
                              <?php foreach ($revisi as $r) : ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="">Edisi</option>
                              <?php foreach ($edisi as $e) : ?>
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
                              <?php foreach ($disdok as $disd) : ?>
                                <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <!-- distribusi dokumen -->
                        <div class="row mb-2">
                          <div class="col">
                            <input required name="file_mscurve" id="file_mscurve" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
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
            <!-- modal tambah mscurve -->
            <!-- tambah dokumen mscurve -->
          </div>
        </div>
        <!-- mscurve -->


        <!-- ps -->
        <div class="card">
          <div class="card-header text-center h5" style="background-color: #e3e2de;">
            <b>Production Schedule</b>
          </div>
          <div class="card-body">
            <!-- tabel dokumen ps -->
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
                      <?php foreach ($dokumen_ps as $dp) : ?>
                        <tr>
                          <td style="font-size: 14px;"><?= $no ?></td>
                          <td style="font-size: 14px;"><?= $dp['no_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $dp['nama_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $dp['tgl_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $dp['nama_status']; ?></td>
                          <td style="font-size: 14px;"><?= $dp['nama_edisi']; ?></td>
                          <td style="font-size: 14px;"><?= $dp['nama_revisi']; ?></td>
                          <!-- transmit -->
                          <?php if ($dp['no_sp'] != NULL) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php else : ?>
                            <td class="text-center"></td>
                          <?php endif ?>
                          <!-- transmit -->
                          <?php
                          $string = explode("/", $dp['no_sp'], 2);
                          $no_sp = $string[0];
                          ?>
                          <!-- no sp -->
                          <td style="font-size: 14px;"><?= $no_sp; ?></td>
                          <!-- no sp -->
                          <!-- status valid -->
                          <?php if ($dp['status'] == 1) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php endif ?>
                          <?php if ($dp['status'] == 0) : ?>
                            <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                          <?php endif ?>
                          <!-- status valid -->
                          <!-- Aksi -->
                          <td>
                            <!-- jika belum transmit admin bisa lihat -->
                            <?php if ($dp['no_sp'] == NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('ps/view/') . $dp['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('ps/edit/') . $ds['id'] ?>" data-toggle="modal" data-target="<?= '#eps' . $dp['id'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($dp['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('ps/revisi/') . $dp['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('ps/hapus/') . $dp['id'] . '/' . $order['id_cc_ord'] . '/' . $dp['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($dp['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('ps/history/') . $dp['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                            <!-- jika sudah transmit bisa lihat semua -->
                            <?php if ($dp['no_sp'] != NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('ps/view/') . $dp['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('ps/edit/') . $dp['id'] ?>" data-toggle="modal" data-target="<?= '#eps' . $dp['id'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($dp['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('ps/revisi/') . $dp['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('ps/hapus/') . $dp['id'] . '/' . $order['id_cc_ord'] . '/' . $dp['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($dp['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('ps/history/') . $dp['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                          </td>
                          <!-- aksi -->
                        </tr>
                        <!-- modal edit dokumen ps -->
                        <div class="modal hide fade" id="<?= 'eps' . $dp['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="eps" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                                <div class="col text-center">
                                  <h5 class="modal-title" id="edrawing">Edit Dokumen Production Schedule</h5>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="<?= base_url('ps/edit/') . $dp['id'] . '/' . $fungsi; ?>" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                  <div class="container-fluid">
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $ds['no_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $dp['nama_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $dp['tgl_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="status_dokumen">Status Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                                          <option value="<?= $dp['status_dokumen'] ?>"><?= $dp['nama_status'] ?></option>
                                          <?php foreach ($status_dokumen as $sd) : ?>
                                            <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="revisi" id="revisi" class="form-control" required>
                                          <option value="<?= $dp['revisi'] ?>"><?= $dp['nama_revisi'] ?></option>
                                          <?php foreach ($revisi as $r) : ?>
                                            <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="edisi" id="edisi" class="form-control" required>
                                          <option value="<?= $dp['edisi'] ?>"><?= $dp['nama_edisi'] ?></option>
                                          <?php foreach ($edisi as $e) : ?>
                                            <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <!-- total -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Copy x Page</label>
                                      <div class="col-lg-2 col-md-2 col-sm-2">
                                        <input type="text" class="form-control" value="<?= $dp['total1'] ?>" name="total1" placeholder="0" required>
                                      </div>
                                      <div class="col-lg-1 col-md-1 col-sm-1">
                                        <h5 class="text-center">x</h5>
                                      </div>
                                      <div class="col-lg-2 col-md-2 col-sm-2">
                                        <input type="text" class="form-control" value="<?= $dp['total2'] ?>" name="total2" placeholder="0" required>
                                      </div>
                                    </div>
                                    <!-- total -->
                                    <!-- ukuran -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Ukuran Kertas</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select class="form-control" name="ukuran" id="ukuran">
                                          <option value="<?= $dp['ukuran'] ?>"><?= $dp['ukuran'] ?></option>
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
                                          <option value="<?= $dp['id_dd'] ?>"><?= $dp['judul_dokumen'] ?></option>
                                        </select>
                                      </div>
                                    </div>
                                    <!-- distribusi dokumen -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="status" id="status" class="form-control">
                                          <?php if ($dp['status_dokumen'] == 1) : ?>
                                            <option value="<?= $dp['status_dokumen'] ?>">Valid</option>
                                          <?php endif ?>
                                          <?php if ($dp['status_dokumen'] == 0) : ?>
                                            <option value="<?= $dp['status_dokumen'] ?>">Tidak Valid</option>
                                          <?php endif ?>
                                          <option value="1">Valid</option>
                                          <option value="0">Tidak Valid</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="file" name="file_ps" id="file_ps" class="form-control" placeholder="File Dokumen (Format pdf / xlsx)">
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
                        <!-- modal edit dokumen ps -->
                        <?php $no++ ?>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- tabel dokumen ps -->
            <!-- tambah dokumen ps -->
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ps">
                    <i class="fa fa-plus"></i> Dokumen Production Schedule
                  </button>
                </div>
              </div>
            <?php endif ?>
            <!-- modal tambah ps -->
            <div class="modal fade" id="ps" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                    <div class="col text-center">
                      <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Production Schedule</h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="<?= base_url('ps/tambah/') . $order['id_cc_ord'] . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">
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
                              <?php foreach ($status_dokumen as $sd) : ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="">Revisi</option>
                              <?php foreach ($revisi as $r) : ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="">Edisi</option>
                              <?php foreach ($edisi as $e) : ?>
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
                              <?php foreach ($disdok as $disd) : ?>
                                <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <!-- distribusi dokumen -->
                        <div class="row mb-2">
                          <div class="col">
                            <input required name="file_ps" id="file_ps" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
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
            <!-- modal tambah ps -->
            <!-- tambah dokumen ps -->
          </div>
        </div>
        <!-- ps -->


      <?php
      } ?>
      <!-- dokumen ppc -->
      <!-- /////////////////////////////////////////////// dokumen ppc ////////////////////////////////////////////// -->



      <!-- /////////////////////////////////////////////// dokumen mm ////////////////////////////////////////////// -->
      <!-- dokumen mm -->
      <?php if ($fungsi == 'MM') {
      ?>
        <!-- mscurve -->
        <div class="card">
          <div class="card-header text-center h5" style="background-color: #e3e2de;">
            <b>Purchase Requisition Sheet (PR)</b>
          </div>
          <div class="card-body">
            <!-- tabel dokumen PR -->
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
                      <?php foreach ($dokumen_pr as $pr) : ?>
                        <tr>
                          <td style="font-size: 14px;"><?= $no ?></td>
                          <td style="font-size: 14px;"><?= $pr['no_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $pr['nama_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $pr['tgl_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $pr['nama_status']; ?></td>
                          <td style="font-size: 14px;"><?= $pr['nama_edisi']; ?></td>
                          <td style="font-size: 14px;"><?= $pr['nama_revisi']; ?></td>
                          <!-- transmit -->
                          <?php if ($pr['no_sp'] != NULL) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php else : ?>
                            <td class="text-center"></td>
                          <?php endif ?>
                          <!-- transmit -->
                          <?php
                          $string = explode("/", $pr['no_sp'], 2);
                          $no_sp = $string[0];
                          ?>
                          <!-- no sp -->
                          <td style="font-size: 14px;"><?= $no_sp; ?></td>
                          <!-- no sp -->
                          <!-- status valid -->
                          <?php if ($pr['status'] == 1) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php endif ?>
                          <?php if ($pr['status'] == 0) : ?>
                            <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                          <?php endif ?>
                          <!-- status valid -->
                          <!-- Aksi -->
                          <td>
                            <!-- jika belum transmit admin bisa lihat -->
                            <?php if ($pr['no_sp'] == NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('mscurve/view/') . $ds['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('pr/edit/') . $pr['id'] ?>" data-toggle="modal" data-target="<?= '#epr' . $pr['id'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($pr['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('pr/revisi/') . $pr['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('pr/hapus/') . $pr['id'] . '/' . $order['id_cc_ord'] . '/' . $pr['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($pr['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('pr/history/') . $pr['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                            <!-- jika sudah transmit bisa lihat semua -->
                            <?php if ($pr['no_sp'] != NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('pr/view/') . $pr['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('pr/edit/') . $pr['id'] ?>" data-toggle="modal" data-target="<?= '#epr' . $pr['id'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($pr['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('pr/revisi/') . $pr['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('pr/hapus/') . $pr['id'] . '/' . $order['id_cc_ord'] . '/' . $pr['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($pr['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('pr/history/') . $pr['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                          </td>
                          <!-- aksi -->
                        </tr>
                        <!-- modal edit dokumen PR -->
                        <div class="modal hide fade" id="<?= 'epr' . $pr['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="epr" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                                <div class="col text-center">
                                  <h5 class="modal-title" id="edrawing">Edit Dokumen Purchase Requisition Sheet (PR)</h5>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="<?= base_url('pr/edit/') . $pr['id'] . '/' . $fungsi; ?>" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                  <div class="container-fluid">
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $ds['no_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $pr['nama_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $pr['tgl_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="status_dokumen">Status Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                                          <option value="<?= $pr['status_dokumen'] ?>"><?= $pr['nama_status'] ?></option>
                                          <?php foreach ($status_dokumen as $sd) : ?>
                                            <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="revisi" id="revisi" class="form-control" required>
                                          <option value="<?= $pr['revisi'] ?>"><?= $pr['nama_revisi'] ?></option>
                                          <?php foreach ($revisi as $r) : ?>
                                            <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="edisi" id="edisi" class="form-control" required>
                                          <option value="<?= $pr['edisi'] ?>"><?= $pr['nama_edisi'] ?></option>
                                          <?php foreach ($edisi as $e) : ?>
                                            <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <!-- total -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Copy x Page</label>
                                      <div class="col-lg-2 col-md-2 col-sm-2">
                                        <input type="text" class="form-control" value="<?= $pr['total1'] ?>" name="total1" placeholder="0" required>
                                      </div>
                                      <div class="col-lg-1 col-md-1 col-sm-1">
                                        <h5 class="text-center">x</h5>
                                      </div>
                                      <div class="col-lg-2 col-md-2 col-sm-2">
                                        <input type="text" class="form-control" value="<?= $pr['total2'] ?>" name="total2" placeholder="0" required>
                                      </div>
                                    </div>
                                    <!-- total -->
                                    <!-- ukuran -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Ukuran Kertas</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select class="form-control" name="ukuran" id="ukuran">
                                          <option value="<?= $pr['ukuran'] ?>"><?= $pr['ukuran'] ?></option>
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
                                          <option value="<?= $pr['id_dd'] ?>"><?= $pr['judul_dokumen'] ?></option>
                                        </select>
                                      </div>
                                    </div>
                                    <!-- distribusi dokumen -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="status" id="status" class="form-control">
                                          <?php if ($pr['status_dokumen'] == 1) : ?>
                                            <option value="<?= $pr['status_dokumen'] ?>">Valid</option>
                                          <?php endif ?>
                                          <?php if ($pr['status_dokumen'] == 0) : ?>
                                            <option value="<?= $pr['status_dokumen'] ?>">Tidak Valid</option>
                                          <?php endif ?>
                                          <option value="1">Valid</option>
                                          <option value="0">Tidak Valid</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="file" name="file_pr" id="file_pr" class="form-control" placeholder="File Dokumen (Format pdf / xlsx)">
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
                        <!-- modal edit dokumen PR -->
                        <?php $no++ ?>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- tabel dokumen PR -->
            <!-- tambah dokumen PR -->
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#pr">
                    <i class="fa fa-plus"></i> Dokumen Purchase Requisition Sheet
                  </button>
                </div>
              </div>
            <?php endif ?>
            <!-- modal tambah PR -->
            <div class="modal fade" id="pr" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                    <div class="col text-center">
                      <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Purchase Requisition Sheet PRRRRRR</h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="<?= base_url('Pr/tambah/') . $order['id_cc_ord'] . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">
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
                              <?php foreach ($status_dokumen as $sd) : ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="">Revisi</option>
                              <?php foreach ($revisi as $r) : ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="">Edisi</option>
                              <?php foreach ($edisi as $e) : ?>
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
                              <?php foreach ($disdok as $disd) : ?>
                                <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <!-- distribusi dokumen -->
                        <div class="row mb-2">
                          <div class="col">
                            <input required name="file_pr" id="file_pr" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
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
            <!-- modal tambah PR -->
            <!-- tambah dokumen PR -->
          </div>
        </div>
        <!-- PR -->


        <!-- IMR -->
        <div class="card">
          <div class="card-header text-center h5" style="background-color: #e3e2de;">
            <b>Inspection Material Request For Stock (IMR)</b>
          </div>
          <div class="card-body">
            <!-- tabel dokumen IMR -->
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
                      <?php foreach ($dokumen_imr as $imr) : ?>
                        <tr>
                          <td style="font-size: 14px;"><?= $no ?></td>
                          <td style="font-size: 14px;"><?= $imr['no_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $imr['nama_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $imr['tgl_dokumen']; ?></td>
                          <td style="font-size: 14px;"><?= $imr['nama_status']; ?></td>
                          <td style="font-size: 14px;"><?= $imr['nama_edisi']; ?></td>
                          <td style="font-size: 14px;"><?= $imr['nama_revisi']; ?></td>
                          <!-- transmit -->
                          <?php if ($imr['no_sp'] != NULL) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php else : ?>
                            <td class="text-center"></td>
                          <?php endif ?>
                          <!-- transmit -->
                          <?php
                          $string = explode("/", $imr['no_sp'], 2);
                          $no_sp = $string[0];
                          ?>
                          <!-- no sp -->
                          <td style="font-size: 14px;"><?= $no_sp; ?></td>
                          <!-- no sp -->
                          <!-- status valid -->
                          <?php if ($imr['status'] == 1) : ?>
                            <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                          <?php endif ?>
                          <?php if ($imr['status'] == 0) : ?>
                            <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                          <?php endif ?>
                          <!-- status valid -->
                          <!-- Aksi -->
                          <td>
                            <!-- jika belum transmit admin bisa lihat -->
                            <?php if ($imr['no_sp'] == NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('imr/view/') . $imr['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('imr/edit/') . $imr['id'] ?>" data-toggle="modal" data-target="<?= '#eimr' . $imr['id'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($imr['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('imr/revisi/') . $imr['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('imr/hapus/') . $imr['id'] . '/' . $order['id_cc_ord'] . '/' . $imr['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($imr['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('imr/history/') . $imr['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                            <!-- jika sudah transmit bisa lihat semua -->
                            <?php if ($imr['no_sp'] != NULL) : ?>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Pilih
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <!-- view -->
                                  <a class="dropdown-item" target="_blank" href="<?= base_url('imr/view/') . $imr['nama_file'] ?>">View</a>
                                  <!-- view -->
                                  <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
                                    <!-- edit -->
                                    <a class="dropdown-item" href="<?= base_url('imr/edit/') . $imr['id'] ?>" data-toggle="modal" data-target="<?= '#eimr' . $imr['id'] ?>">Edit</a>
                                    <!-- edit -->
                                    <!-- revisi -->
                                    <?php if ($imr['status'] == 1) : ?>
                                      <a class="dropdown-item" target="_blank" href="<?= base_url('imr/revisi/') . $imr['kode_unik'] . '/' . $order['id_cc_ord'] . '/' . $fungsi; ?>">Revisi</a>
                                    <?php endif ?>
                                    <!-- revisi -->
                                    <!-- hapus -->
                                    <a href="<?= base_url('imr/hapus/') . $imr['id'] . '/' . $order['id_cc_ord'] . '/' . $imr['nama_file'] . '/' . $fungsi ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                    <!-- hapus -->
                                  <?php endif ?>
                                  <!-- history -->
                                  <?php if ($imr['status'] == 1) : ?>
                                    <a class="dropdown-item" target="_blank" href="<?= base_url('imr/history/') . $imr['kode_unik'] . '/' . $order['id_cc_ord']; ?>">History</a>
                                  <?php endif ?>
                                  <!-- history -->
                                </div>
                              </div>
                            <?php endif ?>
                            <!-- jika belum transmit admin bisa lihat -->
                          </td>
                          <!-- aksi -->
                        </tr>
                        <!-- modal edit dokumen IMR -->
                        <div class="modal hide fade" id="<?= 'eimr' . $imr['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="eimr" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                                <div class="col text-center">
                                  <h5 class="modal-title" id="edrawing">Edit Dokumen Inspection Material Request For Stock (IMR)</h5>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="<?= base_url('imr/edit/') . $imr['id'] . '/' . $fungsi; ?>" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                  <div class="container-fluid">
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $imr['no_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $imr['nama_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $imr['tgl_dokumen'] ?>">
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="status_dokumen">Status Dokumen</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                                          <option value="<?= $imr['status_dokumen'] ?>"><?= $imr['nama_status'] ?></option>
                                          <?php foreach ($status_dokumen as $sd) : ?>
                                            <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="revisi" id="revisi" class="form-control" required>
                                          <option value="<?= $imr['revisi'] ?>"><?= $imr['nama_revisi'] ?></option>
                                          <?php foreach ($revisi as $r) : ?>
                                            <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="edisi" id="edisi" class="form-control" required>
                                          <option value="<?= $imr['edisi'] ?>"><?= $imr['nama_edisi'] ?></option>
                                          <?php foreach ($edisi as $e) : ?>
                                            <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                    </div>
                                    <!-- total -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Copy x Page</label>
                                      <div class="col-lg-2 col-md-2 col-sm-2">
                                        <input type="text" class="form-control" value="<?= $imr['total1'] ?>" name="total1" placeholder="0" required>
                                      </div>
                                      <div class="col-lg-1 col-md-1 col-sm-1">
                                        <h5 class="text-center">x</h5>
                                      </div>
                                      <div class="col-lg-2 col-md-2 col-sm-2">
                                        <input type="text" class="form-control" value="<?= $imr['total2'] ?>" name="total2" placeholder="0" required>
                                      </div>
                                    </div>
                                    <!-- total -->
                                    <!-- ukuran -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Ukuran Kertas</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select class="form-control" name="ukuran" id="ukuran">
                                          <option value="<?= $imr['ukuran'] ?>"><?= $imr['ukuran'] ?></option>
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
                                          <option value="<?= $imr['id_dd'] ?>"><?= $imr['judul_dokumen'] ?></option>
                                        </select>
                                      </div>
                                    </div>
                                    <!-- distribusi dokumen -->
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="status" id="status" class="form-control">
                                          <?php if ($imr['status_dokumen'] == 1) : ?>
                                            <option value="<?= $imr['status_dokumen'] ?>">Valid</option>
                                          <?php endif ?>
                                          <?php if ($imr['status_dokumen'] == 0) : ?>
                                            <option value="<?= $imr['status_dokumen'] ?>">Tidak Valid</option>
                                          <?php endif ?>
                                          <option value="1">Valid</option>
                                          <option value="0">Tidak Valid</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row mb-2">
                                      <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                                      <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="file" name="file_ps" id="file_ps" class="form-control" placeholder="File Dokumen (Format pdf / xlsx)">
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
                        <!-- modal edit dokumen IMR -->
                        <?php $no++ ?>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- tabel dokumen IMR -->
            <!-- tambah dokumen IMR -->
            <?php if ($nama_role == $fungsi or $nama_role == 'Super Admin' or $nama_role == 'Admin') : ?>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#imr">
                    <i class="fa fa-plus"></i> Dokumen Inspection Material Request For Stock (IMR)
                  </button>
                </div>
              </div>
            <?php endif ?>
            <!-- modal tambah IMR -->
            <div class="modal fade" id="imr" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                    <div class="col text-center">
                      <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Inspection Material Request For Stock (IMR)</h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="<?= base_url('imr/tambah/') . $order['id_cc_ord'] . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">
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
                              <?php foreach ($status_dokumen as $sd) : ?>
                                <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="revisi" id="revisi" class="form-control" required>
                              <option value="">Revisi</option>
                              <?php foreach ($revisi as $r) : ?>
                                <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col">
                            <select name="edisi" id="edisi" class="form-control" required>
                              <option value="">Edisi</option>
                              <?php foreach ($edisi as $e) : ?>
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
                              <?php foreach ($disdok as $disd) : ?>
                                <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <!-- distribusi dokumen -->
                        <div class="row mb-2">
                          <div class="col">
                            <input required name="file_imr" id="file_imr" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
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
            <!-- modal tambah IMR -->
            <!-- tambah dokumen IMR -->
          </div>
        </div>
        <!-- IMR -->


      <?php
      } ?>
      <!-- dokumen mm -->
      <!-- /////////////////////////////////////////////// dokumen mm ////////////////////////////////////////////// -->
      <!-- pengkondisian dokumen berdasarkan fungsi -->






      <div style="margin-bottom: 100px; margin-top: 100px;"></div>

    </div>
  </section>
  <!-- content -->

</div>
<!-- halaman -->

<!-- content -->