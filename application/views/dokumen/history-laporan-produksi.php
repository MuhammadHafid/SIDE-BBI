  <!-- content -->

  <!-- halaman -->
  <div class="content-wrapper">

      <!-- judul -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col">
                      <h1 class="m-0 text-center">Histori Dokumen</h1>
                  </div>
              </div>
          </div>
      </div>
      <!-- judul -->

      <!-- alert -->
      <?= $this->session->flashdata('messageHistory'); ?>
      <!-- end alert -->

      <!-- content -->
      <section class="content">
          <div class="container-fluid">

              <!-- tabel histori laporan produksi -->
              <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <div class="table-responsive">
                          <table id="datatable" class="table table-sm table-striped table-bordered">
                              <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>No Dokumen</th>
                                      <th>Nama Dokumen</th>
                                      <th>Tgl Pembuatan</th>
                                      <th>Edisi</th>
                                      <th>Revisi</th>
                                      <th>Valid</th>
                                      <th>Aksi</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $no = 1; ?>
                                  <?php foreach ($dokumen_history as $dh) : ?>
                                      <tr>
                                          <td style="font-size: 14px;"><?= $no ?></td>
                                          <td style="font-size: 14px;"><?= $dh['no_dokumen']; ?></td>
                                          <td style="font-size: 14px;"><?= $dh['nama_dokumen']; ?></td>
                                          <td style="font-size: 14px;"><?= $dh['tgl_pembuatan']; ?></td>
                                          <td style="font-size: 14px;"><?= $dh['nama_edisi']; ?></td>
                                          <td style="font-size: 14px;"><?= $dh['nama_revisi']; ?></td>

                                          <?php if ($dh['status'] == 1) : ?>
                                              <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                                          <?php endif ?>

                                          <?php if ($dh['status'] == 0) : ?>
                                              <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                                          <?php endif ?>

                                          <!-- Aksi -->
                                          <td>
                                              <div class="dropdown">
                                                  <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Pilih
                                                  </button>
                                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                      <!-- view -->
                                                      <a class="dropdown-item" target="_blank" href="<?= base_url('lapprod/view/') . $dh['nama_file'] ?>">View</a>
                                                      <!-- view -->

                                                      <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5) : ?>
                                                          <!-- hapus -->
                                                          <a href="<?= base_url('lapprod/hapus/') . $dh['id'] . '/' . $dh['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                          <!-- hapus -->
                                                      <?php endif ?>

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

                  </div>
              </div>
              <!-- tabel histori laporan produksi -->


              <!-- ///////////////////////////////////////////// -->










          </div>
      </section>
      <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->