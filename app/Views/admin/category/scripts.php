<script type="application/javascript">
    var table;
    function deleteData(id){
        $.ajax({
            url: "<?php echo base_url() . '/api/category' ?>/" + id,
            type: 'delete',
            headers: {"Authorization": "<?php echo $session['token'] ?>"},
            success: function (data) {
                table.ajax.reload();
            }
        });
    }

    $(document).ready(function() {
        table = $('.datatables').DataTable({
            processing: true,
            searching: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('api/category'); ?>",
                type: "GET",
                headers: {"Authorization": "<?php echo $session['token'] ?>"},
            },
            columns: [
            {data: 'name'},
            {data: 'description'},
            {
               'mRender': function (data, type, row) {
                return '<a class="btn btn-xs bg-gradient-primary" href="<?php echo base_url(); ?>/admin/category/edit/' + row.id + '"><i class="fa fa-edit"></i></a>&nbsp; ' +
                '<a class="btn btn-xs bg-gradient-danger" href="#" onclick="deleteData(' + row.id + ')"><i class="fa fa-trash"></i></a>';
                }
            }],
            order: [[ 1, "asc" ]]
        });

        $("#form").validate({
            errorElement: 'span',
            errorClass: "is-invalid",
            submitHandler: function(form) {
                var form = $('form')[0]; // You need to use standard javascript object here
                var formData = JSON.stringify(Object.fromEntries(new FormData(form)));
                $.ajax({
                    url: "<?php echo base_url() . '/api/category' ?>",
                    type: 'post',
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
