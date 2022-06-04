<!DOCTYPE html>
<html>
<head>
  <!-- meta -->
  <?php echo @$_meta; ?>
  <!-- css -->
  <?php echo @$_styles; ?>

  <!-- Google Font -->
  <link rel="stylesheet"
  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background-color: #ffffffcf;
    }
    .loader img{
      position: relative;
      left: 40%;
      top: 40%;
    }
  </style>
</head>
<body class="sidebar-mini layout-fixed control-sidebar-slide-open">
  <div class="loader" id="loading" style="display: none;"><img src="<?php echo base_url(); ?>/assets/admin/dist/img/loading.gif"></div>
  <div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-dark navbar-info">
      <!-- header -->
      <?php echo @$_header; ?>
    </nav>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar elevation-4 sidebar-light-info">
      <!-- sidebar -->
      <?php echo @$_sidebar; ?>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- content -->
      <?php echo @$_content; ?>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <!-- footer -->
      <?php echo @$_footer; ?>
    </footer>

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
     <aside class="control-sidebar-bg"></aside>
     <!-- modals -->
     <?php echo @$_modals_action; ?>
     <?php echo @$_modals_form; ?>
   </div>
   <!-- ./wrapper -->

   <!-- scripts -->
   <?php echo @$_scripts; ?>
   <?php echo @$_custom_scripts; ?>
   <!-- flash -->
   <script type="text/javascript">
    <?php echo @$_flash; ?>

    $(document).ready(function() {
      $('.summernote').summernote();
    });

    $(document).ajaxStart(function() {
      $("#loading").show();
    });

    $(document).ajaxStop(function() {
      $("#loading").hide();
    });
  </script>
</body>
</html>
