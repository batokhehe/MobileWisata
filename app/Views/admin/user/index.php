<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1><?php echo $menu; ?></h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo $menu; ?> List</h3>
            <div class="card-tools">
             <?php if ($securitylib->check_access('create', $slug)) {?>
                <div class="box-header with-border">
                    <a href="<?php echo base_url() . '/admin/' . $slug . '/create' ?>" class="btn bg-gradient-primary" title="Add"  ><i class="fa fa-plus"></i> &nbsp;Add Data</a>
                </div>
            <?php }?>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover datatables" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
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
</section>

