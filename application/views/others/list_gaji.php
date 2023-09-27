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
                       <a class="btn btn-sm btn-secondary" href="<?= site_url('others/payslip/hitung_gaji') ?>">
                          <i class="fas fa-cloud-arrow-up fa-lg text-white"></i>&nbsp; Buat Slip Satuan
                       </a>
                    </div>
                 </div>

                 <div class="widget-content">
                    <div class="widget-content widget-content-area br-6">

                       <form method="POST" action="<?= base_url('others/payslip/proses_multiple'); ?>">
                          <table id="zero-config1" class="table table-striped" style="width:100%">
                             <thead>
                                <tr>
                                   <th>Nama Karyawan</th>
                                   <th>Jabatan</th>
                                   <th>Qty</th>
                                   <th>Bonus Kinerja</th>
                                   <th>PPH21</th>
                                   <th>Pinjaman</th>
                                   <th>Tipe Potongan</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php $no = 1;
                                 foreach ($add as $row) : ?>
                                   <tr>
                                      <?php
                                       // Generate angka acak antara 10000000 dan 999999999
                                       $angka_acak = mt_rand(10000000, 999999999);

                                       // Generate karakter acak huruf kapital
                                       $karakter_acak = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5);

                                       // Gabungkan angka acak dan karakter acak
                                       $no_pembayaran = $angka_acak . $karakter_acak;
                                       ?>
                                      <td>
                                         <input type="hidden" name="id_karyawan[]" value="<?= $row->id_karyawan; ?>">
                                         <input type="hidden" name="user_id[]" value="<?= $row->user_id; ?>">
                                         <?= $row->nama_karyawan; ?>
                                      </td>
                                      <td>
                                         <input type="hidden" name="id_pembayaran[]" value="<?= $no_pembayaran; ?>">
                                         <input type="hidden" name="id_jabatan[]" value="<?= $row->id_jabatan; ?>">
                                         <input type="hidden" name="gaji_pokok[]" value="<?= $row->gaji_pokok; ?>">
                                         <input type="hidden" name="tunjangan_jabatan[]" value="<?= $row->tunjangan_jabatan; ?>">
                                         <input type="hidden" name="tunjangan_makan[]" value="<?= $row->tunjangan_makan; ?>">
                                         <input type="hidden" name="tunjangan_aktivitas[]" value="<?= $row->tunjangan_aktifitas; ?>">
                                         <input type="hidden" name="tipe_pajak[]" value="<?= $row->tipe_pajak; ?>">
                                         <input type="hidden" name="nominal_pajak[]" value="<?= $row->nominal_pajak; ?>">
                                         <input type="hidden" name="bpjs[]" value="<?= $row->bpjs; ?>">
                                         <input type="hidden" name="tunjangan_makan[]" value="<?= $row->tunjangan_makan; ?>">
                                         <input type="hidden" name="id_departement[]" value="<?= $row->id_departement; ?>">
                                         <input type="hidden" name="pph23[]" value="<?= $row->tipe_pajak; ?>">
                                         <?= $row->nama_jabatan; ?>
                                      </td>
                                      <td><input type="text" class="form-control" name="qty[]" value="<?= $row->qty; ?>" readonly></td>
                                      <td><input type="number" class="form-control" name="bonus_kinerja[]" value="0"></td>
                                      <td><input type="number" class="form-control" name="pph21[]" value="0"></td>
                                      <td><input type="number" class="form-control" name="pinjaman[]" value="0"></td>
                                      <td> <select name="id_potongan[]" class="form-control mt-2">
                                            <option hidden>Pilih</option>
                                            <?php foreach ($potongan as $pot) : ?>
                                               <option value="<?= $pot->id_potongan ?>"><?= $pot->tipe_potongan ?></option>
                                            <?php endforeach; ?>
                                         </select></td>
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
                       <h5 class="">Daftar Pembayaran Gaji</h5>
                    </div>
                 </div>

                 <div class="widget-content">
                    <div class="widget-content widget-content-area br-6">
                       <table id="zero-config" class="table table-striped" style="width:100%">
                          <thead>
                             <tr>
                                <th>No.</th>
                                <th>Tanggal Pembayaran</th>
                                <th>No. Transaksi</th>
                                <th>Total Pembayaran</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Departement</th>
                                <th class="no-content"></th>
                             </tr>
                          </thead>
                          <tbody>
                             <?php $no = 1;
                              foreach ($data as $row) : ?>
                                <tr>
                                   <td><?= $no++; ?></td>
                                   <td><?php echo date('d F Y', strtotime($row->tanggal_pembayaran)); ?></td>
                                   <td class="text-secondary"><strong><?= $row->id_pembayaran ?></strong></td>
                                   <td class="text-success"><strong>Rp. <?= is_numeric($row->tunjangan_aktivitas) && is_numeric($row->qty) ? number_format($row->tunjangan_aktivitas * $row->qty + $row->gaji_pokok + $row->tunjangan_jabatan + $row->tunjangan_makan + $row->upah_lembur + $row->bonus_kinerja - $row->pph21 - $row->bpjs - $row->pinjaman - $row->pot_absensi) : number_format($row->gaji_pokok + $row->tunjangan_jabatan + $row->tunjangan_makan + $row->upah_lembur + $row->bonus_kinerja - $row->pph21 - $row->bpjs - $row->pinjaman - $row->pot_absensi) ?></strong></td>
                                   <td><?= $row->nama_karyawan ?></td>
                                   <td><?= $row->nama_jabatan ?></td>
                                   <td><?= $row->nama_departement ?></td>
                                   <td>
                                      <a class="btn btn-sm btn-outline-primary" href="javascript:void(0);" data-toggle="modal" data-target="#exampleModalCenter<?= $row->id_pembayaran ?>">Edit</a>&nbsp;
                                      <a class="btn btn-sm btn-outline-dark" target="_blank" href="<?= site_url('others/payslip/exportToPDF/' . $row->id_pembayaran) ?>">Download</a>
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

  <?php foreach ($data as $row) : ?>
     <div class="modal fade" id="exampleModalCenter<?= $row->id_pembayaran ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Ubah Data Pembayaran : <i><?= $row->id_pembayaran ?></i></strong></h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                       <line x1="18" y1="6" x2="6" y2="18"></line>
                       <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                 </button>
              </div>
              <form action="<?= site_url('others/payslip/proses_ubah') ?>" method="post">
                 <div class="modal-body">
                    <div class="row">

                       <div class="col-md-6">
                          <label class="ml-1">Tanggal Pembayaran <span class="text-danger">*</span></label>
                          <input type="hidden" name="id_pembayaran" value="<?= $row->id_pembayaran ?>">
                          <input type="date" name="tanggal_pembayaran" class="form-control" value="<?= $row->tanggal_pembayaran ?>">
                       </div>

                       <div class="col-md-6">
                          <label class="ml-1">Tanggal Penggajian <span class="text-danger">*</span></label>
                          <input type="date" name="tanggal_penggajian" class="form-control" value="<?= $row->tanggal_penggajian ?>">
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Gaji Pokok <span class="text-danger">*</span></label>
                          <input type="text" name="gaji_pokok" class="form-control" <?= $row->gaji_pokok !== null ? 'value="' . $row->gaji_pokok . '"' : 'placeholder="0"' ?>>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Upah Lembur <span class="text-danger">*</span></label>
                          <input type="text" name="upah_lembur" class="form-control" <?= $row->upah_lembur !== null ? 'value="' . $row->upah_lembur . '"' : 'placeholder="0"' ?>>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Tunjangan Aktivitas <span class="text-danger">*</span></label>
                          <input type="text" name="tunjangan_aktivitas" class="form-control" <?= $row->tunjangan_aktivitas !== null ? 'value="' . $row->tunjangan_aktivitas . '"' : 'placeholder="0"' ?>>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Tunjangan Jabatan <span class="text-danger">*</span></label>
                          <input type="text" name="tunjangan_jabatan" class="form-control" <?= $row->tunjangan_jabatan !== null ? 'value="' . $row->tunjangan_jabatan . '"' : 'placeholder="0"' ?>>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Tunjangan Makan <span class="text-danger">*</span></label>
                          <input type="text" name="tunjangan_makan" class="form-control" <?= $row->tunjangan_makan !== null ? 'value="' . $row->tunjangan_makan . '"' : 'placeholder="0"' ?>>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Bonus Kinerja <span class="text-danger">*</span></label>
                          <input type="text" name="bonus_kinerja" class="form-control" <?= $row->bonus_kinerja !== null ? 'value="' . $row->bonus_kinerja . '"' : 'placeholder="0"' ?>>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">PPH 21 <span class="text-danger">*</span></label>
                          <input type="text" name="pph21" class="form-control" <?= $row->pph21 !== null ? 'value="' . $row->pph21 . '"' : 'placeholder="0"' ?>>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">BPJS <span class="text-danger">*</span></label>
                          <input type="text" name="bpjs" class="form-control" <?= $row->bpjs !== null ? 'value="' . $row->bpjs . '"' : 'placeholder="0"' ?>>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Pinjaman <span class="text-danger">*</span></label>
                          <input type="text" name="pinjaman" class="form-control" <?= $row->pinjaman !== null ? 'value="' . $row->pinjaman . '"' : 'placeholder="0"' ?>>
                       </div>

                       <div class="col-md-6 mt-3">
                          <label class="ml-1">Potongan Absensi <span class="text-danger">*</span></label>
                          <input type="text" name="pot_absensi" class="form-control" <?= $row->pot_absensi !== null ? 'value="' . $row->pot_absensi . '"' : 'placeholder="0"' ?>>
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