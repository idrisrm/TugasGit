<!DOCTYPE html>
<html lang="en">

<?php $this->load->view("_partials/head.php") ?>
<?php $this->load->view("_partials/modal/simpan.php") ?>

<body class="nav-fixed">
    <?php $this->load->view("_partials/header.php") ?>
    <div id="layoutSidenav">
        <?php $this->load->view("_partials/sidebar.php") ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                    <div class="container-fluid">
                        <div class="page-header-content">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="edit-3"></i></div>
                                <span>Edit Waktu Pengecekan</span>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="container-fluid mt-n10">
                    <form action="" method="post" autocomplete="off">
                        <div class="card mb-4">
                            <div class="card-header">Edit Waktu Pengecekan</div>
                            <div class="col mt-3">
                            <?php echo $this->session->flashdata('pesan') ?>
                        </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-xxl-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <label class="small mb-1" for="waktu">Waktu Pengecekan <text class="text-danger">*Dalam Satuan Menit (contoh : 70 Menit)</text> </label>
                                        <input class="form-control" id="waktu" name="waktu" type="number" placeholder="Masukkan Volume Air" value="<?= $waktu['nilai'] ?>" />
                                        <?= form_error('waktu', '<small class="text-danger pl-2">', '</small>'); ?>
                                    </div>
                                </div>
                                <button type="submit" href="" class="btn btn-success mr-2">
                                    <span class="text">Simpan</span>
                                </button>
                                <a class="btn btn-danger" href="javascript:history.go(-1)">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
            <footer class="footer mt-auto footer-light">
                <?php $this->load->view('_partials/footer.php') ?>
            </footer>
        </div>
    </div>
    <?php $this->load->view("_partials/js.php") ?>
</body>

</html>