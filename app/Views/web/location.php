<main>
    <section class="section-base section-color">
        <div class="container">
            <div class="maso-list gap-30" data-columns="3" data-columns-lg="2" data-columns-sm="1">
                <div class="menu-inner">
                    <div><i class="menu-btn"></i><span>Menu</span></div>
                    <ul>
                        <li class="active"><a data-filter="maso-item" href="#">All</a></li>
                        <?php foreach ($category as $c) {?>
                            <li><a data-filter="cat-<?php echo $c->id ?>" href="#"><?php echo $c->name ?></a></li>
                        <?php }?>
                        <li><a class="maso-order" data-sort="asc"></a></li>
                    </ul>
                </div>
                <div class="maso-box">
                    <?php foreach ($popular as $p) {?>
                        <div class="maso-item cat-<?php echo $p->category_id ?>">
                            <div class="cnt-box cnt-box-info boxed" data-href="<?php echo base_url('location_post/' . $p->id) ?>">
                                <a href="location-post.html" class="img-box">
                                    <div class="thumb-img-box" style="background: url('<?php echo $p->media ?>');"></div>
                                </a>
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
            </div>
            <hr class="space" />
        </div>
    </section>
</main>
