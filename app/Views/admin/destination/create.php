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
                    aria-describedby="error-image_portrait" required="">
                    <span class="error" id="error-image_portrait" style="color:red;">
                    </span>
                    <img id="image_portrait_view" style="width: 100px">
                </div>
                <div class="form-group">
                    <label class="control-label">Image Landscape</label>
                    <input type="file" class="form-control" name="image_landscape"
                    accept="image/*"
                    id="image_landscape"
                    aria-describedby="error-image_landscape" required="">
                    <span class="error" id="error-image_landscape" style="color:red;">
                    </span>
                    <img id="image_landscape_view" style="width: 100px">
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
</section>

