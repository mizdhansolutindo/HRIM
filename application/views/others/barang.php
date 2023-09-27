  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
      <div class="layout-px-spacing">



          <div class="row layout-top-spacing" id="cancel-row">

              <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                  <div class="widget widget-chart-three">
                      <div class="widget-heading">
                          <div class="">
                              <h5 class="">Data Barang</h5>
                          </div>

                          <?php if ($this->session->userdata('role') == 4) : ?>
                              <div class="dropdown ">
                                  <a class="dropdown-toggle" href="<?= site_url('others/barang/add') ?>" role="button">
                                      <i class="fas fa-plus-circle fa-lg text-primary"></i>
                                  </a>
                              </div>
                          <?php endif; ?>
                      </div>

                      <div class="widget-content">
                          <div class="widget-content widget-content-area br-6">
                              <?php if ($this->session->userdata('role') == 4) : ?>
                                  <a href="<?php echo base_url('others/barang/exportExcel'); ?>" class="mb-2 mt-4 mr-3" style="float: right;">
                                      <i class="fas fa-file-excel fa-xl text-success"></i>
                                  </a>
                              <?php endif; ?>
                              <table id="zero-config" class="table table-striped" style="width:100%">
                                  <thead>
                                      <tr>
                                          <th>No.</th>
                                          <th>Part Number</th>
                                          <th>Nama Barang</th>
                                          <th>Merek Barang</th>
                                          <th>Tipe</th>
                                          <th>Harga</th>
                                          <th>Jumlah</th>
                                          <th>Supplier</th>
                                          <?php if ($this->session->userdata('role') == 4) : ?>
                                              <th class="no-content"></th>
                                          <?php endif; ?>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $no = 1;
                                        foreach ($barang as $row) :
                                            $stok = $row->stok;
                                        ?>
                                          <tr>
                                              <td><?= $no++; ?></td>
                                              <td class="text-secondary"><strong><?= $row->id_brg ?></strong></td>
                                              <td><strong><?= $row->nama_brg ?></strong></td>
                                              <td class="text-uppercase"><strong><?= $row->merek ?></strong></td>
                                              <td><strong><?= $row->nama_kategori ?></strong></td>
                                              <td>Rp. <?= number_format($row->harga) ?></td>
                                              <td data-toggle="tooltip" title="<?= $stok <= 5 ? 'Stok sudah menipis' : '' ?>">
                                                  <?= number_format($stok) ?>
                                              </td>
                                              <td><strong><?= $row->nama_supplier ?></strong></td>
                                              <?php if ($this->session->userdata('role') == 4) : ?>
                                                  <td>
                                                      <div class="dropdown ">
                                                          <a class="dropdown-toggle" href="#" role="button" id="uniqueVisitors" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                                                  <circle cx="12" cy="12" r="1"></circle>
                                                                  <circle cx="19" cy="12" r="1"></circle>
                                                                  <circle cx="5" cy="12" r="1"></circle>
                                                              </svg>
                                                          </a>

                                                          <div class="dropdown-menu mt-4" aria-labelledby="uniqueVisitors">
                                                              <a class="dropdown-item" href="<?= site_url('others/barang/update/' . $row->id_brg) ?>">Update</a>
                                                              <a class="dropdown-item" href="<?= site_url('others/barang/delete/' . $row->id_brg) ?>">Delete</a>
                                                          </div>
                                                      </div>
                                                  </td>
                                              <?php endif; ?>
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

  <script>
      $(document).ready(function() {
          $('[data-toggle="tooltip"]').tooltip();
      });
  </script>