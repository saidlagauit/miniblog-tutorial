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
      $markdownContent = $about['bio_a'];
      $bio = $Parsedown->text($markdownContent);
      ?>
      <div class="col-md-4">
        <img class="img-about" src="./uploads/<?php echo $about['image'] ?>" alt="me">
      </div>
      <div class="col-md-8 align-self-center">
        <div class="about-info">
          <?php echo $bio ?>
        </div>
        <nav class="nav media border-top">
          <h2 class="link-media">Contact info</h2>
          <a class="nav-link" href="<?php echo $about['fb'] ?>" aria-label="On facebook" target="_blank">
            <i class="fab fa-facebook-square fa-2xl"></i>
          </a>
          <a class="nav-link" href="<?php echo $about['insta'] ?>" aria-label="On instagram" target="_blank">
            <i class="fab fa-instagram-square fa-2xl"></i>
          </a>
          <a class="nav-link" href="<?php echo $about['twt'] ?>" aria-label="On twitter" target="_blank">
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