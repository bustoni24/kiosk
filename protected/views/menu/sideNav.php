<div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= Constant::getImageUrl() . '/user.png' ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= Yii::app()->user->name ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item <?= in_array($this->Id, ['home']) ? 'menu-open' : '' ?>">
            <a href="<?= Constant::baseAdminUrl() . '/' ?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p> Dashboard </p>
            </a>
          </li>

          <li class="nav-item <?= in_array($this->Id, ['test']) ? 'menu-open' : '' ?>">
            <a href="javascript:void(0)" class="nav-link <?= in_array($this->Id, ['test']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-shopping-cart"></i>
              <p> Order </p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link <?= in_array($this->Id, ['test']) && isset($_GET['online']) && in_array($_GET['online'], ['1']) ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Satu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link <?= in_array($this->Id, ['test']) && isset($_GET['online']) && in_array($_GET['online'], ['0']) ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dua</p>
                </a>
              </li>
            </ul>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>