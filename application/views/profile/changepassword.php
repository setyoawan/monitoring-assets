<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                </ol>
            </nav>
            <div class="card shadow mb-4">
                <!-- <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ganti Password</h6>
                </div> -->
                <div class="card-body">
                    <?= $this->session->flashdata('message'); ?>
                    <form action="<?= base_url('profile/changepassword'); ?>" method="post">
                        <div class="form-group">
                            <label for="current_password">Password saat ini</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                            <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="new_password1">Password baru</label>
                            <input type="password" class="form-control" id="new_password1" name="new_password1">
                            <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="new_password2">Ulangi password baru</label>
                            <input type="password" class="form-control" id="new_password2" name="new_password2">
                            <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->