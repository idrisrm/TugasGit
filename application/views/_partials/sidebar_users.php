<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <div class="sidenav-menu-heading">Dashboard</div>
                <a class="nav-link" href="<?= base_url('Dashboard_Users') ?>">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>

                <div class="sidenav-menu-heading">Menu Pengaduan</div>
                <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                    <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                    Pengaduan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse show" id="collapseDashboards" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="<?= base_url('PengaduanOPD/data_proses') ?>">
                            <span class="badge badge-danger mr-1">  </span>
                            Proses
                            <span class="badge badge-primary-soft text-primary ml-auto"><?= $proses ?></span>
                        </a>
                        <a class="nav-link" href="<?= base_url('PengaduanOPD/data_tindak_lanjut') ?>">
                            <span class="badge badge-warning mr-1">  </span>
                            Tindak Lanjut
                            <span class="badge badge-primary-soft text-primary ml-auto"><?= $konfirmasi ?></span>
                        </a>
                        <a class="nav-link" href="<?= base_url('PengaduanOPD/data_selesai') ?>">
                            <span class="badge badge-success mr-1">  </span>
                            Selesai
                            <span class="badge badge-primary-soft text-primary ml-auto"><?= $selesai ?></span>
                        </a>
                        <a class="nav-link" href="<?= base_url('PengaduanOPD/data_arsip') ?>">
                            Arsip
                            <span class="badge badge-primary-soft text-primary ml-auto"><?= $arsip ?></span>
                        </a>
                        <a class="nav-link" href="<?= base_url('PengaduanOPD/pengaduan_offline') ?>">
                            Pengaduan Offline
                            <span class="badge badge-primary-soft text-primary ml-auto"></span>
                        </a>
                    </nav>
                </div>
                <div class="sidenav-menu-heading">Master Data</div>
                <a class="nav-link" href="<?= base_url('Kategori_Users/tambah') ?>">
                    <div class="nav-link-icon"><i data-feather="grid"></i></div>
                    Kategori Pengaduan
                </a>
                <div class="sidenav-menu-heading">Sistem</div>
                <a class="nav-link" href="<?= base_url('EditAkun') ?>">
                    <div class="nav-link-icon"><i data-feather="phone"></i></div>
                    Edit Akun OPD
                </a>
            </div>
        </div>
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Log in sebagai:</div>
                <div class="sidenav-footer-title">Idris</div>
            </div>
        </div>
    </nav>
</div>