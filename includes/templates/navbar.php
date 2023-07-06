<nav class="navbar navbar-expand-lg bg-body-tertiary text-capitalize">
  <div class="container">
    <a class="navbar-brand h1" href="./index.php">Said Lagauit | Developer</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#MyNavbar" aria-controls="MyNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span><i class="fa fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="MyNavbar">
      <ul class="navbar-nav ms-auto">
        <?php foreach ($navbarItems as $itemName => $itemLink) : ?>
          <li class="nav-item">
            <a class="nav-link <?php pageActive($pageTitle, $itemName); ?>" href="<?php echo $itemLink; ?>"><?php echo $itemName; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">