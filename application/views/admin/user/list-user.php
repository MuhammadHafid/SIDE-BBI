  <!-- content -->

  <!-- halaman -->
  <div class="content-wrapper">

    <!-- judul -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-center">Kelola User</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- judul -->

    <!-- content -->
    <section class="content">
      <div class="container-fluid">

        <!-- tambah user -->
        <div class="row mb-2">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <span data-toggle="tooltip" data-placement="top" title="Tambah User">
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-user-plus"></i>
              </button>              
            </span>
          </div>
        </div>
        <!-- end tambah user -->

        <!-- validasi -->
        <?= form_error('nik', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <?= form_error('id_role', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <?= form_error('password', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <?= form_error('password2', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <!-- end validasi -->

        <!-- alert -->
        <?=  
        $this->session->flashdata('messageUser');
        ?>
        <!-- end alert -->

        <!-- tabel user -->
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="table-responsive">
              <table id="datatable" class="table table-sm table-striped table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>NIK</th>                    
                    <th>Nama Karyawan</th>
                    <th>role</th>                                        
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($users as $u): ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $u['nik']; ?></td>
                      <td><?= $u['nama_karyawan']; ?></td>
                      <td><?= $u['nama_role']; ?></td>
                      <td>
                        <a href="<?= base_url('user/edit/') . $u['id_user']; ?>" class="badge badge-success" data-toggle="modal" data-target="<?= '#exampleModal'.$u['id_user'] ?>"><i class="fa fa-edit"></i></a>
                        <a href="<?= base_url('user/hapus/') . $u['id_user']; ?>" class="badge badge-danger" onclick="return confirm('Yakin akan menghapus ini?')"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>


                    <!-- modal edit user -->
                    <div class="modal fade" id="<?= 'exampleModal'.$u['id_user'] ?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                            <div class="col text-center">
                              <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>                
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <form action="<?= base_url('user/edit/').$u['id_user'] ?>" method="post">
                            <div class="modal-body">
                              <div class="container-fluid">

                                <div class="row mb-2">
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input required autocomplete="off" name="nik" id="nik" class="form-control" type="text" placeholder="NIK" value="<?= $u['nik'] ?>" required readonly>
                                  </div>
                                </div>

                                <div class="row mb-2">
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                    <select style="width: 100%;" name="id_role" id="id_role" class="form-control" required>
                                      <option value="<?= $u['id_role'] ?>"><?= $u['nama_role'] ?></option>
                                      <?php foreach ($role as $r): ?>
                                        <option value="<?= $r['id_role'] ?>"><?= $r['nama_role'] ?></option>
                                      <?php endforeach ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="row mb-2">
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input autocomplete="off" name="password" id="password" class="form-control" type="password" placeholder="New Password">
                                  </div>
                                </div>                  

                                <div class="row mb-2">
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input autocomplete="off" name="password2" id="password2" class="form-control" type="password" placeholder="Repeat Password">
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
                    <!-- modal edit user -->


                    <?php $no++ ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
        <!-- end tabel user -->

        <!-- modal tambah user -->
        <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                <div class="col text-center">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>                
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form action="<?= base_url('user'); ?>" method="post">
                <div class="modal-body">
                  <div class="container-fluid">

                    <div class="row mb-2">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <select style="width: 100%;" name="nik" id="nik" class="form-control select2" required>
                          <option value="">Pilih Karyawan</option>
                          <?php foreach ($karyawan as $kry): ?>
                            <option value="<?= $kry['nik'] ?>"><?= $kry['nama_karyawan'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <select style="width: 100%;" name="id_role" id="id_role" class="form-control" required>
                          <option value="">Role</option>
                          <?php foreach ($role as $r): ?>
                            <option value="<?= $r['id_role'] ?>"><?= $r['nama_role'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <input required autocomplete="off" name="password" id="password" class="form-control" type="password" placeholder="Password" required>
                      </div>
                    </div>                  

                    <div class="row mb-2">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <input required autocomplete="off" name="password2" id="password2" class="form-control" type="password" placeholder="Repeat Password" required>
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
        <!-- modal tambah user -->

      </div>
    </section>
    <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->



