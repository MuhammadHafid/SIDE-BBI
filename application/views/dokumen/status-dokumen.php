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

        <!-- tambah status dokumen -->
        <div class="row mb-2">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
              <i class="fa fa-plus"></i> Status Dokumen
            </button>
          </div>
        </div>
        <!-- end tambah status dokumen -->

        <!-- validasi -->
        <?= form_error('nama_status', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <!-- end validasi -->

        <!-- alert -->
        <?=  
        $this->session->flashdata('messageStatus');
        ?>
        <!-- end alert -->

        <!-- tabel menu -->
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="table-responsive">
              <table id="datatable" class="table table-sm table-striped table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($status_dokumen as $sd): ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $sd['nama_status']; ?></td>
                      <td>
                        <a href="<?= base_url('dokumen/edit_status/') . $sd['id_status']; ?>" class="badge badge-success" data-toggle="modal" data-target="<?= '#exampleModal'.$sd['id_status'] ?>"><i class="fa fa-edit"></i></a>
                        <a href="<?= base_url('dokumen/hapus_status/') . $sd['id_status']; ?>" class="badge badge-danger" onclick="return confirm('Yakin akan menghapus ini?')"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>


                    <!-- modal edit status -->
                    <div class="modal fade" id="<?= 'exampleModal'.$sd['id_status'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                            <div class="col text-center">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Status Dokumen</h5>                
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <form action="<?= base_url('dokumen/edit_status/').$sd['id_status']; ?>" method="post">
                            <div class="modal-body">
                              <div class="container-fluid">
                                <div class="row mb-2">
                                  <div class="col">
                                    <input required autocomplete="off" name="nama_status" id="nama_status" class="form-control" type="text" placeholder="Nama Status" value="<?= $sd['nama_status'] ?>">
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
                    <!-- modal edit status -->


                    <?php $no++ ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
        <!-- end tabel status dokumen -->

        <!-- modal tambah status -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                <div class="col text-center">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Status Dokumen</h5>                
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>


              <form action="<?= base_url('dokumen/status'); ?>" method="post">
                <div class="modal-body">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col">
                        <input required autocomplete="off" name="nama_status" id="nama_status" class="form-control" type="text" placeholder="Nama Status">
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
        <!-- modal tambah status -->

      </div>
    </section>
    <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->



