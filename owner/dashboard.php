<?php
session_start();
$pageTitle = 'Dashboard';
include "init.php";
$do = isset($_GET['do']) ? $_GET['do'] : 'dashboard';
$IsUser = getLatest("*", "admin", "id");
$IsRoles = getLatest("*", "roles", "id");
if (isset($_SESSION['role']) && $_SESSION['role'] == 'author') {
  header('Location: edit.php?do=new-posts');
  exit;
}
if (isset($_SESSION['username'])) {
  if ($do == 'dashboard') {
?>
    <h1 class="text-md-center my-1 text-capitalize">Welcome
      <?php echo $_SESSION['username'] ?> to dashboard
    </h1>
    <div class="row g-3">
      <div class="col-md-3">
        <div class="card text-bg-primary">
          <div class="card-header"><i class="fas fa-users"></i>&nbsp;Admins</div>
          <div class="card-body">
            <?php echo countItems('id', 'admin') ?>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-bg-success">
          <div class="card-header"><i class="fas fa-file-text"></i>&nbsp;Articles</div>
          <div class="card-body">
            <?php echo countItems('id', 'articles') ?>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-bg-info">
          <div class="card-header"><i class="fas fa-comments"></i>&nbsp;Comments</div>
          <div class="card-body">
            <?php echo countItems('id', 'comments') ?>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-bg-light">
          <div class="card-header"><i class="fas fa-envelope"></i>&nbsp;Messages</div>
          <div class="card-body">
            <?php echo countItems('id', 'contacts') ?>
          </div>
        </div>
      </div>



    </div>
  <?php
  } elseif ($do == 'users') {
  ?>
    <h1>Users&nbsp;<a class="btn btn-outline-primary" href="?do=new-user">Add New</a></h1>
    <div class="table-responsive">
      <?php if (isset($_SESSION['message'])): ?>
        <div id="message">
          <?php echo $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); ?>
      <?php endif; ?>
      <table class="table">
        <tbody>
          <tr class="text-bg-primary">
            <td>Username</td>
            <td>Name</td>
            <td>Email</td>
            <td>Role</td>
            <td>Controller</td>
          </tr>
          <?php
          if (!empty($IsUser)) {
            foreach ($IsUser as $user) {
          ?>
              <tr>
                <td>
                  <?php echo $user['username']; ?>
                </td>
                <td>
                  <?php echo $user['name']; ?>
                </td>
                <td>
                  <?php echo $user['email']; ?>
                </td>
                <td>
                  <?php echo $user['role']; ?>
                </td>
                <td class="d-flex">
                  <a class="btn btn-info" href="?do=author&id=<?php echo $user['id']; ?>">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a class="btn btn-danger" href="?do=users-delete&id=<?php echo $user['id']; ?>">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
          <?php
            }
          } else {
            echo '<p>Add new user</p>';
          }
          ?>
        </tbody>
      </table>
    </div>
  <?php
  } elseif ($do == 'new-user') {
  ?>
    <h1>Add New User</h1>
    <div class="row g-3">
      <div class="col-md-5 mx-auto">
        <?php if (isset($_SESSION['message'])): ?>
          <div id="message">
            <?php echo $_SESSION['message']; ?>
          </div>
          <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <form class="form-edit text-capitalize" action="?do=user-true" method="post" autocomplete="off"
          enctype="multipart/form-data">
          <div class="form-group mb-3">
            <label>Full Name</label>
            <input name="name" class="form-control" />
          </div>
          <div class="form-group mb-3">
            <label>Username<span class="text-danger">*</span></label>
            <input name="username" class="form-control" required="required" />
          </div>
          <div class="form-group mb-3">
            <label>Email<span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" required="required" />
          </div>
          <div class="form-group mb-3">
            <label>Password<span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" required="required" />
          </div>
          <div class="form-group mb-3">
            <select class="form-select text-capitalize" name="role" required="required">
              <option selected>roles</option>
              <?php
              if (!empty($IsRoles)) {
                foreach ($IsRoles as $role) {
                  echo '<option value="' . $role['role'] . '">' . $role['role'] . '</option>';
                }
              } else {
                echo '<option value="...">...</option>';
              }
              ?>
            </select>
          </div>
          <div class="d-grid gap-2 mb-3">
            <button class="btn btn-primary" type="submit"><i class="fas fa-user-plus"></i>&nbsp;Add New User</button>
          </div>
        </form>
      </div>
    </div>
    <?php
  } elseif ($do == 'users-delete') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $stmt = $con->prepare("DELETE FROM `admin` WHERE `admin`.`id` = ?");
    $stmt->execute(array($id));
    show_message('The user has already been deleted.', 'danger');
    header('Location: dashboard.php?do=users');
    exit();
  } elseif ($do == 'user-true') {
    $name = cleanInput($_POST['name']);
    $username = cleanInput($_POST['username']);
    $email = cleanInput($_POST['email']);
    $role = cleanInput($_POST['role']);
    $password = cleanInput($_POST['password']);
    $hashedPass = sha1($password);
    $FormError = array();
    if (empty($name)) {
      $FormError[] = '<div class="alert alert-danger">Full Name Cant Be <strong>Empty</strong></div>';
    }
    $checkUsername = $con->prepare("SELECT * FROM `admin` WHERE `username` = ?");
    $checkUsername->execute(array($username));
    if ($checkUsername->rowCount() > 0) {
      $FormError[] = '<div class="alert alert-danger">Username is already in use, please choose another one</div>';
    }
    if (strlen($username) < 4) {
      $FormError[] = '<div class="alert alert-danger">Username Cant Be Less than <strong>4 characters</strong></div>';
    }
    if (strlen($username) > 20) {
      $FormError[] = '<div class="alert alert-danger">Username Cant Be Less than <strong>20 characters</strong></div>';
    }
    if (empty($email)) {
      $FormError[] = '<div class="alert alert-danger">Email Cant Be <strong>Empty</strong></div>';
    }
    if (empty($FormError)) {
      $stmt = $con->prepare("INSERT INTO `admin`(`name`, `username`, `email`, `password`, `role`) VALUES (?,?,?,?,?)");
      $stmt->execute(array($name, $username, $email, $hashedPass, $role));
      show_message('Record Inserted', 'success');
      header('Location: dashboard.php?do=new-user');
      exit();
    } else {
      $_SESSION['message'] = implode('', $FormError);
      header('Location: dashboard.php?do=new-user');
      exit();
    }
  } elseif ($do == 'author') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $stmt = $con->prepare("SELECT * FROM `admin` WHERE `id` = ? LIMIT 1");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
    ?>
      <h1 class=" text-capitalize">Author Description</h1>
      <hr />
      <div class="row g-3">
        <div class="col-md-6">
          <ul class="text-capitalize">
            <li>
              <span class="fw-bold">Username :</span>
              <?php echo $row['username']; ?>
            </li>
            <li>
              <span class="fw-bold">Full name :</span>
              <?php echo $row['name']; ?>
            </li>
            <li>
              <span class="fw-bold">E-mail :</span>
              <?php echo $row['email']; ?>
            </li>
            <li>
              <span class="fw-bold">Role :</span>
              <?php echo $row['role']; ?>
            </li>
            <li>
              <span class="fw-bold">Bio :</span>
              <?php echo $row['biographical']; ?>
            </li>
          </ul>
        </div>
        <div class="col-md-2 ms-auto">
          <a href="<?php echo $row['fb']; ?>" target="_blank"><i class="fab fa-facebook-square fa-2xl"></i></a>
          <a href="<?php echo $row['twt']; ?>" target="_blank"><i class="fab fa-twitter-square fa-2xl"></i></a>
          <a href="<?php echo $row['in']; ?>" target="_blank"><i class="fab fa-linkedin fa-2xl"></i></a>
        </div>
      </div>
<?php
    } else {
      header('Location: dashboard.php?do=users');
      exit();
    }
  }
} else {
  header('Location: index.php');
  exit();
}
include $tpl . 'footer.php'; ?>
