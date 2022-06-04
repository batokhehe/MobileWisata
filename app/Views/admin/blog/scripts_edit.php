<script type="application/javascript">
    var table;

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
            url: "<?php echo base_url() . '/api/blog/' . $id ?>",
            type: 'get',
            headers: {"Authorization": "<?php echo $session['token'] ?>"},
            success: function (response) {
                var data = response.data;
                $('#title').val(data.title);
                $('#description').summernote('code', data.description);
                initCategory(data.category_id);
            }
        });



        $("#form").validate({
            errorElement: 'span',
            errorClass: "is-invalid",
            submitHandler: function(form) {
                var form = $('form')[0]; // You need to use standard javascript object here
                var formData = new FormData(form);
                formData.append('description', $('#description').summernote('code'));
                $.ajax({
                    url: "<?php echo base_url() . '/api/blog/' . $id ?>",
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {"Authorization": "<?php echo $session['token'] ?>"},
                    success: function (data) {
                        $(location).prop('href', "<?php echo base_url('admin/blog') ?>");
                    }
                });
            }
        });
    });
</script>
