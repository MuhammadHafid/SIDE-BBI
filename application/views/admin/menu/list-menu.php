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

        <!-- tambah menu -->
        <div class="row mb-2">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
              <i class="fa fa-plus"></i> Menu
            </button>
          </div>
        </div>
        <!-- end tambah menu -->

        <!-- validasi -->
        <?= form_error('nama_menu', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <?= form_error('url_menu', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <?= form_error('icon_menu', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <!-- end validasi -->

        <!-- alert -->
        <?=  
        $this->session->flashdata('messageMenu');
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
                    <th>Nama Menu</th>
                    <th>Url Menu</th>
                    <th>Icon Menu</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($menu as $m): ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $m['nama_menu']; ?></td>
                      <td><?= $m['url_menu']; ?></td>
                      <td><?= $m['icon_menu']; ?></td>
                      <td>
                        <a href="<?= base_url('menu/edit/') . $m['kode_unik']; ?>" class="badge badge-success" data-toggle="modal" data-target="<?= '#exampleModal'.$m['id_menu'] ?>"><i class="fa fa-edit"></i></a>
                        <a href="<?= base_url('menu/hapus/') . $m['id_menu']; ?>" class="badge badge-danger" onclick="return confirm('Yakin akan menghapus ini?')"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>


                    <!-- modal edit menu -->
                    <div class="modal fade" id="<?= 'exampleModal'.$m['id_menu'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                            <div class="col text-center">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>                
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>


                          <form action="<?= base_url('menu/edit/').$m['id_menu']; ?>" method="post">
                            <div class="modal-body">
                              <div class="container-fluid">
                                <div class="row mb-2">
                                  <div class="col">
                                    <input required autocomplete="off" name="nama_menu" id="nama_menu" class="form-control" type="text" placeholder="Nama Menu" value="<?= $m['nama_menu'] ?>">
                                  </div>
                                </div>
                                <div class="row mb-2">
                                  <div class="col">
                                    <input required autocomplete="off" name="url_menu" id="url_menu" class="form-control" type="text" placeholder="URL Menu" value="<?= $m['url_menu'] ?>">
                                  </div>
                                </div>
                                <div class="row mb-2">
                                  <div class="col">
                                    <input required name="icon_menu" id="icon_menu" class="form-control" type="text" placeholder="Icon Menu" value="<?= $m['icon_menu'] ?>">
                                  </div>
                                </div>

                                <div class="row mb-2 ml-2">
                                  <div class="col">
                                    <?php if ($m['submenu'] == 1): ?>
                                      <input type="checkbox" class="form-check-input" id="submenu" name="submenu" value="1" checked>
                                      <?php else: ?>
                                        <input type="checkbox" class="form-check-input" id="submenu" name="submenu" value="1">          
                                      <?php endif ?>
                                      <label class="form-check-label" for="submenu">Submenu?</label>
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
                      <!-- modal edit menu -->


                      <?php $no++ ?>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
          <!-- end tabel menu -->

          <!-- Modal Tambah Menu -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                  <div class="col text-center">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>                
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>


                <form action="<?= base_url('menu'); ?>" method="post">
                  <div class="modal-body">
                    <div class="container-fluid">
                      <div class="row mb-2">
                        <div class="col">
                          <input required autocomplete="off" name="nama_menu" id="nama_menu" class="form-control" type="text" placeholder="Nama Menu">
                        </div>
                      </div>
                      <div class="row mb-2">
                        <div class="col">
                          <input required autocomplete="off" name="url_menu" id="url_menu" class="form-control" type="text" placeholder="URL Menu">
                        </div>
                      </div>
                      <div class="row mb-2">
                        <div class="col">
                          <input required name="icon_menu" id="icon_menu" class="form-control" type="text" placeholder="Icon Menu">
                        </div>
                      </div>

                      <div class="row mb-2 ml-2">
                        <div class="col">
                          <input type="checkbox" class="form-check-input" id="submenu" name="submenu" value="1">
                          <label class="form-check-label" for="submenu">Submenu?</label>
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
          <!-- END Modal -->

        </div>
      </section>
      <!-- content -->

    </div>
    <!-- halaman -->

    <!-- content -->



