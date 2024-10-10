  <!-- content -->

  <!-- halaman -->
  <div class="content-wrapper">

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

        <!-- tambah kode fungsi -->
        <div class="row mb-2">
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
              <i class="fa fa-plus"></i> Kode Fungsi
            </button>
          </div>
        </div>
        <!-- end tambah kode fungsi -->

        <!-- alert -->
        <?=  
        $this->session->flashdata('messageKode');
        ?>
        <!-- end alert -->

        <!-- tabel kode fungsi -->
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="table-responsive">
              <table id="datatable" class="table table-sm table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Fungsi</th>
                    <th>Organisasi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($kode_fungsi as $kf): ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $kf['id_kode']; ?></td>
                      <td><?= $kf['nama_cc_ord']; ?></td>
                      <td>
                        <a href="<?= base_url('kfungsi/edit/') . $kf['kode_unik']; ?>" class="badge badge-success" data-toggle="modal" data-target="<?= '#exampleModal'.$kf['id'] ?>"><i class="fa fa-edit"></i></a>
                        <a href="<?= base_url('kfungsi/hapus/') . $kf['id']; ?>" class="badge badge-danger" onclick="return confirm('Yakin akan menghapus ini?')"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>

                    <!-- modal edit kode fungsi -->
                    <div class="modal fade" id="<?= 'exampleModal'.$kf['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                            <div class="col text-center">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Kode Fungsi</h5>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <form action="<?= base_url('kfungsi/edit/').$kf['id']; ?>" method="post">
                            <div class="modal-body">
                              <div class="container-fluid">
                                <div class="row mb-2">
                                  <div class="col">
                                    <input required autocomplete="off" name="id_kode" id="id_kode" class="form-control" type="text" placeholder="Kode Fungsi" value="<?= $kf['id_kode'] ?>">
                                  </div>
                                </div>
                                <div class="row mb-2">
                                  <div class="col">

                                    <select name="organisasi" id="organisasi" class="form-control">
                                      <option value="<?= $kf['organisasi'] ?>"><?= $kf['nama_cc_ord'] ?></option>
                                      <?php foreach ($cc_ord as $co): ?>
                                        <option value="<?= $co['id_cc_ord'] ?>"><?= $co['nama_cc_ord'] ?></option>
                                      <?php endforeach ?>
                                    </select>

                                  </div>
                                </div>

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
                    <!-- modal edit kode fungsi -->

                    <?php $no++ ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
        <!-- tabel kode fungsi -->

        <!-- modal tambah kode fungsi -->
        <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                <div class="col text-center">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Kode Fungsi</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form action="<?= base_url('kfungsi'); ?>" method="post">
                <div class="modal-body">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col">
                        <input required autocomplete="off" name="id_kode" id="id_kode" class="form-control" type="text" placeholder="Kode Fungsi">
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col">

                        <select style="width: 100%" name="organisasi" id="organisasi" class="form-control select2">
                          <option value="">Organisasi</option>
                          <?php foreach ($cc_ord as $co): ?>
                            <option value="<?= $co['id_cc_ord'] ?>"><?= $co['nama_cc_ord'] ?></option>
                          <?php endforeach ?>
                        </select>

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
        <!-- modal tambah kode fungsi -->

      </div>
    </section>
    <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->



