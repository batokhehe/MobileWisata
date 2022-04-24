<script type="application/javascript">

    function initDestination(id){
        $.ajax({
            url: "<?php echo base_url() . '/api/destination' ?>",
            type: 'get',
            headers: {"Authorization": "<?php echo $session['token'] ?>"},
            success: function (data) {
                var html = '';
                $.each(data.data, function (i, item) {
                    html += '<option value="' + item.id + '"';
                    if (item.id == id) {
                        html += ' selected';
                    }
                    html +='>' + item.name + '</option>';
                });
                $('#destination_id').append(html);
            }
        });
    }

    $(document).ready(function() {
        $.ajax({
            url: "<?php echo base_url() . '/api/headline/1' ?>",
            type: 'get',
            headers: {"Authorization": "<?php echo $session['token'] ?>"},
            success: function (response) {
                var data = response.data;
                $('#altitude').val(data.altitude);
                $('#temperature').val(data.temperature);
                $('#tourist').val(data.tourist);
                initDestination(data.destination_id);
            }
        });

        $("#form").validate({
            errorElement: 'span',
            errorClass: "is-invalid",
            submitHandler: function(form) {
                var form = $('form')[0]; // You need to use standard javascript object here
                var formData = new FormData(form);
                $.ajax({
                    url: "<?php echo base_url() . '/api/headline/1' ?>",
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {"Authorization": "<?php echo $session['token'] ?>"},
                    success: function (data) {
                        $(location).prop('href', "<?php echo base_url('admin/headline') ?>");
                    }
                });
            }
        });
    });
</script>
