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
                    <th>Cost Center</th>                    
                    <th>Organisasi</th>
                    <th>Kode Fungsi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($cc_ord as $co): ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $co['id_cc_ord']; ?></td>                      
                      <td><?= $co['nama_cc_ord']; ?></td>
                      <td><?= $co['kode_fungsi']; ?></td>
                      <td>
                        <a href="<?= base_url('kfungsi/edit/') . $co['id']; ?>" class="badge badge-success" data-toggle="modal" data-target="<?= '#exampleModal'.$co['id'] ?>"><i class="fa fa-edit"></i></a>
                      </td>
                    </tr>

                    <!-- modal edit kode fungsi -->
                    <div class="modal fade" id="<?= 'exampleModal'.$co['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                          <form action="<?= base_url('kfungsi/edit/').$co['id']; ?>" method="post">
                            <div class="modal-body">
                              <div class="container-fluid">
                                <!-- organisasi -->
                                <div class="row mb-2">
                                  <div class="col">
                                    <input required autocomplete="off" name="nama_cc_ord" id="nama_cc_ord" class="form-control" type="text" placeholder="Organisasi" value="<?= $co['nama_cc_ord'] ?>" readonly>
                                  </div>
                                </div>
                                <!-- organisasi -->
                                <!-- kode fungsi -->
                                <div class="row mb-2">
                                  <div class="col">
                                    <input required autocomplete="off" name="kode_fungsi" id="kode_fungsi" class="form-control" type="text" placeholder="Kode Fungsi" value="<?= $co['kode_fungsi'] ?>">
                                  </div>
                                </div>
                                <!-- kode fungsi -->
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

      </div>
    </section>
    <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->



