<main>
    <section class="section-base ">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h2><?php echo $blog['title'] ?></h2>
                    <div class="icon-links icon-links-grid icon-social social-colors">
                        <a data-social="share-facebook" class="facebook"><i class="icon-facebook"></i></a>
                        <a data-social="share-twitter" class="twitter"><i class="icon-twitter"></i></a>
                    </div>
                    <hr class="space-sm" />
                    <img src="<?php echo $blog['image'] ?>" alt="" />
                    <hr class="space-sm" />
                    <?php echo $blog['description'] ?>
                    <div class="list-nav">
                        <a href="#">Previous post</a>
                        <a class="list-archive" href="#"></a>
                        <a href="#">Next post</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <form class="form-box">
                        <div class="input-text-btn">
                            <input class="input-text" type="text" placeholder="Search ..." /><input type="submit" value="Search" class="btn" />
                        </div>
                    </form>
                    <hr class="space-sm" />
                    <h3>Categories</h3>
                    <hr class="space-sm" />
                    <div class="menu-inner menu-inner-vertical">
                        <ul>
                            <?php foreach ($category as $c) {?>
                                <li>
                                    <a href="#">
                                        <?php echo $c->name ?>
                                    </a>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                    <hr class="space-sm" />
                    <h3>Latest posts</h3>
                    <hr class="space-sm" />
                    <div class="menu-inner menu-inner-vertical menu-inner-image">
                        <ul>
                           <?php foreach ($latest as $l) {?>
                            <li>
                                <a href="#">
                                    <img src="<?php echo $l->image ?>" alt="" />
                                    <span><?php echo $l->created_at ?></span>
                                    <p><?php echo $l->title ?></p>
                                </a>
                            </li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
