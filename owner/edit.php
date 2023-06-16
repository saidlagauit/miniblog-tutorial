<?php
ob_start();
session_start();
$pageTitle = 'Dashboard - Posts';
include "init.php";
$do = isset($_GET['do']) ? $_GET['do'] : 'manage';
$IsArticles = getLatest("*", "articles", "id");
if ($_SESSION['username']) {
  if ($do == 'manage') {
    if ($_SESSION['role'] == 'author') {
      header('Location: edit.php?do=new-posts');
      exit;
    }
?>
    <h1>Posts&nbsp;<a class="btn btn-outline-primary" href="?do=new-posts">Add New</a></h1>
    <?php if (!empty($IsArticles)) { ?>
      <?php if (isset($_SESSION['message'])) : ?>
        <div id="message">
          <?php echo $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); ?>
      <?php endif; ?>
      <div class="table-responsive">
        <table class="table">
          <tbody>
            <tr class="text-bg-success">
              <td>Title</td>
              <td>Author</td>
              <td>Categories</td>
              <td>Tags</td>
              <td>Date</td>
              <td>Controller</td>
            </tr>
            <?php
            foreach ($IsArticles as $article) {
            ?>
              <tr>
                <td class="<?php if ($article['status_a'] == '0') :
                              echo 'text-success';
                            else :
                              echo 'text-danger';
                            endif; ?>">
                  <?php echo $article['title']; ?>
                </td>
                <td>
                  <?php echo $article['author']; ?>
                </td>
                <td>
                  <?php echo $article['categories']; ?>
                </td>
                <td>
                  <?php echo $article['tags']; ?>
                </td>
                <td>
                  <?php echo $article['created']; ?>
                </td>
                <td class="d-flex">
                  <a class="btn btn-success" href="?do=edit&id=<?php echo $article['id']; ?>">
                    <i class="fas fa-edit"></i>
                  </a>
                  <?php
                  if ($article['status_a'] == 0) {
                  ?>
                    <a class="btn btn-info" href="../index.php?do=reading&slug=<?php echo $article['slug']; ?>" target="_blank">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a class="btn btn-danger" href="?do=action&id=<?php echo $article['id']; ?>&action=trash">
                      <i class=" fas fa-times-circle"></i>
                    </a>
                  <?php
                  } else {
                  ?>
                    <a class="btn btn-danger" href="?do=delete&id=<?php echo $article['id']; ?>">
                      <i class="fas fa-trash"></i>
                    </a>
                    <a class="btn btn-primary" href="?do=action&id=<?php echo $article['id']; ?>&action=publish">
                      <i class=" fas fa-check-square"></i>
                    </a>
                  <?php
                  }
                  ?>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    <?php
    } else {
      echo '<p class="alert alert-info">Add new article</p>';
    }
  } elseif ($do == 'edit') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $stmt = $con->prepare("SELECT * FROM `articles` WHERE `id` = ? LIMIT 1");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
    ?>
      <h1>Edit Article :
        <?php echo $row['title']; ?>
      </h1>
      <div class="row g-3">
        <div class="col-md-4">
          <img class="img-edit" src="../uploads/<?php echo $row['cover']; ?>" alt="<?php echo $row['title']; ?>">
        </div>
        <div class="col-md-8 mx-auto">
          <form class="form-edit text-capitalize" action="?do=update" method="post" autocomplete="off">
            <?php if (isset($_SESSION['message'])) : ?>
              <div id="message">
                <?php echo $_SESSION['message']; ?>
              </div>
              <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
            <input type="hidden" name="id" class="form-control" value="<?php echo $row['id']; ?>">
            <div class="form-group mb-3">
              <label>title</label>
              <input name="title" class="form-control" value="<?php echo $row['title']; ?>" />
            </div>
            <div class="form-group mb-3">
              <label>content</label>
              <textarea class="form-control" name="content" rows="14" required="required"><?php echo $row['content']; ?></textarea>
            </div>
            <div class="form-group mb-3">
              <label>author</label>
              <input name="author" class="form-control" value="<?php echo $row['author']; ?>" />
            </div>
            <div class="form-group mb-3">
              <label>categories</label>
              <input name="categories" class="form-control" value="<?php echo $row['categories']; ?>" />
            </div>
            <div class="form-group mb-3">
              <label>tags</label>
              <input name="tags" class="form-control" value="<?php echo $row['tags']; ?>" />
            </div>
            <div class="d-grid gap-2 mb-3">
              <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i>&nbsp;Save</button>
            </div>
          </form>
        </div>
      </div>
    <?php
    } else {
      header('Location: edit.php');
      exit();
    }
  } elseif ($do == 'new-posts') {
    ?>
    <h1>Add New Post</h1>
    <div class="row g-3">
      <div class="col-md-6 mx-auto">
        <?php if (isset($_SESSION['message'])) : ?>
          <div id="message">
            <?php echo $_SESSION['message']; ?>
          </div>
          <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <form class="form-edit text-capitalize" action="?do=post-true" method="post" autocomplete="off" enctype="multipart/form-data">
          <div class="form-group mb-3">
            <label>title<span class="text-danger">*</span></label>
            <input name="title" class="form-control" required="required" />
          </div>
          <div class="form-group mb-3">
            <label>Content<span class="text-danger">*</span></label>
            <p class="text-muted">Write your article in Markdown format.</p>
            <textarea class="form-control" name="content" rows="14" required="required"></textarea>
          </div>
          <div id="cover" class="input-group">
            <input class="form-control" type="text" readonly>
            <label class="input-group-btn">
              <input type="file" accept=".gif,.jpeg,.jpg,.png" name="cover" id="cover-file" style="display:none;">
              <span class="btn btn-outline-primary"><i class="fas fa-image"></i></span>
            </label>
          </div>
          <div class="form-group mb-3">
            <label>author<span class="text-danger">*</span></label>
            <input name="author" class="form-control" value="<?php echo $_SESSION['username']; ?>" required="required" />
          </div>
          <div class="form-group mb-3">
            <label>categories<span class="text-danger">*</span></label>
            <input name="categories" class="form-control" required="required" />
          </div>
          <div class="form-group mb-3">
            <label>tags</label>
            <input name="tags" class="form-control" />
          </div>
          <div class="d-grid gap-2 mb-3">
            <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i>&nbsp;Save</button>
          </div>
        </form>
      </div>
    </div>
<?php
  } elseif ($do == 'post-true') {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
    $author = filter_var($_POST['author'], FILTER_SANITIZE_STRING);
    $categories = filter_var($_POST['categories'], FILTER_SANITIZE_STRING);
    $tags = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
    $slug = strtolower(str_replace(' ', '-', $title));
    $errors = [];
    if (empty($title)) {
      $errors[] = 'Title field is required.';
    }
    if (empty($content)) {
      $errors[] = 'Content field is required.';
    }
    if (empty($categories)) {
      $errors[] = 'Categories field is required.';
    }
    if (!empty($errors)) {
      foreach ($errors as $error) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
      }
    } else {
      $cover = '';
      if (!empty($_FILES['cover']['name'])) {
        $extension = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
          $errors[] = 'Invalid file type. Only JPG, JPEG, PNG and GIF files are allowed';
        } else {
          $file_name = uniqid('cover_', true) . '.' . $extension;
          if (move_uploaded_file($_FILES['cover']['tmp_name'], '../uploads/' . $file_name)) {
            $cover = $file_name;
          } else {
            $errors[] = 'Failed to upload the image.';
          }
        }
      }
      if (empty($errors)) {
        $checkSlug = $con->prepare("SELECT * FROM articles WHERE slug = ?");
        $checkSlug->execute([$slug]);
        $counter = 1;
        $originalSlug = $slug;
        while ($checkSlug->fetch()) {
          $slug = $originalSlug . '+' . $counter;
          $counter++;
          $checkSlug->execute([$slug]);
        }
        $stmt = $con->prepare('INSERT INTO articles (title, slug, cover, content, author, categories, tags) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$title, $slug, $cover, $content, $author, $categories, $tags]);
        show_message('Article added successfully!', 'success');
        header('Location: edit.php?do=new-posts');
      }
    }
  } elseif ($do == 'update') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $categories = $_POST['categories'];
    $tags = $_POST['tags'];
    $slug = strtolower(str_replace(' ', '-', $title));
    $FormError = array();
    if (empty($title)) {
      $FormError[] = '<div class="alert alert-danger">Title Cant Be <strong>Empty</strong></div>';
    }
    if (empty($content)) {
      $FormError[] = '<div class="alert alert-danger">Content Cant Be <strong>Empty</strong></div>';
    }
    if (empty($categories)) {
      $FormError[] = '<div class="alert alert-danger">Categories Cant Be <strong>Empty</strong></div>';
    }
    foreach ($FormError as $error) {
      echo $error;
    }
    if (empty($FormError)) {
      $stmt = $con->prepare("UPDATE `articles` SET `title`= ?,`slug`= ?,`content`= ?,`author`= ?,`categories`= ?,`tags`= ? WHERE `id`= ?");
      $stmt->execute(array($title, $slug, $content, $author, $categories, $tags, $id));
      if ($stmt->rowCount() > 0) {
        show_message('New record updated successfully', 'success');
        header('Location: edit.php?do=edit&id=' . $id . '');
      } else {
        show_message('Not updated', 'danger');
      }
    } else {
      header('Location: edit.php');
      exit();
    }
  } elseif ($do == 'action') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'publish') {
      $stmt = $con->prepare("UPDATE `articles` SET `status_a` = '0' WHERE `articles`.`id` = ?;");
      $stmt->execute(array($id));
      show_message('The post has already been published.', 'success');
    } elseif ($action == 'trash') {
      $stmt = $con->prepare("UPDATE `articles` SET `status_a` = '1' WHERE `articles`.`id` = ?;");
      $stmt->execute(array($id));
      show_message('The post has already been trashed.', 'success');
    }
    header('Location: edit.php');
    exit();
  } elseif ($do == 'delete') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $stmt = $con->prepare("DELETE FROM articles WHERE `articles`.`id` = ?");
    $stmt->execute(array($id));
    $msg = 'The post has already been deleted.';
    header('Location: edit.php');
    exit();
  }
} else {
  header('Location: index.php');
  exit();
}
include $tpl . 'footer.php';
ob_end_flush(); ?>