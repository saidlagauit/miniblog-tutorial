<?php
session_start();
$pageTitle = 'Said Lagauit - Categories';
include 'init.php';

$categories = isset($_GET['category']) ? $_GET['category'] : '';

$categoryArticles = $con->prepare("SELECT `title`, `slug` FROM `articles` WHERE `categories` = :categories");
$categoryArticles->execute(array(':categories' => $categories));
echo '<h1 class="rounded-top text-md-center text-capitalize text-bg-dark mt-1 py-1">' . $categories . '</h1>';
?>
<div class="row">
  <div class="col-md-4 text-md-center mx-auto">
    <?php
    if (!empty($categories)) {
      while ($article = $categoryArticles->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <nav class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="index.php?do=reading&slug=<?php echo $article['slug'] ?>">
              <?php echo $article['title']; ?>
            </a>
          </li>
        </nav>
        <?php
      }
    } else {
      header('Location: index.php');
    }
    ?>
  </div>
</div>
<?php

include $tpl . 'footer.php'; ?>