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
                    <label class="control-label">Name</label>
                    <input type="text" class="form-control" name="name"
                    placeholder="Name"
                    id="name"
                    aria-describedby="error-name" required="">
                    <span class="error" id="error-name" style="color:red;">
                    </span>
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
                    <label class="control-label">URL</label>
                    <input type="text" class="form-control" name="url"
                    placeholder="URL"
                    id="url"
                    aria-describedby="error-url" required="">
                    <span class="error" id="error-url" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Latitude</label>
                    <input type="text" class="form-control" name="lat"
                    placeholder="Latitude"
                    id="lat"
                    aria-describedby="error-lat" required="">
                    <span class="error" id="error-lat" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Longitude</label>
                    <input type="text" class="form-control" name="long"
                    placeholder="Longitude"
                    id="long"
                    aria-describedby="error-long" required="">
                    <span class="error" id="error-long" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Image Portrait</label>
                    <input type="file" class="form-control" name="image_portrait"
                    accept="image/*"
                    id="image_portrait"
                    aria-describedby="error-image_portrait">
                    <span class="error" id="error-image_portrait" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Image Landscape</label>
                    <input type="file" class="form-control" name="image_landscape"
                    accept="image/*"
                    id="image_landscape"
                    aria-describedby="error-image_landscape">
                    <span class="error" id="error-image_landscape" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Category</label>
                    <select class="form-control" name="category_id" id="category_id" required="">
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Status APPS</label>
                    <select class="form-control" name="status_apps" id="status_apps" required="">
                        <option value="1">Intro</option>
                        <option value="2">Home</option>
                        <option value="3">Intro & Home</option>
                    </select>
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

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Media List</h3>
            <div class="card-tools">
             <?php if ($securitylib->check_access('create', 'media')) {?>
                <div class="box-header with-border">
                    <a href="<?php echo base_url() . '/admin/media/create/' . $id ?>" class="btn bg-gradient-primary" title="Add"  ><i class="fa fa-plus"></i> &nbsp;Add Media</a>
                </div>
            <?php }?>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover datatables" id="media_table" width="100%">
                <thead>
                    <tr>
                        <th>Media Type</th>
                        <th>File Path</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

     <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rate & Review List</h3>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover datatables" id="rate_table" width="100%">
                <thead>
                    <tr>
                        <th>Review</th>
                        <th>Rate</th>
                        <th>Username</th>
                        <th>Date</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->
</section>

