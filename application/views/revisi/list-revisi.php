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

        <!-- tambah revisi -->
        <div class="row mb-2">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
              <i class="fa fa-plus"></i> Revisi
            </button>
          </div>
        </div>
        <!-- end tambah revisi -->

        <!-- validasi -->
        <?= form_error('nama_revisi', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <!-- end validasi -->

        <!-- alert -->
        <?=  
        $this->session->flashdata('messageRevisi');
        ?>
        <!-- end alert -->

        <!-- tabel revisi -->
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="table-responsive">
              <table id="datatable" class="table table-sm table-striped table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Revisi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($revisi as $r): ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $r['nama_revisi']; ?></td>
                      <td>
                        <a href="<?= base_url('revisi/edit/') . $r['id_revisi']; ?>" class="badge badge-success" data-toggle="modal" data-target="<?= '#exampleModal'.$r['id_revisi'] ?>"><i class="fa fa-edit"></i></a>
                        <a href="<?= base_url('revisi/hapus/') . $r['id_revisi']; ?>" class="badge badge-danger" onclick="return confirm('Yakin akan menghapus ini?')"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>


                    <!-- modal edit revisi -->
                    <div class="modal fade" id="<?= 'exampleModal'.$r['id_revisi'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                            <div class="col text-center">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Revisi</h5>                
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>


                          <form action="<?= base_url('revisi/edit/').$r['id_revisi']; ?>" method="post">
                            <div class="modal-body">
                              <div class="container-fluid">
                                <div class="row mb-2">
                                  <div class="col">
                                    <input required autocomplete="off" name="nama_revisi" id="nama_revisi" class="form-control" type="text" placeholder="Nama Revisi" value="<?= $r['nama_revisi'] ?>">
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
                    <!-- modal edit revisi -->


                    <?php $no++ ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
        <!-- end tabel revisi -->

        <!-- modal tambah revisi -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                <div class="col text-center">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Revisi</h5>                
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>


              <form action="<?= base_url('revisi'); ?>" method="post">
                <div class="modal-body">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col">
                        <input required autocomplete="off" name="nama_revisi" id="nama_revisi" class="form-control" type="text" placeholder="Nama Revisi">
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
        <!-- modal tambah revisi -->

      </div>
    </section>
    <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->



