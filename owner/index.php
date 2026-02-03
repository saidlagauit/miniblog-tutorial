<?php
session_start();
$noNavbar = '';
$pageTitle = 'Login';
include "init.php";
if (isset($_SESSION['username'])) {
  header('Location: dashboard.php');
  exit();
} else {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = cleanInput($_POST['username']);
    $password = cleanInput($_POST['password']);
    $hashedPass = sha1($password);
    $stmt = $con->prepare("SELECT `id`, `username`, `password`, `role` FROM `admin` WHERE `username` = ? AND `password`= ?");
    $stmt->execute(array($username, $hashedPass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
      $_SESSION['username'] = $username;
      $_SESSION['id'] = $row['id'];
      $_SESSION['role'] = $row['role'];
      header('Location: dashboard.php');
      exit();
    } else {
      $error = '<div class="alert alert-danger">Invalid username or password</div>';
    }
  }
?>
  <div class="login">
    <form class="form-login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" autocomplete="off">
      <h1 class="text-md-center">Sign in</h1>
      <?php if (isset($error)) {
        echo $error;
      } ?>
      <div class="form-floating mb-3">
        <input name="username" type="text" class="form-control">
        <label>username</label>
      </div>
      <div class="form-floating mb-3">
        <input name="password" type="password" class="form-control">
        <label>Password</label>
      </div>
      <div class="d-grid gap-2 mb-3">
        <button class="btn btn-primary" type="submit"><i class="fas fa-sign-in-alt"></i> sign in</button>
      </div>
    </form>
  </div>
<?php
}
include $tpl . 'footer.php'; ?>
