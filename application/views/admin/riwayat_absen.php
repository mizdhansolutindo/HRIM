  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
     <div class="layout-px-spacing">



        <div class="row layout-top-spacing" id="cancel-row">

           <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
              <div class="widget widget-chart-three">
                 <div class="widget-heading">
                    <div class="">
                       <h5 class="">Input Data Absensi</h5>
                    </div>

                    <div class="dropdown ">
                       <a class="btn btn-sm btn-secondary" href="javascript:void(0);" data-toggle="modal" data-target="#exampleModalCenter">
                          <i class="fas fa-cloud-arrow-up fa-lg text-white"></i>&nbsp; Unggah File
                       </a>
                    </div>
                 </div>

                 <div class="widget-content">
                    <div class="widget-content widget-content-area br-6">
                       <form onsubmit="return validateForm();" method="POST" action="<?= base_url('admin/absensi/proses_multiple'); ?>">
                          <table id="zero-config1" class="table table-striped" style="width:100%">
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
                                      <center>Tgl Absensi
                                   </th>
                                   <th>
                                      <center>Shift
                                   </th>
                                   <th>
                                      <center>Status
                                   </th>
                                   <th>
                                      <center>Jam Masuk Reguler
                                   </th>
                                   <th>
                                      <center>Jam Pulang Reguler
                                   </th>
                                   <th>
                                      <center>Jam Masuk Lembur
                                   </th>
                                   <th>
                                      <center>Jam Pulang Lembur
                                   </th>
                                   <th>
                                      <center>Aktivitas
                                   </th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php $no = 1;
                                 foreach ($add as $row) : ?>
                                   <tr>
                                      <td>
                                         <center>
                                            <input type="hidden" name="user_id[]" value="<?= $row->user_id; ?>">
                                            <strong> <?= $row->nama_karyawan; ?></strong> <br> <?= $row->id_karyawan; ?>
                                      </td>
                                      <td>
                                         <center>
                                            <span class="text-muted"> <strong><?= $row->nama_departement; ?></strong></span>
                                      </td>
                                      <td>
                                         <center>
                                            <span class="text-muted"> <strong><?= $row->nama_jabatan; ?></strong></span>
                                      </td>
                                      <td>
                                         <center><input type="date" class="form-control form-control-sm" name="tanggal[]" placeholder="00.00" style="width: 190px;">
                                      </td>
                                      <td>
                                         <center>
                                            <select name="shift[]" class="form-control form-control-sm" style="width: 160px;">
                                               <option value="07.00 - 16.00">07.00 - 16.00</option>
                                               <option value="14.00 - 23.00">14.00 - 23.00</option>
                                            </select>
                                      </td>
                                      <td style="text-align: center;">
                                         <center>
                                            <select name="status[]" class="form-control form-control-sm" style="width: 130px;">
                                               <option value="Masuk">Masuk</option>
                                               <option value="Cuti">Cuti</option>
                                               <option value="Izin">Izin</option>
                                               <option value="Alpha">Alpha</option>
                                               <option value="Sakit">Sakit</option>
                                            </select>
                                      </td>
                                      <td>
                                         <center><input type="time" class="form-control form-control-sm" name="jam_masuk_reguler[]" required placeholder="00.00" style="width: 170px;">
                                      </td>
                                      <td>
                                         <center><input type="time" class="form-control form-control-sm" name="jam_pulang_reguler[]" required placeholder="00.00" style="width: 170px;">
                                      </td>
                                      <td>
                                         <center><input type="time" class="form-control form-control-sm" name="jam_masuk_lembur[]" placeholder="00.00" style="width: 170px;">
                                      </td>
                                      <td>
                                         <center><input type="time" class="form-control form-control-sm" name="jam_pulang_lembur[]" placeholder="00.00" style="width: 170px;">
                                      </td>
                                      <td>
                                         <center><input type="text" class="form-control form-control-sm" name="aktivitas[]" required placeholder="0" style="width: 140px;">
                                      </td>
                                   </tr>
                                <?php endforeach; ?>
                             </tbody>
                          </table>
                          <button type="submit" class="btn btn-secondary mb-3 ml-3">Simpan</button>
                       </form>
                    </div>
                 </div>
              </div>
           </div>

           <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
              <div class="widget widget-chart-three">
                 <div class="widget-heading">
                    <div class="">
                       <h5 class="">Riwayat Absensi</h5>
                    </div>
                 </div>

                 <div class="widget-content">
                    <div class="widget-content widget-content-area br-6">
                       <table id="zero-config" class="table table-striped" style="width:100%">
                          <thead>
                             <tr>
                                <th>Tanggal</th>
                                <th>Nama Karyawan</th>
                                <th>Shift</th>
                                <th>Status</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th class="no-content"></th>
                             </tr>
                          </thead>
                          <tbody>
                             <?php $no = 1;
                              foreach ($absen as $row) : ?>
                                <tr>
                                   <td><?php echo date('d F Y', strtotime($row->tanggal)); ?></td>
                                   <td><strong><?= $row->nama_karyawan ?></strong> <br><?= $row->id_karyawan ?></td>
                                   <td><strong><?= $row->shift ?></strong></td>
                                   <td>
                                      <?php if ($row->status == "Masuk") { ?>
                                         <span class="badge badge-success"> Masuk </span>
                                      <?php } else if ($row->status == "Cuti") { ?>
                                         <span class="badge badge-warning"> Cuti </span>
                                      <?php } else if ($row->status == "Izin") { ?>
                                         <span class="badge badge-primary"> Izin </span>
                                      <?php } else if ($row->status == "Alpha") { ?>
                                         <span class="badge badge-dark"> Alpha </span>
                                      <?php } else if ($row->status == "Sakit") { ?>
                                         <span class="badge badge-secondary"> Sakit </span>
                                      <?php } ?>
                                   </td>
                                   <td><strong><?= $row->jam_masuk_reguler ?></strong></td>
                                   <td><strong><?= $row->jam_pulang_reguler ?></strong></td>
                                   <td>
                                      <a class="btn btn-sm btn-outline-primary" href="javascript:void(0);" data-toggle="modal" data-target="#exampleModalCenter<?= $row->id_absen ?>">Edit</a>&nbsp;
                                      <a class="btn btn-sm btn-outline-danger" href="<?= site_url('admin/absensi/delete/' . $row->id_absen) ?>">Hapus</a>
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

  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
           <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Upload File Absensi</strong></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                 </svg>
              </button>
           </div>
           <form action="<?= site_url('admin/absensi/upload') ?>" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                 <div class="row">
                    <div class="col-md-12">
                       <label class="ml-1">Unggah File <span class="text-danger">*</span></label>
                       <input type="file" name="excel_file" class="form-control" accept=".xls, .xlsx">
                       <span style="float: right;" class="text-muted mt-2 mb-4"><strong class="text-danger">*</strong> Ukuran file : 2 MB</span>
                    </div>
                 </div>
              </div>
              <div class="modal-footer">
                 <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                 <button type="submit" class="btn btn-primary">Upload</button>
              </div>
           </form>
        </div>
     </div>
  </div>


  <?php foreach ($absen as $row) : ?>
     <div class="modal fade" id="exampleModalCenter<?= $row->id_absen ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Ubah Data Absensi : <i><?= $row->nama_karyawan ?></i></strong></h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                       <line x1="18" y1="6" x2="6" y2="18"></line>
                       <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                 </button>
              </div>
              <form action="<?= site_url('admin/absensi/proses_ubah') ?>" method="post">
                 <div class="modal-body">
                    <div class="row">

                       <div class="col-md-12">
                          <label class="ml-1">Tanggal Absensi </label>
                          <input type="hidden" name="id_absen" value="<?= $row->id_absen ?>">
                          <input type="date" name="tanggal" class="form-control" value="<?= $row->tanggal ?>">
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Shift </label>
                          <select name="shift" class="form-control">
                             <option hidden value="<?= $row->shift ?>"><?= $row->shift ?></option>
                             <option value="08.00 - 17.00">08.00 - 17.00</option>
                             <option value="09.00 - 18.00">09.00 - 18.00</option>
                          </select>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Status Absen </label>
                          <select name="status" class="form-control">
                             <option hidden value="<?= $row->status ?>"><?= $row->status ?></option>
                             <option value="Masuk">Masuk</option>
                             <option value="Cuti">Cuti</option>
                             <option value="Izin">Izin</option>
                             <option value="Alpha">Alpha</option>
                             <option value="Sakit">Sakit</option>
                          </select>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Jam Masuk </label>
                          <input type="time" name="jam_masuk_reguler" class="form-control" value="<?= $row->jam_masuk_reguler ?>">
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Jam Pulang </label>
                          <input type="time" name="jam_pulang_reguler" class="form-control" value="<?= $row->jam_pulang_reguler ?>">
                       </div>

                       <div class="col-md-3 mt-3">
                          <label class="ml-1">Jam Masuk Lembur </label>
                          <input type="time" name="jam_masuk_lembur" class="form-control" value="<?= $row->jam_masuk_lembur ?>">
                       </div>

                       <div class="col-md-3 mt-3">
                          <label class="ml-1">Jam Pulang Lembur</label>
                          <input type="time" name="jam_pulang_lembur" class="form-control" value="<?= $row->jam_pulang_lembur ?>">
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Aktivitas</label>
                          <input type="number" name="aktivitas" class="form-control" value="<?= $row->aktivitas ?>">
                       </div>

                    </div>
                 </div>
                 <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                 </div>
              </form>
           </div>
        </div>
     </div>
  <?php endforeach; ?>