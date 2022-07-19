<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/main.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/parallax.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/glide.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/magnific-popup.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/tab-accordion.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/imagesloaded.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/pagination.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/star-rating.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/krajee-svg/theme.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/isotope.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/progress.js') ?>" async></script>

<script type="text/javascript" src="<?php echo base_url('assets/web/resources/scripts/custom.js') ?>" async></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

<script type="application/javascript">
	<?php if (isset($reset_password)) {?>
		$("#reset_form").validate({
			errorElement: 'span',
			errorClass: "is-invalid",
			submitHandler: function(form) {
                var form = $('form')[2]; // You need to use standard javascript object here
                var tmp = new FormData(form);
                tmp.append('code', '<?php echo $code ?>');
                var formData = JSON.stringify(Object.fromEntries(tmp));
                $.ajax({
                    url: "<?php echo base_url() . '/api/reset_password' ?>",
                    type: 'post',
                    data: formData,
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function (data) {
                        // $(location).prop('href', "<?php echo base_url('/') ?>");
                    }
                });
            }
        });
	<?php }?>


    function addToFavorite(id){

        $.ajax({
                    url: "<?php echo base_url() . '/api/favorite' ?>",
                    type: 'post',
                    data: JSON.stringify({destination_id:id}),
                    dataType: 'json',
                    contentType: 'application/json',
                    headers: {"Authorization": localStorage.token},
                    success: function(res, status, xhr) { 
                        
                    }
                });
        alert("telah dimasukan ke favorite");
    }

    if (localStorage.token) {
        $("#btnLogin").hide();
        $("#btnRegister").hide();        
        $(".nameUserData").html(localStorage.userData.name);        
        $(".imgUserData").attr("src", localStorage.userData.image);        
    }

    if (!localStorage.token) {
        $("#btnLogout").hide();
        $("#userDataHeader").hide();        
        $("#formUserReview").hide();        
    }

    $("#formLogin").validate({
        errorElement: 'span',
        errorClass: "is-invalid",
        submitHandler: function(form) {
                var form = $('form')[1]; // You need to use standard javascript object here
                var formData = JSON.stringify(Object.fromEntries(new FormData(form)));
                $.ajax({
                    url: "<?php echo base_url() . '/api/login' ?>",
                    type: 'post',
                    data: formData,
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function(res, status, xhr) { 
                        alert(xhr.getResponseHeader("AuthToken"));
                        localStorage.token = xhr.getResponseHeader("AuthToken");
                        localStorage.userData = res.data;
                        $(location).prop('href', "<?php echo base_url('/') ?>");
                    }
                });
            }
        });

    $("#formUserReview").validate({
        errorElement: 'span',
        errorClass: "is-invalid",
        submitHandler: function(form) {
                var form = $('form')[0];//$('form[name="formUserReview"]'); // You need to use standard javascript object here
                var formData = JSON.stringify(Object.fromEntries(new FormData(form)));
                $.ajax({
                    url: "<?php echo base_url() . '/api/rateReview' ?>",
                    type: 'post',
                    data: formData,
                    dataType: 'json',
                    contentType: 'application/json',
                    headers: {"Authorization": localStorage.token},
                    success: function(res, status, xhr) { 
                        alert("data submit");
                        $(location).reload();
                    }
                });
            }
        });


    $("#btnLogout").click(function() {
        alert("logout");
        localStorage.clear();
        $(location).prop('href', "<?php echo base_url('/') ?>");
    });

</script>