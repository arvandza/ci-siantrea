<!DOCTYPE html>
<html lang="en">

<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar') ?>

<body>
    <div id="app">
        <div class="main-wrapper">

            <?= $this->include('layout/topbar') ?>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Kelola Antrean</h1>
                    </div>
                   
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">

                            <?php if (session('errors') || session('success')) : ?>
                                <div class="alert alert-dismissible show fade <?= session('errors') ? 'alert-danger' : 'alert-success' ?>" role="alert">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        <?php if (session('errors')) : ?>
                                            <?= session('errors') ?>
                                        <?php endif ?>

                                        <?php if (session('success')) : ?>
                                            <?= session('success') ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Data Antrean</h4>
                                </div>

                                <div class="card-body p-1">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-md">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Dosen</th>
                                                <th>Tanggal</th>
                                                <th>Jumlah Antrean</th>
                                                <th>Maks Antrean</th>
                                                <th>Keterangan</th>
                                                <th>
                                                    <div class="d-flex justify-content-center">Action</div>
                                                </th>
                                            </tr>
                                            <?php foreach ($antre as $antre => $value) : ?>
                                                <tr>
                                                    <td> <?= $antre + 1 ?> </td>
                                                    <td> <?=session()->get('nama') ?> </td>
                                                    <td> <?= date('d-m-Y', strtotime($value['tanggal'])) ?> </td>
                                                    <td> <?= $value['jumlah_antrean'] ?> </td>
                                                    <td> <?= $value['maks_antrean'] ?> </td>
                                                    <td> <?= $value['keterangan'] ?> </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="<?= site_url('dosen/kelola_antrean/edit?id=' . $value['id']) ?>" class="btn btn-icon btn-info mr-2"><i class="far fa-edit"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>

                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <nav class="d-inline-block">
                                        <!-- pager here -->
                                        <?= $pager->links('default', 'pagination') ?>
                                    </nav>
                                </div>
                            </div>

                        </div>

                    </div>
                </section>
            </div>
            <!-- Modal Create Antrean -->

        </div>

        <div class="section-body">

        </div>
    </div>

    </div>
    <?= $this->include('layout/footer') ?>
    </div>
    </div>

    <!-- General JS Library -->
    <?= $this->include('layout/js') ?>

    <!-- Page Specific JS File -->
</body>

</html>