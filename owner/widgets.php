<?php
session_start();
$pageTitle = 'Dashboard - Widgets';
include "init.php";
$do = isset($_GET['do']) ? $_GET['do'] : 'widgets';

$IsWidgets = getLatest("*", "me", "id", 1);
$IsWidgetsAbout = getLatest("*", "about", "id", 1);

if (isset($_SESSION['role']) && $_SESSION['role'] == 'author') {
  header('Location: edit.php?do=new-posts');
  exit;
}

if (isset($_SESSION['username'])) {
  if ($do == 'widgets') {
    if (!empty($IsWidgets)) {
      foreach ($IsWidgets as $widgets) {
        ?>
        <h1>Widgets Header</h1>
        <a class="btn bt-clean btn-danger" href="widgets.php?do=trash&id=<?php echo $widgets['id']; ?>">
          <i class="fas fa-trash"></i>&nbsp;Clear Widgets
        </a>
        <a class="btn btn-info" href="widgets.php?do=widgets-about">
          <i class="fas fa-eye"></i>&nbsp;View Widgets About
        </a>
        <hr />
        <div class="row">
          <div class="col-md-6 mx-auto">
            <img class="img-widgets" src="../uploads/<?php echo $widgets['pic']; ?>" alt="<?php echo $widgets['name']; ?>">
            <p class="m-0">
              <span class="fw-bold">Full Name :</span>
              <?php echo $widgets['name']; ?>
            </p>
            <p>
              <span class="fw-bold">biographical :</span>
              <?php echo $widgets['bio']; ?>
            </p>
          </div>
        </div>
        <?php
      }
    } else {
      ?>
      <h1>Create Widgets</h1>
      <hr />
      <div class="row">
        <div class="col-md-6 mx-auto">
          <?php if (isset($_SESSION['message'])): ?>
            <div id="message">
              <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
          <?php endif; ?>
          <form action="?do=add-true" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="form-group">
              <label for="product_name">Full Name</label>
              <input type="text" class="form-control" name="name" required="required">
            </div>
            <div class="form-group">
              <label for="product_description">Bio</label>
              <textarea class="form-control" name="bio" rows="3" required="required"></textarea>
            </div>
            <div class="form-group">
              <label for="pic">Image Upload</label>
              <input type="file" class="form-control" name="pic" required="required">
            </div>
            <div class="form-group mt-3">
              <button type="submit" class="btn btn-primary">Add Widgets</button>
            </div>
          </form>
        </div>
      </div>
      <?php
    }
  } elseif ($do == 'widgets-about') {
    if (!empty($IsWidgetsAbout)) {
      foreach ($IsWidgetsAbout as $about) {
        ?>
        <h1>Widgets About</h1>
        <a class="btn bt-clean btn-danger" href="widgets.php?do=trash-about&id=<?php echo $about['id']; ?>">
          <i class="fas fa-trash"></i>&nbsp;Clear Widgets
        </a>
        <a class="btn btn-info" href="widgets.php?do=widgets">
          <i class="fas fa-eye"></i>&nbsp;View Widgets Header
        </a>
        <hr />
        <div class="row">
          <div class="col-md-6 mx-auto">
            <img class="img-widgets" src="../uploads/<?php echo $about['image']; ?>" alt="">
            <p>
              <span class="fw-bold">biographical :</span>
              <?php echo $about['bio_a']; ?>
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
        </div>
        <?php
      }
    } else {
      ?>
      <h1>Create Widgets</h1>
      <hr />
      <div class="row">
        <div class="col-md-6 mx-auto">
          <?php if (isset($_SESSION['message'])): ?>
            <div id="message">
              <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
          <?php endif; ?>
          <form action="?do=add-about-true" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="form-group">
              <label for="image">Image Upload</label>
              <input type="file" class="form-control" name="image" required="required">
            </div>
            <div class="form-group">
              <label for="bio_a">Bio</label>
              <textarea class="form-control" name="bio_a" rows="3" required="required"></textarea>
            </div>
            <div class="input-group my-3">
              <button class="btn btn-primary"><i class="fab fa-facebook-square"></i></button>
              <input name="fb" class="form-control" required="required" />
            </div>
            <div class="input-group mb-3">
              <button class="btn btn-primary"><i class="fab fa-instagram-square"></i></button>
              <input name="insta" class="form-control" required="required" />
            </div>
            <div class="input-group mb-3">
              <button class="btn btn-primary"><i class="fab fa-twitter-square"></i></button>
              <input name="twt" class="form-control" required="required" />
            </div>
            <div class="form-group mt-3">
              <button type="submit" class="btn btn-primary">Add Widgets</button>
            </div>
          </form>
        </div>
      </div>
      <?php
    }
  } elseif ($do == 'trash-about') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $stmt = $con->prepare("DELETE FROM about WHERE `about`.`id` = ?");
    $stmt->execute(array($id));
    header('Location: widgets.php?do=widgets-about');
    exit();
  } elseif ($do == 'trash') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $stmt = $con->prepare("DELETE FROM me WHERE `me`.`id` = ?");
    $stmt->execute(array($id));
    header('Location: widgets.php');
    exit();
  } elseif ($do == 'add-about-true') {
    $bio_a = $_POST['bio_a'];
    $fb = $_POST['fb'];
    $insta = $_POST['insta'];
    $twt = $_POST['twt'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
      $file_name = $_FILES['image']['name'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
      $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
      if (in_array($file_ext, $allowed_exts, )) {
        $upload_dir = '../uploads/';
        $new_file_name = uniqid('about_', true) . '.' . $file_ext;
        if (move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
          $stmt = $con->prepare("INSERT INTO `about`(`image`, `bio_a`, `fb`, `insta`, `twt`) VALUES (?,?,?,?,?)");
          $stmt->execute(array($new_file_name, $bio_a, $fb, $insta, $twt));
          header('Location: widgets.php?do=widgets-about');
          exit();
        } else {
          show_message('Failed to upload the image', 'danger');
        }
      } else {
        show_message('Invalid file type. Only JPG, JPEG, PNG and GIF files are allowed', 'danger');
      }
    } else {
      show_message('No image was uploaded', 'danger');
    }
  } elseif ($do == 'add-true') {
    $name = $_POST['name'];
    $bio = $_POST['bio'];
    if (isset($_FILES['pic']) && $_FILES['pic']['error'] == 0) {
      $file_name = $_FILES['pic']['name'];
      $file_tmp = $_FILES['pic']['tmp_name'];
      $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
      $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
      if (in_array($file_ext, $allowed_exts, )) {
        $upload_dir = '../uploads/';
        $new_file_name = uniqid('pic_', true) . '.' . $file_ext;
        if (move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
          $stmt = $con->prepare("INSERT INTO `me`(`name`, `bio`, `pic`) VALUES (?,?,?)");
          $stmt->execute(array($name, $bio, $new_file_name));
          header('Location: widgets.php');
          exit();
        } else {
          show_message('Failed to upload the image', 'danger');
        }
      } else {
        show_message('Invalid file type. Only JPG, JPEG, PNG and GIF files are allowed', 'danger');
      }
    } else {
      show_message('No image was uploaded', 'danger');
    }
  }
} else {
  header('Location: index.php');
  exit();
}
include $tpl . 'footer.php'; ?>