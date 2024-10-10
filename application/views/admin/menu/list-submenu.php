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

        <!-- tambah submenu -->
        <div class="row mb-2">
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
              <i class="fa fa-plus"></i> Submenu
            </button>
          </div>
        </div>
        <!-- end tambah submenu -->

        <!-- validasi -->
        <?= form_error('nama_submenu', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <?= form_error('url_submenu', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <?= form_error('id_menu', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <!-- end validasi -->
        <!-- alert -->
        <?=  
        $this->session->flashdata('messageSubmenu');
        ?>
        <!-- end alert -->

        <!-- tabel submenu -->
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="table-responsive">
              <table id="datatable" class="table table-sm table-striped table-bordered first">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Submenu</th>
                    <th>Url Submenu</th>
                    <th>Menu</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($submenu as $sm): ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $sm['nama_submenu']; ?></td>
                      <td><?= $sm['url_submenu']; ?></td>
                      <td><?= $sm['nama_menu']; ?></td>
                      <td>
                        <a href="<?= base_url('submenu/edit/') . $sm['kode_unik']; ?>" class="badge badge-success" data-toggle="modal" data-target="<?= '#exampleModal'.$sm['id_submenu'] ?>"><i class="fa fa-edit"></i></a>
                        <a href="<?= base_url('submenu/hapus/') . $sm['id_submenu']; ?>" class="badge badge-danger" onclick="return confirm('Yakin akan menghapus ini?')"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>

                    <!-- modal edit submenu -->
                    <div class="modal fade" id="<?= 'exampleModal'.$sm['id_submenu'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                            <div class="col text-center">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Submenu</h5>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <form action="<?= base_url('submenu/edit/').$sm['id_submenu']; ?>" method="post">
                            <div class="modal-body">
                              <div class="container-fluid">
                                <div class="row mb-2">
                                  <div class="col">
                                    <input required autocomplete="off" name="nama_submenu" id="nama_submenu" class="form-control" type="text" placeholder="Nama Submenu" value="<?= $sm['nama_submenu'] ?>">
                                  </div>
                                </div>
                                <div class="row mb-2">
                                  <div class="col">

                                    <select name="id_menu" id="id_menu" class="form-control">
                                      <option value="<?= $sm['id_menu'] ?>"><?= $sm['nama_menu'] ?></option>
                                      <?php foreach ($menu as $m): ?>
                                        <option value="<?= $m['id_menu'] ?>"><?= $m['nama_menu'] ?></option>
                                      <?php endforeach ?>
                                    </select>

                                  </div>
                                </div>
                                <div class="row mb-2">
                                  <div class="col">
                                    <input required autocomplete="off" name="url_submenu" id="url_submenu" class="form-control" type="text" placeholder="URL Submenu" value="<?= $sm['url_submenu'] ?>">
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
                    <!-- modal edit submenu -->

                    <?php $no++ ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
        <!-- end tabel submenu -->

        <!-- modal tambah submenu -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                <div class="col text-center">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Submenu</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form action="<?= base_url('submenu'); ?>" method="post">
                <div class="modal-body">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col">
                        <input required autocomplete="off" name="nama_submenu" id="nama_submenu" class="form-control" type="text" placeholder="Nama Submenu">
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col">

                        <select name="id_menu" id="id_menu" class="form-control">
                          <option value="">Pilih Menu</option>
                          <?php foreach ($menu as $m): ?>
                            <option value="<?= $m['id_menu'] ?>"><?= $m['nama_menu'] ?></option>
                          <?php endforeach ?>
                        </select>

                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col">
                        <input required autocomplete="off" name="url_submenu" id="url_submenu" class="form-control" type="text" placeholder="URL Submenu">
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
        <!-- end modal tambah submenu-->

      </div>
    </section>
    <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->



