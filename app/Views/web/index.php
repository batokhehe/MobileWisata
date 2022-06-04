    <main>
        <section class="section-image section-full-width-right light ken-burn-center" data-parallax="scroll" data-image-src="<?php echo base_url('assets/web/images/komodo-island.jpg') ?>">
            <div class="container">
                <hr class="space-lg" />
                <hr class="space-sm" />
                <div class="row">
                    <div class="col-lg-6">
                        <h1 data-anima="fade-left" data-time="2000" class="text-lg text-uppercase text-black">Wisata? Ngak usah jauh-jauh <span>#NusaTenggaraTimur</span></h1>
                    </div>
                    <div class="col-lg-6">
                        <hr class="space-xs" />
                        <div class="counter counter-vertical counter-icon">
                            <div>
                                <h3>Altitude</h3>
                                <div class="value">
                                    <span class="text-md" data-to="<?php echo $headline['altitude'] ?>" data-speed="3000">825</span>
                                    <span>m</span>
                                </div>
                            </div>
                        </div>
                        <hr class="space-sm" />
                        <div class="counter counter-horizontal counter-icon">
                            <i class="im-cloud-sun text-md"></i>
                            <div>
                                <h3><?php echo $destination['name'] ?></h3>
                                <div class="value">
                                    <span class="text-md" data-to="<?php echo $headline['temperature'] ?>" data-speed="2000"></span>
                                    <span>° C</span>
                                </div>
                            </div>
                        </div>
                        <hr class="space-sm" />
                        <div class="counter counter-vertical counter-icon">
                            <div>
                                <h3>Tourists / year</h3>
                                <div class="value">
                                    <span class="text-md" data-to="<?php echo $headline['tourist'] ?>" data-speed="5000">2000</span>
                                    <span>+</span>
                                </div>
                            </div>
                        </div>
                        <hr class="space" />
                        <ul class="slider" data-options="type:carousel,nav:true,perView:3,perViewLg:2,perViewSm:1,gap:30,controls:out,autoplay:3000">

                            <?php
                            foreach ($media as $m) {?>
                                <li>
                                    <a class="img-box <?php echo $m['media_type'] == 'image' ? '' : 'btn-video'; ?> lightbox" href="<?php echo $m['file_path'] ?>" data-lightbox-anima="fade-top">
                                        <div class="thumb-img-box" style="background: url(<?php echo $m['media_type'] != 'youtube' ? $m['file_path'] : 'https://i.ytimg.com/vi_webp/' . explode('v=', $m['file_path'])[1] . '/maxresdefault.webp'; ?>);"></div>
                                    </a>
                                </li>

                            <?php }
                            ?>
                        </ul>
                    </div>
                </div>
                <hr class="space-lg" />
            </div>
        </section>
        <section class="section-base section-color bg-image">
            <div class="bg-overlay"></div>
            <div class="container">
                <div class="title m-0">
                    <h2>Destinasi Pilihan</h2>
                    <p>Lokasi yang wajib kamu kunjungi.</p>
                </div>
                <hr class="space-sm" />
                <div class="grid-list pagination-top-right" data-columns="3" data-columns-md="2" data-columns-sm="1">
                    <div class="grid-box">

                        <?php
                        $counter = count($popular) >= 10 ? 10 : count($popular);
                        for ($i = 0; $i < $counter; $i++) {
                            $p = $popular[$i];
                            ?>

                            <div class="grid-item">
                                <div class="cnt-box cnt-box-info boxed h-100" data-href="<?php echo base_url('location_post/' . $p->id) ?>">
                                    <a href="<?php echo base_url('location_post/' . $p->id) ?>" class="img-box"><div class="thumb-img-box" style="background: url('<?php echo $p->media ?>');"></div></a>
                                    <div class="caption">
                                        <h2><?php echo $p->name; ?></h2>
                                        <div class="rating-star">
                                            <input class="star-rating-loc" value="<?php echo $p->rate; ?>" />
                                            <span>(<?php echo $p->reviewer; ?>)</span>
                                        </div>
                                        <div class="cnt-info">
                                            <div><a href="#"><span>Rute</span><i class="las la-directions"></i></a></div>
                                            <div><a href="#"><span>Simpan</span><i class="las la-bookmark"></i></a></div>
                                            <div><a href="#"><span>Bagikan</span><i class="las la-share"></i></a></div>
                                        </div>
                                        <p>
                                            <?php echo $p->description; ?> </p>
                                            <div class="bottom-info">
                                                <?php echo $p->name; ?>, Nusa Tenggara Timur
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php }?>
                        </div>
                        <div class="list-pagination">
                            <ul class="pagination align-center" data-page-items="3" data-page-items-md="2" data-pagination-anima="fade-right"></ul>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <a href="<?php echo base_url('location') ?>" class="btn btn-sm btn-circle">Lihat Semua</a>
                    </div>
                </div>
            </section>
            <section class="section-base news-article">
                <div class="container">
                    <div class="title align-center">
                        <h2>Jelajahi cerita terbaru kami</h2>
                        <p>Cerita Perjalanan dan Berita</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="cnt-box cnt-box-info headline" style="background: url('<?php echo $blog[0]->image; ?>');">
                                <div class="bgOverlay"></div>
                                <hr class="space-sm visible-sm" />
                                <div class="title">
                                    <a href="#">
                                        <p><?php echo $blog[0]->category_name; ?></p>
                                    </a>
                                    <a href="<?php echo base_url('blog_post/' . $blog[0]->id) ?>">
                                        <h2 class="mb-2 mt-1"><?php echo $blog[0]->title; ?></h2>
                                    </a>
                                    <span><?php echo $blog[0]->created_at; ?></span>
                                </div>
                                <p>
                                    <?php echo strip_tags($blog[0]->description); ?>
                                </p>
                            </div>
                        </div>
                        <?php for ($i = 1; $i < count($blog); $i++) {?>
                            <div class="col-lg-7">
                                <ul class="slider controls-right" data-options="type:carousel,nav:true,perView:2,perViewSm:1,gap:30,controls:out">
                                    <li>
                                        <div class="cnt-box cnt-box-info">
                                            <a href="<?php echo base_url('blog_post') ?>" class="img-box">
                                                <div class="thumb-img-box" style="background: url('<?php echo $blog[$i]->image; ?>');"></div>
                                            </a>
                                            <div class="caption">
                                                <a href="#"><span><?php echo $blog[$i]->category_name; ?></span></a>
                                                <a href="<?php echo base_url('blog_post/' . $blog[$i]->id) ?>">
                                                    <h2 class="my-1"><?php echo $blog[$i]->title; ?></h2>
                                                </a>
                                                <span><?php echo $blog[$i]->created_at; ?></span>
                                                <p>
                                                    <?php echo strip_tags($blog[$i]->description); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        <?php }?>
                        <div class="col-12 text-center">
                            <a href="<?php echo base_url('blog_list') ?>" class="btn btn-sm btn-circle">Lihat Semua</a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section-base section-color bg-image" data-parallax="true" data-natural-height="1080" data-natural-width="1920" data-bleed="100" data-image-src="<?php echo base_url('assets/web/images/segBg04.jpg') ?>">
                <div class="bg-overlay"></div>
                <div class="container">
                    <div class="title align-center">
                        <h2>Destinasi Pilihan</h2>
                        <p>Inspirasi perjalanan anda</p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="album" data-album-anima="fade-bottom" data-columns-md="2" data-columns-sm="1">
                                <div class="album-list">

                                    <?php
                                    $counter = count($popular) >= 6 ? 6 : count($popular);
                                    for ($i = 0; $i < $counter; $i++) {
                                        $p = $popular[$i];
                                        ?>
                                        <div class="album-box">
                                            <a href="#" class="img-box img-scale">
                                                <img src="<?php echo $p->media ?>" alt="" />
                                            </a>
                                            <div class="caption">
                                                <h3><?php echo $p->name ?></h3>
                                            </div>
                                        </div>
                                    <?php }?>
                                </div>
                                <div class="cnt-album-box">
                                    <p class="album-title"><span>...</span> <a>Album list</a></p>
                                    <div class="album-item">
                                        <div class="grid-list list-gallery" data-lightbox-anima="fade-top" data-columns="3" data-columns-md="2">
                                            <div class="grid-box">
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-pagination">
                                                <ul class="pagination" data-page-items="6" data-pagination-anima="fade-right"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="album-item">
                                        <div class="grid-list list-gallery" data-lightbox-anima="fade-top" data-columns="3" data-columns-md="2">
                                            <div class="grid-box">
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-pagination">
                                                <ul class="pagination" data-page-items="6" data-pagination-anima="fade-right"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="album-item">
                                        <div class="grid-list list-gallery" data-lightbox-anima="fade-top" data-columns="3" data-columns-md="2">
                                            <div class="grid-box">
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-pagination">
                                                <ul class="pagination" data-page-items="6" data-pagination-anima="fade-right"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="album-item">
                                        <div class="grid-list list-gallery" data-lightbox-anima="fade-top" data-columns="3" data-columns-md="2">
                                            <div class="grid-box">
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-pagination">
                                                <ul class="pagination" data-page-items="6" data-pagination-anima="fade-right"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="album-item">
                                        <div class="grid-list list-gallery" data-lightbox-anima="fade-top" data-columns="3" data-columns-md="2">
                                            <div class="grid-box">
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-pagination">
                                                <ul class="pagination" data-page-items="6" data-pagination-anima="fade-right"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="album-item">
                                        <div class="grid-list list-gallery" data-lightbox-anima="fade-top" data-columns="3" data-columns-md="2">
                                            <div class="grid-box">
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                                <div class="grid-item">
                                                    <a class="img-box" href="http://via.placeholder.com/800x500">
                                                        <img src="http://via.placeholder.com/800x500" alt="" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-pagination">
                                                <ul class="pagination" data-page-items="6" data-pagination-anima="fade-right"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section-base travel-guidance">
                <div class="container">
                    <div class="title align-center">
                        <h2>Panduan Perjalanan</h2>
                        <p>Informasi esensial untuk memulai petualangan</p>
                    </div>
                    <table class="table table-grid table-border table-6-md">
                        <tbody>
                            <tr>
                                <?php foreach ($guide as $g) { ?>
                                 <td>
                                    <a href="#">
                                        <div class="icon-box icon-box-top align-center">
                                            <div class="thumb-img-box" style="background: url('<?php echo $g->image ?>');">
                                                <h3><i class="lab <?php echo $g->icon ?>"></i> <?php echo $g->title ?></h3>
                                            </div>
                                            <div class="caption">
                                                <p class="text-left"><?php echo $g->description ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </td>   
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal Registration -->
    <div class="modal fade-in" id="regModal" tabindex="-1" aria-labelledby="regModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="regModal">Registration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-0">
                    <form action="" class="">
                        <div class="row m-0">
                            <div class="col-lg-6 form-group">
                                <label>Name</label>
                                <input id="name" name="name" placeholder="Full name" type="text" class="input-text" required>
                            </div>
                            <div class="col-lg-6 form-group mt-0">
                                <label>Phone Number</label>
                                <input id="telp" name="phone" placeholder="0812345678" type="number" class="input-text" required>
                            </div>
                            <div class="col-lg-12 form-group mt-0">
                                <label>Email</label>
                                <input id="email" name="email" placeholder="myemail@mail.com" type="email" class="input-text" required>
                            </div>
                            <div class="col-lg-12 form-group mt-0">
                                <label>Password</label>
                                <input id="password" name="password" placeholder="Password" type="password" class="input-text" required>
                            </div>
                            <div class="col-lg-12 form-group mt-0">
                                <label>Confirm Password</label>
                                <input id="repassword" name="repassword" placeholder="Confirm Password" type="password" class="input-text" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="form-checkbox justify-content-between">
                        <input type="checkbox" id="check" name="check" value="check" required>
                        <label for="check" class="pl-2 d-inline">You accept the terms of service and the privacy policy</label>
                    </div>
                    <div class="flex-fill text-right mt-2">
                        <button class="btn btn-sm" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal fade-in" id="loginModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModal">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-0">
                    <form action="" class="">
                        <div class="row m-0">
                            <div class="col-lg-12 form-group mt-0">
                                <label>Email</label>
                                <input id="email-login" name="email" placeholder="myemail@mail.com" type="email" class="input-text" required>
                            </div>
                            <div class="col-lg-12 form-group mt-0">
                                <label>Password</label>
                                <input id="password-login" name="password" placeholder="Password" type="password" class="input-text" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="form-checkbox justify-content-between">
                        <input type="checkbox" id="check" name="check" value="check" required>
                        <label for="check" class="pl-2 d-inline">Remember me</label>
                    </div>
                    <div class="flex-fill text-right mt-2">
                        <button class="btn btn-sm" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($reset_password)) { ?>
        <div class="modal fade-in show" id="resetModal" tabindex="-1" aria-labelledby="resetModal" style="padding-right: 17px; display: block;" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered">
                <form id="reset_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resetModal">Reset Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body px-0">
                            <div class="row m-0">
                                <div class="col-lg-12 form-group mt-0">
                                    <label>New Password</label>
                                    <input id="password" name="password" placeholder="New Password" type="password" class="input-text" required="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <div class="flex-fill text-right mt-2">
                                <button class="btn btn-sm" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
