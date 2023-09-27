  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
     <div class="layout-px-spacing">



        <div class="row layout-top-spacing" id="cancel-row">

           <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
              <div class="widget widget-chart-three">
                 <div class="widget-heading">
                    <div class="">
                       <h5 class="">Tambah Data Keseluruhan</h5>
                    </div>

                    <div class="dropdown ">
                       <a class="btn btn-sm btn-secondary" href="javascript:void(0);" data-toggle="modal" data-target="#exampleModalCenter">
                          <i class="fas fa-cloud-arrow-up fa-lg text-white"></i>&nbsp; Unggah File
                       </a>
                    </div>
                 </div>

                 <div class="widget-content">
                    <div class="widget-content widget-content-area br-6">

                       <form onsubmit="return validateForm();" method="POST" action="<?= base_url('other/absensi/proses_multiple'); ?>">
                          <table id="zero-config1" class="table table-striped" style="width:100%">
                             <thead>
                                <tr>
                                   <th>Nama Karyawan</th>
                                   <th>Jabatan</th>
                                   <th>Waktu Absen</th>
                                   <th>Lokasi Kerja</th>
                                   <th>Shift Time</th>
                                   <th>Jam Alternatif</th>
                                   <th>Aktivitas</th>
                                   <th>Kesehatan</th>
                                   <th>Keterangan</th>
                                   <th>Qty Kinerja</th>
                                   <th>Catatan</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php $no = 1;
                                 foreach ($add as $row) : ?>
                                   <tr>
                                      <td>
                                         <input type="hidden" name="user_id[]" value="<?= $row->user_id; ?>">
                                         <?= $row->nama_karyawan; ?>
                                      </td>
                                      <td>
                                         <?= $row->nama_jabatan; ?>
                                      </td>
                                      <td><input type="datetime-local" name="waktu[]" class="form-control" style="width: 250px;"></td>
                                      <td><input type="text" class="form-control" name="lokasi_kerja[]" placeholder="Latitude: -6.2114, Longitude: 106.8446" style="width: 350px;"></td>
                                      <td>
                                         <select id="shiftSelect" name="shift_line[]" class="form-control" onchange="showTime(this)" style="width: 130px;">
                                            <option hidden>Shift</option>
                                            <option value="08.00 - 17.00">08.00 - 17.00</option>
                                            <option value="09.00 - 18.00">09.00 - 18.00</option>
                                            <option value="Paruh Waktu">Paruh Waktu</option>
                                         </select>
                                      </td>
                                      <td>
                                         <div class="alternatif" style="display: none;">
                                            <input type="text" name="jam_masuk_alternatif[]" placeholder="Jam Masuk">
                                            <input type="text" name="jam_pulang_alternatif[]" placeholder="Jam Pulang">
                                         </div>
                                      </td>
                                      <td><input type="text" class="form-control" name="aktivitas[]" style="width: 250px;"></td>
                                      <td>
                                         <select name="kondisi_kesehatan[]" class="form-control" style="width: 130px;">
                                            <option hidden>Kondisi</option>
                                            <option value="SEHAT">SEHAT</option>
                                            <option value="TIDAK FIT">TIDAK FIT</option>
                                            <option value="SAKIT">SAKIT</option>
                                         </select>
                                      </td>
                                      <td>
                                         <select name="keterangan[]" class="form-control" onchange="showQty(this)" style="width: 130px;">
                                            <option hidden value="masuk">Status</option>
                                            <option value="masuk">masuk</option>
                                            <option value="pulang">pulang</option>
                                         </select>
                                      </td>
                                      <td><input type="number" name="kinerja[]" class="form-control qty" style="display: none;"></td>
                                      <td><input type="text" name="catatan[]" class="form-control" style="width: 250px;"></td>
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
                                <th>Nama</th>
                                <th>Waktu Kerja</th>
                                <th>Kondisi</th>
                                <th>Aktivitas</th>
                                <th>Waktu Absen</th>
                                <th>Lokasi</th>
                                <th>Keterangan</th>
                                <th class="no-content"></th>
                             </tr>
                          </thead>
                          <tbody>
                             <?php $no = 1;
                              foreach ($absen as $row) : ?>
                                <tr>
                                   <td><?php echo date('d F Y', strtotime($row->estimated)); ?></td>
                                   <td><strong><?= $row->nama_karyawan ?></strong> <br><?= $row->id_karyawan ?></td>
                                   <td><strong><?= $row->shift_line ?></strong> <br><?= $row->jam_masuk_alternatif ?> - <?= $row->jam_pulang_alternatif ?></td>
                                   <td><strong><?= $row->kondisi_kesehatan ?></strong></td>
                                   <td><?= $row->aktivitas ?></td>
                                   <td>
                                      <?php
                                       // Mengatur zona waktu ke WIB
                                       date_default_timezone_set('Asia/Jakarta');

                                       // Mengambil data waktu dari $row->waktu dan mengonversinya ke format yang diinginkan
                                       $waktu = strtotime($row->waktu);
                                       $formattedTime = date('d F Y, H:i', $waktu);

                                       // Menambahkan informasi WIB
                                       $formattedTimeWithWIB = $formattedTime . ' WIB';

                                       echo $formattedTimeWithWIB;
                                       ?>
                                   </td>
                                   <?php
                                    // Mencari koordinat Latitude dan Longitude dalam string
                                    preg_match('/Latitude: ([-\d.]+), Longitude: ([-\d.]+)/', $row->lokasi_kerja, $matches);

                                    if (count($matches) == 3) {
                                       // Ambil nilai Latitude dan Longitude
                                       $latitude = trim($matches[1]);
                                       $longitude = trim($matches[2]);

                                       // URL Google Maps dengan koordinat Latitude dan Longitude
                                       $mapsUrl = "https://www.google.com/maps?q={$latitude},{$longitude}";
                                    } else {
                                       $mapsUrl = '#'; // Tautan tidak valid jika format tidak sesuai
                                    }
                                    ?>
                                   <td><a target="_blank" href="<?= $mapsUrl ?>" class="text-secondary"><i class="fas fa-location-dot"></i>&nbsp; Lihat Lokasi</a></td>
                                   <td>
                                      <?php if ($row->keterangan == "masuk") { ?>
                                         <span class="badge badge-success"> Masuk </span>
                                      <?php } else { ?>
                                         <span class="badge badge-danger"> Pulang </span>
                                      <?php } ?>
                                   </td>
                                   <td>
                                      <a class="btn btn-sm btn-outline-primary" href="javascript:void(0);" data-toggle="modal" data-target="#exampleModalCenter<?= $row->id_absen ?>">Edit</a>&nbsp;
                                      <a class="btn btn-sm btn-outline-danger" href="<?= site_url('other/absensi/delete/' . $row->id_absen) ?>">Hapus</a>
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


  <!-- Modal create-->
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
           <form action="<?= site_url('other/absensi/upload') ?>" method="post" enctype="multipart/form-data">
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
              <form action="<?= site_url('other/absensi/proses_ubah') ?>" method="post">
                 <div class="modal-body">
                    <div class="row">

                       <div class="col-md-6">
                          <label class="ml-1">Tanggal Absensi <span class="text-danger">*</span></label>
                          <input type="hidden" name="id_absen" value="<?= $row->id_absen ?>">
                          <input type="datetime-local" name="waktu" class="form-control" value="<?= $row->waktu ?>">
                       </div>

                       <div class="col-md-6">
                          <label class="ml-1">Tanggal input <span class="text-danger">*</span></label>
                          <input type="date" name="estimated" class="form-control" value="<?= $row->estimated ?>">
                       </div>

                       <div class="col-md-12 mt-3">
                          <label class="ml-1">Lokasi Kerja <span class="text-danger">*</span></label>
                          <input type="text" name="lokasi_kerja" class="form-control" <?= $row->lokasi_kerja !== '' ? 'value="' . $row->lokasi_kerja . '"' : 'placeholder="Latitude: -6.2114, Longitude: 106.8446"' ?>>
                       </div>

                       <?php if ($row->shift_line == "Paruh Waktu") { ?>
                          <div class="col-md-6 mt-3">
                             <label class="ml-1">Shift Kerja <span class="text-danger">*</span></label>
                             <select name="shift_line" class="form-control">
                                <option hidden value="<?= $row->shift_line ?>"><?= $row->shift_line ?></option>
                                <option value="08.00 - 17.00">08.00 - 17.00</option>
                                <option value="09.00 - 18.00">09.00 - 18.00</option>
                                <option value="Paruh Waktu">Paruh Waktu</option>
                             </select>
                          </div>

                          <div class="col-md-3 mt-3">
                             <label class="ml-1">Jam Masuk <span class="text-danger">*</span></label>
                             <input type="text" class="form-control" name="jam_masuk_alternatif" value="<?= $row->jam_masuk_alternatif ?>">
                          </div>

                          <div class="col-md-3 mt-3">
                             <label class="ml-1">Jam Pulang <span class="text-danger">*</span></label>
                             <input type="text" class="form-control" name="jam_pulang_alternatif" value="<?= $row->jam_pulang_alternatif ?>">
                          </div>
                       <?php } else { ?>
                          <div class="col-md-12 mt-3">
                             <label class="ml-1">Shift Kerja <span class="text-danger">*</span></label>
                             <select name="shift_line" class="form-control">
                                <option hidden value="<?= $row->shift_line ?>"><?= $row->shift_line ?></option>
                                <option value="08.00 - 17.00">08.00 - 17.00</option>
                                <option value="09.00 - 18.00">09.00 - 18.00</option>
                                <option value="Paruh Waktu">Paruh Waktu</option>
                             </select>
                          </div>
                       <?php } ?>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Kondisi Kesehatan <span class="text-danger">*</span></label>
                          <select name="kondisi_kesehatan" class="form-control">
                             <option hidden value="<?= $row->kondisi_kesehatan ?>"><?= $row->kondisi_kesehatan ?></option>
                             <option value="SEHAT">SEHAT</option>
                             <option value="TIDAK FIT">TIDAK FIT</option>
                             <option value="SAKIT">SAKIT</option>
                          </select>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Keterangan Absen <span class="text-danger">*</span></label>
                          <select name="keterangan" class="form-control">
                             <option hidden value="<?= $row->keterangan ?>"><?= $row->keterangan ?></option>
                             <option value="masuk">masuk</option>
                             <option value="pulang">pulang</option>
                          </select>
                       </div>

                       <div class="col-md-12 mt-3">
                          <label class="ml-1">Catatan <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" name="catatan" value="<?= $row->catatan ?>">
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

  <script>
     function showQty(select) {
        var qtyField = select.parentElement.parentElement.querySelector('.qty');
        qtyField.style.display = select.value === 'pulang' ? 'block' : 'none';
     }
  </script>

  <script>
     function showTime(select) {
        var timeField = select.parentElement.parentElement.querySelector('.alternatif');
        timeField.style.display = select.value === 'Paruh Waktu' ? 'block' : 'none';
     }
  </script>

  <script>
     function validateForm() {
        var selectBox = document.getElementById("shiftSelect");
        var selectedOption = selectBox.options[selectBox.selectedIndex];

        if (selectedOption.value === 'Shift') {
           alert("Harap pilih opsi Shift yang valid.");
           return false; // Mencegah form dari submit
        }

        return true; // Izinkan form untuk submit
     }
  </script>