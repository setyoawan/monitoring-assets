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
    </div> -->
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#inputModal"><i class="fas fa-plus"></i> Add New User</a>
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#importExcel"><i class="fas fa-file-excel"></i> Import Excel</a>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Nik</th>
                            <th>Role</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($usermanagement as $p) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $p->name; ?></td>
                                <td><?= $p->email; ?></td>
                                <td><?= $p->nik; ?></td>
                                <td>
                                    <?php if ($p->role_id == 1) {
                                        echo '<p>Administrator</p>';
                                    } else if ($p->role_id == 2) {
                                        echo '<p>ICT</p>';
                                    } else if ($p->role_id == 3) {
                                        echo '<p>User</p>';
                                    }
                                    ?>
                                </td>
                                <td><?= $p->is_active; ?></td>
                                <td>
                                    <a data-toggle="modal" data-target="#editModal<?= $p->id; ?>" class="btn btn-sm btn-warning" title="Edit Data" style="color:white;cursor:pointer"><i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= base_url('admin/hapusUser/') . $p->id ?>" onclick="return confirm('Apakah Anda Ingin Menghapus User <?= $p->name ?> ?');" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fa fa-trash"></i> Delete
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
            <form action="<?= base_url('admin/usermanagement'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input name="name" placeholder="Full name" class="form-control" type="text" value="<?= set_value('name'); ?>">
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <input name="email" placeholder="Email Address" class="form-control" type="text" value="<?= set_value('email'); ?>">
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small> '); ?>
                    </div>
                    <div class="form-group">
                        <input name="nik" placeholder="Nik" class="form-control" type="text" value="<?= set_value('nik'); ?>">
                        <?= form_error('nik', '<small class="text-danger pl-3">', '</small> '); ?>
                    </div>
                    <div class="form-group">
                        <input name="password1" placeholder="Password" class="form-control" type="password">
                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small> '); ?>
                    </div>
                    <div class="form-group">
                        <input name="password2" placeholder="Repeat Password" class="form-control" type="password">
                    </div>
                    <select name="role_id" id="role_id" class="form-control">
                        <option selected disabled>Select Role</option>
                        <?php foreach ($role as $m) : ?>
                            <option value="<?= $m['id']; ?>"><?= $m['role']; ?></option>
                        <?php endforeach; ?>
                    </select>
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
<?php foreach ($usermanagement as $p) : ?>
    <div class="modal fade" id="editModal<?= $p->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/editUser'); ?>" method="post">
                    <input type="hidden" name="id" value="<?= $p->id; ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <input name="name" placeholder="Full name" class="form-control" type="text" value="<?= $p->name; ?>">
                            <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input name="email" placeholder="Email Address" class="form-control" type="text" value="<?= $p->email; ?>">
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small> '); ?>
                        </div>
                        <div class="form-group">
                            <input name="nik" placeholder="Nik" class="form-control" type="text" value="<?= $p->nik; ?>">
                            <?= form_error('nik', '<small class="text-danger pl-3">', '</small> '); ?>
                        </div>
                        <div class="form-group">
                            <input name="password1" placeholder="Password" class="form-control" type="password">
                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small> '); ?>
                        </div>

                        <select name="role_id" id="role_id" class="form-control">
                            <?php foreach ($role as $m) {
                                if ($p->role_id == $m['id']) {
                                    $select = "selected";
                                } else {
                                    $select = "";
                                }
                                echo "<option value=" . $m['id'] . " $select>" . $m['role'] . "</option>";
                            } ?>
                        </select>
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


<!-- Modal import excel-->
<div class="modal fade bd-example-modal-lg" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Import Data: User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col text-center">
                        <p><b>Step 1: Download Template</b></p>
                        <a href="<?= base_url('admin/downloadtemplate'); ?>" class="btn btn-primary mb-3"><i class="fas fa-file-excel"></i> Download</a>
                        <p>— Don't forget to remove example row —</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col text-center">
                        <p><b>Step 2: Upload Excel Data</b></p>
                        <form method="post" action="<?= base_url('admin/uploadUser'); ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="excel" name="userfile">
                                            <label class="custom-file-label" for="excel">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p>— Make sure you upload the correct file —</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>