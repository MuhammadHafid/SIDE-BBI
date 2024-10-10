  <!-- content -->

  <!-- halaman -->
  <div class="content-wrapper" style="margin-bottom: 75px;">

      <!-- judul -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col">
                      <h1 class="m-0 text-center">Revisi Dokumen Production Schedule</h1>
                  </div>
              </div>
          </div>
      </div>
      <!-- judul -->

      <!-- content -->
      <section class="content">
          <div class="container-fluid">

              <form action="<?= base_url('ps/revisi/') . $kode_unik . '/' . $no_order . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">

                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>No. Dokumen</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $dd['no_dokumen'] ?>" readonly>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Nama Dokumen</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $dd['nama_dokumen'] ?>" readonly>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Tgl Revisi</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <input type="text" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" placeholder="Tgl dokumen" onfocus="(this.type='date')">
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Status Dokumen</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                              <option value="<?= $dd['status'] ?>"><?= $dd['nama_status'] ?></option>
                              <?php foreach ($status_dokumen as $sd) : ?>
                                  <option value="<?= $sd['id_status'] ?>"><?= $sd['nama_status'] ?></option>
                              <?php endforeach ?>
                          </select>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Revisi</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <select name="revisi" id="revisi" class="form-control" required>
                              <option value="<?= $dd['revisi'] ?>"><?= $dd['nama_revisi'] ?></option>
                              <?php foreach ($revisi as $r) : ?>
                                  <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                          </select>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Edisi</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <select name="edisi" id="edisi" class="form-control" required>
                              <option value="<?= $dd['edisi'] ?>"><?= $dd['nama_edisi'] ?></option>
                              <?php foreach ($edisi as $e) : ?>
                                  <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option>
                              <?php endforeach ?>
                          </select>
                      </div>
                  </div>

                  <!-- total -->
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Copy x Page</h6>
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-2">
                          <input type="text" class="form-control" value="<?= $dd['total1'] ?>" name="total1" placeholder="0" required>
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-2">
                          <h5 class="text-center">x</h5>
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-2">
                          <input type="text" class="form-control" value="<?= $dd['total2'] ?>" name="total2" placeholder="0" required>
                      </div>
                  </div>
                  <!-- total -->

                  <!-- ukuran -->
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Ukuran</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <select class="form-control" name="ukuran" id="ukuran">
                              <option value="<?= $dd['ukuran'] ?>"><?= $dd['ukuran'] ?></option>
                              <option value="A3">A3</option>
                              <option value="A4">A4</option>
                          </select>
                      </div>
                  </div>
                  <!-- ukuran -->

                  <!-- distribusi dokumen -->
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Distribusi Dokumen</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <select class="form-control" name="distribusi_dokumen" id="distribusi_dokumen">

                              <option selected value="<?= $dd['id_dd'] ?>"><?= $dd['judul_dokumen'] ?></option>

                              <!--                 <?php foreach ($disdok as $disd) : ?>

                  <?php if ($disd['id_dd'] == $dd['id_dd']) : ?>
                    
                    <option selected value="<?= $dd['id_dd'] ?>"><?= $dd['judul_dokumen'] ?></option>

                    <?php else : ?>

                      <option value="<?= $disd['id_dd'] ?>"><?= $disd['judul_dokumen'] ?></option>

                    <?php endif ?>

                    <?php endforeach ?> -->
                          </select>
                      </div>
                  </div>
                  <!-- distribusi dokumen -->

                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>File</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <input required name="file_mscurve" id="file_mscurve" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen" required>
                      </div>
                  </div>

                  <div class="row mt-2">
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <button type="submit" name="update" class="btn btn-sm btn-primary btn-block">Revisi</button>
                      </div>
                  </div>

              </form>

          </div>
      </section>
      <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->