<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
                <div class="col-md-12" id="peringatan-stok" style="display: none;">
                    <div class="alert alert-primary" role="alert">
                        <b>Penting!</b>, Harap periksa beberapa produk berikut karna stok sudah mendekati batas minimum <br>
                        <button class="btn btn-success mt-2" id="lihat-barang"><b>Lihat Barang</b></button>
                    </div>
                </div>
                <div class="user-profile layout-spacing">
                    <div class="widget-content widget-content-area">
                        <div class="text-center user-info">
                            <img src="<?= base_url('assets/default.jpg') ?>" width="50" alt="avatar">
                            <p class="text-uppercase">Hi, <?php echo $this->session->userdata('username') ?></p>
                        </div>
                        <hr>
                        <div class="user-info-list">

                            <div class="">
                                <ul class="contacts-block list-unstyled">
                                    <li class="contacts-block__item">
                                        <?php if ($this->session->userdata('role') == 4) : ?>
                                    <li class="contacts-block__item">
                                        <i class="fas fa-circle-user fa-lg"></i>&nbsp;&nbsp; Staff Gudang
                                    </li>
                                <?php elseif ($this->session->userdata('role') == 5) : ?>
                                    <li class="contacts-block__item">
                                        <i class="fas fa-circle-user fa-lg"></i>&nbsp;&nbsp; Staff Purchasing
                                    </li>
                                <?php elseif ($this->session->userdata('role') == 6) : ?>
                                    <li class="contacts-block__item">
                                        <i class="fas fa-circle-user fa-lg"></i>&nbsp;&nbsp; Staff Finance
                                    </li>
                                <?php endif; ?>

                                </li>

                                <li class="contacts-block__item">
                                    <i class="fas fa-envelope-open-text fa-lg"></i>&nbsp;&nbsp; <?php echo $this->session->userdata('email') ?>
                                </li>

                                <li class="contacts-block__item">
                                    <i class="fas fa-circle-check fa-lg text-success"></i>&nbsp;&nbsp; <span class="text-success">Verified</span>
                                </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">

                <div class="row">
                    <!-- role gudang -->
                    <?php if ($this->session->userdata('role') == 4) : ?>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-card-four">
                                <div class="widget-content">
                                    <div class="w-header">
                                        <div class="w-info">
                                            <h6 class="value"><small><strong>Permintaan Barang</strong></small></h6>
                                        </div>
                                        <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                            <a href="<?= site_url('others/permintaan') ?>"> <span class="badge badge-dark">Lihat selengkapnya</span></a>
                                        </div>
                                    </div>

                                    <div class="w-content">
                                        <div class="w-info">
                                            <p class="value">
                                                <?= $permintaan; ?> <span><a href="<?= site_url('others/permintaan') ?>" class="text-dark">Permintaan</a></span>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-card-four">
                                <div class="widget-content">
                                    <div class="w-header">
                                        <div class="w-info">
                                            <h6 class="value"><small><strong>Barang Terealisasi</strong></small></h6>
                                        </div>
                                        <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                            <a href="<?= site_url('others/permintaan') ?>"> <span class="badge badge-dark">Lihat selengkapnya</span></a>
                                        </div>
                                    </div>

                                    <div class="w-content">
                                        <div class="w-info">
                                            <p class="value">
                                                <?= $acceptProduct; ?> <span><a href="javascript:(0)" class="text-dark">Barang</a></span>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div id="timelineBasic">
                                <div class="widget-content widget-content-area pb-1">
                                    <div class="mt-container mx-auto">
                                        <div class="timeline-line">
                                            <?php foreach ($request as $req) : ?>

                                                <?php if ($req->status === 'waiting confirm') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-warning">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> <br>sedang di proses oleh bagian <strong>inventory</strong></p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>


                                                <?php if ($req->status === 'accept') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-success">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> <br>sedang di proses oleh bagian <strong>purchasing</strong></p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($req->status === 'in process') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-primary">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> <br>sedang di proses oleh bagian finance</p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($req->status === 'finish') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-dark">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> sudah terpenuhi</p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            <?php endforeach; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- role purchasing -->
                    <?php if ($this->session->userdata('role') == 5) : ?>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-card-four">
                                <div class="widget-content">
                                    <div class="w-header">
                                        <div class="w-info">
                                            <h6 class="value"><small><strong>Permintaan Barang</strong></small></h6>
                                        </div>
                                        <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                            <a href="<?= site_url('others/permintaan_gudang') ?>"> <span class="badge badge-dark">Lihat selengkapnya</span></a>
                                        </div>
                                    </div>

                                    <div class="w-content">
                                        <div class="w-info">
                                            <p class="value">
                                                <?= $permintaan_gudang; ?> <span><a href="javascript:(0)" class="text-dark">Permintaan</a></span>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-card-four">
                                <div class="widget-content">
                                    <div class="w-header">
                                        <div class="w-info">
                                            <h6 class="value"><small><strong>Barang Terealisasi</strong></small></h6>
                                        </div>
                                        <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                            <a href="<?= site_url('others/permintaan_gudang') ?>"> <span class="badge badge-dark">Lihat selengkapnya</span></a>
                                        </div>
                                    </div>

                                    <div class="w-content">
                                        <div class="w-info">
                                            <p class="value">
                                                <?= $realisasiProduct; ?> <span><a href="javascript:(0)" class="text-dark">Barang</a></span>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-card-four">
                                <div class="widget-content">
                                    <div class="w-header">
                                        <div class="w-info">
                                            <h6 class="value"><small><strong>Unit Beroperasi</strong></small></h6>
                                        </div>
                                        <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                            <a href="<?= site_url('others/barang_keluar') ?>"> <span class="badge badge-dark">Lihat selengkapnya</span></a>
                                        </div>
                                    </div>

                                    <div class="w-content">
                                        <div class="w-info">
                                            <p class="value">
                                                <?= $operate; ?> <span><a href="javascript:(0)" class="text-dark">Barang</a></span>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-card-four">
                                <div class="widget-content">
                                    <div class="w-header">
                                        <div class="w-info">
                                            <h6 class="value"><small><strong>Unit Rusak</strong></small></h6>
                                        </div>
                                        <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                            <a href="<?= site_url('others/unit') ?>"> <span class="badge badge-dark">Lihat selengkapnya</span></a>
                                        </div>
                                    </div>

                                    <div class="w-content">
                                        <div class="w-info">
                                            <p class="value">
                                                <?= $unitTrash; ?> <span><a href="javascript:(0)" class="text-dark">Barang</a></span>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div id="timelineBasic">
                                <div class="widget-content widget-content-area pb-1">
                                    <div class="mt-container mx-auto">
                                        <div class="timeline-line">
                                            <?php foreach ($request as $req) : ?>

                                                <?php if ($req->status === 'waiting confirm') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-warning">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> <br>sedang di proses oleh bagian <strong>inventory</strong></p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>


                                                <?php if ($req->status === 'accept') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-success">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> <br>sedang di proses oleh bagian <strong>purchasing</strong></p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($req->status === 'in process') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-primary">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> <br>sedang di proses oleh bagian finance</p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($req->status === 'finish') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-dark">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> sudah terpenuhi</p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            <?php endforeach; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- role finance -->
                    <?php if ($this->session->userdata('role') == 6) : ?>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-card-four">
                                <div class="widget-content">
                                    <div class="w-header">
                                        <div class="w-info">
                                            <h6 class="value"><small><strong>Total Permintaan</strong></small></h6>
                                        </div>
                                        <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                            <a href="<?= site_url('others/permintaan_purchasing') ?>"> <span class="badge badge-danger">Lihat selengkapnya</span></a>
                                        </div>
                                    </div>

                                    <div class="w-content">
                                        <div class="w-info">
                                            <p class="value">
                                                <?= $permintaan_purchase; ?> <span><a href="javascript:(0)" class="text-dark">Permintaan</a></span>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-card-four">
                                <div class="widget-content">
                                    <div class="w-header">
                                        <div class="w-info">
                                            <h6 class="value"><small><strong>Total Tagihan</strong></small></h6>
                                        </div>
                                        <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                            <a href="<?= site_url('others/permintaan_purchasing') ?>"> <span class="badge badge-danger">Lihat selengkapnya</span></a>
                                        </div>
                                    </div>

                                    <div class="w-content">
                                        <div class="w-info">
                                            <p class="value">
                                                <?php echo number_format($total_tagihan) ?> <span><a href="javascript:(0)" class="text-dark">Rupiah</a></span>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div id="timelineBasic">
                                <div class="widget-content widget-content-area pb-1">
                                    <div class="mt-container mx-auto">
                                        <div class="timeline-line">
                                            <?php foreach ($request as $req) : ?>

                                                <?php if ($req->status === 'waiting confirm') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-warning">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> <br>sedang di proses oleh bagian <strong>inventory</strong></p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>


                                                <?php if ($req->status === 'accept') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-success">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> <br>sedang di proses oleh bagian <strong>purchasing</strong></p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($req->status === 'in process') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-primary">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> <br>sedang di proses oleh bagian finance</p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($req->status === 'finish') : ?>
                                                    <div class="item-timeline mt-3">
                                                        <p class="t-time"><?php echo date('H:i', strtotime($req->date_request)); ?></p>
                                                        <div class="t-dot t-dot-dark">
                                                        </div>
                                                        <div class="t-text">
                                                            <p>Permintaan <span class="text-danger"><?= $req->invoice_number ?> (<?= $req->nama_brg ?>)</span> sudah terpenuhi</p>
                                                            <p class="text-muted mt-1"><small><?php echo date('d F Y', strtotime($req->date_request)); ?></small></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            <?php endforeach; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->

<!-- Modal untuk menampilkan daftar produk -->
<div class="modal fade" id="produkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Daftar Produk dengan Stok Mendekati Jumlah Minimum</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="produk-table">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Supplier</th>
                            <th>Stok</th>
                            <th>Jumlah Minimum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data produk akan ditampilkan di sini -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Ambil nilai dari PHP dan cek apakah ada barang dengan stok mendekati jumlah minimum
        var stokBarangMenipis = <?php echo json_encode($stokBarangMenipis); ?>;

        // Cek apakah ada produk yang stoknya mendekati jumlah minimum
        var adaProdukMendekatiMinimum = false;
        $.each(stokBarangMenipis, function(index, product) {
            if (parseInt(product.stok) >= (parseInt(product.jumlah_minimum) - 1) &&
                parseInt(product.stok) <= (parseInt(product.jumlah_minimum) + 1)) {
                adaProdukMendekatiMinimum = true;
                return false; // Keluar dari perulangan setelah menemukan satu produk yang sesuai
            }
        });

        // Cek apakah pesan peringatan harus ditampilkan atau disembunyikan
        if (adaProdukMendekatiMinimum) {
            // Tampilkan pesan peringatan
            $('#peringatan-stok').show();

            // Tambahkan event listener untuk tombol "Lihat Barang"
            $('#lihat-barang').click(function() {
                // Tampilkan modal
                $('#produkModal').modal('show');

                // Tampilkan daftar produk yang stoknya mendekati jumlah minimum dalam tabel
                var produkListHtml = '';
                $.each(stokBarangMenipis, function(index, product) {
                    var stokClass = ''; // Inisialisasi kelas CSS untuk stok

                    // Periksa apakah stok mendekati jumlah minimum
                    if (parseInt(product.stok) >= (parseInt(product.jumlah_minimum) - 1) &&
                        parseInt(product.stok) <= (parseInt(product.jumlah_minimum) + 1)) {
                        stokClass = 'text-danger'; // Tambahkan kelas CSS untuk warna merah
                    }

                    produkListHtml += '<tr>';
                    produkListHtml += '<td>' + product.id_brg + '</td>';
                    produkListHtml += '<td>' + product.nama_brg + '</td>';
                    produkListHtml += '<td>' + product.nama_supplier + '</td>';
                    produkListHtml += '<td class="' + stokClass + '">' + product.stok + '</td>';
                    produkListHtml += '<td>' + product.jumlah_minimum + '</td>';
                    produkListHtml += '</tr>';
                });

                // Tampilkan daftar produk di dalam tabel
                $('#produk-table tbody').html(produkListHtml);

                console.log('Data produk:', stokBarangMenipis);
            });
        } else {
            // Sembunyikan pesan peringatan jika tidak ada produk yang mendekati jumlah minimum
            $('#peringatan-stok').hide();
        }
    });
</script>


</div>
<!-- END MAIN CONTAINER -->