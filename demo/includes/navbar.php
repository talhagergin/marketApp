<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="../pages/dashboard.php">Ana Sayfa</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><?= isset($breadcrumb) ? $breadcrumb : ''; ?></li>
          </ol>
          <h6 class="font-weight-bolder mb-0"><?= isset($breadcrumb) ? $breadcrumb : ''; ?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <?php 
              if(isset($_SESSION["user_id"])){?>
              <a href="../pages/profile.php?user_id=<?=$_SESSION['user_id'] ;?>" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"><?=$loginUser["username"];?></span>

              </a>
            </li>
              <li>
              <?php } else { ?>
              <a href="../pages/sign-in.php" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Giriş</span>
              </a>
              <?php } ?>
              
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
            </li>
            <?php if(isset($_SESSION['user_id'])){ ?>
            <li class="nav-item d-flex align-items-center">
              <a href="../pages/sign-out.php" class="nav-link text-body font-weight-bold px-0">
                <span class="d-sm-inline d-none"></span>
                <i class="fa fa-sign-out me-sm-1">Çıkış</i>
              </a>
            </li>
            <?php }?>
          </ul>
        </div>
      </div>
    </nav>