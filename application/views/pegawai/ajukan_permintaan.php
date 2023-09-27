<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <form action="<?= site_url('pegawai/permintaan/proses_permintaan'); ?>" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center align-items-center layout-top-spacing">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-chart-three">
                        <div class="widget-heading">
                            <div class="">
                                <h5 class="">Pengajuan Permintaan Barang</h5>
                            </div>
                        </div>

                        <div id="dynamic-input-container">
                            <div class="row ml-2 mt-4 mr-2 mb-2 dynamic-input-row no-top-border">
                                <div class="col-md-6">
                                    <label class="ml-1">Nama Barang <span class="text-danger">*</span></label>
                                    <input type="hidden" name="user_id" class="form-control" value="<?php echo $this->session->userdata('user_id'); ?>">
                                    <input type="hidden" name="status" class="form-control" value="waiting confirm">
                                    <select name="id_brg" class="form-control basic-jabatan">
                                        <?php foreach ($product as $row) : ?>
                                            <option value="<?= $row->id_brg ?>"><?= $row->nama_brg ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="ml-1">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="qty" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="ml-1">Pilih Unit atau Departemen <span class="text-danger">*</span></label>
                                    <select name="pilih_unit_departemen" id="pilih_unit_departemen" class="form-control">
                                        <option>--- Pilih Opsi ---</option>
                                        <option value="unit">Unit</option>
                                        <option value="departemen">Departemen</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="unit_select" style="display: none;">
                                    <label class="ml-1">Nama Unit <span class="text-danger">*</span></label>
                                    <select name="id_unit" class="form-control basic-jabatan">
                                        <?php foreach ($unit as $row) : ?>
                                            <option value="<?= $row->id_unit ?>"><?= $row->nama_unit ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6" id="departemen_select" style="display: none;">
                                    <label class="ml-1">Nama Departement <span class="text-danger">*</span></label>
                                    <select name="id_departement" class="form-control basic-jabatan">
                                        <?php foreach ($departement as $row) : ?>
                                            <option value="<?= $row->id_departement ?>"><?= $row->nama_departement ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
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
<!--  END CONTENT AREA  -->


</div>
<!-- END MAIN CONTAINER -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
    });
</script>