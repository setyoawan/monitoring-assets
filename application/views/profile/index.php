<!-- Begin Page Content -->
<div class="container-fluid">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body custom-profil text-center">
                    <img class="img-profile" src="<?= base_url('assets/img/profile/') . $user['image']; ?>">
                    <h5><?= $user['name']; ?></h5>
                    <?php
                    if ($user['role_id'] == 1) {
                        echo '<p>Administrator</p>';
                    } else if ($user['role_id'] == 2) {
                        echo '<p>ICT</p>';
                    } else if ($user['role_id'] == 3) {
                        echo '<p>User Operasional</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-md-12">Full Name</label>
                        <div class="col-md-12">
                            <h4 class="form-control form-control-line"><?= $user['name'];  ?></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-email" class="col-md-12">Email</label>
                        <div class="col-md-12">
                            <h4 class="form-control form-control-line"><?= $user['email'];  ?></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Member since</label>
                        <div class="col-md-12">
                            <h4 class="form-control form-control-line"><?= date('d F Y', $user['date_created']); ?></h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <a href="<?= base_url('profile/edit'); ?>" type="submit" class="btn btn-primary">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->