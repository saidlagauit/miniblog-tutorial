<?php
session_start();
$pageTitle = 'Dashboard - Comments';
include "init.php";
$do = isset($_GET['do']) ? $_GET['do'] : 'manage';
$IsComments = getLatest("*", "comments", "id");
if ($_SESSION['role'] == 'author') {
  header('Location: edit.php?do=new-posts');
  exit;
}
if ($_SESSION['username']) {
  if ($do == 'manage') {
    if (!empty($IsComments)) {
      ?>
      <h1>Comments</h1>
      <div class="table-responsive">
        <?php if (isset($_SESSION['message'])): ?>
          <div id="message">
            <?php echo $_SESSION['message']; ?>
          </div>
          <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <table class="table">
          <tbody>
            <tr class="text-bg-info">
              <td>Author</td>
              <td>Comment</td>
              <td>Date</td>
              <td>Controller</td>
            </tr>
            <?php
            foreach ($IsComments as $comment) {
              ?>
              <tr>
                <td>
                  <?php echo $comment['name']; ?>
                </td>
                <td>
                  <?php echo $comment['comment']; ?>
                </td>
                <td>
                  <?php echo $comment['date_c']; ?>
                </td>
                <td class="d-flex">
                  <a class="btn btn-danger" href="?do=delete&id=<?php echo $comment['id']; ?>">
                    <i class="fas fa-trash"></i>
                  </a>
                  <?php
                  if ($comment['approved'] == 1) {
                    ?>
                    <a class="btn btn-info" href="../index.php?do=reading&id=<?php echo $comment['articlesid']; ?>"
                      target="_blank">
                      <i class="fas fa-eye"></i>
                    </a>
                    <?php
                  } else {
                    ?>
                    <a class="btn btn-success" href="?do=approved&id=<?php echo $comment['id']; ?>">
                      <i class="fas fa-check-circle"></i>
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
      echo '<p class="mt-1 alert alert-success">There are no comments currently</p>';
    }
  } elseif ($do == 'approved') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $stmt = $con->prepare("UPDATE `comments` SET `approved` = '1' WHERE `comments`.`id` = ?");
    $stmt->execute(array($id));
    show_message('The comments has already been approved.', 'success');
    header('Location: edit-comments.php');
    exit();
  } elseif ($do == 'delete') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $stmt = $con->prepare("DELETE FROM comments WHERE `comments`.`id` = ?");
    $stmt->execute(array($id));
    $msg = '';
    show_message('The comments has already been deleted.', 'success');
    header('Location: edit-comments.php');
    exit();
  }
} else {
  header('Location: index.php');
  exit();
}
include $tpl . 'footer.php'; ?>