<?php if ($_SESSION['role'] == 'administrator') { ?>
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark text-capitalize">
    <div class="container">
      <a class="navbar-brand" href="dashboard.php">
        Dashboard
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#MyNavbar"
        aria-controls="MyNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fa fa-bars"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="MyNavbar">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="edit.php">Post</a></li>
          <li class="nav-item"><a class="nav-link" href="edit-comments.php">comments</a></li>
          <li class="nav-item"><a class="nav-link" href="edit-contacts.php">Message</a></li>
          <li class="nav-item"><a class="nav-link" href="widgets.php">widgets</a></li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="edit-users.php">
                  <i class="fas fa-at"></i>
                  <?php echo $_SESSION['username']; ?><br />
                  <span class="text-secondary">See you profile</span>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="../"><i class="fas fa-eye"></i>&nbsp;Visit Website</a></li>
              <li><a class="dropdown-item" href="dashboard.php?do=users"><i class="fas fa-users"></i>&nbsp;Users</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out"></i>&nbsp;Sign Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
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
                  <?php echo $_SESSION['username']; ?><br />
                  <i class="fas fa-at"></i>
                  <?php echo $_SESSION['username']; ?>
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
<?php } ?>
<div class="container">