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

        <!-- tabel viewer -->
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="table-responsive">
              <table id="datatable" class="table table-sm table-striped table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama Karyawan</th>
                    <th>Bagian</th>
                    <th>Dilihat</th>                    
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($viewer as $v): ?>

                    <!-- ambil user where nik -->
                    <?php 
                    $this->db->select('a.*, b.nama_role, c.nama_karyawan');
                    $this->db->from('sdo.user a');
                    $this->db->join('sdo.role b','b.id_role = a.id_role', 'left');
                    $this->db->join('keuangan.karyawan c','c.nik = a.nik', 'left');   
                    $this->db->where('a.nik =', $v['nik']);
                    $user = $this->db->get()->row_array();
                    ?>

                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $v['nik']; ?></td>
                      <td><?= $user['nama_karyawan']; ?></td>
                      <td><?= $user['nama_role']; ?></td>
                      <td><?= $v['tgl_view']; ?></td>
                    </tr>

                    <?php $no++ ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
        <!-- end tabel viewer -->

      </div>
    </section>
    <!-- content -->

  </div>
  <!-- halaman -->

  <!-- content -->