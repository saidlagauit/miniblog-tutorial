<?php
session_start();
$pageTitle = 'Said Lagauit';
include 'init.php';
$do = isset($_GET['do']) ? $_GET['do'] : 'view';

$Parsedown = new Parsedown();

if ($do == 'view') {
  $recordsPerPage = 10;
  $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
  $offset = ($currentPage - 1) * $recordsPerPage;
  $totalRecords = $con->prepare('SELECT COUNT(*) FROM `articles`')->fetchColumn();
  $IsArticles = $con->prepare("SELECT * FROM `articles` WHERE `status_a` IN (0, 1) ORDER BY `created` DESC LIMIT :limit OFFSET :offset");
  $IsArticles->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
  $IsArticles->bindParam(':offset', $offset, PDO::PARAM_INT);
  $IsArticles->execute();
  ?>
  <div class="row g-3">
    <div class="col-md-10">
      <h1 class="text-capitalize">articles</h1>
      <ul class="view text-capitalize border-top border-dark">
        <?php
        if ($IsArticles->rowCount() > 0) {
          foreach ($IsArticles as $article) {
            $dateString = empty($article['updated']) ? $article['created'] : $article['updated'];
            $now = date('Y-m-d H:i:s');
            $timeDiff = strtotime($now) - strtotime($dateString);
            if ($timeDiff > 86400) {
              $formattedDate = date('d-M', strtotime($dateString));
            } else {
              $formattedDate = date('H:i', strtotime($dateString));
            }
            ?>
            <li class="d-view">
              <a class="text-bg-light border-bottom pb-2" href="index.php?do=reading&slug=<?php echo $article['slug']; ?>">
                <?php echo $article['title'] ?>&nbsp;<span class="badge bg-dark">
                  <?php echo $formattedDate; ?>
                </span>
              </a>
            </li>
            <?php
          }
        } else {
          echo '<p>No articles found.</p>';
        }
        ?>
      </ul>
    </div>
    <div class="col-md-2">
      <div class="category text-md-end">
        <h1 class="text-capitalize">categories</h1>
        <?php
        $categoriesCount = $con->query("SELECT categories, COUNT(*) AS count FROM articles GROUP BY categories");
        while ($category = $categoriesCount->fetch(PDO::FETCH_ASSOC)) {
          echo '<a class="text-secondary" href="categories.php?category=' . $category['categories'] . '">';
          echo $category['categories'] . ' (' . $category['count'] . ')';
          echo '</a><br />';
        }
        ?>
      </div>
    </div>
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
  $slug = $_GET['slug'];
  $Articles = $con->prepare("SELECT `id`, `title`, `slug`, `cover`, `content`, `author`, `status_a`, `categories`, `tags`, `created`, `updated` FROM `articles` WHERE `slug` = ? AND `status_a` = 1");
  $Articles->execute([$slug]);
  if (!empty($Articles)) {
    foreach ($Articles as $article) {
      ?>
      <div class="row g-3 my-1">
        <h2 class="title-reading text-capitalize">
          <?php echo $article['title']; ?>
        </h2>
        <?php
        if (!empty($article['cover'])) {
          ?>
          <div class="col-md-4">
            <img class="img-reading" src="./uploads/<?php echo $article['cover']; ?>" alt="<?php echo $article['title']; ?>">
          </div>
          <?php
        }
        ?>
        <div class="col-md-8 mx-auto">
          <p>
            <?php
            $markdownContent = $article['content'];
            $htmlContent = $Parsedown->text($markdownContent);
            echo $htmlContent; ?>
          </p>
          <div class="comments-show border my-1 p-2">
            <?php if (isset($_SESSION['message'])): ?>
              <div id="message">
                <?php echo $_SESSION['message']; ?>
              </div>
              <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
            <ul>
              <?php
              $articlesid = $article['id'];
              $Allcomments = $con->prepare("SELECT comments.articlesid, comments.comment, comments.name, comments.approved, comments.date_c, articles.id FROM comments INNER JOIN articles ON comments.articlesid = articles.id WHERE comments.articlesid = ? ORDER BY comments.date_c DESC");
              $Allcomments->execute(array($articlesid));
              foreach ($Allcomments as $comments) {
                $dateString = $comments['date_c'];
                $now = date('Y-m-d H:i:s');
                $timeDiff = strtotime($now) - strtotime($dateString);
                if ($timeDiff > 86400) {
                  $formattedDate = date('d-M', strtotime($dateString));
                } else {
                  $formattedDate = date('H:i', strtotime($dateString));
                }
                if ($comments['approved'] == 1) {
                  ?>
                  <li>
                    <h6>
                      <?php echo $comments['name'] . '&nbsp;:&nbsp;<i class="fas fa-quote-left"></i>&nbsp;' . $comments['comment'] ?>&nbsp;
                      <i class="fas fa-quote-right"></i></i>&nbsp;<span class="badge bg-dark">
                        <?php echo $formattedDate; ?>
                      </span>
                    </h6>
                  </li>
                  <?php
                } else {
                  echo '<p></p>';
                }
              }
              ?>
            </ul>
          </div>
          <form class="shadow p-2" action="index.php?do=comments-true" method="post" autocomplete="off" id="comments">
            <div class="row g-3">
              <div class="col-md-12">
                <div class="form-group">
                  <input type="hidden" name="articlesid" value="<?php echo $id; ?>">
                  <label for="textarea" class="control-label">Comments<span class="text-danger">*</span></label>
                  <textarea name="comment" class="form-control" rows="3" required="required"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Name<span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="name" required="required" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Email<span class="text-danger">*</span></label>
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
                  <i class="fa fa-paper-plane"></i>&nbsp;Comment
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <?php
    }
  } else {
    header('Location: index.php');
    exit();
  }
} elseif ($do == 'comments-true') {
  if (isset($_POST['comments'])) {
    $articlesid = cleanInput($_POST['articlesid']);
    $comment = cleanInput($_POST['comment']);
    $name = cleanInput($_POST['name']);
    $email = cleanInput($_POST['email']);
    $website = cleanInput($_POST['website']);
    $stmt = $con->prepare("INSERT INTO `comments`(`articlesid`, `comment`, `name`, `email`, `website`) VALUES (?,?,?,?,?)");
    $stmt->execute(array($articlesid, $comment, $name, $email, $website));
    show_message('Thank you for comment', 'success');
    header('Location: ?do=reading&id=' . $articlesid . '#comments');
    exit();
  } else {
    header('Location: index.php');
    exit();
  }
}

include $tpl . 'footer.php'; ?>