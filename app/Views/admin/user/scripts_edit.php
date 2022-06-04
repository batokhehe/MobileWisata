<script type="application/javascript">
    var table;

    $(document).ready(function() {

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
