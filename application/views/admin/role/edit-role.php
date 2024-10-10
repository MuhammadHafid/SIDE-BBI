  <!-- content -->

  <!-- halaman -->
  <div class="content-wrapper">

    <!-- judul -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-center">Edit Role</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- judul -->

    <!-- content -->
    <section class="content">
      <div class="container-fluid">

        <!-- form edit role -->
        <div class="row" style="margin-top: 20px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <?= form_error('nama_role', '<div class="alert alert-danger" role="alert">', '</div>');  ?>
            <?=  
            $this->session->flashdata('role');
            ?>

            <?= form_open_multipart (base_url('role/edit/') . $role['kode_unik'])?>

            <input type="hidden" class="form-control" id="id_role" name="id_role" value="<?= $role['id_role'];  ?>">

            <!-- nama_role -->
            <div class="form-group row">
              <label class="col-form-label col-md-3 col-sm-3 text-right" for="nama_role">Nama Role</label>
              <div class="col-md-6 col-sm-6 ">
                <input type="text" id="nama_role" name="nama_role" required="required" class="form-control" value="<?= $role['nama_role'];  ?>">
              </div>
            </div>
            <!-- end nama_role -->

            <!-- akses_menu -->
            <div class="form-group row">
              <label class="col-form-label col-md-3 col-sm-3 text-right" for="url_menu">Akses Menu</label>
              <div class="col-md-6 col-sm-6 ">
                <select name="id_menu[]" id="id_menu[]" class="form-control select2" multiple="multiple">
                  <?php foreach ($aksesMenu as $am): ?>
                    <option selected="selected" value="<?= $am['id_menu']; ?>"><?= $am['nama_menu']; ?></option>
                  <?php endforeach ?>
                  <?php foreach ($menu as $m): ?>             
                    <option value="<?= $m['id_menu']; ?>"><?= $m['nama_menu']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <!-- end akses_menu -->

            <div class="form-group row">
              <div class="col-md-3 col-sm-3"></div>
              <div class="col-md-6 col-sm-6 d-flex justify-content-end">
                <button type="submit" class="btn btn-md btn-primary">Edit</button>
              </div>
            </div>
          </div>
        </div>
        <!-- end form edit role -->

      </div>
    </section>
    <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->



