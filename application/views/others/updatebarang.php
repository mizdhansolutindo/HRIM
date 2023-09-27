<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row justify-content-center align-items-center layout-top-spacing">

            <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-three left-card">
                    <div class="widget-heading">
                        <div class="">
                            <h5 class="">Ubah Data Barang : <strong><i><?= $barang->id_brg ?></i></strong></h5>
                        </div>
                    </div>

                    <div class="widget-content">
                        <form action="<?= site_url('others/barang/proses_ubah') ?>" method="post">
                            <div class="row ml-2 mt-4 mr-2 mb-2">

                                <div class="col-md-6">
                                    <label class="ml-1">Nama Barang <span class="text-danger">*</span></label>
                                    <input type="hidden" name="id_brg" class="form-control" value="<?= $barang->id_brg; ?>" readonly>
                                    <input type="text" name="nama_brg" class="form-control" value="<?= $barang->nama_brg ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="ml-1">Merek Barang <span class="text-danger">*</span></label>
                                    <input type="text" name="merek" class="form-control" value="<?= $barang->merek ?>">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label class="ml-1">Supplier <span class="text-danger">*</span></label>
                                    <select name="id_supplier" class="form-control">
                                        <option hidden value="<?= $barang->id_supplier ?>"><?= $barang->nama_supplier ?></option>
                                        <?php foreach ($supplier as $sup) : ?>
                                            <option value="<?= $sup->id_supplier ?>"><?= $sup->nama_supplier ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label class="ml-1">Tipe Barang <span class="text-danger">*</span></label>
                                    <select name="id_kategori" class="form-control basic-jabatan">
                                        <option hidden value="<?= $barang->id_kategori ?>"><?= $barang->nama_kategori ?></option>
                                        <?php foreach ($kategori as $kat) : ?>
                                            <option value="<?= $kat->id_kategori ?>"><?= $kat->nama_kategori ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label class="ml-1">Harga <span class="text-danger">*</span></label>
                                    <input type="text" name="harga" class="form-control" value="<?= $barang->harga ?>">
                                </div>

                            </div>
                            <hr>
                            <button type="submit" class="mb-4 ml-4 btn btn-primary">Ubah</button>
                            <a href="<?= site_url('others/barang') ?>" class="mb-4 ml-2 btn btn-danger">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>

</div>
<!--  END CONTENT AREA  -->


</div>
<!-- END MAIN CONTAINER -->