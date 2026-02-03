<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'administrator') { ?>
  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark border-right" id="sidebar-wrapper">
      <div class="sidebar-heading text-white">MiniBlog Admin</div>
      <div class="list-group list-group-flush">
        <a href="dashboard.php" class="list-group-item list-group-item-action bg-dark text-light"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="edit.php" class="list-group-item list-group-item-action bg-dark text-light"><i class="fas fa-edit"></i> Post</a>
        <a href="edit-comments.php" class="list-group-item list-group-item-action bg-dark text-light"><i class="fas fa-comments"></i> Comments</a>
        <a href="edit-contacts.php" class="list-group-item list-group-item-action bg-dark text-light"><i class="fas fa-envelope"></i> Messages</a>
        <a href="widgets.php" class="list-group-item list-group-item-action bg-dark text-light"><i class="fas fa-th"></i> Widgets</a>
        <a href="dashboard.php?do=users" class="list-group-item list-group-item-action bg-dark text-light"><i class="fas fa-users"></i> Users</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom top-navbar">
        <div class="container-fluid">
          <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user-circle"></i> <?php echo $_SESSION['username']; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="edit-users.php"><i class="fas fa-user"></i> Profile</a>
                  <a class="dropdown-item" href="../"><i class="fas fa-eye"></i> Visit Website</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="container-fluid mt-4">
      <?php } else { ?>
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark text-capitalize">
          <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#MyNavbar"
              aria-controls="MyNavbar" aria-expanded="false" aria-label="Toggle navigation">
              <span><i class="fa fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="MyNavbar">
              <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                  </a>
                  <ul class="dropdown-menu  dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="edit-users.php">
                        <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?><br />
                        <i class="fas fa-at"></i>
                        <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>
                      </a>
                    </li>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item" href="edit.php?do=new-posts">Create Posts</a>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out"></i>&nbsp;Sign Out</a></li>
                </li>
              </ul>
              </li>
              </ul>
            </div>
          </div>
        </nav>
        <div class="container">
        <?php } ?>