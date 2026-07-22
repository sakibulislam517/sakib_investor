<?php
$company_ar = $db->getFull('settings','*',' and id = 1')[0];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=0"
    />
    <meta name=”robots” content=”noindex”>
    <title><?php echo $company_ar['company_name'];?></title>
    <link rel="shortcut icon" href="images/logo/fab.png" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="assets/plugins/bootstrap/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="assets/plugins/flags/flags.css" />
    <link
      rel="stylesheet"
      href="assets/plugins/fontawesome/css/fontawesome.min.css"
    />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link
      rel="stylesheet"
      href="assets/plugins/datatables/datatables.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css"
    />
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  </head>

  <body>
    <style type="text/css">
      input[type="checkbox"]{
        margin: 0;
        cursor: pointer!important;
      }
      .page-wrapper{
        min-height: unset!important;
      }
      .only_print{
        display: none;
      }
      [disabled] {
          background: #524c7a66;
          opacity: 0.4;
      }
      .text-right{
        text-align: right!important;
      }
      a,button{
        cursor: pointer!important;
      }
      input{
        cursor: auto!important;
      }
      .pg_title {
          float: left;
          font-weight: bold;
          font-size: 20px;
      }
      .table tr td{
        padding: 0.2rem .5rem !important;
      }
      .sl_start {
          counter-reset: my-sec-counter;
      }
      .dy_sl::before {
        counter-increment: my-sec-counter;
        content: counter(my-sec-counter);
      }
      @media print {
        body{
          background-color: #fff!important;
        }
        td,th{
          font-size: 12px!important;
        }
        body {
          margin: 0!important;
          padding: 0!important;
        }
        .sidebar,.header,.no-print,footer,.card-header,form{
          display: none!important;
        }
        .card,.content,.page-wrapper {
          margin: 0!important;
          padding: 0!important;
          box-shadow: unset!important;
        }
        .only_print{
          display: block!important;
        }

      }
      .form-group {
          margin: 5px 0;
      }
      .select2-container .select2-selection--single {
          height: 38px;
      }
      .select2-container--default .select2-selection--single .select2-selection__rendered {
          line-height: 37px;
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow {
          height: 37px;
      }
      .modal-header,.modal-footer {
          padding: 0.5rem 1rem;
      }
      form{
        margin:0
      }
    </style>
    <div class="main-wrapper">
      <div class="header">
        <div class="header-left">
          <a href="<?php echo domain;?>" class="logo" style="margin:0 auto;display:block;">
            <img src="<?php echo domain;?>images/logo/logo.png?r=50" alt="Logo" style="max-height:70px;"/>
          </a>
          <a href="<?php echo domain;?>" class="logo logo-small">
            <img
              src="<?php echo domain;?>images/logo/logo.png"
              alt="Logo"
              width="30"
              height="30"
            />
          </a>
        </div>
        <div class="menu-toggle">
          <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
          </a>
        </div>

        <a class="mobile_btn" id="mobile_btn">
          <i class="fas fa-bars"></i>
        </a>

        <ul class="nav user-menu">

<!-- 
          <li class="nav-item dropdown noti-dropdown me-2">
            <a
              href="#"
              class="dropdown-toggle nav-link header-nav-list"
              data-bs-toggle="dropdown"
            >
              <img src="assets/img/icons/header-icon-05.svg" alt="" />
            </a>
            <div class="dropdown-menu notifications">
              <div class="topnav-dropdown-header">
                <span class="notification-title">Notifications</span>
                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
              </div>
              <div class="noti-content">
                <ul class="notification-list">
                
              
                  <li class="notification-message">
                    <a href="#">
                      <div class="media d-flex">
                        <span class="avatar avatar-sm flex-shrink-0">
                          <img
                            class="avatar-img rounded-circle"
                            alt="User Image"
                            src="assets/img/profiles/avatar-13.jpg"
                          />
                        </span>
                        <div class="media-body flex-grow-1">
                          <p class="noti-details">
                            <span class="noti-title">Mercury Software Inc</span>
                            added a new product
                            <span class="noti-title">Apple MacBook Pro</span>
                          </p>
                          <p class="noti-time">
                            <span class="notification-time">12 mins ago</span>
                          </p>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="topnav-dropdown-footer">
                <a href="#">View all Notifications</a>
              </div>
            </div>
          </li> -->
          <?php
          $img = $db->getonecol('img','admin','id',$db->uid());
          if (!empty($img) and file_exists('images/other/'.$img)) {
            $img = domain.'images/other/'.$img;
          }else{
            $img = domain.'assets/img/profiles/user.png';
          }
          ?>
          <li class="nav-item dropdown has-arrow new-user-menus">
            <a
              href="#"
              class="dropdown-toggle nav-link"
              data-bs-toggle="dropdown"
            >
              <span class="user-img">
                <img class="rounded-circle" src="<?php echo $img;?>" width="31"/>
                <div class="user-text">
                  <h6><?php echo isset($_SESSION['name'])?$_SESSION['name']:'';?></h6>
                  <p class="text-muted mb-0"><?php echo isset($_SESSION['desig'])?$_SESSION['desig']:'';?></p>
                </div>
              </span>
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="<?php echo domain;?>logout">Logout</a>
            </div>
          </li>
        </ul>
      </div>

      <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
          <div id="sidebar-menu" class="sidebar-menu">
            <ul>

              <?php 
              
              
              foreach ($db->getFull('pages','*',' and parent_id = 0 order by sl') as $key => $value) {
                $sub_manue_ar = $db->getFull('pages','*',' and parent_id = '.$value['id'].' order by sl') ;
                if ($sub_manue_ar) {
                  $sub_manue = '';$paren_class = 'submenu';
                  
                  foreach ($sub_manue_ar as $k => $v) {
                    $sub_class = '';
                    if ($v['url'] == $pg) {
                      $paren_class .= ' active';
                      $sub_class = 'active';
                    }
                    if (in_array($v['url'], $access)) {
                      $sub_manue .= '<li><a class="'.$sub_class.'" href="'.$v['url'].'"><i class="'.$v['icon'].'"></i><span> '.$v['name'].'</span></a></li>';
                    }
                    
                  }
                  if (in_array($value['url'], $access)) {
                  echo '<li class="submenu '.$paren_class.'">
                          <a href="'.domain.$value['url'].'">
                          <i class="'.$value['icon'].'"></i> <span> '.$value['name'].'</span>
                          <span class="menu-arrow"></span></a>
                          <ul>'.$sub_manue.'</ul>
                        </li>';
                    }
                }else{
                  if (in_array($value['url'], $access)) {
                    echo '<li';
                    echo $pg==$value['url']?' class="active"':'';
                    echo '><a href="'.domain.$value['url'].'"><i class="'.$value['icon'].'"></i> <span> '.$value['name'].'</span></a></li>';
                  }
                }
                
              }

              ?>

            
            </ul>
          </div>
        </div>
      </div>
    <div class="page-wrapper">
      <div class="content container-fluid">