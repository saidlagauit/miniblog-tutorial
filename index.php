<?php
session_start();
$pageTitle = 'Home';
include 'init.php';
$do = isset($_GET['do']) ? $_GET['do'] : 'view';
if ($do == 'view') {
  $recordsPerPage = 10;
  $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
  $offset = ($currentPage - 1) * $recordsPerPage;
  $totalRecords = $con->prepare('SELECT COUNT(*) FROM `articles`')->fetchColumn();
  $IsArticles = $con->prepare("SELECT * FROM `articles` WHERE `status_a` = '1' ORDER BY `created` DESC LIMIT :limit OFFSET :offset");
  $IsArticles->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
  $IsArticles->bindParam(':offset', $offset, PDO::PARAM_INT);
  $IsArticles->execute();
  $stmt = $con->prepare("SELECT `id`, `image`, `bio_a`, `fb`, `insta`, `twt` FROM `about` LIMIT 1");
  $stmt->execute();
  $about = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt = $con->prepare("SELECT `id`, `name`, `bio`, `pic` FROM `me` LIMIT 1");
  $stmt->execute();
  $me = $stmt->fetch(PDO::FETCH_ASSOC);
?>
  <div class="hero">
    <h1>Hi! I'm <?php echo $me['name']; ?></h1>
    <p><?php echo $me['bio']; ?></p>
    <ul class="social-media d-flex">
      <li class="nav-item"><a class="nav-link" aria-label="On facebook" href="<?php echo $about['fb']; ?>"><i class="fab fa-facebook-f fa-lg"></i></a></li>
      <li class="nav-item mx-3"><a class="nav-link" aria-label="On instagram" href="<?php echo $about['insta']; ?>"><i class="fab fa-instagram fa-lg"></i></a></li>
      <li class="nav-item"><a class="nav-link" aria-label="On twitter" href="<?php echo $about['twt']; ?>"><i class="fab fa-twitter fa-lg"></i></a></li>
    </ul>
    <a href="./contact.php" class="btn btn-main">Get in Touch</a>
  </div>
  <h2 class="mb-3">Blog Posts&nbsp;<i class="fas fa-sort-down"></i></h2>
  <div class="row g-3">
    <?php foreach ($IsArticles as $article) :
      $dateString = empty($article['updated']) ? $article['created'] : $article['updated'];
      $now = date('Y-m-d H:i:s');
      $timeDiff = strtotime($now) - strtotime($dateString);
      if ($timeDiff > 86400) {
        $Date = date('d-M', strtotime($dateString));
      } else {
        $Date = date('H:i', strtotime($dateString));
      }
      $cover = $article['cover'];
      $title = $article['title'];
      $slug = $article['slug'];
    ?>
      <div class="col-md-4">
        <div class="card">
          <img class="card-img-top" src="./uploads/<?php echo $cover; ?>" alt="<?php echo $title; ?>">
          <div class="card-body">
            <a href="./index.php?do=reading&slug=<?php echo $slug; ?>" class="card-title h2"><?php echo $title; ?></a>
            <p class="card-text"><?php echo $Date; ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php
  $totalPages = ceil($totalRecords / $recordsPerPage);
  if ($totalPages > 1) {
    echo '<nav><ul class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++) {
      if ($i == $currentPage) {
        echo '<li class="page-item active" aria-current="page">
          <span class="page-link">' . $i . '</span>
        </li>';
      } else {
        echo '<li class="page-item"><a class="page-link" href="index.php?page=' . $i . '">' . $i . '</a></li>';
      }
    }
    echo '</ul></nav>';
  }
} elseif ($do == 'reading') {
  $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
  $Articles = $con->prepare("SELECT `id`, `title`, `slug`, `cover`, `content`, `author`, `status_a`, `categories`, `tags`, `created`, `updated` FROM `articles` WHERE `slug` = ? AND `status_a` = '1'");
  $Articles->execute([$slug]);
  $post = $Articles->fetch(PDO::FETCH_ASSOC);
  if (!$post) {
  ?>
    <div class="col-md-8 mx-auto">
      <div class="alert alert-warning text-center mt-2" role="alert">
        Article not found
      </div>
    </div>
  <?php
  } else {
    $dateString = empty($post['updated']) ? $post['created'] : $post['updated'];
    $now = date('Y-m-d H:i:s');
    $timeDiff = strtotime($now) - strtotime($dateString);
    if ($timeDiff > 86400) {
      $Date = date('d-M', strtotime($dateString));
    } else {
      $Date = date('H:i', strtotime($dateString));
    }
    $postID = $post['id'];
    $cover = $post['cover'];
    $title = $post['title'];
    $markdownContent = $post['content'];
    $content = $Parsedown->text($markdownContent);
  ?>
    <ul class="reading">
      <li class="reading-cover text-bg-dark" style="background-image: url(./uploads/<?php echo $cover ?>);">
        <h1 class="reading-title"><?php echo $title ?></h1>
        <span class="reading-date"><?php echo $Date ?></span>
      </li>
      <li class="reading-content mt-4">
        <div class="col-md-8 mx-auto">
          <?php echo $content ?>
        </div>
      </li>
      <li class="commint">
        <div class="d-commint">
          <div class="col-md-8 mx-auto">
            <h3>Comments</h3>
            <?php
            if (isset($_SESSION['message'])) : ?>
              <div id="message">
                <?php echo $_SESSION['message']; ?>
              </div>
            <?php unset($_SESSION['message']);
            endif;
            $articlesid = $postID;
            $Allcomments = $con->prepare("SELECT comments.articlesid, comments.comment, comments.name, comments.approved, comments.date_c, articles.id FROM comments INNER JOIN articles ON comments.articlesid = articles.id WHERE comments.articlesid = ? AND comments.approved = '1' ORDER BY comments.date_c DESC");
            $Allcomments->execute([$articlesid]);
            foreach ($Allcomments as $commint) :
              $dateString = $commint['date_c'];
              $now = date('Y-m-d H:i:s');
              $timeDiff = strtotime($now) - strtotime($dateString);
              if ($timeDiff > 86400) {
                $formattedDate = date('d-M', strtotime($dateString));
              } else {
                $formattedDate = date('H:i', strtotime($dateString));
              }
            ?>
              <div class="card bg-body-tertiary p-2 mt-3">
                <span class="by text-capitalize"><?php echo $commint['name'] . ' commented on ' . $formattedDate; ?></span>
                <hr />
                <p class="m-0"><?php echo $commint['comment']; ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="col-md-8 mx-auto">
          <hr />
          <h4>Leave a Comment</h4>
          <form class="bg-body-tertiary p-2" action="index.php?do=comments-true" method="post" autocomplete="off" id="comments">
            <div class="row g-3">
              <input type="hidden" name="articlesid" value="<?php echo $articlesid; ?>">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="textarea" class="control-label">Comments *</label>
                  <textarea name="comment" class="form-control" rows="3" required="required"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Name *</label>
                  <input class="form-control" type="text" name="name" required="required" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Email *</label>
                  <input class="form-control" type="email" name="email" required="required" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Website</label>
                  <input class="form-control" type="url" name="website" />
                </div>
              </div>
              <div class="col-md-12">
                <button class="btn btn-primary" type="submit" name="comments">
                  <i class="fa fa-paper-plane"></i>&nbsp;Post Comment
                </button>
              </div>
            </div>
          </form>
          <hr />
        </div>
      </li>
    </ul>
  <?php
  }
} elseif ($do == 'comments-true') {
  if (isset($_POST['comments'])) {
    $articlesid = cleanInput($_POST['articlesid']);
    $comment = cleanInput($_POST['comment']);
    $name = cleanInput($_POST['name']);
    $email = cleanInput($_POST['email']);
    $website = cleanInput($_POST['website']);
    if (!empty($comment) && !empty($name) && !empty($email)) {
      $stmt = $con->prepare("INSERT INTO `comments`(`articlesid`, `comment`, `name`, `email`, `website`) VALUES (?,?,?,?,?)");
      $stmt->execute(array($articlesid, $comment, $name, $email, $website));
      show_message('Thank you for your comment', 'success');
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    } else {
      show_message('Please fill in all required fields', 'danger');
      header('location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  } else {
    header('Location: index.php');
    exit();
  }
} else {
  ?>
  <div class="col-md-8 mx-auto">
    <div class="alert alert-warning text-center mt-2" role="alert">
      Page not found
    </div>
  </div>
<?php
}
include $tpl . 'footer.php'; ?>
