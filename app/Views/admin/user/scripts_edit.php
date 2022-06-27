<script type="application/javascript">
    var table;

    function readURL(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var num = $(input).attr('class').split('-')[2];
                $(target).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {

        $('#image').change(function(){
            readURL(this, '#image_view');
        });

        $.ajax({
            url: "<?php echo base_url() . '/api/user/' . $id ?>",
            type: 'get',
            headers: {"Authorization": "<?php echo $session['token'] ?>"},
            success: function (response) {
                var data = response.data;
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#address').val(data.address);
                $('#phone').val(data.phone);
                $('#image_view').attr('src', data.image);
            }
        });



        $("#form").validate({
            errorElement: 'span',
            errorClass: "is-invalid",
            submitHandler: function(form) {
                var form = $('form')[0]; // You need to use standard javascript object here
                var formData = new FormData(form);
                $.ajax({
                    url: "<?php echo base_url() . '/api/user/' . $id ?>",
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {"Authorization": "<?php echo $session['token'] ?>"},
                    success: function (data) {
                        $(location).prop('href', "<?php echo base_url('admin/user') ?>");
                    }
                });
            }
        });
    });
</script>
