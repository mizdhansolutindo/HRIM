<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
   <div class="layout-px-spacing">
      <?php if ($this->session->userdata('role') == 2) : ?>
         <div class="row layout-top-spacing">
            <div class="col-xl-3 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">

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

            <div class="col-xl-9 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">

               <div class="row">

                  <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                     <div class="widget widget-card-four">
                        <div class="widget-content">
                           <div class="w-header">
                              <div class="w-info">
                                 <h6 class="value"><small><strong>Total Karyawan Masuk</strong></small></h6>
                              </div>
                              <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                 <a href="<?= site_url('other/absensi') ?>"> <span class="badge badge-dark">Lihat selengkapnya</span></a>
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
                                       <a href="<?= site_url('other/karyawan') ?>"> <span class="badge badge-dark">Lihat selengkapnya</span></a>
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
                                       <h6><strong>Tidak Capai Target</strong></h6>
                                    </div>
                                    <div class="col-md-6 pl-0 col-sm-6 col-12 text-right">
                                       <a href="<?= site_url('other/karyawan') ?>"> <span class="badge badge-dark">Lihat selengkapnya</span></a>
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

               </div>

            </div>
         </div>
      <?php endif; ?>
   </div>
</div>
<!--  END CONTENT AREA  -->


</div>
<!-- END MAIN CONTAINER -->