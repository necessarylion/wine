<?php
if(!isset($_COOKIE['admin']) && $_COOKIE['admin'] != '12345878' ){
  $link = $link_url.'login/login.php';
  header("location:$link");
}

if(isset($_GET['logout'])){
  unset($_COOKIE['admin']);
  unset($_COOKIE['username']);
  unset($_COOKIE['user_id']);
  setcookie('admin', null, -1, '/');
  setcookie('username', null, -1, '/');
  setcookie('user_id', null, -1, '/');
  $link = $link_url.'login/login.php';
  header("location:$link");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title> ZKK - <?php echo $title; ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo $application_url; ?>resource/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo $application_url; ?>resource/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo $application_url; ?>resource/vendor/datepicker/css/datepicker.css" rel="stylesheet">
  <link href="<?php echo $application_url; ?>resource/vendor/select2/dist/css/select2.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

<?php include $include_url.'layout/sidebar.php' ?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
      <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Topbar Navbar -->
    <ul class="navbar-nav">
    <li class="nav-item no-arrow mx-1">
              <a href='<?php echo $link_url; ?>extension' class="nav-link text-black" >
                <i class="fas fa-cog fa-fw"></i> &nbsp; Extensions
                <!-- Counter - Alerts -->
              </a>
              
       </li>
       <div class="topbar-divider d-none d-sm-block"></div>
    </ul>
    <ul class="navbar-nav ml-auto">

      <!-- Nav Item - Search Dropdown (Visible Only XS) 
      <li class="nav-item dropdown no-arrow d-sm-none">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-search fa-fw"></i>
        </a>
       Dropdown - Messages
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
          <form class="form-inline mr-auto w-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->
    

      <div class="topbar-divider d-none d-sm-block"></div>

      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small text-uppercase"><?php echo $_COOKIE['username'] ?></span>
          <img class="img-profile rounded-circle" src="<?php echo $application_url."resource/img/garfield.png" ?>">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
         
          <a href='?logout=1' class="dropdown-item" >
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>
        </div>
      </li>

    </ul>

  </nav>