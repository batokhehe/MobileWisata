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
                <h3 class="card-title"><i class="fa fa-plus fa-fw"></i>&nbsp;<?php echo 'Edit ' . $menu; ?></h3>
                <div class="card-tools">
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="control-label">Title</label>
                    <input type="text" class="form-control" name="title"
                    placeholder="Title"
                    id="title"
                    aria-describedby="error-title" required="">
                    <span class="error" id="error-title" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Icon</label>
                    <input type="text" class="form-control" name="icon"
                    placeholder="Icon"
                    id="icon"
                    aria-describedby="error-icon" required="">
                </div>
                <div class="form-group">
                    <label class="control-label">Description</label>
                    <input type="text" class="form-control" name="description"
                    placeholder="Description"
                    id="description"
                    aria-describedby="error-description" required="">
                    <span class="error" id="error-description" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Image</label>
                    <input type="file" class="form-control" name="image"
                    accept="image/*"
                    id="image"
                    aria-describedby="error-image" required="">
                    <span class="error" id="error-image" style="color:red;">
                    </span>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="<?php echo base_url('admin/' . $slug) ?>" class="btn bg-gradient-default"><i class="fa fa-times"></i> &nbsp;Close</a>
                <button type="submit" class="btn bg-gradient-primary float-right"><i class="fa fa-save"></i> &nbsp;Save</button>
            </div>
            <!-- /.card-footer-->
        </form>
    </div>
    <!-- /.card -->
</section>

