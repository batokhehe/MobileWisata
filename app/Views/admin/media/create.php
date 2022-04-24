<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $menu; ?></h1>
            </div>
            <?php echo $breadcrumbs; ?>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <!-- Default box -->
    <div class="card">
        <form id="form">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-plus fa-fw"></i>&nbsp;<?php echo 'Add ' . $menu; ?></h3>
                <div class="card-tools">
                </div>
            </div>
            <div class="card-body">
                <input type="hidden" name="destination_id" id="destination_id" value="<?php echo $id ?>">
                <div class="form-group">
                    <label class="control-label">Media Type</label>
                    <select class="form-control" name="media_type" id="media_type" required="">
                        <option value="youtube">Youtube</option>
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Link</label>
                    <input type="text" class="form-control" name="link"
                    placeholder="Link"
                    id="link"
                    aria-describedby="error-link">
                    <span class="error" id="error-link" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Media</label>
                    <input type="file" class="form-control" name="media"
                    id="media"
                    aria-describedby="error-media">
                    <span class="error" id="error-media" style="color:red;">
                    </span>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="<?php echo base_url('admin/destination/edit/' . $id) ?>" class="btn bg-gradient-default"><i class="fa fa-times"></i> &nbsp;Close</a>
                <button type="submit" class="btn bg-gradient-primary float-right"><i class="fa fa-save"></i> &nbsp;Save</button>
            </div>
            <!-- /.card-footer-->
        </form>
    </div>
    <!-- /.card -->
</section>

