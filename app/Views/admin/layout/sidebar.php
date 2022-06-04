<!-- sidebar: style can be found in sidebar.less -->
<a href="<?php echo base_url(); ?>" class="brand-link navbar-info">
    <img src="<?php echo base_url(); ?>/assets/web/images/elements/favicon.png"
        alt="MW Panel"
        class="brand-image img-circle elevation-3"
        style="background-color:white">
    <span class="brand-text font-weight-light" style="color:white">MW Panel</span>
</a>

<div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="<?php echo base_url(); ?>/assets/admin/dist/img/user2-160x160.jpg" class="brand-image img-circle elevation-3" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block"><?php echo $session['email'] ?></a>
        </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- <li class="header">MAIN NAVIGATION</li> -->
            <?php echo $menulib->sidebar($slug); ?>
        </ul>
    </nav>
</div>
<!-- /.sidebar -->