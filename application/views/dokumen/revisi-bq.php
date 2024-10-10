  <!-- content -->

  <!-- halaman -->
  <div class="content-wrapper" style="margin-bottom: 75px;">

    <!-- judul -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-center">Revisi Dokumen BQ</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- judul -->

    <!-- content -->
    <section class="content">
      <div class="container-fluid">

        <form action="<?= base_url('bq/revisi/') . $kode_unik . '/' . $no_order . '/' . $fungsi ?>" method="post" enctype="multipart/form-data">

          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <h6>No. Dokumen</h6>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $db['no_dokumen'] ?>" readonly>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <h6>Nama Dokumen</h6>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $db['nama_dokumen'] ?>" readonly>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <h6>Tgl Revisi</h6>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <input type="text" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" placeholder="Tgl revisi dokumen" onfocus="(this.type='date')">
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <h6>Status Dokumen</h6>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <select name="status_dokumen" id="status_dokumen" class="form-control" required>
                <option value="<?= $db['status'] ?>"><?= $db['nama_status'] ?></option>
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
                <option value="<?= $db['revisi'] ?>"><?= $db['nama_revisi'] ?></option>
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
                <option value="<?= $db['edisi'] ?>"><?= $db['nama_edisi'] ?></option>
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
              <input type="text" class="form-control" value="<?= $db['total1'] ?>" name="total1" placeholder="0" required>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2">
              <h5 class="text-center">x</h5>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2">
              <input type="text" class="form-control" value="<?= $db['total2'] ?>" name="total2" placeholder="0" required>
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
                <option value="<?= $db['ukuran'] ?>"><?= $db['ukuran'] ?></option>
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

                <option selected value="<?= $db['id_dd'] ?>"><?= $db['judul_dokumen'] ?></option>

                <!--                 <?php foreach ($disdok as $disd) : ?>

                  <?php if ($disd['id_dd'] == $db['id_dd']) : ?>

                    <option selected value="<?= $db['id_dd'] ?>"><?= $db['judul_dokumen'] ?></option>

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
              <input required name="file_bq" id="file_bq" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (format pdf / xlsx)" required>
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