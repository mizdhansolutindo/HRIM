<style>
    .dynamic-input-row {
        border-top: 1px dashed #ccc;
        /* Warna dan jenis garis putus-putus */
        margin-top: 20px;
        /* Atur margin agar terlihat lebih baik */
        padding-top: 20px;
        /* Atur padding agar terlihat lebih baik */
    }

    .no-top-border {
        border-top: none;
        /* Menghilangkan garis putus-putus pada baris pertama */
    }
</style>



<!-- BEGIN CONTENT AREA -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <form action="<?= site_url('admin/barang_keluar/add_proses'); ?>" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center align-items-center layout-top-spacing">
                <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-chart-three">
                        <div class="widget-heading">
                            <div class="">
                                <h5 class="">Tambah Barang Keluar</h5>
                            </div>

                            <div class="dropdown ">
                                <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="tambahBaris">
                                    <i class="fas fa-plus-circle fa-lg text-primary"></i>&nbsp; <span class="text-primary">Tambah Baris</span>
                                </a>
                            </div>
                        </div>
                        <div id="dynamic-input-container">
                            <div class="row ml-2 mt-4 mr-2 mb-2 dynamic-input-row no-top-border">
                                <div class="col-md-6">
                                    <label class="ml-1">Nama Barang <span class="text-danger">*</span></label>
                                    <input type="hidden" name="status[]" class="form-control" value="success">
                                    <select name="id_brg[]" class="form-control basic-jabatan">
                                        <?php foreach ($product as $row) : ?>
                                            <option value="<?= $row->id_brg ?>"><?= $row->nama_brg ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="ml-1">Nama Peminjam <span class="text-danger">*</span></label>
                                    <select name="id_karyawan[]" class="form-control basic-jabatan">
                                        <?php foreach ($karyawan as $row) : ?>
                                            <option value="<?= $row->id_karyawan ?>"><?= $row->nama_karyawan ?> - <?= $row->nama_departement ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="ml-1">Pilih Unit atau Departemen <span class="text-danger">*</span></label>
                                    <select name="pilih_unit_departemen[]" id="pilih_unit_departemen" class="form-control">
                                        <option>--- Pilih Opsi ---</option>
                                        <option value="unit">Unit</option>
                                        <option value="departemen">Departemen</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="unit_select" style="display: none;">
                                    <label class="ml-1">Nama Unit <span class="text-danger">*</span></label>
                                    <select name="id_unit[]" class="form-control basic-jabatan">
                                        <?php foreach ($unit as $row) : ?>
                                            <option value="<?= $row->id_unit ?>"><?= $row->nama_unit ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6" id="departemen_select" style="display: none;">
                                    <label class="ml-1">Nama Departement <span class="text-danger">*</span></label>
                                    <select name="id_departement[]" class="form-control basic-jabatan">
                                        <?php foreach ($departement as $row) : ?>
                                            <option value="<?= $row->id_departement ?>"><?= $row->nama_departement ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="ml-1 mt-3">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah[]" class="form-control" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="ml-1 mt-3">Tgl Pencatatan <span class="text-danger">*</span></label>
                                    <input type="date" name="created_at[]" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-primary btn-block mt-2 mb-4">Submit</button>
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
        $('#pilih_unit_departemen').change(function() {
            var selectedOption = $(this).val();
            if (selectedOption === 'unit') {
                $('#unit_select').show();
                $('#departemen_select').hide();
            } else if (selectedOption === 'departemen') {
                $('#unit_select').hide();
                $('#departemen_select').show();
            }
        });

        $(document).ready(function() {
            // Memuat data "Nama Barang" dari PHP ke dalam variabel JavaScript
            var productOptions = <?php echo json_encode($product); ?>;
            var karyawanOptions = <?php echo json_encode($karyawan); ?>;
            var unitOptions = <?php echo json_encode($unit); ?>;
            var departemenOptions = <?php echo json_encode($departement); ?>;

            // Fungsi untuk memuat opsi "Nama Barang" ke dalam select element
            function loadProductOptions(selectElement) {
                // Menghapus opsi yang ada sebelumnya
                $(selectElement).empty();

                // Menambahkan opsi "Nama Barang" ke dalam select element
                $.each(productOptions, function(index, product) {
                    $(selectElement).append('<option value="' + product.id_brg + '">' + product.nama_brg + '</option>');
                });
            }

            // Fungsi untuk memuat opsi "Nama Peminjam" ke dalam select element
            function loadKaryawanOptions(selectElement) {
                // Menghapus opsi yang ada sebelumnya
                $(selectElement).empty();

                // Menambahkan opsi "Nama Peminjam" ke dalam select element
                $.each(karyawanOptions, function(index, karyawan) {
                    $(selectElement).append('<option value="' + karyawan.id_karyawan + '">' + karyawan.nama_karyawan + ' - ' + karyawan.nama_departement + '</option>');
                });
            }

            // Fungsi untuk memuat opsi "Nama Unit" ke dalam select element
            function loadUnitOptions(selectElement) {
                // Menghapus opsi yang ada sebelumnya
                $(selectElement).empty();

                // Menambahkan opsi "Nama Unit" ke dalam select element
                $.each(unitOptions, function(index, unit) {
                    $(selectElement).append('<option value="' + unit.id_unit + '">' + unit.nama_unit + '</option>');
                });
            }

            // Fungsi untuk memuat opsi "Nama Departemen" ke dalam select element
            function loadDepartemenOptions(selectElement) {
                // Menghapus opsi yang ada sebelumnya
                $(selectElement).empty();

                // Menambahkan opsi "Nama Departemen" ke dalam select element
                $.each(departemenOptions, function(index, departemen) {
                    $(selectElement).append('<option value="' + departemen.id_departement + '">' + departemen.nama_departement + '</option>');
                });
            }

            // Tambahkan tindakan untuk menambahkan input field ketika tombol "Tambah Baris" diklik
            $('#tambahBaris').click(function() {
                var newRow = '<div class="row ml-2 mt-4 mr-2 mb-2 dynamic-input-row">';
                newRow += '<hr class="dashed-line">';
                newRow += '<div class="col-md-6">';
                newRow += '<label class="ml-1">Nama Barang <span class="text-danger">*</span></label>';
                newRow += '<input type="hidden" name="status[]" class="form-control" value="success">';
                newRow += '<select name="id_brg[]" class="form-control basic-jabatan"></select>';
                newRow += '</div>';
                newRow += '<div class="col-md-6">';
                newRow += '<label class="ml-1">Nama Peminjam <span class="text-danger">*</span></label>';
                newRow += '<select name="id_karyawan[]" class="form-control basic-jabatan"></select>';
                newRow += '</div>';
                newRow += '<div class="col-md-6 mt-3">';
                newRow += '<label class="ml-1">Pilih Unit atau Departemen <span class="text-danger">*</span></label>';
                newRow += '<select name="pilih_unit_departemen[]" class="form-control">';
                newRow += '<option>--- Pilih Opsi ---</option>';
                newRow += '<option value="unit">Unit</option>';
                newRow += '<option value="departemen">Departemen</option>';
                newRow += '</select>';
                newRow += '</div>';
                newRow += '<div class="col-md-6 mt-3" id="unit_select" style="display: none;">';
                newRow += '<label class="ml-1">Nama Unit <span class="text-danger">*</span></label>';
                newRow += '<select name="id_unit[]" class="form-control basic-jabatan"></select>';
                newRow += '</div>';
                newRow += '<div class="col-md-6 mt-3" id="departemen_select" style="display: none;">';
                newRow += '<label class="ml-1">Nama Departemen <span class="text-danger">*</span></label>';
                newRow += '<select name="id_departement[]" class="form-control basic-jabatan"></select>';
                newRow += '</div>';
                newRow += '<div class="col-md-12">';
                newRow += '<label class="ml-1 mt-3">Quantity <span class="text-danger">*</span></label>';
                newRow += '<input type="number" name="jumlah[]" class="form-control" required>';
                newRow += '</div>';
                newRow += '<div class="col-md-12 mt-3">';
                newRow += '<label class="ml-1 mt-3">Tgl Pencatatan <span class="text-danger">*</span></label>';
                newRow += '<input type="date" name="created_at[]" class="form-control" required>';
                newRow += '</div>';
                newRow += '</div>';

                $('#dynamic-input-container').append(newRow);

                // Memuat opsi "Nama Barang" dalam baris baru
                var newProductSelect = $('#dynamic-input-container').find('select[name="id_brg[]"]:last');
                loadProductOptions(newProductSelect);

                // Memuat opsi "Nama Peminjam" dalam baris baru
                var newKaryawanSelect = $('#dynamic-input-container').find('select[name="id_karyawan[]"]:last');
                loadKaryawanOptions(newKaryawanSelect);

                // Re-bind the change event to the newly added elements
                $('#dynamic-input-container').on('change', 'select[name="pilih_unit_departemen[]"]', function() {
                    var selectedOption = $(this).val();
                    var parentRow = $(this).closest('.dynamic-input-row');
                    var unitSelect = parentRow.find('#unit_select');
                    var departemenSelect = parentRow.find('#departemen_select');

                    // Memuat opsi "Nama Unit" atau "Nama Departemen" berdasarkan pilihan
                    if (selectedOption === 'unit') {
                        unitSelect.show();
                        departemenSelect.hide();
                        var newUnitSelect = parentRow.find('select[name="id_unit[]"]');
                        loadUnitOptions(newUnitSelect);
                    } else if (selectedOption === 'departemen') {
                        unitSelect.hide();
                        departemenSelect.show();
                        var newDepartemenSelect = parentRow.find('select[name="id_departement[]"]');
                        loadDepartemenOptions(newDepartemenSelect);
                    }
                });
            });

            // Handle change event for the first row
            $('select[name="pilih_unit_departemen[]"]').change(function() {
                var selectedOption = $(this).val();
                var unitSelect = $('#unit_select');
                var departemenSelect = $('#departemen_select');

                // Memuat opsi "Nama Unit" atau "Nama Departemen" berdasarkan pilihan
                if (selectedOption === 'unit') {
                    unitSelect.show();
                    departemenSelect.hide();
                    var newUnitSelect = $('select[name="id_unit[]"]');
                    loadUnitOptions(newUnitSelect);
                } else if (selectedOption === 'departemen') {
                    unitSelect.hide();
                    departemenSelect.show();
                    var newDepartemenSelect = $('select[name="id_departement[]"]');
                    loadDepartemenOptions(newDepartemenSelect);
                }
            });
        });
    });
</script>