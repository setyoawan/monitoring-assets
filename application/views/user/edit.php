<?php
$id = $this->uri->segment(3);
?>


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
                    <form action="<?= base_url('user/itam'); ?>" method="post" id="form-itam">
                        <input type="hidden" name="id" value="<?= $id; ?>">
                        <div class="form-group">
                            <label for="jenis_kebutuhan">Jenis Kebutuhan</label>
                            <select class="custom-select" name="jenis_kebutuhan" id="jenis_kebutuhan">
                                <option selected disabled>Kebutuhan</option>
                                <option value="1">Diperpanjang</option>
                                <option value="2">Diganti</option>
                            </select>
                        </div>
                        <div class="row type">

                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn-simpan">Update</button>
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

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<script>
    $(document).ready(function() {
        
        $("#form-itam").on("submit", function(e) {
            let prevent = 0;
            e.preventDefault();

            // check page
            if ($("#page").val() == "create") {
                $(" #form-itam input,#form-itam select").each(function() {
                    if ($(this).val() === "" || $(this).val() === null)
                        $(this).addClass("is-invalid").removeClass("is-valid");
                    else {
                        prevent++;
                        $(this).addClass("is-valid").removeClass("is-invalid");
                    }
                });
                // check jenis user
                if ($("#jenis_kebutuhan").val() == 2) {
                    if ($("#type").val() != $("#confirm").val()) {
                        $("#confirm").addClass("is-invalid").removeClass("is-valid");
                    } else {
                        prevent++;
                        $("#confrim").addClass("is-valid").removeClass("is-invalid");
                    }
                }
                // page create jumlah field = 7;
                if (prevent == ($("#jenis_kebutuhan").val() == 0 ? 4 : 7))
                    document.getElementById("form-itam").submit();
            } else {
                $(" #form-itam input[type=text],#form-itam select").each(
                    function() {
                        if ($(this).val() === "" || $(this).val() === null)
                            $(this).addClass("is-invalid").removeClass("is-valid");
                        else {
                            prevent++;
                            $(this).addClass("is-valid").removeClass("is-invalid");
                        }
                    }
                );
                // check jenis user
                if ($("#jenis_kebutuhan").val() == 2) {
                    if ($("#type").val() != $("#confirm").val()) {
                        $("#confirm").addClass("is-invalid").removeClass("is-valid");
                    } else {
                        prevent++;
                        $("#confrim").addClass("is-valid").removeClass("is-invalid");
                    }
                }
                if (prevent == 5) console.log(prevent);
                document.getElementById("form-itam").submit();
            }
        });

        type();
        $("#jenis_kebutuhan").change(type);
    });

    const type = function() {
        const val = $("#jenis_kebutuhan").val();
        if (val == 2) {
            let html = "";
            if ($("#page").val() == "create") {
                html = `<div class="col-sm-6">
                    <label for="type">Type</label>
                    <select class="custom-select" name="type" id="type">                           
                        <option value="Type A">Type A</option>
                        <option value="Type B">Type B</option>
                        <option value="Type C">Type C</option>
                        <option value="Type D">Type D</option>
                    </select>
                </div>`;
            } else {
                html = `
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="custom-select" name="type" id="type">                           
                            <option value="Type A">Type A</option>
                            <option value="Type B">Type B</option>
                            <option value="Type C">Type C</option>
                            <option value="Type D">Type D</option>
                        </select>
                    </div>
                </div>`;
            }
            $(".type").html(html);
        } else {
            $(".type").html("");
        }
    };

    function capitalize(str) {
        var splitStr = str.toLowerCase().split(" ");
        for (var i = 0; i < splitStr.length; i++) {
            splitStr[i] =
                splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
        }
        return splitStr.join(" ");
    }
</script>