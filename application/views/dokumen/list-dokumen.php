<!-- content -->
<!-- halaman -->
<div class="content-wrapper">
    <!-- judul -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0 text-center">List Dokumen</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- judul -->
    <!-- alert -->
    <?=
    $this->session->flashdata('messageListDokumen');
    ?>
    <!-- end alert -->
    <!-- content -->
    <section class="content">
        <div class="container-fluid">
            <!-- list dokumen (valid) -->
            <div class="card">
                <div class="card-header text-center h5" style="background-color: #e3e2de;">
                    <b>Update Dokumen Ter-Upload</b>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-2 col-md-2">
                            <select name="forma" class="col-lg-12 col-md-12 col-sm-12 col-xs-4 form-control" onchange="location = this.value;">
                                <option value="">Pilih Dokumen</option>
                                <option value="<?= base_url('order/namaDokumen/spk') ?>">SPK</option>
                                <option value="<?= base_url('order/namaDokumen/mscurve') ?>">Master Schedule 'S' Curve</option>
                                <option value="<?= base_url('order/namaDokumen/ps') ?>">Production Schedule</option>
                                <option value="<?= base_url('order/namaDokumen/drawing') ?>">Drawing</option>
                                <option value="<?= base_url('order/namaDokumen/bq') ?>">BQ</option>
                                <option value="<?= base_url('order/namaDokumen/eis') ?>">EIS</option>
                                <option value="<?= base_url('order/namaDokumen/mp') ?>">MP</option>
                                <option value="<?= base_url('order/namaDokumen/clo') ?>">CLO</option>
                                <option value="<?= base_url('order/namaDokumen/mrs') ?>">MRS</option>
                                <option value="<?= base_url('order/namaDokumen/pr') ?>">Purchase Requisition Sheet</option>
                                <option value="<?= base_url('order/namaDokumen/imr') ?>">Inspection Material Request for Stock</option>
                                <option value="<?= base_url('order/namaDokumen/po') ?>">Purchase Order</option>
                                <option value="<?= base_url('order/namaDokumen/it') ?>">IT Plan</option>
                                <option value="<?= base_url('order/namaDokumen/anrm') ?>">Acceptance Notice Raw Material</option>
                                <option value="<?= base_url('order/namaDokumen/ancm') ?>">Acceptance Notice Consumable Material</option>
                                <option value="<?= base_url('order/namaDokumen/ansm') ?>">Acceptance Notice Stock Material</option>
                                <option value="<?= base_url('order/namaDokumen/ncr') ?>">NCR</option>
                                <option value="<?= base_url('order/namaDokumen/pcm') ?>">Permintaan Certificate Material</option>
                                <option value="<?= base_url('order/namaDokumen/ipm') ?>">Info Pengajuan Material</option>
                                <option value="<?= base_url('order/namaDokumen/ndeo') ?>">NDE Operator Qualification</option>
                                <option value="<?= base_url('order/namaDokumen/ndep') ?>">NDE Procedure</option>
                                <option value="<?= base_url('order/namaDokumen/loc') ?>">List Of Calibration Equipment</option>
                            </select>
                        </div>
                    </div>
                    <!-- tabel dokumen drawing -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="table-responsive">
                                <table id="datatable" class="table table-sm table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Dokumen</th>
                                            <th>Nama Dokumen</th>
                                            <th>Tanggal</th>
                                            <th>Order</th>
                                            <th>Status</th>
                                            <th>Edisi</th>
                                            <th>Revisi</th>
                                            <th>No. SP</th>
                                            <th>Valid</th>
                                            <th>Dokumen</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <!-- dokumen drawing -->
                                        <?php foreach ($dokumen_drawing as $dd) : ?>
                                            <tr>
                                                <td style="font-size: 14px;"><?= $no ?></td>
                                                <td style="font-size: 14px;"><?= $dd['no_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $dd['nama_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $dd['tgl_dokumen']; ?></td>
                                                <td style="font-size: 14px; text-align: center"><?= $dd['no_order'] ?></td>
                                                <td style="font-size: 14px;"><?= $dd['nama_status']; ?></td>
                                                <td style="font-size: 14px;"><?= $dd['nama_edisi']; ?></td>
                                                <td style="font-size: 14px;"><?= $dd['nama_revisi']; ?></td>
                                                <?php
                                                $string = explode("/", $dd['no_sp'], 2);
                                                $no_sp = $string[0];
                                                ?>
                                                <!-- no sp -->
                                                <td style="font-size: 14px;"><?= $no_sp; ?></td>
                                                <!-- no sp -->
                                                <!-- status valid -->
                                                <?php if ($dd['status'] == 1) : ?>
                                                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                                                <?php endif ?>
                                                <?php if ($dd['status'] == 0) : ?>
                                                    <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                                                <?php endif ?>
                                                <!-- status valid -->
                                                <!-- jenis dokumen -->
                                                <td style="font-size: 14px; text-align: center">Drawing</td>
                                                <!-- jenis dokumen -->
                                                <!-- Aksi -->
                                                <td>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <?php if ($dd['no_sp'] == NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/view/') . $dd['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('drawing/edit/') . $dd['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#edrawing' . $dd['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($dd['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/revisi/') . $dd['kode_unik'] . '/' . $dd['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('drawing/hapus/') . $dd['id_dokumen'] . '/' . $dd['no_order'] . '/' . $dd['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($dd['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/history/') . $dd['kode_unik'] . '/' . $dd['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <!-- jika sudah transmit bisa lihat semua -->
                                                    <?php if ($dd['no_sp'] != NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/view/') . $dd['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('drawing/edit/') . $dd['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#edrawing' . $dd['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($dd['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/revisi/') . $dd['kode_unik'] . '/' . $dd['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('drawing/hapus/') . $dd['id_dokumen'] . '/' . $dd['no_order'] . '/' . $dd['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($dd['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('drawing/history/') . $dd['kode_unik'] . '/' . $dd['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                </td>
                                                <!-- aksi -->

                                            </tr>
                                            <?php $no++ ?>
                                        <?php endforeach ?>
                                        <!-- dokumen drawing -->
                                        <!-- dokumen bq -->
                                        <?php foreach ($dokumen_bq as $db) : ?>
                                            <tr>
                                                <td style="font-size: 14px;"><?= $no ?></td>
                                                <td style="font-size: 14px;"><?= $db['no_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $db['nama_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $db['tgl_dokumen']; ?></td>
                                                <td style="font-size: 14px; text-align: center"><?= $db['no_order'] ?></td>
                                                <td style="font-size: 14px;"><?= $db['nama_status']; ?></td>
                                                <td style="font-size: 14px;"><?= $db['nama_edisi']; ?></td>
                                                <td style="font-size: 14px;"><?= $db['nama_revisi']; ?></td>
                                                <?php
                                                $string = explode("/", $db['no_sp'], 2);
                                                $no_sp = $string[0];
                                                ?>
                                                <!-- no sp -->
                                                <td style="font-size: 14px;"><?= $no_sp; ?></td>
                                                <!-- no sp -->
                                                <!-- status valid -->
                                                <?php if ($db['status'] == 1) : ?>
                                                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                                                <?php endif ?>
                                                <?php if ($db['status'] == 0) : ?>
                                                    <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                                                <?php endif ?>
                                                <!-- status valid -->
                                                <!-- jenis dokumen -->
                                                <td style="font-size: 14px; text-align: center">BQ</td>
                                                <!-- jenis dokumen -->
                                                <!-- Aksi -->
                                                <td>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <?php if ($db['no_sp'] == NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('bq/view/') . $db['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('bq/edit/') . $db['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#ebq' . $db['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($db['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('bq/revisi/') . $db['kode_unik'] . '/' . $db['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('bq/hapus/') . $db['id_dokumen'] . '/' . $db['no_order'] . '/' . $db['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($db['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('bq/history/') . $db['kode_unik'] . '/' . $db['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <!-- jika sudah transmit bisa lihat semua -->
                                                    <?php if ($db['no_sp'] != NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('bq/view/') . $db['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('bq/edit/') . $db['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#ebq' . $db['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($db['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('bq/revisi/') . $db['kode_unik'] . '/' . $db['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('bq/hapus/') . $db['id_dokumen'] . '/' . $db['no_order'] . '/' . $db['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($db['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('bq/history/') . $db['kode_unik'] . '/' . $db['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                </td>
                                                <!-- aksi -->
                                            </tr>
                                            <?php $no++ ?>
                                        <?php endforeach ?>
                                        <!-- dokumen drawing -->
                                        <!-- dokumen eis -->
                                        <?php foreach ($dokumen_eis as $de) : ?>
                                            <tr>
                                                <td style="font-size: 14px;"><?= $no ?></td>
                                                <td style="font-size: 14px;"><?= $de['no_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $de['nama_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $de['tgl_dokumen']; ?></td>
                                                <td style="font-size: 14px; text-align: center"><?= $de['no_order'] ?></td>
                                                <td style="font-size: 14px;"><?= $de['nama_status']; ?></td>
                                                <td style="font-size: 14px;"><?= $de['nama_edisi']; ?></td>
                                                <td style="font-size: 14px;"><?= $de['nama_revisi']; ?></td>
                                                <?php
                                                $string = explode("/", $de['no_sp'], 2);
                                                $no_sp = $string[0];
                                                ?>
                                                <!-- no sp -->
                                                <td style="font-size: 14px;"><?= $no_sp; ?></td>
                                                <!-- no sp -->
                                                <!-- status valid -->
                                                <?php if ($de['status'] == 1) : ?>
                                                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                                                <?php endif ?>
                                                <?php if ($de['status'] == 0) : ?>
                                                    <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                                                <?php endif ?>
                                                <!-- status valid -->
                                                <!-- jenis dokumen -->
                                                <td style="font-size: 14px; text-align: center">EIS</td>
                                                <!-- jenis dokumen -->
                                                <!-- Aksi -->
                                                <td>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <?php if ($de['no_sp'] == NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('eis/view/') . $de['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('eis/edit/') . $de['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eeis' . $de['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($de['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('eis/revisi/') . $de['kode_unik'] . '/' . $de['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('eis/hapus/') . $de['id_dokumen'] . '/' . $de['no_order'] . '/' . $de['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($de['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('eis/history/') . $de['kode_unik'] . '/' . $de['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <!-- jika sudah transmit bisa lihat semua -->
                                                    <?php if ($de['no_sp'] != NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('eis/view/') . $de['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('eis/edit/') . $de['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eeis' . $de['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($de['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('eis/revisi/') . $de['kode_unik'] . '/' . $de['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('eis/hapus/') . $de['id_dokumen'] . '/' . $de['no_order'] . '/' . $de['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($de['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('eis/history/') . $de['kode_unik'] . '/' . $de['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                </td>
                                                <!-- aksi -->
                                            </tr>
                                            <?php $no++ ?>
                                        <?php endforeach ?>
                                        <!-- dokumen eis -->
                                        <!-- dokumen mp -->
                                        <?php foreach ($dokumen_mp as $dm) : ?>
                                            <tr>
                                                <td style="font-size: 14px;"><?= $no ?></td>
                                                <td style="font-size: 14px;"><?= $dm['no_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $dm['nama_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $dm['tgl_dokumen']; ?></td>
                                                <td style="font-size: 14px; text-align: center"><?= $dm['no_order'] ?></td>
                                                <td style="font-size: 14px;"><?= $dm['nama_status']; ?></td>
                                                <td style="font-size: 14px;"><?= $dm['nama_edisi']; ?></td>
                                                <td style="font-size: 14px;"><?= $dm['nama_revisi']; ?></td>
                                                <?php
                                                $string = explode("/", $dm['no_sp'], 2);
                                                $no_sp = $string[0];
                                                ?>
                                                <!-- no sp -->
                                                <td style="font-size: 14px;"><?= $no_sp; ?></td>
                                                <!-- no sp -->
                                                <!-- status valid -->
                                                <?php if ($dm['status'] == 1) : ?>
                                                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                                                <?php endif ?>
                                                <?php if ($dm['status'] == 0) : ?>
                                                    <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                                                <?php endif ?>
                                                <!-- status valid -->
                                                <!-- jenis dokumen -->
                                                <td style="font-size: 14px; text-align: center">MP</td>
                                                <!-- jenis dokumen -->
                                                <!-- Aksi -->
                                                <td>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <?php if ($dm['no_sp'] == NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('mp/view/') . $dm['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('mp/edit/') . $dm['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eeis' . $dm['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($dm['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('mp/revisi/') . $dm['kode_unik'] . '/' . $dm['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('mp/hapus/') . $dm['id_dokumen'] . '/' . $dm['no_order'] . '/' . $dm['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($dm['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('mp/history/') . $dm['kode_unik'] . '/' . $dm['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <!-- jika sudah transmit bisa lihat semua -->
                                                    <?php if ($dm['no_sp'] != NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('mp/view/') . $dm['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('mp/edit/') . $dm['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#emp' . $dm['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($dm['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('mp/revisi/') . $dm['kode_unik'] . '/' . $dm['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('mp/hapus/') . $dm['id_dokumen'] . '/' . $dm['no_order'] . '/' . $dm['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($dm['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('mp/history/') . $dm['kode_unik'] . '/' . $dm['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                </td>
                                                <!-- aksi -->
                                            </tr>
                                            <?php $no++ ?>
                                        <?php endforeach ?>
                                        <!-- dokumen mp -->
                                        <!-- dokumen clo -->
                                        <?php foreach ($dokumen_clo as $dc) : ?>
                                            <tr>
                                                <td style="font-size: 14px;"><?= $no ?></td>
                                                <td style="font-size: 14px;"><?= $dc['no_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $dc['nama_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $dc['tgl_dokumen']; ?></td>
                                                <td style="font-size: 14px; text-align: center"><?= $dc['no_order'] ?></td>
                                                <td style="font-size: 14px;"><?= $dc['nama_status']; ?></td>
                                                <td style="font-size: 14px;"><?= $dc['nama_edisi']; ?></td>
                                                <td style="font-size: 14px;"><?= $dc['nama_revisi']; ?></td>
                                                <?php
                                                $string = explode("/", $dc['no_sp'], 2);
                                                $no_sp = $string[0];
                                                ?>
                                                <!-- no sp -->
                                                <td style="font-size: 14px;"><?= $no_sp; ?></td>
                                                <!-- no sp -->
                                                <!-- status valid -->
                                                <?php if ($dc['status'] == 1) : ?>
                                                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                                                <?php endif ?>
                                                <?php if ($dc['status'] == 0) : ?>
                                                    <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                                                <?php endif ?>
                                                <!-- status valid -->
                                                <!-- jenis dokumen -->
                                                <td style="font-size: 14px; text-align: center">CLO</td>
                                                <!-- jenis dokumen -->
                                                <!-- Aksi -->
                                                <td>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <?php if ($dc['no_sp'] == NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('clo/view/') . $dc['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('clo/edit/') . $dc['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eclo' . $dm['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($dc['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('clo/revisi/') . $dc['kode_unik'] . '/' . $dc['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('clo/hapus/') . $dc['id_dokumen'] . '/' . $dc['no_order'] . '/' . $dc['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($dc['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('clo/history/') . $dc['kode_unik'] . '/' . $dc['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <!-- jika sudah transmit bisa lihat semua -->
                                                    <?php if ($dc['no_sp'] != NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('clo/view/') . $dc['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('clo/edit/') . $dc['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#eclo' . $dc['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($dc['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('clo/revisi/') . $dc['kode_unik'] . '/' . $dc['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('clo/hapus/') . $dc['id_dokumen'] . '/' . $dc['no_order'] . '/' . $dc['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($dc['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('clo/history/') . $dc['kode_unik'] . '/' . $dc['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                </td>
                                                <!-- aksi -->
                                            </tr>
                                            <?php $no++ ?>
                                        <?php endforeach ?>
                                        <!-- dokumen clo -->
                                        <!-- dokumen mrs -->
                                        <?php foreach ($dokumen_mrs as $dm) : ?>
                                            <tr>
                                                <td style="font-size: 14px;"><?= $no ?></td>
                                                <td style="font-size: 14px;"><?= $dm['no_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $dm['nama_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $dm['tgl_dokumen']; ?></td>
                                                <td style="font-size: 14px; text-align: center"><?= $dm['no_order'] ?></td>
                                                <td style="font-size: 14px;"><?= $dm['nama_status']; ?></td>
                                                <td style="font-size: 14px;"><?= $dm['nama_edisi']; ?></td>
                                                <td style="font-size: 14px;"><?= $dm['nama_revisi']; ?></td>
                                                <?php
                                                $string = explode("/", $dm['no_sp'], 2);
                                                $no_sp = $string[0];
                                                ?>
                                                <!-- no sp -->
                                                <td style="font-size: 14px;"><?= $no_sp; ?></td>
                                                <!-- no sp -->
                                                <!-- status valid -->
                                                <?php if ($dm['status'] == 1) : ?>
                                                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                                                <?php endif ?>
                                                <?php if ($dm['status'] == 0) : ?>
                                                    <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                                                <?php endif ?>
                                                <!-- status valid -->
                                                <!-- jenis dokumen -->
                                                <td style="font-size: 14px; text-align: center">MRS</td>
                                                <!-- jenis dokumen -->
                                                <!-- Aksi -->
                                                <td>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <?php if ($dm['no_sp'] == NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/view/') . $dm['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('mrs/edit/') . $dm['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#emrs' . $dm['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($dm['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/revisi/') . $dm['kode_unik'] . '/' . $dm['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('mrs/hapus/') . $dm['id_dokumen'] . '/' . $dm['no_order'] . '/' . $dm['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($dm['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/history/') . $dm['kode_unik'] . '/' . $dm['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <!-- jika sudah transmit bisa lihat semua -->
                                                    <?php if ($dm['no_sp'] != NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/view/') . $dm['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('mrs/edit/') . $dm['id_dokumen']; ?>" data-toggle="modal" data-target="<?= '#emrs' . $dm['id_dokumen'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($dm['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/revisi/') . $dm['kode_unik'] . '/' . $dm['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('mrs/hapus/') . $dm['id_dokumen'] . '/' . $dm['no_order'] . '/' . $dm['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($dm['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('mrs/history/') . $dm['kode_unik'] . '/' . $dm['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                </td>
                                                <!-- aksi -->
                                            </tr>
                                            <?php $no++ ?>
                                        <?php endforeach ?>
                                        <!-- dokumen mrs -->
                                        <!-- dokumen spk -->
                                        <?php foreach ($dokumen_spk as $ds) : ?>
                                            <tr>
                                                <td style="font-size: 14px;"><?= $no ?></td>
                                                <td style="font-size: 14px;"><?= $ds['no_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $ds['nama_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $ds['tgl_dokumen']; ?></td>
                                                <td style="font-size: 14px; text-align: center"><?= $ds['no_order'] ?></td>
                                                <td style="font-size: 14px;"><?= $ds['nama_status']; ?></td>
                                                <td style="font-size: 14px;"><?= $ds['nama_edisi']; ?></td>
                                                <td style="font-size: 14px;"><?= $ds['nama_revisi']; ?></td>
                                                <?php
                                                $string = explode("/", $ds['no_sp'], 2);
                                                $no_sp = $string[0];
                                                ?>
                                                <!-- no sp -->
                                                <td style="font-size: 14px;"><?= $no_sp; ?></td>
                                                <!-- no sp -->
                                                <!-- status valid -->
                                                <?php if ($ds['status'] == 1) : ?>
                                                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                                                <?php endif ?>
                                                <?php if ($ds['status'] == 0) : ?>
                                                    <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                                                <?php endif ?>
                                                <!-- status valid -->
                                                <!-- jenis dokumen -->
                                                <td style="font-size: 14px; text-align: center">SPK</td>
                                                <!-- jenis dokumen -->
                                                <!-- Aksi -->
                                                <td>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <?php if ($ds['no_sp'] == NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('spk/view/') . $ds['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('spk/edit/') . $ds['id']; ?>" data-toggle="modal" data-target="<?= '#espk' . $ds['id'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($ds['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('spk/revisi/') . $ds['kode_unik'] . '/' . $ds['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('spk/hapus/') . $ds['id'] . '/' . $ds['no_order'] . '/' . $ds['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($ds['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('spk/history/') . $ds['kode_unik'] . '/' . $ds['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                    <!-- jika sudah transmit bisa lihat semua -->
                                                    <?php if ($ds['no_sp'] != NULL) : ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Pilih
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <!-- view -->
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('spk/view/') . $ds['nama_file'] ?>">View</a>
                                                                <!-- view -->
                                                                <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                    <!-- edit -->
                                                                    <a class="dropdown-item" href="<?= base_url('spk/edit/') . $ds['id']; ?>" data-toggle="modal" data-target="<?= '#espk' . $ds['id'] ?>">Edit</a>
                                                                    <!-- edit -->
                                                                    <!-- revisi -->
                                                                    <?php if ($ds['status'] == 1) : ?>
                                                                        <a class="dropdown-item" target="_blank" href="<?= base_url('spk/revisi/') . $ds['kode_unik'] . '/' . $ds['no_order']; ?>">Revisi</a>
                                                                    <?php endif ?>
                                                                    <!-- revisi -->
                                                                    <!-- hapus -->
                                                                    <a href="<?= base_url('spk/hapus/') . $ds['id'] . '/' . $ds['no_order'] . '/' . $ds['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                    <!-- hapus -->
                                                                <?php endif ?>
                                                                <!-- history -->
                                                                <?php if ($ds['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('spk/history/') . $ds['kode_unik'] . '/' . $ds['no_order']; ?>">History</a>
                                                                <?php endif ?>
                                                                <!-- history -->
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    <!-- jika belum transmit admin bisa lihat -->
                                                </td>
                                                <!-- aksi -->
                                            </tr>
                                            <?php $no++ ?>
                                        <?php endforeach ?>
                                        <!-- dokumen spk -->
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- list dokumen (valid) -->










                    <div style="margin-bottom: 100px;"></div>

                </div>
    </section>
    <!-- content -->

</div>
<!-- halaman -->

<!-- content -->