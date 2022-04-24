<script type="application/javascript">
    $(document).ready(function() {
        $("#form").validate({
            errorElement: 'span',
            errorClass: "is-invalid",
            submitHandler: function(form) {
                var form = $('form')[0]; // You need to use standard javascript object here
                var formData = new FormData(form);
                $.ajax({
                    url: "<?php echo base_url() . '/api/media' ?>",
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {"Authorization": "<?php echo $session['token'] ?>"},
                    success: function (data) {
                        $(location).prop('href', "<?php echo base_url('admin/destination/edit/' . $id) ?>");
                    }
                });
            }
        });
    });
</script>
