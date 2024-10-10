  <!-- content -->

  <!-- halaman -->
  <div class="content-wrapper" style="margin-bottom: 75px;">

      <!-- judul -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col">
                      <h1 class="m-0 text-center"><?= $title ?></h1>
                  </div>
              </div>
          </div>
      </div>
      <!-- judul -->

      <!-- content -->
      <section class="content">
          <div class="container-fluid">

              <form action="<?= base_url('lapprod/revisi/') . $kode_unik ?>" method="post" enctype="multipart/form-data">

                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>No. Dokumen</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $laporan['no_dokumen'] ?>" readonly>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Nama Dokumen</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $laporan['nama_dokumen'] ?>" readonly>
                      </div>
                  </div>

                  <!-- divisi -->
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Divisi</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <input required name="divisi" id="divisi" class="form-control" type="text" placeholder="Divisi" value="<?= $laporan['divisi'] ?>" readonly>
                      </div>
                  </div>
                  <!-- divisi -->

                  <!-- bulan -->
                  <div class="row mb-2">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Bulan</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <select name="bulan" id="bulan" class="form-control" required>
                              <?php if ($laporan['bulan'] == '01') { ?><option value="01"><?= "Januari" ?></option><?php } ?>
                              <?php if ($laporan['bulan'] == '02') { ?><option value="02"><?= "Februari" ?></option><?php } ?>
                              <?php if ($laporan['bulan'] == '03') { ?><option value="03"><?= "Maret" ?></option><?php } ?>
                              <?php if ($laporan['bulan'] == '04') { ?><option value="04"><?= "April" ?></option><?php } ?>
                              <?php if ($laporan['bulan'] == '05') { ?><option value="05"><?= "Mei" ?></option><?php } ?>
                              <?php if ($laporan['bulan'] == '06') { ?><option value="06"><?= "Juni" ?></option><?php } ?>
                              <?php if ($laporan['bulan'] == '07') { ?><option value="07"><?= "Juli" ?></option><?php } ?>
                              <?php if ($laporan['bulan'] == '08') { ?><option value="08"><?= "Agustus" ?></option><?php } ?>
                              <?php if ($laporan['bulan'] == '09') { ?><option value="09"><?= "September" ?></option><?php } ?>
                              <?php if ($laporan['bulan'] == '10') { ?><option value="10"><?= "Oktober" ?></option><?php } ?>
                              <?php if ($laporan['bulan'] == '11') { ?><option value="11"><?= "November" ?></option><?php } ?>
                              <?php if ($laporan['bulan'] == '12') { ?><option value="12"><?= "Desember" ?></option><?php } ?>
                              <option value="">Bulan</option>
                              <option value="01">Januari</option>
                              <option value="02">Februari</option>
                              <option value="03">Maret</option>
                              <option value="04">April</option>
                              <option value="05">Mei</option>
                              <option value="06">Juni</option>
                              <option value="07">Juli</option>
                              <option value="08">Agustus</option>
                              <option value="09">September</option>
                              <option value="10">Oktober</option>
                              <option value="11">November</option>
                              <option value="12">Desember</option>
                          </select>
                      </div>
                  </div>
                  <!-- bulan -->

                  <!-- tahun -->
                  <!-- tentukan tahun sekarang dan sebelumnya -->
                  <?php
                    $tahun_sekarang = date('Y');
                    $tahun_kemarin = date('Y') - 1;
                    ?>
                  <!-- tentukan tahun sekarang dan sebelumnya -->

                  <div class="row mb-2">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Tahun</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <select name="tahun" id="tahun" class="form-control" required>
                              <option value="<?= $laporan['tahun'] ?>"><?= $laporan['tahun'] ?></option>
                              <option value="<?= $tahun_sekarang ?>"><?= $tahun_sekarang ?></option>
                              <option value="<?= $tahun_kemarin ?>"><?= $tahun_kemarin ?></option>
                          </select>
                      </div>
                  </div>
                  <!-- tahun -->

                  <!-- tgl_pembuatan -->
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Tgl Revisi</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <input type="text" id="tgl_pembuatan" name="tgl_pembuatan" required="required" class="form-control" placeholder="Tgl Pembuatan" onfocus="(this.type='date')">
                      </div>
                  </div>
                  <!-- tgl_pembuatan -->

                  <!-- edisi -->
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Edisi</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <select name="edisi" id="edisi" class="form-control" required>
                              <option value="<?= $laporan['edisi'] ?>"><?= $laporan['nama_edisi'] ?></option>
                              <?php foreach ($edisi as $e) : ?>
                                  <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option>
                              <?php endforeach ?>
                          </select>
                      </div>
                  </div>
                  <!-- edisi -->

                  <!-- revisi -->
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>Revisi</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <select name="revisi" id="revisi" class="form-control" required>
                              <option value="<?= $laporan['revisi'] ?>"><?= $laporan['nama_revisi'] ?></option>
                              <?php foreach ($revisi as $r) : ?>
                                  <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                              <?php endforeach ?>
                          </select>
                      </div>
                  </div>
                  <!-- revisi -->

                  <!-- file laporan -->
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <h6>File</h6>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12">
                          <input required name="file_laporan" id="file_laporan" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen" required>
                      </div>
                  </div>
                  <!-- file laporan -->

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