  <!-- content -->

  <!-- halaman -->
  <div class="content-wrapper">

    <!-- judul -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-center">List Transmittal</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- judul -->

    <!-- content -->
    <section class="content">
      <div class="container-fluid">

        <!-- filter no order -->
        <div class="row mb-2">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <select name="forma" class="col-lg-2 col-md-2 col-sm-2 col-xs-4 form-control select2" onchange="location = this.value;">
              <option value="">Pilih No. Order</option>
              <option value="<?= base_url('transmittal')?>">All</option>
              <?php foreach ($no_order as $no): ?>
                <option value="<?= base_url('transmittal/index/').$no['id_cc_ord'] ?>"><?= $no['id_cc_ord'] ?></option>                
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <!-- filter no order -->

        <!-- alert -->
        <?=  
        $this->session->flashdata('messageTransmittal');
        ?>
        <!-- end alert -->

        <!-- tabel transmittal -->
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="table-responsive">
              <table id="datatable" class="table table-sm table-striped table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No SP</th>
                    <th>Tgl Transmittal</th>
                    <th>Jenis Dokumen</th>                    
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($transmittal as $t): ?>

                    <?php if ( $this->session->userdata('id_role')!= 1 && $this->session->userdata('id_role')!= 5 && $this->session->userdata('id_role')!= 13 && $t['submit'] == 1): ?>

                    <?php 
                    // cek dokumen drawing
                    $drawing = $this->db->get_where('dokumen_drawing',['no_sp'=>$t['no_sp']])->num_rows();
                    // cek dokumen BQ
                    $bq = $this->db->get_where('dokumen_bq',['no_sp'=>$t['no_sp']])->num_rows();
                    // cek dokumen EIS
                    $eis = $this->db->get_where('dokumen_eis',['no_sp'=>$t['no_sp']])->num_rows();
                    // cek dokumen MP
                    $mp = $this->db->get_where('dokumen_mp',['no_sp'=>$t['no_sp']])->num_rows(); 
                    // cek dokumen CLO
                    $clo = $this->db->get_where('dokumen_clo',['no_sp'=>$t['no_sp']])->num_rows();
                    // cek dokumen MRS
                    $mrs = $this->db->get_where('dokumen_mrs',['no_sp'=>$t['no_sp']])->num_rows();
                    ?>

                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $t['no_sp'] ?></td>
                      <td><?= $t['tgl_transmittal']; ?></td>

                      <td>
                        <?php if ($drawing > 0): ?>
                          <?= 'Drawing, ' ?>                        
                        <?php endif ?>
                        <?php if ($bq > 0): ?>
                          <?= 'BQ, ' ?>                        
                        <?php endif ?>
                        <?php if ($eis > 0): ?>
                          <?= 'EIS, ' ?>                        
                        <?php endif ?>
                        <?php if ($mp > 0): ?>
                          <?= 'MP, ' ?>                        
                        <?php endif ?>
                        <?php if ($clo > 0): ?>
                          <?= 'CLO, ' ?>                        
                        <?php endif ?>
                        <?php if ($mrs > 0): ?>
                          <?= 'MRS, ' ?>                        
                        <?php endif ?>
                      </td>

                      <!-- Aksi -->
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                            <!-- detail -->
                            <a class="dropdown-item" href="<?= base_url('transmittal/detail/').$t['id_transmittal'].'/'.$t['no_order'].'/drawing' ?>">Detail</a>
                            <!-- detail -->

                            <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                            <!-- hapus -->
                            <a href="<?= base_url('transmittal/hapus/') . $t['id_transmittal'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                            <!-- hapus -->

                          <?php endif ?>

                        </div>
                      </div>
                    </td>
                    <!-- aksi -->

                  </tr>

                <?php endif ?>

                <?php if ( $this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13 ): ?>

                <?php 
                // cek dokumen drawing
                $drawing = $this->db->get_where('dokumen_drawing',['no_sp'=>$t['no_sp']])->num_rows();
                // cek dokumen BQ
                $bq = $this->db->get_where('dokumen_bq',['no_sp'=>$t['no_sp']])->num_rows();
                // cek dokumen EIS
                $eis = $this->db->get_where('dokumen_eis',['no_sp'=>$t['no_sp']])->num_rows();
                // cek dokumen MP
                $mp = $this->db->get_where('dokumen_mp',['no_sp'=>$t['no_sp']])->num_rows(); 
                // cek dokumen CLO
                $clo = $this->db->get_where('dokumen_clo',['no_sp'=>$t['no_sp']])->num_rows();
                // cek dokumen MRS
                $mrs = $this->db->get_where('dokumen_mrs',['no_sp'=>$t['no_sp']])->num_rows();
                ?>

                <tr>
                  <td><?= $no ?></td>

                  <?php if ($t['submit'] == 1): ?>

                    <td><?= $t['no_sp']; ?> <i style="color: green; font-weight: bold;" class="far fa-check-circle"></i> </td>

                    <?php else: ?>

                      <td><?= $t['no_sp']; ?></td>

                    <?php endif ?>

                    <td><?= $t['tgl_transmittal']; ?></td>

                    <td>
                      <?php if ($drawing > 0): ?>
                        <?= 'Drawing, ' ?>                        
                      <?php endif ?>
                      <?php if ($bq > 0): ?>
                        <?= 'BQ, ' ?>                        
                      <?php endif ?>
                      <?php if ($eis > 0): ?>
                        <?= 'EIS, ' ?>                        
                      <?php endif ?>
                      <?php if ($mp > 0): ?>
                        <?= 'MP, ' ?>                        
                      <?php endif ?>
                      <?php if ($clo > 0): ?>
                        <?= 'CLO, ' ?>                        
                      <?php endif ?>
                      <?php if ($mrs > 0): ?>
                        <?= 'MRS, ' ?>                        
                      <?php endif ?>
                    </td>

                    <!-- Aksi -->
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Pilih
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                          <!-- detail -->
                          <a class="dropdown-item" href="<?= base_url('transmittal/detail/').$t['id_transmittal'].'/'.$t['no_order'].'/drawing' ?>">Detail</a>
                          <!-- detail -->

                          <?php if ($this->session->userdata('id_role') == 1 OR $this->session->userdata('id_role') == 5 OR $this->session->userdata('id_role') == 13): ?>

                          <?php if ($t['submit'] != 1): ?>

                            <a href="<?= base_url('transmittal/submit/').$t['id_transmittal'] ?>" class="dropdown-item" onclick="return confirm('Transmittal yang sudah di submit tidak bisa diubah lagi. Yakin akan melakukan submit?')">Submit</a>

                            <?php else: ?>

                              <a target="_blank" href="<?= base_url('Pdftransmittal/index/').$t['id_transmittal'].'/'.$t['no_order'] ?>" class="dropdown-item">Cetak</a>                              

                            <?php endif ?>

                            <!-- hapus -->
                            <a href="<?= base_url('transmittal/hapus/') . $t['id_transmittal'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                            <!-- hapus -->

                          <?php endif ?>

                        </div>
                      </div>


                    </td>
                    <!-- aksi -->

                  </tr>

                <?php endif ?>

                <?php $no++ ?>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- end tabel transmittal -->

  </div>
</section>
<!-- content -->

</div>
<!-- halaman -->

<!-- content -->



