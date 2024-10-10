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

        <!-- tambah edisi -->
        <div class="row mb-2">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
              <i class="fa fa-plus"></i> Edisi
            </button>
          </div>
        </div>
        <!-- end tambah edisi -->

        <!-- validasi -->
        <?= form_error('nama_edisi', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <!-- end validasi -->

        <!-- alert -->
        <?=  
        $this->session->flashdata('messageEdisi');
        ?>
        <!-- end alert -->

        <!-- tabel edisi -->
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="table-responsive">
              <table id="datatable" class="table table-sm table-striped table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Edisi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($edisi as $e): ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $e['nama_edisi']; ?></td>
                      <td>
                        <a href="<?= base_url('edisi/edit/') . $e['id_edisi']; ?>" class="badge badge-success" data-toggle="modal" data-target="<?= '#exampleModal'.$e['id_edisi'] ?>"><i class="fa fa-edit"></i></a>
                        <a href="<?= base_url('edisi/hapus/') . $e['id_edisi']; ?>" class="badge badge-danger" onclick="return confirm('Yakin akan menghapus ini?')"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>


                    <!-- modal edit edisi -->
                    <div class="modal fade" id="<?= 'exampleModal'.$e['id_edisi'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                            <div class="col text-center">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Edisi</h5>                
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <form action="<?= base_url('edisi/edit/').$e['id_edisi']; ?>" method="post">
                            <div class="modal-body">
                              <div class="container-fluid">
                                <div class="row mb-2">
                                  <div class="col">
                                    <input required autocomplete="off" name="nama_edisi" id="nama_edisi" class="form-control" type="text" placeholder="Nama Edisi" value="<?= $e['nama_edisi'] ?>">
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
                    <!-- modal edit edisi -->

                    <?php $no++ ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
        <!-- end tabel edisi -->

        <!-- modal tambah edisi -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                <div class="col text-center">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Edisi</h5>                
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form action="<?= base_url('edisi'); ?>" method="post">
                <div class="modal-body">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col">
                        <input required autocomplete="off" name="nama_edisi" id="nama_edisi" class="form-control" type="text" placeholder="Nama Edisi">
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
        <!-- modal tambah edisi -->

      </div>
    </section>
    <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->



