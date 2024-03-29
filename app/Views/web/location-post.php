﻿<main>
    <section class="section-base">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="cnt-box cnt-box-side">
                        <iframe src="https://www.google.com/maps/embed/v1/view?key=AIzaSyBbzLLqcMjbMIiBdB3I0b_khv79IfZG5Ls&zoom=18&center=<?php echo $destination->lat ?>,<?php echo $destination->long ?>" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="cnt-box cnt-box-side">
                        <div class="caption p-0">
                            <h2 class="m-0"><?php echo $destination->name ?></h2>
                            <div class="extra-field">
                                <div class="rating-star">
                                    <input class="star-rating-loc" value="<?php echo $destination->rate ?>" />
                                    <span>(<?php echo $destination->reviewer ?>) Reviews</span>
                                </div>
                            </div>
                            <p class="pt-3">
                                <?php echo $destination->description ?>
                            </p>
                        </div>
                    </div>
                    <hr class="space-sm" />
                    <ul class="text-list text-list-line">
                        <li><i class="las la-map-marker"></i><hr /><p><?php echo $destination->name ?>, Nusa Tenggara Timur</p></li>
                        <li>
                            <i class="las la-clock"></i><hr />
                            <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="text-dark">Sunday <span class="text-danger">Closed</span> • Open 7AM <i class="las la-angle-down"></i>
                                <div class="collapse mt-2" id="collapseExample">
                                    <div class="card card-body">
                                        <ul class="text-list text-list-line">
                                            <li>Sunday<hr /><p>Closed</p></li>
                                            <li>Monday<hr /><p>7AM–6PM</p></li>
                                            <li>Tuesday<hr /><p>7AM–6PM</p></li>
                                            <li>Wednesday<hr /><p>7AM–6PM</p></li>
                                            <li>Thursday<hr /><p>7AM–6PM</p></li>
                                            <li>Friday<hr /><p>7AM–6PM</p></li>
                                            <li>Saturday<hr /><p>7AM–6PM</p></li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><i class="las la-globe"></i><hr /><a href="<?php echo $destination->url ?>" ><?php echo $destination->url ?></a></li>
                        <li><i class="las la-phone"></i><hr /><p>0812-3456-789</p></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="section-base">
        <div class="container pt-4">
            <div class="row flex-wrap-reverse">
                <div class="col-lg-6 hr-line">
                    <h2 class="mb-4">Reviews</h2>
                    <div class="user-reviews">
                        <?php foreach ($rate as $r) { ?>
                            <div class="user-post">
                                <div class="user-post-head">
                                    <img src="<?php echo $r->image ?>" class="img-fluid">
                                    <div class="user-data">
                                        <h5><?php echo $r->name ?></h5>
                                        <h6>Local Guide • <?php echo $r->total_review ?> reviews</h6>
                                    </div>
                                    <div class="user-menu">
                                        <div class="dropdown">
                                            <i class="las la-ellipsis-v"></i>
                                            <ul>
                                                <li><a href="#">Flag as inappropiate</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-post-body">
                                    <div class="rating-star">
                                        <input class="star-rating" value="<?php echo $r->rate ?>" />
                                        <span class="ml-2"><?php echo $r->created_at ?></span>
                                    </div>
                                    <div class="read-more" onclick="this.classList.add('expanded')">
                                        <div class="content">
                                            <p><?php echo $r->review ?></p>
                                        </div>
                                        <span class="trigger">+ read more</span>
                                    </div>
                                <!-- <div class="image-post">
                                    <a class="lightbox" href="images/article-01.jpg" data-lightbox-anima="fade-in">
                                        <img src="images/article-01.jpg" class="img-fluid">
                                    </a>
                                    <a class="lightbox" href="images/article-02.jpg" data-lightbox-anima="fade-in">
                                        <img src="images/article-02.jpg" class="img-fluid">
                                    </a>
                                    <a class="lightbox" href="images/article-03.jpg" data-lightbox-anima="fade-in">
                                        <img src="images/article-03.jpg" class="img-fluid">
                                    </a>
                                    <a class="lightbox" href="images/article-04.jpg" data-lightbox-anima="fade-in">
                                        <img src="images/article-04.jpg" class="img-fluid">
                                    </a>
                                </div> -->
                                <div class="user-feedback">
                                    <button class="btn btn-xs btn-circle btn-outline-primary px-3 my-0 ml-2"><i class="las la-share"></i> Share</button>
                                    <button class="btn btn-xs btn-circle btn-outline-primary px-3 my-0 ml-2"><i class="las la-thumbs-up"></i> Helpful</button>
                                    <button class="btn btn-xs btn-circle btn-outline-primary px-3 my-0 ml-2"><i class="las la-thumbs-down"></i> Not Helpful</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-lg-6 hr-line m-0">
                <h2 class="mb-4">Review summary</h2>
                <div class="d-flex user-reviews-summary">
                    <div class="flex-fill progress-line py-2">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="<?php echo $summary->five ?>" aria-valuemin="0" aria-valuemax="<?php echo $summary->total_review ?>" style="width: 75%"><span>5</span></div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="<?php echo $summary->four ?>" aria-valuemin="0" aria-valuemax="<?php echo $summary->total_review ?>" style="width: 75%"><span>4</span></div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="<?php echo $summary->three ?>" aria-valuemin="0" aria-valuemax="<?php echo $summary->total_review ?>" style="width: 75%"><span>3</span></div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="<?php echo $summary->two ?>" aria-valuemin="0" aria-valuemax="<?php echo $summary->total_review ?>" style="width: 75%"><span>2</span></div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="<?php echo $summary->one ?>" aria-valuemin="0" aria-valuemax="<?php echo $summary->total_review ?>" style="width: 75%"><span>1</span></div>
                        </div>
                    </div>
                    <div class="ml-4 progress-sum-star">
                        <div class="rating-star">
                            <input class="star-rating-summary" value="<?php echo $summary->average ?>" />
                            <span class="reviews"><?php echo $summary->total_review ?> reviews</span>
                        </div>
                    </div>
                </div>
                <form class="" id="formUserReview" name="formUserReview" action="">
                    <div class="user-reviews">
                        <div class="user-post">
                            <div class="user-post-head mb-2">
                                <img src="" class="img-fluid imgUserData">
                                <div class="user-data">
                                    <h5 class="nameUserData"></h5>
                                    <h6>Posting publicly</h6>
                                </div>
                            </div>
                            <div class="user-post-body">
                                <div class="rating-star mt-2">
                                    <input required id="rating-input" name="rate" />
                                </div>
                                <input type="hidden" id="destination_id" name="destination_id" value="<?php echo $destination->id ?>">
                                <textarea id="review" name="review" rows="15" placeholder="Share details of your own experience at this place"></textarea>
                                <!-- <span>Add image</span>
                                <div class="upload-box">
                                    <div class="upload-img-wrap"></div>
                                    <div class="upload-btn-box">
                                        <label class="btn upload-btn">
                                            <i class="las la-camera-retro"></i>
                                            <input type="file" multiple="" data-max_length="20" class="upload-inputfile">
                                        </label>
                                    </div>
                                </div> -->
                                <div class="float-right">
                                    <button class="btn btn-sm btn-circle btn-outline-primary my-0">Cancel</button>
                                    <button type="submit" class="btn btn-sm btn-circle my-0 ml-2">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr class="space" />
    </div>
</section>
</main>
