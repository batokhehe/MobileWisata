<script type="application/javascript">
    var table;

    function deleteData(id){
        $.ajax({
            url: "<?php echo base_url() . '/api/media' ?>/" + id,
            type: 'delete',
            headers: {"Authorization": "<?php echo $session['token'] ?>"},
            success: function (data) {
                table.ajax.reload();
            }
        });
    }

    $(document).ready(function() {

        $.ajax({
            url: "<?php echo base_url() . '/api/category/' . $id ?>",
            type: 'get',
            headers: {"Authorization": "<?php echo $session['token'] ?>"},
            success: function (response) {
                var data = response.data;
                $('#name').val(data.name);
                $('#description').val(data.description);
            }
        });



        $("#form").validate({
            errorElement: 'span',
            errorClass: "is-invalid",
            submitHandler: function(form) {
                var form = $('form')[0]; // You need to use standard javascript object here
                var formData = JSON.stringify(Object.fromEntries(new FormData(form)));
                $.ajax({
                    url: "<?php echo base_url() . '/api/category/' . $id ?>",
                    type: 'put',
                    data: formData,
                    dataType: 'json',
                    contentType: 'application/json',
                    headers: {"Authorization": "<?php echo $session['token'] ?>"},
                    success: function (data) {
                        $(location).prop('href', "<?php echo base_url('admin/category') ?>");
                    }
                });
            }
        });
    });
</script>
