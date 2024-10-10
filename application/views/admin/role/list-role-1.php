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

              <!-- rambah role -->
              <div class="row mb-2">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                          <i class="fa fa-plus"></i> Role
                      </button>
                  </div>
              </div>
              <!-- end tambah role -->

              <!-- validasi error -->
              <?= form_error('nama_role', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
              <!-- end validasi drror -->

              <!-- alert -->
              <?=
                $this->session->flashdata('messageRole');
                ?>
              <!-- end alert -->

              <!-- tabel role -->
              <div class="row" style="margin-bottom: 75px;">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                      <div class="table-responsive" style="margin-bottom: 50px;">
                          <table id="datatable" class="table table-sm table-striped table-bordered first">
                              <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Nama Role</th>
                                      <th>Aksi</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $no = 1; ?>
                                  <?php foreach ($role as $r) : ?>
                                      <tr>
                                          <td><?= $no ?></td>
                                          <td><?= $r['nama_role']; ?></td>
                                          <td>
                                              <?php if ($r['id_role'] != 5) : ?>
                                                  <a href="<?= base_url('role/edit/') . $r['kode_unik']; ?>" class="badge badge-success"><i class="fa fa-edit"></i></a>
                                                  <a href="<?= base_url('role/hapus/') . $r['id_role']; ?>" class="badge badge-danger" onclick="return confirm('Yakin akan menghapus ini?')"><i class="fa fa-trash"></i></a>
                                              <?php endif ?>
                                          </td>
                                      </tr>

                                      <?php
                                        // Ambil akses menu berdasarkan 'id_role' pada tabel sdm_role_akses
                                        $this->db->select('role_akses.*, nama_menu');
                                        $this->db->from('role_akses');
                                        $this->db->join('menu', 'role_akses.id_menu = menu.id_menu', 'left');
                                        $this->db->where('role_akses.id_role =', $r['id_role']);
                                        $aksesMenu = $this->db->get()->result_array();
                                        ?>

                                      <?php $no++ ?>
                                  <?php endforeach ?>
                              </tbody>
                          </table>
                      </div>

                  </div>
              </div>
              <!-- end tabel role -->

              <!-- modal tambah role -->
              <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                              <div class="col text-center">
                                  <h5 class="modal-title" id="exampleModalLabel">Tambah Role</h5>
                              </div>
                              <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>

                          <form action="<?= base_url('role'); ?>" method="post">
                              <div class="modal-body">
                                  <div class="container-fluid">
                                      <div class="row mb-2">
                                          <div class="col">
                                              <input required autocomplete="off" name="nama_role" id="nama_role" class="form-control" type="text" placeholder="Nama Role" autofocus>
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
              <!-- end modal tambah role -->

          </div>
      </section>
      <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->