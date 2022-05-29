<!DOCTYPE html>
<html lang="en">

<?php $this->load->view("_partials/head.php") ?>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-15">
                                <div class="card-header justify-content-center">
                                    <!-- <img class="img-fluid login-logo mx-auto" style="width: 80px;" src="<?php echo base_url('assets/img/logo_aqila.png') ?>" alt="Logo Kota Pasuruan"> -->
                                </div>
                                <div class="card-body">
                                    <div class="col">
                                    <?php echo $this->session->flashdata('pesan') ?>
                                    </div>
                                    <form action="" method="post" autocomplete="off">
                                        <div class="form-group"><label class="small mb-1" for="username">Username</label>
                                            <input class="form-control py-4" id="username" name="username" type="text" placeholder="Masukkan Username" />
                                        </div>
                                        <div class="form-group"><label class="small mb-1" for="password">Password</label>
                                            <input class="form-control py-4" id="password" name="password" type="password" placeholder="Masukkan Password" />
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary btn-user">
                                                Login
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="footer mt-auto footer-dark">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-md-center small">
                            Copyright &copy; <?= SITE_NAME?> 2021
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    </div>
    <?php $this->load->view("_partials/js.php") ?>
</body>

</html>