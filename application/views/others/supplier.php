  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
     <div class="layout-px-spacing">



        <div class="row layout-top-spacing" id="cancel-row">

           <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
              <div class="widget widget-chart-three">
                 <div class="widget-heading">
                    <div class="">
                       <h5 class="">Data Supplier</h5>
                    </div>

                    <?php if ($this->session->userdata('role') == 4) : ?>
                       <div class="dropdown ">
                          <a class="dropdown-toggle" href="javascript:void(0);" data-toggle="modal" data-target="#exampleModalCenter" role="button">
                             <i class="fas fa-plus-circle fa-lg text-primary"></i>
                          </a>
                       </div>
                    <?php endif; ?>
                 </div>

                 <div class="widget-content">
                    <div class="widget-content widget-content-area br-6">
                       <table id="zero-config" class="table table-striped" style="width:100%">
                          <thead>
                             <tr>
                                <th>No.</th>
                                <th>Kode Supplier</th>
                                <th>Nama Supplier</th>
                                <?php if ($this->session->userdata('role') == 4) : ?>
                                   <th class="no-content"></th>
                                <?php endif; ?>
                             </tr>
                          </thead>
                          <tbody>
                             <?php $no = 1;
                              foreach ($supplier as $row) : ?>
                                <tr>
                                   <td><?= $no++; ?></td>
                                   <td class="text-secondary"><strong><?= $row->id_supplier ?></strong></td>
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
                                               <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#exampleModalCenter<?= $row->id_supplier ?>">Update</a>
                                               <a class="dropdown-item" href="<?= site_url('others/supplier/delete/' . $row->id_supplier) ?>">Delete</a>
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

  <!-- Modal create-->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
           <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Tambah Supplier</strong></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                 </svg>
              </button>
           </div>
           <form action="<?= site_url('others/supplier/proses') ?>" method="post">
              <div class="modal-body">
                 <div class="row">
                    <div class="col-md-12">
                       <label class="ml-1">Nama Supplier <span class="text-danger">*</span></label>
                       <input type="hidden" name="id_supplier" value="<?php echo $id_supplier; ?>">
                       <input type="text" name="nama_supplier" class="form-control" placeholder="Nama Supplier">
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

  <!-- Modal update-->
  <?php foreach ($supplier as $row) : ?>
     <div class="modal fade" id="exampleModalCenter<?= $row->id_supplier ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Ubah Data Supplier : <i><?= $row->id_supplier ?></i></strong></h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                       <line x1="18" y1="6" x2="6" y2="18"></line>
                       <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                 </button>
              </div>
              <form action="<?= site_url('others/supplier/proses_ubah') ?>" method="post">
                 <div class="modal-body">
                    <div class="row">

                       <div class="col-md-12">
                          <label class="ml-1">Nama Supplier <span class="text-danger">*</span></label>
                          <input type="hidden" name="id_supplier" value="<?= $row->id_supplier ?>">
                          <input type="text" name="nama_supplier" class="form-control" value="<?= $row->nama_supplier ?>">
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