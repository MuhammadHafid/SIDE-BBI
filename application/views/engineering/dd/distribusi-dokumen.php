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

        <!-- tambah distribusi dokumen, download form, import -->
        <div class="row mb-2">
          <div class="col-lg-3 col-md-3">
            <div class="row">
              <div class="col-lg-2 co-md-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                  <i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="Tambah Dokumen"></i>
                </button>
              </div>
              <div class="col-lg-2 co-md-2">
                <a target="_blank" href="<?= base_url('export/formDd') ?>" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Download Form Import Distribusi Dokumen"><i class="fa fa-download"></i></a>
              </div>
              <div class="col-lg-6 co-md-6">
                <form action="<?= base_url('import/dd') ?>" method="POST" enctype="multipart/form-data">
                  <input type="text"  id="file_import" name="file_import" placeholder="Upload excel" class="form-control" onfocus="(this.type='file')" required>
                </div>              
                <div class="col-lg-2 co-md-2" style="padding-left:0; padding-right: 0;">
                  <button class="btn btn-warning" type="submit" name="upload" data-toggle="tooltip" data-placement="top" title="Import Data Distribusi Dokumen"><i class="fa fa-upload"></i></button>
                </form>
              </div>              
            </div>
          </div>
        </div>
        <!-- end tambah distribusi dokumen, download form, import -->

        <!-- validasi -->
        <?= form_error('judul_dokumen', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
        <!-- end validasi -->

        <!-- alert -->
        <?=  
        $this->session->flashdata('messageDd');
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
                    <th>Judul Dokumen</th>
                    <th>JML</th>
                    <th>PPC</th>
                    <th>QA</th>
                    <th>QC</th>
                    <th>FAB</th>
                    <th>MM</th>
                    <th>LOG</th>                    
                    <th>KEU</th>
                    <th>ENG</th>
                    <th>PROD</th>                    
                    <th>HRD</th>
                    <th>SALES</th>
                    <th>MPI</th>
                    <th>EXP</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($distribusi_dokumen as $dd): ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $dd['judul_dokumen']; ?></td>
                      <td><?= $dd['jml_dokumen']; ?></td>                      
                      <td><?= $dd['ppc']; ?></td>                      
                      <td><?= $dd['qa']; ?></td>                      
                      <td><?= $dd['qc']; ?></td>                      
                      <td><?= $dd['fab']; ?></td>                      
                      <td><?= $dd['mm']; ?></td>                      
                      <td><?= $dd['log']; ?></td>                      
                      <td><?= $dd['keu']; ?></td>                      
                      <td><?= $dd['eng']; ?></td>
                      <td><?= $dd['prod']; ?></td>                      
                      <td><?= $dd['hrd']; ?></td>                      
                      <td><?= $dd['sales']; ?></td>                      
                      <td><?= $dd['mpi']; ?></td>
                      <td><?= $dd['exp_dokumen']; ?></td>                     
                      <td>
                        <a href="<?= base_url('dd/edit/') . $dd['id_dd']; ?>" class="badge badge-success" data-toggle="modal" data-target="<?= '#exampleModal'.$dd['id_dd'] ?>"><i class="fa fa-edit"></i></a>
                        <a href="<?= base_url('dd/hapus/') . $dd['id_dd']; ?>" class="badge badge-danger" onclick="return confirm('Yakin akan menghapus ini?')"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>

                    <!-- modal edit -->
                    <div class="modal fade" id="<?= 'exampleModal'.$dd['id_dd'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                            <div class="col text-center">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen</h5>                
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <form action="<?= base_url('dd/edit/').$dd['id_dd']; ?>" method="post">
                            <div class="modal-body">
                              <div class="container-fluid">

                                <div class="row mb-2">
                                  <div class="col">
                                    <input required autocomplete="off" name="judul_dokumen" id="judul_dokumen" class="form-control" type="text" placeholder="Judul Dokumen" value="<?= $dd['judul_dokumen'] ?>" required>
                                  </div>
                                </div>

                                <div class="row" style="text-align: center;">
                                  <div class="col">
                                    <h6>Distribusi :</h6>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">PPC</div>
                                      </div>
                                      <input type="text" class="form-control" id="ppc" name="ppc" placeholder="0" value="<?= $dd['ppc'] ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">QC</div>
                                      </div>
                                      <input type="text" class="form-control" id="qc" name="qc" placeholder="0" value="<?= $dd['qc'] ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">QA</div>
                                      </div>
                                      <input type="text" value="<?= $dd['qa'] ?>" class="form-control" id="qa" name="qa" placeholder="0">
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">FAB</div>
                                      </div>
                                      <input type="text" value="<?= $dd['fab'] ?>" class="form-control" id="fab" name="fab" placeholder="0">
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">MM</div>
                                      </div>
                                      <input type="text" class="form-control" value="<?= $dd['mm'] ?>" id="mm" name="mm" placeholder="0">
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">LOG</div>
                                      </div>
                                      <input type="text" class="form-control" value="<?= $dd['log'] ?>" id="log" name="log" placeholder="0">
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">KEU</div>
                                      </div>
                                      <input type="text" value="<?= $dd['keu'] ?>" class="form-control" id="keu" name="keu" placeholder="0">
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">ENG</div>
                                      </div>
                                      <input type="text" value="<?= $dd['eng'] ?>" class="form-control" id="eng" name="eng" placeholder="0">
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">PROD</div>
                                      </div>
                                      <input type="text" class="form-control" value="<?= $dd['prod'] ?>" id="prod" name="prod" placeholder="0">
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">HRD</div>
                                      </div>
                                      <input type="text" class="form-control" value="<?= $dd['hrd'] ?>" id="hrd" name="hrd" placeholder="0">
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">SALES</div>
                                      </div>
                                      <input type="text" value="<?= $dd['sales'] ?>" class="form-control" id="sales" name="sales" placeholder="0">
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">MPI</div>
                                      </div>
                                      <input type="text" value="<?= $dd['mpi'] ?>" class="form-control" id="mpi" name="mpi" placeholder="0">
                                    </div>
                                  </div>
                                </div>

                                <div class="row mb-2 justify-content-center">
                                  <div class="col-lg-3 col-md-3">
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">EXP</div>
                                      </div>
                                      <input type="text" class="form-control" id="exp_dokumen" name="exp_dokumen" placeholder="0" value="<?= $dd['exp_dokumen'] ?>">
                                    </div>
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
                    <!-- modal edit -->

                    <?php $no++ ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
        <!-- end tabel -->

        <!-- modal tambah -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                <div class="col text-center">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen</h5>                
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form action="<?= base_url('dd'); ?>" method="post">
                <div class="modal-body">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col">
                        <input required autocomplete="off" name="judul_dokumen" id="judul_dokumen" class="form-control" type="text" placeholder="Judul Dokumen" required>
                      </div>
                    </div>

                    <div class="row" style="text-align: center;">
                      <div class="col">
                        <h6>Distribusi :</h6>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">PPC</div>
                          </div>
                          <input type="text" class="form-control" id="ppc" name="ppc" placeholder="0">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">QC</div>
                          </div>
                          <input type="text" class="form-control" id="qc" name="qc" placeholder="0">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">QA</div>
                          </div>
                          <input type="text" class="form-control" id="qa" name="qa" placeholder="0">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">FAB</div>
                          </div>
                          <input type="text" class="form-control" id="fab" name="fab" placeholder="0">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">MM</div>
                          </div>
                          <input type="text" class="form-control" id="mm" name="mm" placeholder="0">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">LOG</div>
                          </div>
                          <input type="text" class="form-control" id="log" name="log" placeholder="0">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">KEU</div>
                          </div>
                          <input type="text" class="form-control" id="keu" name="keu" placeholder="0">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">ENG</div>
                          </div>
                          <input type="text" class="form-control" id="eng" name="eng" placeholder="0">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">PROD</div>
                          </div>
                          <input type="text" class="form-control" id="prod" name="prod" placeholder="0">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">HRD</div>
                          </div>
                          <input type="text" class="form-control" id="hrd" name="hrd" placeholder="0">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">SALES</div>
                          </div>
                          <input type="text" class="form-control" id="sales" name="sales" placeholder="0">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">MPI</div>
                          </div>
                          <input type="text" class="form-control" id="mpi" name="mpi" placeholder="0">
                        </div>
                      </div>
                    </div>

                    <div class="row mb-2 justify-content-center">
                      <div class="col-lg-3 col-md-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">EXP</div>
                          </div>
                          <input type="text" class="form-control" id="exp_dokumen" name="exp_dokumen" placeholder="0">
                        </div>
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
        <!-- modal tambah -->

      </div>
    </section>
    <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->