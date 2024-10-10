    <!-- sidebar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a style="text-align: center; font-size: 18px; color: #fff;" href="<?= base_url('dashboard'); ?>" class="brand-link">
        <!-- <i class="fas fa-store"></i> -->
        <img style="width: 40px; height: 40px; margin-top: 0; padding-top: 0; margin-bottom: 10px;" src="<?= base_url('assets/img/logo bbi/bbi.png') ?>">
        <span style="font-size: 30px;" class="font-weight-bold">SIDE-BBI</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

         <!--   <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li> -->

          <?php 
          // cek 'id_role' dari session
          $id_role = $this->session->userdata('id_role');

          // ambil menu
          $this->db->select('*');
          $this->db->from('menu');
          $this->db->order_by('nama_menu','ASC');
          $menu = $this->db->get()->result_array();
          ?>


          <!-- looping menu -->
          <?php foreach ($menu as $m): ?>

            <!-- cek menu dengan role_akses -->
            <?php 
            $this->db->select('*');
            $this->db->from('role_akses');
            $this->db->where('id_role =', $id_role);
            $this->db->where('id_menu =', $m['id_menu']);
            $cekRole = $this->db->get()->num_rows();
            ?>

            <!-- jika role nya ada -->
            <?php if ($cekRole == 1): ?>

              <!-- cek ketersediaan submenu berdasarkan 'id_menu' -->
              <?php 
              $this->db->select('*');
              $this->db->from('submenu');
              $this->db->where('id_menu =', $m['id_menu']);
              $cekSub = $this->db->get()->num_rows();

              // ambil submenu berdasarkan 'id_menu'
              $this->db->select('*');
              $this->db->from('submenu');
              $this->db->where('id_menu =', $m['id_menu']);
              $submenu = $this->db->get()->result_array();
              ?>

              <!-- jika ada submenu -->
              <?php if ($cekSub != 0): ?>

                <!-- cek apakah ada submenu dari menu yang memiliki nama = title -->
                <?php 
                $this->db->select('*');
                $this->db->from('submenu');
                $this->db->where('id_menu =', $m['id_menu']);
                $this->db->where('nama_submenu =', $title);
                $csm = $this->db->get()->num_rows();                
                ?>

                <?php if ($csm == 1): ?>
                  <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                      <?php else: ?>
                        <li class="nav-item">
                          <a href="#" class="nav-link">                      
                          <?php endif ?>

                          <i class="nav-icon fas fa-th"></i>
                          <p>
                            <?= $m['nama_menu'] ?>
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <!-- looping submenu -->
                          <?php foreach ($submenu as $sm): ?>
                            <li class="nav-item">
                              <?php if ($title == $sm['nama_submenu']): ?>
                                <a href="<?= base_url($sm['url_submenu']) ?>" class="nav-link active">
                                  <?php else: ?>
                                    <a href="<?= base_url($sm['url_submenu']) ?>" class="nav-link">
                                    <?php endif ?>
                                    <i class="far fa-circle nav-icon"></i>
                                    <p><?= $sm['nama_submenu'] ?></p>
                                  </a>
                                </li>
                              <?php endforeach ?>
                              <!-- end looping submenu -->
                            </ul>
                          </li>

                          <!-- jika tidak ada submenu -->
                          <?php else: ?>  

                            <li class="nav-item">
                              <?php if ($title == $m['nama_menu']): ?>
                                <a href="<?= base_url($m['url_menu']) ?>" class="nav-link active">
                                  <?php else: ?>
                                    <a href="<?= base_url($m['url_menu']) ?>" class="nav-link">                          
                                    <?php endif ?>
                                    <i class="<?= 'nav-icon '.$m['icon_menu'] ?>"></i>
                                    <p>
                                      <?= $m['nama_menu'] ?>
                                    </p>
                                  </a>
                                </li>

                              <?php endif ?>

                            <?php endif ?>

                          <?php endforeach ?>
                          <!-- end looping menu -->





                          <!-- <li class="nav-item menu-open"> -->
                      <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                            Menu 2
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="./index.html" class="nav-link active">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Submenu 1</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="./index2.html" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Submenu 2</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="./index3.html" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Submenu 3</p>
                            </a>
                          </li>
                        </ul>
                      </li> -->




                    </ul>
                  </nav>
                  <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
              </aside>

  <!-- sidebar -->