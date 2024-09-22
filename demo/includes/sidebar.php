<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="<?= url('pages/dashboard.php');?>">
        <img src="../assets/img/gerginlogo.png" class="navbar-brand-img h-100" alt="main_logo">
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a id="menu-dashboard" class="nav-link text-white" href="<?= url('pages/dashboard.php'); ?>">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Ana Sayfa</span>
          </a>
        </li>
        <li class="nav-item">
          <a id="menu-projeler" class="nav-link text-white " href="<?= url('pages/projects.php'); ?>">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Projeler</span>
          </a>
        </li>
          <?php if($_SESSION['user_role']==1){ ?>
        <li class="nav-item">
          <a id="menu-kullanıcılar" class="nav-link text-white " href="<?= url('pages/kullanıcılar.php'); ?>">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">engineering</i>
            </div>
            <span class="nav-link-text ms-1">Personeller</span>
          </a>
        </li>
          <li class="nav-item">
              <a id="menu-firmalar" class="nav-link text-white " href="<?= url('pages/firmalar.php');?>">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">store</i>
                  </div>
                  <span class="nav-link-text ms-1">Firmalar</span>
              </a>
          </li>
              <li class="nav-item">
                  <a id="menu-missions" class="nav-link text-white " href="<?=url('pages/missions.php');?>">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                          <i class="material-icons opacity-10">list_alt</i>
                      </div>
                      <span class="nav-link-text ms-1">Görevler</span>
                  </a>
              </li>
          <?php }
          if($_SESSION['user_role']==0){?>
        <li class="nav-item">
          <a id="menu-missions" class="nav-link text-white " href="<?=url('pages/missions.php');?>">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">list_alt</i>
            </div>
            <span class="nav-link-text ms-1">Görevlerim</span>
          </a>
        </li>
          <?php } ?>
          <li class="nav-item">
              <a id="menu-actions" class="nav-link text-white " href="../pages/actions.php">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                  </div>
                  <span class="nav-link-text ms-1">İşlemler</span>
              </a>
          </li>

        <!-- <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
        </li> -->
        <li class="nav-item">
          <a id="menu-profile2" class="nav-link text-white " href="<?= url('pages/profile.php'); ?>">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a id="menu-hasilat" class="nav-link text-white " href="<?= url('pages/hasilat.php'); ?>">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">receipt_long</i>
            </div>
            <span class="nav-link-text ms-1">Hasılat</span>
          </a>
        </li> -->
        <!-- <li class="nav-item">
          <a id="menu-login" class="nav-link text-white " href="<?= url('pages/sign-in.php'); ?>">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">login</i>
            </div>
            <span class="nav-link-text ms-1">Giriş</span>
          </a>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link text-white " href="../pages/sign-up.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i id="menu-signup" class="material-icons opacity-10">assignment</i>
            </div>
            <span class="nav-link-text ms-1">Sign Up</span>
          </a>
        </li> -->
      </ul>
    </div>