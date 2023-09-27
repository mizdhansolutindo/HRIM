<!-- BEGIN CONTENT AREA -->
<div id="content" class="main-content">
   <div class="layout-px-spacing">

      <div class="row justify-content-center align-items-center layout-top-spacing">

         <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-three left-card">
               <div class="widget-heading">
                  <div class="">
                     <h5 class="">Tambah Inventaris Kantor</h5>
                  </div>

                  <div class="dropdown ">
                     <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="tambahBaris">
                        <i class="fas fa-plus-circle fa-lg text-primary"></i>&nbsp; <span class="text-primary">Tambah Baris</span>
                     </a>
                  </div>
               </div>

               <div class="widget-content">
                  <form id="formBarang" action="<?= site_url('admin/barang/proses') ?>" method="post">
                     <div id="rows">
                        <div class="row ml-2 mt-4 mr-2 mb-2">

                           <div class="col-md-6">
                              <label class="ml-1">Part Number <span class="text-danger">*</span></label>
                              <input type="text" name="id_brg[]" class="form-control" placeholder="Part Number">
                           </div>

                           <div class="col-md-6">
                              <label class="ml-1">Nama Barang <span class="text-danger">*</span></label>
                              <input type="text" name="nama_brg[]" class="form-control" placeholder="Nama Barang">
                           </div>

                           <div class="col-md-6 mt-3">
                              <label class="ml-1">Merek Barang <span class="text-danger">*</span></label>
                              <input type="text" name="merek[]" class="form-control" placeholder="Merek Barang">
                           </div>

                           <div class="col-md-6 mt-3">
                              <label class="ml-1">Supplier <span class="text-danger">*</span></label>
                              <select name="id_supplier[]" class="form-control">
                                 <option hidden>Pilih Supplier</option>
                                 <?php foreach ($supplier as $sup) : ?>
                                    <option value="<?= $sup->id_supplier ?>"><?= $sup->nama_supplier ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </div>

                           <div class="col-md-6 mt-3 mb-4">
                              <label class="ml-1">Tipe Barang <span class="text-danger">*</span></label>
                              <select name="id_kategori[]" class="form-control">
                                 <option hidden>Pilih Tipe Barang</option>
                                 <?php foreach ($kategori as $kat) : ?>
                                    <option value="<?= $kat->id_kategori ?>"><?= $kat->nama_kategori ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </div>

                           <div class="col-md-3 mt-3 mb-4">
                              <label class="ml-1">Harga <span class="text-danger">*</span></label>
                              <input type="text" name="harga[]" class="form-control" placeholder="Rp. 0.00">
                           </div>

                           <div class="col-md-3 mt-3 mb-4">
                              <label class="ml-1">Jumlah minimum <span class="text-danger">*</span></label>
                              <input type="text" name="jumlah_minimum[]" class="form-control" value="0">
                           </div>

                        </div>
                     </div>
                     <hr>
                     <button type="submit" class="mb-4 ml-4 btn btn-primary">Submit</button>
                     <a href="<?= site_url('admin/barang') ?>" class="mb-4 ml-2 btn btn-danger">Kembali</a>
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

<script>
   $(document).ready(function() {
      // Menangani klik tombol "Tambah Baris"
      $("#tambahBaris").click(function() {
         // Duplikat baris pertama dan tambahkan ke dalam #rows
         var newRow = $("#rows .row:first").clone();
         $("#rows").append(newRow);

         // Reset nilai input kode unik untuk field baru
         newRow.find('input[name="id_brg[]"]').val('');

         // Reset nilai input lainnya jika diperlukan
         newRow.find('input[type="text"], select').val('');
      });
   });
</script>