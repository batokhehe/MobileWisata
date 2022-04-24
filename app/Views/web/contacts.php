﻿<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>WISATA</title>
    
    <link rel="icon" href="images/elements/favicon.png">
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-grid.css">
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="stylesheet" href="resources/css/glide.css">
    <link rel="stylesheet" href="resources/css/magnific-popup.css">
    <link rel="stylesheet" href="resources/css/content-box.css">
    <link rel="stylesheet" href="resources/css/contact-form.css">
    <link rel="stylesheet" href="resources/css/media-box.css">
    <link rel="stylesheet" href="resources/css/star-rating.min.css">
    <link rel="stylesheet" href="resources/scripts/krajee-svg/theme.min.css">
    <link rel="stylesheet" href="resources/fonts/icons/iconsmind/line-icons.min.css">
    <link rel="stylesheet" href="resources/fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="resources/css/skin.css">
</head>
<body class="page-main">
    <div id="preloader"></div>
    <nav class="menu-classic menu-fixed align-right" data-menu-anima="fade-in">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="menu-brand">
                <a href="index.html">
                    <img class="logo-default scroll-hide" src="images/elements/logo-black-blue-solid.svg" alt="logo" />
                    <img class="logo-retina scroll-hide" src="images/elements/logo-black-blue-solid.svg" alt="logo" />
                    <img class="logo-default scroll-show" src="images/elements/logo-white-solid.svg" alt="logo" />
                    <img class="logo-retina scroll-show" src="images/elements/logo-white-solid.svg" alt="logo" />
                </a>
            </div>
            <i class="menu-btn"></i>
            <div class="menu-cnt">
                <ul id="main-menu">
                    <li class="dropdown">
                        <a href="#">Tempat & Atraksi</a>
                        <ul>
                            <li><a href="#">Destinasi</a></li>
                            <li><a href="#">Atraksi</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#">Rencanakan Perjalanan</a>
                        <ul>
                            <li><a href="#">Informasi Umum</a></li>
                            <li><a href="#">Promosi</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#">Panduan</a>
                        <ul>
                            <li><a href="#">Kesempatan<br>Berkerjasama</a></li>
                            <li><a href="#">Panduan Brand</a></li>
                            <li><a href="#">E-Brochure</a></li>
                            <li><a href="#">E-Booklet</a></li>
                        </ul>
                    </li>
                    <li class="dropdown user-menu">
                        <a href="account.html">Akun</a>
                        <ul>
                            <li>
                                <div>
                                    <img class="user-picture img-fluid" src="images/elements/user.png" />
                                    <p>Jhon Doe Sriningsih Widjayanto</p>
                                </div>
                            </li>
                            <li><a href="account.html">Account</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#regModal">Logout</a></li>
                            <li><a href="#loginModal" data-toggle="modal" data-target="#loginModal">Login</a></li>
                            <li><a href="#regModal" data-toggle="modal" data-target="#regModal">Register</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="menu-right">
                    <ul class="lan-menu">
                        <li class="dropdown">
                            <a href="#"><img src="images/elements/id.png" />ID </a>
                            <ul>
                                <li><a href="#"><img src="images/elements/id.png" />ID</a></li>
                                <li><a href="#"><img src="images/elements/en.png" />EN</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="section-base">
            <div class="container">
                <div class="google-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6664669606785!2d106.82496411471924!3d-6.1753870622327955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sNational%20Monument!5e0!3m2!1sen!2sid!4v1647974443341!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>   
                <hr class="space" />
                <div class="row">
                    <div class="col-lg-8">
                        <div class="title">
                            <h2>Write us</h2>
                            <p>Contact us from here</p>
                        </div>
                        <form action="" class="form-box form-ajax" method="post" data-email="example@domain.com">
                            <div class="row">
                                <div class="col-lg-6">
                                    <p>Name</p>
                                    <input id="name-contact" name="name" placeholder="Name" type="text" class="input-text" required>
                                </div>
                                <div class="col-lg-6">
                                    <p>Email</p>
                                    <input id="email-contact" name="email" placeholder="Email" type="email" class="input-text" required>
                                </div>
                            </div>
                            <p>Messagge</p>
                            <textarea id="messagge-contact" name="messagge" class="input-textarea" placeholder="Write something ..." required></textarea>
                            <div class="form-checkbox">
                                <input type="checkbox" id="check" name="check" value="check" required>
                                <label for="check">You accept the terms of service and the privacy policy</label>
                            </div>
                            <button class="btn btn-sm" type="submit">Send messagge</button>
                            <div class="success-box">
                                <div class="alert alert-success">Congratulations. Your message has been sent successfully</div>
                            </div>
                            <div class="error-box">
                                <div class="alert alert-warning">Error, please retry. Your message has not been sent</div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="title">
                            <h2>Contacts</h2>
                            <p>Information</p>
                        </div>
                        <ul class="text-list text-list-line">
                            <li><b>Address</b><hr /><p>Jakarta, Indonesia</p></li>
                            <li><b>Email</b><hr /><p>info@domain.com</p></li>
                            <li><b>Phone</b><hr /><p>(+62) 1234 5678 90</p></li>  
                        </ul> 
                        <hr class="space-sm" />
                        <div class="icon-links icon-social icon-links-grid social-colors-hover">
                            <a class="facebook"><i class="icon-facebook"></i></a>
                            <a class="twitter"><i class="icon-twitter"></i></a>
                            <a class="instagram"><i class="icon-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="light bg-image">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h3>Wisata</h3>
                    <p>Semua isi yang tercantum di dalam situs ini bertujuan untuk memberikan informasi dan bukan sebagai tujuan komersial.</p>
                </div>
                <div class="col-lg-4">
                    <h3>Contacts</h3>
                    <ul class="icon-list icon-line">
                        <li>Bandung, Indonesia</li>
                        <li>hello@example.com</li>
                        <li>02 123 333 444</li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="icon-links icon-social icon-links-grid social-colors">
                        <a class="facebook"><i class="icon-facebook"></i></a>
                        <a class="twitter"><i class="icon-twitter"></i></a>
                        <a class="instagram"><i class="icon-instagram"></i></a>
                    </div>
                    <hr class="space-sm" />
                    <p>Follow us on the social media.</p>
                </div>
            </div>
        </div>
        <div class="footer-bar">
            <div class="container">
                <span>WISATA © 2022 WARBRAIN Creative.</span>
                <span><a href="contacts.html">Contact us</a> | <a href="#">Privacy policy</a></span>
            </div>
        </div>
    </footer>
    
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

    <script type="text/javascript" src="resources/scripts/jquery.min.js"></script>
    <script type="text/javascript" src="resources/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="resources/scripts/main.js"></script>
    <script type="text/javascript" src="resources/scripts/parallax.min.js"></script>
    <script type="text/javascript" src="resources/scripts/glide.min.js"></script>
    <script type="text/javascript" src="resources/scripts/magnific-popup.min.js"></script>
    <script type="text/javascript" src="resources/scripts/tab-accordion.js"></script>
    <script type="text/javascript" src="resources/scripts/imagesloaded.min.js"></script>
    <script type="text/javascript" src="resources/scripts/pagination.min.js"></script>
    <script type="text/javascript" src="resources/scripts/star-rating.min.js"></script>
    <script type="text/javascript" src="resources/scripts/krajee-svg/theme.min.js"></script>
    <script type="text/javascript" src="resources/scripts/isotope.min.js"></script>
    <script type="text/javascript" src="resources/scripts/progress.js" async></script>

    <script type="text/javascript" src="resources/scripts/custom.js" async></script>
</body>
</html>