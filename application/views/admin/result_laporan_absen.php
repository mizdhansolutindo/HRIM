  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
     <div class="layout-px-spacing">



        <div class="row layout-top-spacing" id="cancel-row">

           <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
              <div class="widget widget-chart-three">
                 <div class="widget-heading">
                    <div class="">
                       <h5 class="">Hasil Laporan Absensi</h5>
                    </div>

                    <div class="dropdown ">
                       <a class="dropdown-toggle" href="<?php echo base_url('admin/laporan_absen/exportExcel'); ?>" role="button">
                          <i class="fas fa-file-excel fa-xl text-success"></i>
                       </a>
                    </div>
                 </div>

                 <div class="widget-content">
                    <div class="widget-content widget-content-area br-6">
                       <form action="<?= site_url('admin/laporan_absen/filter') ?>" method="post">
                          <div class="row ml-2 mt-4 mr-2 mb-2">
                             <div class="col-md-2">
                                <label class="ml-1">Tanggal Absen <span class="text-danger">*</span></label>
                                <select name="bulan" class="form-control">
                                   <option value="" hidden>Pilih Bulan</option>
                                   <option value="01">Januari</option>
                                   <option value="02">Februari</option>
                                   <option value="03">Maret</option>
                                   <option value="04">April</option>
                                   <option value="05">Mei</option>
                                   <option value="06">Juni</option>
                                   <option value="07">Juli</option>
                                   <option value="08">Agustus</option>
                                   <option value="09">September</option>
                                   <option value="10">Oktober</option>
                                   <option value="11">November</option>
                                   <option value="12">Desember</option>
                                </select>
                             </div>

                             <div class="col-md-2">
                                <label class="ml-1">Jabatan <span class="text-danger">*</span></label>
                                <select name="id_jabatan" class="form-control basic-jabatan">
                                   <option value="" hidden>Jabatan</option>
                                   <?php foreach ($jabatan as $jab) : ?>
                                      <option value="<?= $jab->id_jabatan ?>"><?= $jab->nama_jabatan ?></option>
                                   <?php endforeach; ?>
                                </select>
                             </div>

                             <div class="col-md-3">
                                <label class="ml-1">Departement <span class="text-danger">*</span></label>
                                <select name="id_departement" class="form-control basic-jabatan">
                                   <option value="" hidden>Departement</option>
                                   <?php foreach ($departement as $dep) : ?>
                                      <option value="<?= $dep->id_departement ?>"><?= $dep->nama_departement ?></option>
                                   <?php endforeach; ?>
                                </select>
                             </div>

                             <div class="col-md-3 mt-4">
                                <button type="submit" class="mt-2 ml-3 btn btn-primary btn-rounded"><i class="fas fa-search"></i>&nbsp; Filter</button>
                             </div>
                          </div>
                          <hr>

                       </form>

                       <table id="zero-config" class="table table-striped" style="width:100%">
                          <thead>
                             <tr>
                                <th>
                                   <center>Nama Karyawan
                                </th>
                                <th>
                                   <center>Departement
                                </th>
                                <th>
                                   <center>Jabatan
                                </th>
                                <th>
                                   <center>Jam Reguler
                                </th>
                                <th>
                                   <center>Jam Lembur
                                </th>
                                <th>
                                   <center>Aktifitas
                                </th>
                                <th>
                                   <center>Sakit
                                </th>
                                <th>
                                   <center>Izin
                                </th>
                                <th>
                                   <center>Alpha
                                </th>
                                <th class="no-content">
                                   <center>Cuti
                                </th>
                             </tr>
                          </thead>
                          <tbody>
                             <?php $no = 1;
                              foreach ($absen as $row) : ?>
                                <tr>
                                   <td>
                                      <center><strong><?= $row->nama_karyawan ?></strong> <br><?= $row->id_karyawan ?>
                                   </td>
                                   <td>
                                      <center><strong><?= $row->nama_departement ?></strong>
                                   </td>
                                   <td>
                                      <center><strong><?= $row->nama_jabatan ?></strong>
                                   </td>
                                   <td>
                                      <center><strong><?= $row->total_jam_kerja_reguler ?></strong>
                                   </td>
                                   <td>
                                      <center><strong><?= $row->total_jam_kerja_lembur ?></strong>
                                   </td>
                                   <td>
                                      <center><strong><?= $row->total_aktivitas ?></strong>
                                   </td>
                                   <td>
                                      <center><strong><?= $row->total_sakit ?></strong>
                                   </td>
                                   <td>
                                      <center><strong><?= $row->total_izin ?></strong>
                                   </td>
                                   <td>
                                      <center><strong><?= $row->total_alpha ?></strong>
                                   </td>
                                   <td>
                                      <center><strong><?= $row->total_cuti ?></strong>
                                   </td>
                                </tr>
                             <?php endforeach; ?>
                          </tbody>
                       </table>
                    </div>
                 </div>
              </div>
           </div>

        </div>

     </div>
  </div>
  <!--  END CONTENT AREA  -->