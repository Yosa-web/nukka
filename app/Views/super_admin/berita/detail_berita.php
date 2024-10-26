<?= $this->extend('layout/master_dashboard'); ?>

<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">
                            Detail Berita
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Kelola Konten</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="kelola-berita.html">Kelola Berita</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Detail Berita
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <div class="text-center mb-3">
                                    <h4>Beautiful Day with Friends</h4>
                                </div>
                                <div class="mb-4">
                                    <img src="assets/images/small/img-2.jpg" alt="" class="img-thumbnail mx-auto d-block">
                                </div>

                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mt-4 mt-sm-0">
                                                <h6 class="mb-2">Date published</h6>
                                                <p class="text-muted font-size-15">20 June 2022</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Posted by</p>
                                                <h5 class="font-size-15">Super Admin</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="mt-4">
                                    <div class="text-muted font-size-14">
                                        <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam enim ad minima veniam quis</p>

                                        <p class="mb-4">Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt</p>

                                        <blockquote class="p-4 border-light border rounded mb-4">
                                            <div class="d-flex">
                                                <div class="me-3">
                                                    <i class="bx bxs-quote-alt-left text-body font-size-24"></i>
                                                </div>
                                                <div>
                                                    <p class="mb-0"> At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium deleniti atque corrupti quos dolores et quas molestias excepturi sint quidem rerum facilis est</p>
                                                </div>
                                            </div>

                                        </blockquote>

                                        <p>Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Sed ut perspiciatis unde omnis iste natus error sit</p>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias, dolorem fugiat sed veniam iste ducimus, harum praesentium nobis soluta nostrum officia, accusantium facilis! Earum illo fugit praesentium veritatis, beatae aperiam!</p>
                                        <p>Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Sed ut perspiciatis unde omnis iste natus error sit</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>