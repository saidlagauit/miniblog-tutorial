<nav class="navbar navbar-expand-lg bg-light navbar-light text-capitalize">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#MyNavbar"
      aria-controls="MyNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span><i class="fa fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="MyNavbar">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">articles</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">about</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">contact</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
  <div class="me border-bottom">
    <div class="me-info text-md-center">
      <?php
      $IsMe = $con->prepare("SELECT * FROM `me` LIMIT 1");
      $IsMe->execute();
      if (!empty($IsMe)) {
        foreach ($IsMe as $me) {
          echo '<img class="img-me rounded-circle" src="./uploads/' . $me['pic'] . '" alt="' . $me['name'] . '">
          <h1 class="n-info mt-1 text-capitalize">Said lagauit</h1>
          <p class="p-info">' . $me['bio'] . '</p>';
        }
      } else {
        echo '<p class="alert alert-info">Create New Bio</p>';
      }
      ?>
    </div>
  </div>