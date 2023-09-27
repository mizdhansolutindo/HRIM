  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
      <div class="layout-px-spacing">



          <div class="row layout-top-spacing" id="cancel-row">

              <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                  <div class="widget widget-chart-three">
                      <div class="widget-heading">
                          <div class="">
                              <h5 class="">Pengajuan Permintaan Staff Purchasing</h5>
                          </div>
                      </div>

                      <div class="widget-content">
                          <div class="widget-content widget-content-area br-6">
                              <table id="zero-config" class="table table-striped" style="width:100%">
                                  <thead>
                                      <tr>
                                          <th>No.</th>
                                          <th>Invoice ID</th>
                                          <th>Tanggal Pengajuan</th>
                                          <th>Nama Pengaju</th>
                                          <th>Nama Barang</th>
                                          <th>Qty</th>
                                          <th>Status</th>
                                          <th>Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                        $no = 1;
                                        foreach ($request_gudang as $row) : ?>
                                          <tr>
                                              <td><?= $no++; ?></td>
                                              <td><?= $row->invoice_number ?></td>
                                              <td><?php echo date('d F Y', strtotime($row->created_at)); ?></td>
                                              <td><?= $row->nama_karyawan ?></td>
                                              <td><?= $row->nama_brg ?> <br> <small><b>Rp <?= number_format($row->harga) ?></b></small></td>
                                              <td><?= $row->qty ?></td>
                                              <td>
                                                  <?php if ($row->status_permintaan === 'waiting confirm') : ?>
                                                      <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                                  <?php elseif ($row->status_permintaan === 'accept') : ?>
                                                      <span class="badge badge-primary">Disetujui</span>
                                                  <?php elseif ($row->status_permintaan === 'in process') : ?>
                                                      <span class="badge badge-secondary">Dalam Proses</span>
                                                  <?php elseif ($row->status_permintaan === 'finish') : ?>
                                                      <span class="badge badge-success">Permintaan Selesai</span>
                                                  <?php endif; ?>
                                              </td>
                                              <td>
                                                  <?php if ($row->status == 'in process') { ?>
                                                      <button onclick="accFinanceStatusChange(
                                                        '<?php echo base_url('others/permintaan_purchasing/konfirmasi/' . $row->id) ?>',
                                                        '<?php echo $row->invoice_number; ?>',
                                                        '<?php echo $row->nama_karyawan; ?>',
                                                        '<?php echo $row->nama_brg; ?>',
                                                        '<?php echo $row->qty; ?>',
                                                        '<?php echo $row->harga * $row->qty; ?>',
                                                        '<?php echo $row->deadline_at; ?>'
                                                    )" class="btn btn-sm btn-primary"><i class="fas fa-check"></i></button>
                                                  <?php } ?>
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