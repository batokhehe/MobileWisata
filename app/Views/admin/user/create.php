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
                    <label class="control-label">Email</label>
                    <input type="text" class="form-control" name="email"
                    placeholder="Email"
                    id="email"
                    aria-describedby="error-email" required="">
                    <span class="error" id="error-email" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input type="password" class="form-control" name="password"
                    placeholder="Password"
                    id="password"
                    aria-describedby="error-password" required="">
                    <span class="error" id="error-password" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Phone</label>
                    <input type="text" class="form-control" name="phone"
                    placeholder="Phone"
                    id="phone"
                    aria-describedby="error-phone" required="">
                    <span class="error" id="error-phone" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Address</label>
                    <input type="text" class="form-control" name="address"
                    placeholder="Address"
                    id="address"
                    aria-describedby="error-address" required="">
                    <span class="error" id="error-address" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Image</label>
                    <input type="file" class="form-control" name="image"
                    id="image"
                    aria-describedby="error-image">
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

