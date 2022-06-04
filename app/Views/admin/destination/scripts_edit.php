<script type="application/javascript">
    var media_table;
    var rate_table;

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

    function initCategory(id){
        $.ajax({
            url: "<?php echo base_url() . '/api/category' ?>",
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
                $('#category_id').append(html);
            }
        });
    }

    $(document).ready(function() {

        $.ajax({
            url: "<?php echo base_url() . '/api/destination/' . $id ?>",
            type: 'get',
            headers: {"Authorization": "<?php echo $session['token'] ?>"},
            success: function (response) {
                var data = response.data;
                $('#name').val(data.name);
                $('#description').val(data.description);
                $('#url').val(data.url);
                $('#lat').val(data.lat);
                $('#long').val(data.long);
                $('#status_apps').val(data.status_apps);
                initCategory(data.category_id);
            }
        });

        media_table = $('#media_table').DataTable({
            processing: true,
            searching: false,
            paging:false,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('api/media?destination=' . $id); ?>",
                type: "GET",
                headers: {"Authorization": "<?php echo $session['token'] ?>"},
            },
            columns: [
            {data: 'media_type'},
            {data: 'file_path'},
            {
               'mRender': function (data, type, row) {
                return '<a class="btn btn-xs bg-gradient-danger" href="#" onclick="deleteData(' + row.id + ')"><i class="fa fa-trash"></i></a>';
            }
        }
        ],
        order: [[ 1, "asc" ]]
    });

        rate_table = $('#rate_table').DataTable({
            processing: true,
            searching: false,
            paging:true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('api/rateReview?destination=' . $id); ?>",
                type: "GET",
                headers: {"Authorization": "<?php echo $session['token'] ?>"},
            },
            columns: [
            {data: 'review'},
            {data: 'rate'},
            {data: 'name'},
            {data: 'created_at'},
            ],
            order: [[ 1, "asc" ]]
        });

        $("#form").validate({
            errorElement: 'span',
            errorClass: "is-invalid",
            submitHandler: function(form) {
                var form = $('form')[0]; // You need to use standard javascript object here
                var formData = new FormData(form);
                $.ajax({
                    url: "<?php echo base_url() . '/api/destination/' . $id ?>",
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {"Authorization": "<?php echo $session['token'] ?>"},
                    success: function (data) {
                        $(location).prop('href', "<?php echo base_url('admin/destination') ?>");
                    }
                });
            }
        });
    });
</script>
