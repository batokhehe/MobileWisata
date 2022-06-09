<script type="application/javascript">
    var table;
    function deleteData(id){
        $.ajax({
            url: "<?php echo base_url() . '/api/destination' ?>/" + id,
            type: 'delete',
            headers: {"Authorization": "<?php echo $session['token'] ?>"},
            success: function (data) {
                table.ajax.reload();
            }
        });
    }

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
        $('#image_portrait').change(function(){
            readURL(this, '#image_portrait_view');
        });

        $('#image_landscape').change(function(){
            readURL(this, '#image_landscape_view');
        });
        
        $.ajax({
            url: "<?php echo base_url() . '/api/category' ?>",
            type: 'get',
            headers: {"Authorization": "<?php echo $session['token'] ?>"},
            success: function (data) {
                var html = '';
                $.each(data.data, function (i, item) {
                    html += '<option value="' + item.id + '">' + item.name + '</option>';
                });
                $('#category_id').append(html);
            }
        });

        table = $('.datatables').DataTable({
            processing: true,
            searching: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('api/destination'); ?>",
                type: "GET",
                headers: {"Authorization": "Bearer <?php echo $session['token'] ?>"},
            },
            columns: [
            {data: 'name'},
            {data: 'description'},
            {data: 'url'},
            {data: 'status_apps'},
            {data: 'status_web'},
            {
             'mRender': function (data, type, row) {
                return '<a class="btn btn-xs bg-gradient-primary" href="<?php echo base_url(); ?>/admin/destination/edit/' + row.id + '"><i class="fa fa-edit"></i></a>&nbsp; ' +
                '<a class="btn btn-xs bg-gradient-danger" href="#" onclick="deleteData(' + row.id + ')"><i class="fa fa-trash"></i></a>';
            }
        }
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
                    url: "<?php echo base_url() . '/api/destination' ?>",
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
