<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <?php echo @$_meta; ?>
    <!-- css -->
    <?php echo @$_styles; ?>
</head>
<body class="page-main">
    <?php echo @$_header; ?>
    <main>
        <?php echo @$_content; ?>
    </main>

    <?php echo @$_footer; ?>

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
<?php echo @$_scripts; ?>
</body>
</html>