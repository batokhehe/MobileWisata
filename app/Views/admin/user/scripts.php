<script type="application/javascript">
    var table;
    function deleteData(id){
        $.ajax({
            url: "<?php echo base_url() . '/api/user' ?>/" + id,
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
        $('#image').change(function(){
            readURL(this, '#image_view');
        });

<?php
if ($session['is_first_login'] == 'true') {
    ?>
      setTimeout(function(){
        table = $('.datatables').DataTable({
            processing: true,
            searching: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('api/user'); ?>",
                type: "GET",
                headers: {"Authorization": "<?php echo $session['token'] ?>"},
            },
            columns: [
            {data: 'name'},
            {data: 'email'},
            {data: 'phone'},
            {data: 'status'},
            {
               'mRender': function (data, type, row) {
                return '<a class="btn btn-xs bg-gradient-primary" href="<?php echo base_url(); ?>/admin/user/edit/' + row.id + '"><i class="fa fa-edit"></i></a>&nbsp; ' +
                '<a class="btn btn-xs bg-gradient-danger" href="#" onclick="deleteData(' + row.id + ')"><i class="fa fa-trash"></i></a>';
                }
            }],
            order: [[ 1, "asc" ]]
        });
      },10000);
      <?php
} else {
    ?>
        table = $('.datatables').DataTable({
            processing: true,
            searching: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('api/user'); ?>",
                type: "GET",
                headers: {"Authorization": "<?php echo $session['token'] ?>"},
            },
            columns: [
            {data: 'name'},
            {data: 'email'},
            {data: 'phone'},
            {data: 'status'},
            {
               'mRender': function (data, type, row) {
                return '<a class="btn btn-xs bg-gradient-primary" href="<?php echo base_url(); ?>/admin/user/edit/' + row.id + '"><i class="fa fa-edit"></i></a>&nbsp; ' +
                '<a class="btn btn-xs bg-gradient-danger" href="#" onclick="deleteData(' + row.id + ')"><i class="fa fa-trash"></i></a>';
                }
            }],
            order: [[ 1, "asc" ]]
        });
    <?php }?>

        $("#form").validate({
            errorElement: 'span',
            errorClass: "is-invalid",
            submitHandler: function(form) {
                var form = $('form')[0]; // You need to use standard javascript object here
                var formData = new FormData(form);
                $.ajax({
                    url: "<?php echo base_url() . '/api/user' ?>",
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
