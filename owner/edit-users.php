<?php
session_start();
$pageTitle = 'Dashboard - Profile';
include "init.php";
$do = isset($_GET['do']) ? $_GET['do'] : 'settings';
$IsContacts = getLatest("*", "contacts", "id");
if ($_SESSION['username']) {
  if ($do == 'settings') {
    $id = $_SESSION['id'];
    $stmt = $con->prepare("SELECT * FROM `admin` WHERE `id` = ? LIMIT 1");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
      ?>
      <h1>Profile</h1>
      <a class="btn bt-del btn-danger" href="edit-users.php?do=user-delete&id=<?php echo $row['id']; ?>">
        <i class="fas fa-trash"></i>&nbsp;Delete Account
      </a>
      <div class="row g-3">
        <div class="col-md-5 mx-auto">
          <?php if (isset($_SESSION['message'])): ?>
            <div id="message">
              <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
          <?php endif; ?>
          <form class="form-edit text-capitalize" action="?do=user-update" method="post" autocomplete="off"
            enctype="multipart/form-data">
            <div class="form-group mb-3">
              <label>Username&nbsp;<sup class="text-danger">Usernames cannot be changed.</sup></label>
              <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
              <input name="username" class="form-control" value="<?php echo $row['username']; ?>" required="required"
                style="pointer-events: none;" />
            </div>
            <hr />
            <div class="form-group mb-3">
              <label>Full Name</label>
              <input name="name" class="form-control" value="<?php echo $row['name']; ?>" />
            </div>
            <div class="form-group mb-3">
              <label>Email<span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>"
                required="required" />
            </div>
            <div class="form-group mb-3">
              <label>biographical</label>
              <textarea class="form-control" name="biographical" rows="3"><?php echo $row['biographical']; ?></textarea>
            </div>
            <hr />
            <div class="input-group mb-3">
              <button class="btn btn-primary"><i class="fab fa-facebook-square"></i></button>
              <input name="fb" class="form-control" value="<?php echo $row['fb']; ?>" />
            </div>
            <div class="input-group mb-3">
              <button class="btn btn-primary"><i class="fab fa-twitter-square"></i></button>
              <input name="twt" class="form-control" value="<?php echo $row['twt']; ?>" />
            </div>
            <div class="input-group mb-3">
              <button class="btn btn-primary"><i class="fab fa-linkedin"></i></button>
              <input name="in" class="form-control" value="<?php echo $row['in']; ?>" />
            </div>
            <hr />
            <div class="form-group mb-3">
              <label>New Password</label>
              <input type="hidden" name="password-old" class="form-control" value="<?php echo $row['password']; ?>" />
              <input type="password" name="password-new" class="form-control"
                placeholder="Leave Blank If You Done Want To Change" />
            </div>
            <div class="d-grid gap-2 mb-3">
              <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i>&nbsp;Update Profile</button>
            </div>
          </form>
        </div>
      </div>
      <?php
    } else {
      header('Location: dashboard.php?do=users');
      exit();
    }
  } elseif ($do == 'user-update') {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $biographical = $_POST['biographical'];
    $email = $_POST['email'];
    $fb = $_POST['fb'];
    $twt = $_POST['twt'];
    $in = $_POST['in'];
    $password = empty($_POST['password-new']) ? $_POST['password-old'] : sha1($_POST['password-new']);
    $formErrors = array();
    if (empty($email)) {
      $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
    }
    foreach ($formErrors as $error) {
      echo '<div class="alert alert-danger">' . $error . '</div>';
    }
    if (empty($formErrors)) {
      $stmt = $con->prepare("UPDATE `admin` SET `name`= ?,`username`= ?,`biographical`= ?,`email`= ?,`fb`= ?,`twt`= ?,`in`= ?,`password`= ? WHERE `id`= ?");
      $stmt->execute(array($name, $username, $biographical, $email, $fb, $twt, $in, $password, $id));
      show_message('The profile has been updated successfully', 'success');
      header('Location: edit-users.php');
      exit();
    }
  } elseif ($do == 'user-delete') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $stmt = $con->prepare("DELETE FROM `admin` WHERE `admin`.`id` = ?");
    $stmt->execute(array($id));
    header('Location: logout.php');
    exit();
  }
} else {
  header('Location: index.php');
  exit();
}
include $tpl . 'footer.php'; ?>