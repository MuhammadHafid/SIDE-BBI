<?php
$CI = &get_instance();
$CI->load->library('secure');
?>
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

            <!-- tabel order -->
            <div class="row" style="margin-bottom: 75px;">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="table-responsive">
                        <table id="datatable" class="table table-sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Order</th>
                                    <th>Customer</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($order as $o) : ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $o['id_cc_ord']; ?></td>
                                        <td><?= $o['nama_cc_ord']; ?></td>
                                        <td>
                                            <?php $encrypt_id = $CI->secure->encrypt_url($o['id_cc_ord']); ?>
                                            <a target="_blank" href="<?= base_url('order/dokumen/') . $encrypt_id ?>" class="badge badge-dark"><i class="far fa-file"></i> Dokumen</a>
                                        </td>
                                    </tr>

                                    <?php $no++ ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- end tabel order -->

        </div>
    </section>
    <!-- content -->

</div>
<!-- halaman -->

<!-- content -->