<!-- Begin Page Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
        </ol>
    </nav>

    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?= $this->session->flashdata('message'); ?>

    <!-- <div class="row">
        <div class="col-md-10">
            <form method="post" action="<?= base_url('admin/uploadUser'); ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excel" name="userfile">
                                <label class="custom-file-label" for="excel">Choose file</label>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-2">
            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#inputModal"><i class="fas fa-plus"></i> Add New User</a>
        </div>
    </div> -->
    
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#inputModal"><i class="fas fa-plus"></i> Add New Assets</a>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Assets</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Code</th>
                            <th>Category</th>
                            <th>Budget alct</th>
                            <th>Specs</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($assets as $p) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $p->code; ?></td>
                                <td><?= $p->category; ?></td>
                                <td><?= $p->budget_alct; ?></td>
                                <td><?= $p->specs; ?></td>
                                <td>
                                    <a data-toggle="modal" data-target="#editModal<?= $p->id; ?>" class="btn btn-sm btn-warning" title="Edit Data" style="color:white;cursor:pointer"><i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= base_url('master/deleteAssets/') . $p->id ?>" onclick="return confirm('Apakah Anda Ingin Menghapus Assets <?= $p->code ?> ?');" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Tambah-->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/assets'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input name="code" placeholder="Code" class="form-control" type="text" value="<?= set_value('name'); ?>">
                        <?= form_error('code', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <select name="category" id="category" class="form-control">
                            <option value="">Category</option>
                            <option value="Laptop">Laptop</option>
                            <option value="	Desktop Computer">	Desktop Computer</option>
                        </select>
                    </div>  
                    <div class="form-group">
                        <input name="budget" placeholder="Budget" class="form-control" type="text" value="<?= set_value('email'); ?>">
                        <?= form_error('budget', '<small class="text-danger pl-3">', '</small> '); ?>
                    </div>                                      
                    <div class="form-group">
                        <input name="specs" placeholder="Specs" class="form-control" type="text" value="<?= set_value('email'); ?>">
                        <?= form_error('specs', '<small class="text-danger pl-3">', '</small> '); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Edit-->
<?php foreach ($assets as $p) : ?>
    <div class="modal fade" id="editModal<?= $p->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('master/editAssets'); ?>" method="post">
                    <input type="hidden" name="id" value="<?= $p->id; ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <input name="code" placeholder="Code" class="form-control" type="text" value="<?= $p->code; ?>">
                            <?= form_error('code', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input name="category" placeholder="Category" class="form-control" type="text" value="<?= $p->category; ?>">
                            <?= form_error('category', '<small class="text-danger pl-3">', '</small> '); ?>
                        </div>
                        <div class="form-group">
                            <input name="budget" placeholder="Budget" class="form-control" type="text" value="<?= $p->budget_alct; ?>">
                            <?= form_error('budget', '<small class="text-danger pl-3">', '</small> '); ?>
                        </div>                        
                        <div class="form-group">
                            <input name="specs" placeholder="Specs" class="form-control" type="text" value="<?= $p->specs; ?>">
                            <?= form_error('specs', '<small class="text-danger pl-3">', '</small> '); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>