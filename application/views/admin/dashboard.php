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
                              <i class="fas fa-circle-user fa-lg"></i>&nbsp;&nbsp; Administrator
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
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                  <div class="widget widget-card-four">
                     <div class="widget-content">
                        <div class="w-header">
                           <div class="w-info">
                              <h6 class="value"><small><strong>Permintaan Barang</strong></small></h6>
                           </div>
                        </div>

                        <div class="w-content">

                           <div class="w-info">
                              <p class="value">
                                 <?= $permintaan; ?> <span><a href="<?= site_url('admin/permintaan') ?>" class="text-dark">Permintaan</a></span>
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
                              <h6 class="value"><small><strong>Pembelian Barang</strong></small></h6>
                           </div>
                        </div>

                        <div class="w-content">

                           <div class="w-info">
                              <p class="value">
                                 <?= $pembelian; ?> <span><a href="" class="text-dark">Pembelian</a></span>
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
                              <h6 class="value"><small><strong>Pembelian Berhasil</strong></small></h6>
                           </div>
                           <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                           </div>
                        </div>

                        <div class="w-content">

                           <div class="w-info">
                              <p class="value">
                                 <?= $purchasing; ?> <span><a href="" class="text-dark">Pembelian</a></span>
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
                              <h6 class="value"><small><strong>Karyawan Masuk</strong></small></h6>
                           </div>
                        </div>

                        <div class="w-content">

                           <div class="w-info">
                              <p class="value">
                                 <?php echo $jumlah_masuk; ?> <span><a href="<?= site_url('admin/absensi') ?>" class="text-dark">Karyawan</a></span>
                              </p>
                           </div>

                        </div>
                     </div>
                  </div>
               </div>

               <!-- Bagian untuk menampilkan karyawan yang sudah mencapai target -->
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                  <div class="card">
                     <div class="card-body">
                        <div class="progress-order">
                           <div class="progress-order-header">
                              <div class="row">
                                 <div class="col-md-6 col-sm-6 col-12">
                                    <h6><strong>Mencapai Target</strong></h6>
                                 </div>
                                 <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                    <a href="<?= site_url('admin/karyawan') ?>"> <span class="badge badge-dark">Lihat selengkapnya</span></a>
                                 </div>
                              </div>
                           </div>

                           <div class="progress-order-body">
                              <div class="row mt-4">
                                 <div class="col-md-12 text-right">
                                    <span class="p-o-percentage mr-4"><?= round($persentase_karyawan_mencapai_target, 2) . '%'; ?></span>
                                    <div class="progress p-o-progress mt-2">
                                       <div class="progress-bar bg-success" role="progressbar" style="width: <?= round($persentase_karyawan_mencapai_target, 2) . '%'; ?>" aria-valuenow="<?= round($persentase_karyawan_mencapai_target, 2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Bagian untuk menampilkan karyawan yang belum mencapai target -->
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                  <div class="card">
                     <div class="card-body">
                        <div class="progress-order">
                           <div class="progress-order-header">
                              <div class="row">
                                 <div class="col-md-6 col-sm-6 col-12">
                                    <h6><strong>Tidak Mencapai Target</strong></h6>
                                 </div>
                                 <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                    <a href="<?= site_url('admin/karyawan') ?>"> <span class="badge badge-dark">Lihat selengkapnya</span></a>
                                 </div>
                              </div>
                           </div>

                           <div class="progress-order-body">
                              <div class="row mt-4">
                                 <div class="col-md-12 text-right">
                                    <span class="p-o-percentage mr-4"><?= round($persentase_karyawan_tidak_mencapai_target, 2) . '%'; ?></span>
                                    <div class="progress p-o-progress mt-2">
                                       <div class="progress-bar bg-danger" role="progressbar" style="width: <?= round($persentase_karyawan_tidak_mencapai_target, 2) . '%'; ?>" aria-valuenow="<?= round($persentase_karyawan_tidak_mencapai_target, 2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                 </div>
                              </div>
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
                              <h6 class="value"><small><strong>Unit Kondisi Baik</strong></small></h6>
                           </div>
                        </div>

                        <div class="w-content">

                           <div class="w-info">
                              <p class="value">
                                 <?= $unit_baik; ?> <span><a href="" class="text-dark">Unit</a></span>
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
                              <h6 class="value"><small><strong>Unit Kondisi Rusak</strong></small></h6>
                           </div>
                        </div>

                        <div class="w-content">

                           <div class="w-info">
                              <p class="value">
                                 <?= $unit_rusak; ?> <span><a href="" class="text-dark">Unit</a></span>
                              </p>
                           </div>

                        </div>
                     </div>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>
<!--  END CONTENT AREA  -->


</div>
<!-- END MAIN CONTAINER -->

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