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
                <h3 class="card-title"><i class="fa fa-plus fa-fw"></i>&nbsp;<?php echo 'Update ' . $menu; ?></h3>
                <div class="card-tools">
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="control-label">Destination</label>
                    <select class="form-control" name="destination_id" id="destination_id" required="">
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Altitude</label>
                    <input type="text" class="form-control" name="altitude"
                    placeholder="Altitude"
                    id="altitude"
                    aria-describedby="error-altitude" required="">
                    <span class="error" id="error-altitude" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Temperature</label>
                    <input type="text" class="form-control" name="temperature"
                    placeholder="Temperature"
                    id="temperature"
                    aria-describedby="error-temperature" required="">
                    <span class="error" id="error-temperature" style="color:red;">
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label">Tourist per year</label>
                    <input type="text" class="form-control" name="tourist"
                    placeholder="Tourist per year"
                    id="tourist"
                    aria-describedby="error-tourist" required="">
                    <span class="error" id="error-tourist" style="color:red;">
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

