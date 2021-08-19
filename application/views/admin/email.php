<!-- Begin Page Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <?= $this->session->flashdata('message'); ?>

                    <form action="<?= base_url('admin/email'); ?>" method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject">
                            <?= form_error('subject', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="isi">Template</label>
                            <textarea type="text" class="form-control" id="isi" name="isi"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Send Email</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- End of Main Content -->
<script type="text/javascript" src="<?php echo base_url('assets'); ?>/ckeditor/ckeditor.js"></script>

<!-- load jquery-ui -->
<script src="<?= base_url('assets/'); ?>js/jquery-ui.js"></script>
<script src="<?= base_url('assets/'); ?>js/jquery-ui.min.js"></script>

<script>
    // Replace the <textarea id="editor1"> with a CKEditor 4
    // instance, using default configuration.
    CKEDITOR.replace('isi');


    // Initialize 
    $("#email").autocomplete({
        source: function(request, response) {
            // Fetch data
            $.ajax({
                url: "<?= base_url() ?>admin/userList",
                type: 'post',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            // Set selection
            $('#email').val(ui.item.label); // display the selected text
            // $('#userid').val(ui.item.value); // save selected id to input
            return false;
        }
    });
</script>