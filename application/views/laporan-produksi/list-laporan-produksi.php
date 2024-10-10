<!-- content -->
<!-- halaman -->
<div class="content-wrapper">
    <!-- content -->
    <section class="content">
        <div class="container-fluid">

            <!-- laporan produksi -->
            <div class="card">
                <div class="card-header text-center h5" style="background-color: #e3e2de;">
                    <b><?= $title ?></b>
                </div>
                <div class="card-body">

                    <!-- alert -->
                    <?= $this->session->flashdata('messageLapprod'); ?>
                    <!-- end alert -->

                    <!-- tabel laporan produksi -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-sm table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Dokumen</th>
                                            <th>Nama Dokumen</th>
                                            <th>Divisi</th>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Tgl. Pembuatan</th>
                                            <th>Edisi</th>
                                            <th>Revisi</th>
                                            <th>Valid</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($laporan_produk as $lp) : ?>
                                            <tr>
                                                <td style="font-size: 14px;"><?= $no ?></td>
                                                <td style="font-size: 14px;"><?= $lp['no_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $lp['nama_dokumen']; ?></td>
                                                <td style="font-size: 14px;"><?= $lp['divisi']; ?></td>
                                                <?php if ($lp['bulan'] == '01') { ?>
                                                    <td style="font-size: 14px;">Januari</td>
                                                <?php } ?>
                                                <?php if ($lp['bulan'] == '02') { ?>
                                                    <td style="font-size: 14px;">Februari</td>
                                                <?php } ?>
                                                <?php if ($lp['bulan'] == '03') { ?>
                                                    <td style="font-size: 14px;">Maret</td>
                                                <?php } ?>
                                                <?php if ($lp['bulan'] == '04') { ?>
                                                    <td style="font-size: 14px;">April</td>
                                                <?php } ?>
                                                <?php if ($lp['bulan'] == '05') { ?>
                                                    <td style="font-size: 14px;">Mei</td>
                                                <?php } ?>
                                                <?php if ($lp['bulan'] == '06') { ?>
                                                    <td style="font-size: 14px;">Juni</td>
                                                <?php } ?>
                                                <?php if ($lp['bulan'] == '07') { ?>
                                                    <td style="font-size: 14px;">Juli</td>
                                                <?php } ?>
                                                <?php if ($lp['bulan'] == '08') { ?>
                                                    <td style="font-size: 14px;">Agustus</td>
                                                <?php } ?>
                                                <?php if ($lp['bulan'] == '09') { ?>
                                                    <td style="font-size: 14px;">September</td>
                                                <?php } ?>
                                                <?php if ($lp['bulan'] == '10') { ?>
                                                    <td style="font-size: 14px;">Oktober</td>
                                                <?php } ?>
                                                <?php if ($lp['bulan'] == '11') { ?>
                                                    <td style="font-size: 14px;">November</td>
                                                <?php } ?>
                                                <?php if ($lp['bulan'] == '12') { ?>
                                                    <td style="font-size: 14px;">Desember</td>
                                                <?php } ?>
                                                <td style="font-size: 14px;"><?= $lp['tahun']; ?></td>
                                                <td style="font-size: 14px;"><?= $lp['tgl_pembuatan']; ?></td>
                                                <td style="font-size: 14px;"><?= $lp['nama_edisi']; ?></td>
                                                <td style="font-size: 14px;"><?= $lp['nama_revisi']; ?></td>
                                                <!-- status valid -->
                                                <?php if ($lp['status'] == 1) : ?>
                                                    <td class="text-center"><i style="color: green; font-weight: bold;" class="far fa-check-circle"></i></td>
                                                <?php endif ?>
                                                <?php if ($lp['status'] == 0) : ?>
                                                    <td class="text-center"><i style="color: red; font-weight: bold;" class="far fa-times-circle"></i></td>
                                                <?php endif ?>
                                                <!-- status valid -->
                                                <!-- Aksi -->
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Pilih
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <!-- view -->
                                                            <a class="dropdown-item" target="_blank" href="<?= base_url('lapprod/view/') . $lp['nama_file'] ?>">View</a>
                                                            <!-- view -->
                                                            <?php if ($this->session->userdata('id_role') == 1 or $this->session->userdata('id_role') == 5 or $this->session->userdata('id_role') == 13) : ?>
                                                                <!-- edit -->
                                                                <a class="dropdown-item" href="<?= base_url('lapprod/edit/') . $lp['kode_unik'] ?>">Edit</a>
                                                                <!-- edit -->
                                                                <!-- revisi -->
                                                                <?php if ($lp['status'] == 1) : ?>
                                                                    <a class="dropdown-item" target="_blank" href="<?= base_url('lapprod/revisi/') . $lp['kode_unik'] ?>">Revisi</a>
                                                                <?php endif ?>
                                                                <!-- revisi -->
                                                                <!-- hapus -->
                                                                <a href="<?= base_url('lapprod/hapus/') . $lp['id'] . '/' . $lp['nama_file'] ?>" class="dropdown-item" onclick="return confirm('Yakin akan menghapus ini?')">Hapus</a>
                                                                <!-- hapus -->
                                                            <?php endif ?>
                                                            <!-- history -->
                                                            <?php if ($lp['status'] == 1) : ?>
                                                                <a class="dropdown-item" target="_blank" href="<?= base_url('lapprod/history/') . $lp['kode_unik'] ?>">History</a>
                                                            <?php endif ?>
                                                            <!-- history -->
                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- aksi -->
                                            </tr>
                                            <!-- modal edit dokumen drawing -->
                                            <div class="modal hide fade" id="<?= 'edrawing' . $lp['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="edrawing" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                                                            <div class="col text-center">
                                                                <h5 class="modal-title" id="edrawing">Edit Laporan Produksi</h5>
                                                            </div>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="<?= base_url('drawing/edit/') . $lp['id'] ?>" method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <div class="container-fluid">
                                                                    <div class="row mb-2">
                                                                        <label class="col-lg-12 col-md-12 col-sm-12" for="no_dokumen">No. Dokumen</label>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                                            <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen" value="<?= $lp['no_dokumen'] ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <label class="col-lg-12 col-md-12 col-sm-12" for="nama_dokumen">Nama Dokumen</label>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                                            <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen" value="<?= $lp['nama_dokumen'] ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <label class="col-lg-12 col-md-12 col-sm-12" for="tgl_dokumen">Tgl Dokumen</label>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                                            <input type="date" id="tgl_dokumen" name="tgl_dokumen" required="required" class="form-control" value="<?= $lp['tgl_pembuatan'] ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <label class="col-lg-12 col-md-12 col-sm-12" for="revisi">Revisi</label>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                                            <select name="revisi" id="revisi" class="form-control" required>
                                                                                <option value="<?= $lp['revisi'] ?>"><?= $lp['nama_revisi'] ?></option>
                                                                                <?php foreach ($revisi as $r) : ?>
                                                                                    <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                                                                                <?php endforeach ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <label class="col-lg-12 col-md-12 col-sm-12" for="edisi">Edisi</label>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                                            <select name="edisi" id="edisi" class="form-control" required>
                                                                                <option value="<?= $lp['edisi'] ?>"><?= $lp['nama_edisi'] ?></option>
                                                                                <?php foreach ($edisi as $e) : ?>
                                                                                    <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option>
                                                                                <?php endforeach ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <label class="col-lg-12 col-md-12 col-sm-12" for="issue_sheet">Valid</label>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                                            <select name="status" id="status" class="form-control">
                                                                                <?php if ($lp['status'] == 1) : ?>
                                                                                    <option value="<?= $lp['status'] ?>">Valid</option>
                                                                                <?php endif ?>
                                                                                <?php if ($lp['status'] == 0) : ?>
                                                                                    <option value="<?= $lp['status_dokumen'] ?>">Tidak Valid</option>
                                                                                <?php endif ?>
                                                                                <option value="1">Valid</option>
                                                                                <option value="0">Tidak Valid</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <label class="col-lg-12 col-md-12 col-sm-12" for="file_drawing">File</label>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                                            <input type="file" name="file_drawing" id="file_drawing" class="form-control" placeholder="File Dokumen (Format pdf / xlsx)">
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
                                            <!-- modal edit dokumen drawing -->
                                            <?php $no++ ?>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- tabel laporan produksi -->
                    <!-- tambah laporan produksi -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#lapprod">
                                <i class="fa fa-plus"></i> Laporan Produksi
                            </button>
                        </div>
                    </div>
                    <!-- modal tambah laporan produksi -->
                    <div class="modal fade" id="lapprod" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #2A3F54; color: #fff;">
                                    <div class="col text-center">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Laporan Produksi</h5>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('lapprod/tambah/') ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <input required name="no_dokumen" id="no_dokumen" class="form-control" type="text" placeholder="No Dokumen">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <input required name="nama_dokumen" id="nama_dokumen" class="form-control" type="text" placeholder="Nama Dokumen">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <input required name="divisi" id="divisi" class="form-control" type="text" placeholder="Divisi">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <select name="bulan" id="bulan" class="form-control" required>
                                                        <option value="">Bulan</option>
                                                        <option value="01">Januari</option>
                                                        <option value="02">Februari</option>
                                                        <option value="03">Maret</option>
                                                        <option value="04">April</option>
                                                        <option value="05">Mei</option>
                                                        <option value="06">Juni</option>
                                                        <option value="07">Juli</option>
                                                        <option value="08">Agustus</option>
                                                        <option value="09">September</option>
                                                        <option value="10">Oktober</option>
                                                        <option value="11">November</option>
                                                        <option value="12">Desember</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- tentukan tahun sekarang dan sebelumnya -->
                                            <?php
                                            $tahun_sekarang = date('Y');
                                            $tahun_kemarin = date('Y') - 1;
                                            ?>
                                            <!-- tentukan tahun sekarang dan sebelumnya -->
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <select name="tahun" id="tahun" class="form-control" required>
                                                        <option value="">Tahun</option>
                                                        <option value="<?= $tahun_sekarang ?>"><?= $tahun_sekarang ?></option>
                                                        <option value="<?= $tahun_kemarin ?>"><?= $tahun_kemarin ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <input type="text" id="tgl_pembuatan" name="tgl_pembuatan" required="required" class="form-control" placeholder="Tgl Pembuatan" onfocus="(this.type='date')">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <select name="edisi" id="edisi" class="form-control" required>
                                                        <option value="">Edisi</option>
                                                        <?php foreach ($edisi as $e) : ?>
                                                            <option value="<?= $e['id_edisi'] ?>"><?= $e['nama_edisi'] ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <select name="revisi" id="revisi" class="form-control" required>
                                                        <option value="">Revisi</option>
                                                        <?php foreach ($revisi as $r) : ?>
                                                            <option value="<?= $r['id_revisi'] ?>"><?= $r['nama_revisi'] ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <input required name="file_laporan" id="file_laporan" class="form-control" type="text" onfocus="(this.type='file')" placeholder="File dokumen (Format pdf / xlsx)" required>
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
                    <!-- modal tambah laporan produksi -->
                    <!-- tambah laporan produksi -->
                </div>
            </div>
            <!-- laporan produksi -->

            <div style="margin-bottom: 100px; margin-top: 100px;"></div>
        </div>
    </section>
    <!-- content -->
</div>
<!-- halaman -->
<!-- content -->