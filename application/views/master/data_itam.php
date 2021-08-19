<!-- Begin Page Content -->
<div class="container-fluid">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-10">
            <form method="post" action="<?= base_url('master/uploadItam'); ?>" enctype="multipart/form-data">
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
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Itam</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="itam-data" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Model</th>
                            <th>Category</th>
                            <th>Username</th>
                            <th>Harga</th>
                            <th>Jumlah_device</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Company</th>
                            <th>Model</th>
                            <th>Category</th>
                            <th>Username</th>
                            <th>Harga</th>
                            <th>Jumlah Device</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

