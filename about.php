<?php
session_start();
$pageTitle = 'About';
include 'init.php';
$IsAbout = $con->prepare("SELECT * FROM `about` LIMIT 1");
$IsAbout->execute();
if (!empty($IsAbout)) {
  ?>
  <div class="row g-3">
    <?php
    foreach ($IsAbout as $about) {
      ?>
      <div class="col-md-3">
        <img class="img-about" src="./uploads/<?php echo $about['image'] ?>" alt="me">
      </div>
      <div class="col-md-9 align-self-center">
        <h2 class="about-title">About me</h2>
        <p class="about-info">
          <?php echo $about['bio_a'] ?>
        </p>
        <nav class="nav media border-top">
          <h3 class="link-media">Contact info</h3>
          <a class="nav-link" href="<?php echo $about['fb'] ?>" target="_blank">
            <i class="fab fa-facebook-square fa-2xl"></i>
          </a>
          <a class="nav-link" href="<?php echo $about['insta'] ?>" target="_blank">
            <i class="fab fa-instagram-square fa-2xl"></i>
          </a>
          <a class="nav-link" href="<?php echo $about['twt'] ?>" target="_blank">
            <i class="fab fa-twitter-square fa-2xl"></i>
          </a>
        </nav>
      </div>
      <?php
    }
    ?>
  </div>
  <?php
} else {
  echo '<p class="alert alert-info">Add info About</p>';
}
include $tpl . 'footer.php'; ?>