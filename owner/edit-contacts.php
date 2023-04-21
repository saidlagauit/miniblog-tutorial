<?php
session_start();
$pageTitle = 'Dashboard - Comments';
include "init.php";
$do = isset($_GET['do']) ? $_GET['do'] : 'manage';
$IsContacts = getLatest("*", "contacts", "id");
if ($_SESSION['role'] == 'author') {
  header('Location: edit.php?do=new-posts');
  exit;
}
if ($_SESSION['username']) {
  if ($do == 'manage') {
    if (!empty($IsContacts)) {
      ?>
      <h1>Messages</h1>
      <div class="table-responsive">
        <?php if (isset($_SESSION['message'])): ?>
          <div id="message">
            <?php echo $_SESSION['message']; ?>
          </div>
          <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <table class="table">
          <tbody>
            <tr class="text-bg-light">
              <td>Name</td>
              <td>Subject</td>
              <td>Date</td>
              <td>Controller</td>
            </tr>
            <?php
            foreach ($IsContacts as $contact) {
              ?>
              <tr>
                <td>
                  <?php echo $contact['name']; ?>
                </td>
                <td>
                  <?php echo $contact['subject']; ?>
                </td>
                <td>
                  <?php echo $contact['created_c']; ?>
                </td>
                <td class="d-flex">
                  <a class="btn btn-danger" href="?do=delete&id=<?php echo $contact['id']; ?>">
                    <i class="fas fa-trash"></i>
                  </a>
                  <a class="btn btn-info" href="?do=eye-message&id=<?php echo $contact['id']; ?>">
                    <i class="fas fa-eye"></i>
                  </a>
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
      echo '<p class="mt-1 alert alert-success">There are no message currently</p>';
    }
  } elseif ($do == 'eye-message') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $stmt = $con->prepare("SELECT * FROM `contacts` WHERE `id` = ? LIMIT 1");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
      ?>
      <h1 class=" text-capitalize">
        <?php echo $row['name']; ?> -
        <?php echo $row['created_c']; ?>
      </h1>
      <hr />
      <div class="row g-3">
        <div class="col-md-6 mx-auto">
          <p class="m-0">
            <span class="fw-bold">E-mail :</span>
            <?php echo $row['email']; ?>
          </p>
          <p>
            <span class="fw-bold">Subject :</span>
            <?php echo $row['subject']; ?>
          </p>
          <hr />
          <p>
            <span class="fw-bold">Message :</span>
            <?php echo $row['message']; ?>
          </p>
        </div>
      </div>
      <?php
    } else {
      header('Location: edit-contacts.php');
      exit();
    }
  } elseif ($do == 'delete') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $stmt = $con->prepare("DELETE FROM contacts WHERE `contacts`.`id` = ?");
    $stmt->execute(array($id));
    show_message('The message has already been deleted.', 'success');
    header('Location: edit-contacts.php');
    exit();
  }
} else {
  header('Location: index.php');
  exit();
}
include $tpl . 'footer.php'; ?>