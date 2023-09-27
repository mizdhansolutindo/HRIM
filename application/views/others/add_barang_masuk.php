<!-- BEGIN CONTENT AREA -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <form action="<?= site_url('others/barang_masuk/add_proses'); ?>" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center align-items-center layout-top-spacing">
                <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-chart-three">
                        <div class="widget-heading">
                            <div class="">
                                <h5 class="">Tambah Barang Masuk</h5>
                            </div>
                            <div class="dropdown ">
                                <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="tambahBaris">
                                    <i class="fas fa-plus-circle fa-lg text-primary"></i>&nbsp; <span class="text-primary">Tambah Baris</span>
                                </a>
                            </div>
                        </div>
                        <div class="widget-content">
                            <div id="dynamic-input-container">
                                <!-- Baris pertama -->
                                <div class="dynamic-input-row" id="row-0">
                                    <div class="row ml-2 mt-4 mr-2 mb-2">
                                        <div class="col-md-6">
                                            <label class="ml-1">Nama Barang <span class="text-danger">*</span></label>
                                            <input type="hidden" name="status[]" class="form-control" value="success">
                                            <select name="id_brg[]" class="form-control basic-jabatan product-select">
                                                <option hidden>Pilih Barang</option>
                                                <?php foreach ($product as $row) : ?>
                                                    <option value="<?= $row->id_brg ?>" data-supplier="<?= $row->nama_supplier ?>"><?= $row->nama_brg ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="ml-1">Quantity <span class="text-danger">*</span></label>
                                            <input type="number" name="jumlah[]" class="form-control" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="ml-1">Supplier <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_supplier[]" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="ml-1">Tgl Pencatatan <span class="text-danger">*</span></label>
                                            <input type="date" name="created_at[]" class="form-control">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="ml-1">Penerima <span class="text-danger">*</span></label>
                                            <input type="text" name="penerima[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir baris pertama -->
                            </div>
                            <hr>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary btn-block mt-2 mb-4">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END CONTENT AREA -->

<script>
    $(document).ready(function() {
        // Sembunyikan elemen #nama_supplier saat halaman dimuat
        $('.dynamic-input-row:first .form-control[name="nama_supplier[]"]').hide();

        // Ketika pilihan dalam dropdown berubah pada baris pertama
        $('.dynamic-input-row:first .product-select').change(function() {
            // Ambil nilai supplier dari atribut data-supplier
            var selectedSupplier = $(this).find(':selected').data('supplier');

            // Temukan input supplier yang sesuai dalam baris pertama
            var supplierInput = $(this).closest('.dynamic-input-row').find('.form-control[name="nama_supplier[]"]');

            // Sembunyikan elemen supplier dengan efek fadeOut pada baris pertama
            supplierInput.fadeOut(function() {
                // Isi nilai supplier pada input supplier
                supplierInput.val(selectedSupplier);

                // Tampilkan elemen supplier dengan efek fadeIn pada baris pertama
                supplierInput.fadeIn();
            });
        });

        // Menangani klik tombol "Tambah Baris"
        var rowCounter = 0;

        $("#tambahBaris").click(function() {
            rowCounter++;

            var newRow = '<div class="dynamic-input-row" id="row-' + rowCounter + '">';
            newRow += '<div class="row ml-2 mt-4 mr-2 mb-2">';
            newRow += '<div class="col-md-6">';
            newRow += '<label class="ml-1">Nama Barang <span class="text-danger">*</span></label>';
            newRow += '<input type="hidden" name="status[]" class="form-control" value="success">';
            newRow += '<select name="id_brg[]" class="form-control basic-jabatan product-select">';
            newRow += '<option hidden>Pilih Barang</option>';
            <?php foreach ($product as $row) : ?>
                newRow += '<option value="<?= $row->id_brg ?>" data-supplier="<?= $row->nama_supplier ?>"><?= $row->nama_brg ?></option>';
            <?php endforeach; ?>
            newRow += '</select>';
            newRow += '</div>';
            newRow += '<div class="col-md-6">';
            newRow += '<label class="ml-1">Quantity <span class="text-danger">*</span></label>';
            newRow += '<input type="number" name="jumlah[]" class="form-control" required>';
            newRow += '</div>';
            newRow += '<div class="col-md-12">';
            newRow += '<label class="ml-1 mt-4">Supplier <span class="text-danger">*</span></label>';
            newRow += '<input type="text" name="nama_supplier[]" class="form-control" readonly>';
            newRow += '</div>';
            newRow += '<div class="col-md-6 mt-3">';
            newRow += '<label class="ml-1">Tgl Pencatatan <span class="text-danger">*</span></label>';
            newRow += '<input type="date" name="created_at[]" class="form-control">';
            newRow += '</div>';
            newRow += '<div class="col-md-6 mt-3">';
            newRow += '<label class="ml-1">Penerima <span class="text-danger">*</span></label>';
            newRow += '<input type="text" name="penerima[]" class="form-control">';
            newRow += '</div>';
            newRow += '</div>';
            newRow += '</div>';

            $("#dynamic-input-container").append(newRow);

            // Ketika pilihan dalam dropdown berubah pada baris baru
            $("#row-" + rowCounter + " .product-select").change(function() {
                var selectedSupplier = $(this).find(':selected').data('supplier');
                var supplierInput = $(this).closest('.dynamic-input-row').find('.form-control[name="nama_supplier[]"]');
                supplierInput.val(selectedSupplier);
            });

            // Menangani perubahan Tgl Pencatatan pada baris baru
            $("#row-" + rowCounter + " input[name='created_at[]']").change(function() {
                // Tambahkan kode di sini untuk menangani perubahan Tgl Pencatatan
            });

            // Menangani perubahan Penerima pada baris baru
            $("#row-" + rowCounter + " input[name='penerima[]']").change(function() {
                // Tambahkan kode di sini untuk menangani perubahan Penerima
            });
        });
    });
</script>