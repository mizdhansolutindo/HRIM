  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
     <div class="layout-px-spacing">



        <div class="row layout-top-spacing" id="cancel-row">

           <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
              <div class="alert alert-arrow-left alert-icon-left alert-light-primary mb-4" role="alert">
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                 </svg>
                 Total Akumulasi Target Kinerja dari Karyawan : <strong><?= $karyawan_data->nama_karyawan ?></strong>
                 <a href="<?= site_url('admin/karyawan') ?>" class="btn btn-sm btn-outline-primary" style="float: right;">Kembali</a>
              </div>

           </div>


           <?php foreach ($bulan_tahun_data as $data) : ?>

              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                 <div class="widget widget-five">

                    <div class="widget-heading">

                       <a href="javascript:void(0)" class="task-info">

                          <div class="w-title">

                             <h5>Target Kinerja : <strong><i><?= $data->bulan_tahun ?></i></strong></h5>

                          </div>

                       </a>

                       <!-- <div class="task-action">
                          <div class="dropdown">
                             <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                   <circle cx="12" cy="12" r="1"></circle>
                                   <circle cx="19" cy="12" r="1"></circle>
                                   <circle cx="5" cy="12" r="1"></circle>
                                </svg>
                             </a>

                             <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                <a class="dropdown-item" href="javascript:void(0);">View Project</a>
                                <a class="dropdown-item" href="javascript:void(0);">Edit Project</a>
                                <a class="dropdown-item" href="javascript:void(0);">Mark as Done</a>
                             </div>
                          </div>
                       </div> -->

                    </div>


                    <div class="widget-content">


                       <div class="progress-data">

                          <div class="progress-info">
                             <div class="task-count">
                             </div>
                             <div class="progress-stats">
                                <p><?= round($data->persentase_kinerja, 2) . '%'; ?></p>
                             </div>
                          </div>

                          <?php
                           // Hitung lebar progress bar berdasarkan persentase kinerja
                           $lebar_progress_bar = round($data->persentase_kinerja, 2);
                           ?>
                          <div class="progress">
                             <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $lebar_progress_bar; ?>%" aria-valuenow="<?= $lebar_progress_bar; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>

                       </div>

                       <div class="meta-info">

                          <div class="due-time">
                             <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                   <circle cx="12" cy="12" r="10"></circle>
                                   <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>&nbsp; <?= round($data->total_jam_kerja, 2) ?> jam kerja</p>
                          </div>

                       </div>


                    </div>

                 </div>

              </div>

           <?php endforeach; ?>

        </div>

     </div>
  </div>
  <!--  END CONTENT AREA  -->