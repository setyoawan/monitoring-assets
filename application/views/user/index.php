<!-- Begin Page Content -->
<div class="container-fluid">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
        </ol>
    </nav>
    <?= $this->session->flashdata('message'); ?>
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Itam</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="itam-data-user" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Saat ini memegang</th>
                            <th>Status</th>
                            <th>Kebutuhan</th> 
                            <th>Aksi</th>                           
                        </tr>
                    </thead>                    
                </table>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->



