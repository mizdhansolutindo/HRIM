<!-- BEGIN CONTENT AREA -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row justify-content-center align-items-center layout-top-spacing">

            <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-three left-card">
                    <div class="widget-heading">
                        <div class="">
                            <h5 class="">Tambah Absensi Karyawan</h5>
                        </div>

                        <div class="dropdown ">
                            <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="tambahBaris">
                                <i class="fas fa-plus-circle fa-lg text-primary"></i>&nbsp; <span class="text-primary">Tambah Baris</span>
                            </a>
                        </div>
                    </div>

                    <div class="widget-content">
                        <form id="formBarang" action="<?= site_url('admin/absensi/proses') ?>" method="post">
                            <div id="rows">
                                <div class="row ml-2 mt-4 mr-2 mb-2">

                                    <div class="col-md-12">
                                        <label class="ml-1">Karyawan <span class="text-danger">*</span></label>
                                        <select name="user_id[]" class="form-control">
                                            <option hidden>Pilih Karyawan</option>
                                            <?php foreach ($karyawan as $kar) : ?>
                                                <option value="<?= $kar->user_id ?>"><?= $kar->nama_karyawan ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="ml-1">Jabatan <span class="text-danger">*</span></label>
                                        <input type=" text" name="id_jabatan[]" class="form-control" readonly>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="ml-1">Departement <span class="text-danger">*</span></label>
                                        <input type="text" name="id_departement[]" class="form-control" readonly>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="ml-1">Lokasi <span class="text-danger">*</span></label>
                                        <input type=" text" name="lokasi_kerja[]" class="form-control">
                                    </div>


                                    <div class="col-md-6 mt-3">
                                        <label class="ml-1">Shift Time <span class="text-danger">*</span></label>
                                        <select name="shift_line[]" class="form-control">
                                            <option hidden>Pilih Waktu Kerja</option>
                                            <option value="08.00 - 17.00">08.00 - 17.00</option>
                                            <option value="09.00 - 18.00">09.00 - 18.00</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="ml-1">Kondisi Kesehatan <span class="text-danger">*</span></label>
                                        <select name="kondisi_kesehatan[]" class="form-control">
                                            <option hidden>Kondisi Kesehatan</option>
                                            <option value="SEHAT">SEHAT</option>
                                            <option value="TIDAK FIT">TIDAK FIT</option>
                                            <option value="SAKIT">SAKIT</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="ml-1">Aktivitas <span class="text-danger">*</span></label>
                                        <input type="text" name="aktivitas[]" class="form-control">
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="ml-1">Waktu Absen <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="waktu[]" class="form-control">
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label class="ml-1">Keterangan <span class="text-danger">*</span></label>
                                        <select name="keterangan[]" class="form-control">
                                            <option hidden>Status Absen</option>
                                            <option value="masuk">masuk</option>
                                            <option value="pulang">pulang</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mt-3 mb-5">
                                        <label class="ml-1">Qty Kinerja <span class="text-danger">*</span></label>
                                        <input type="number" name="kinerja[]" class="form-control">
                                    </div>


                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="mb-4 ml-4 btn btn-primary">Submit</button>
                            <a href="<?= site_url('admin/absensi') ?>" class="mb-4 ml-2 btn btn-danger">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- END CONTENT AREA -->

</div>
<!-- END MAIN CONTAINER -->

<!-- <script>
    $(document).ready(function() {
        // Menangani klik tombol "Tambah Baris"
        $("#tambahBaris").click(function() {
            // Duplikat baris pertama dan tambahkan ke dalam #rows
            var newRow = $("#rows .row:first").clone();
            $("#rows").append(newRow);

            // Reset nilai input kode unik untuk field baru
            newRow.find('input[name="user_id[]"]').val('');

            // Reset nilai input lainnya jika diperlukan
            newRow.find('input[type="text"], select').val('');
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('select[name="user_id[]"]').change(function() {
            var selectedUserId = $(this).val();
            var jabatanInput = $(this).closest('.col-md-12').next().find('input[name="id_jabatan[]"]');
            var departemenInput = $(this).closest('.col-md-12').next().next().find('input[name="id_departement[]"]');

            // Lakukan permintaan AJAX
            $.ajax({
                url: '<?= base_url('admin/absensi/getJabatanDepartemen/') ?>' + selectedUserId, // Sesuaikan dengan URL yang sesuai
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        jabatanInput.val(data.nama_jabatan);
                        departemenInput.val(data.nama_departement);
                    } else {
                        jabatanInput.val('');
                        departemenInput.val('');
                    }
                },
                error: function() {
                    console.error('Terjadi kesalahan dalam permintaan AJAX.');
                }
            });
        });
    });
</script> -->

<script>
    $(document).ready(function() {
        // Menangani klik tombol "Tambah Baris"
        $("#tambahBaris").click(function() {
            // Duplikat baris pertama dan tambahkan ke dalam #rows
            var newRow = $("#rows .row:first").clone();
            $("#rows").append(newRow);

            // Reset nilai input kode unik untuk field baru
            newRow.find('input[name="user_id[]"]').val('');

            // Reset nilai input lainnya jika diperlukan
            newRow.find('input[type="text"], select').val('');

            // Mengaktifkan kembali event listener untuk perubahan dropdown
            newRow.find('select[name="user_id[]"]').change(function() {
                var selectedUserId = $(this).val();
                var jabatanInput = $(this).closest('.col-md-12').next().find('input[name="id_jabatan[]"]');
                var departemenInput = $(this).closest('.col-md-12').next().next().find('input[name="id_departement[]"]');

                // Lakukan permintaan AJAX
                $.ajax({
                    url: '<?= base_url('admin/absensi/getJabatanDepartemen/') ?>' + selectedUserId, // Sesuaikan dengan URL yang sesuai
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            jabatanInput.val(data.nama_jabatan);
                            departemenInput.val(data.nama_departement);
                        } else {
                            jabatanInput.val('');
                            departemenInput.val('');
                        }
                    },
                    error: function() {
                        console.error('Terjadi kesalahan dalam permintaan AJAX.');
                    }
                });
            });
        });

        // Mengaktifkan event listener untuk perubahan dropdown pada baris pertama
        $('select[name="user_id[]"]').change(function() {
            var selectedUserId = $(this).val();
            var jabatanInput = $(this).closest('.col-md-12').next().find('input[name="id_jabatan[]"]');
            var departemenInput = $(this).closest('.col-md-12').next().next().find('input[name="id_departement[]"]');

            // Lakukan permintaan AJAX
            $.ajax({
                url: '<?= base_url('admin/absensi/getJabatanDepartemen/') ?>' + selectedUserId, // Sesuaikan dengan URL yang sesuai
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        jabatanInput.val(data.nama_jabatan);
                        departemenInput.val(data.nama_departement);
                    } else {
                        jabatanInput.val('');
                        departemenInput.val('');
                    }
                },
                error: function() {
                    console.error('Terjadi kesalahan dalam permintaan AJAX.');
                }
            });
        });
    });
</script>