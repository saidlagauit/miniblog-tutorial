<?php
session_start();
$pageTitle = 'Contact';
include 'init.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["subject"]) && !empty($_POST["message"])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $stmt = $con->prepare("INSERT INTO `contacts`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)");
    $stmt->execute(array($name, $email, $subject, $message));
    if ($stmt->rowCount() > 0) {
      show_message('Your message has been sent and will be answered soon', 'success');
      header('location: contact.php');
      exit();
    } else {
      show_message('An error occurred while sending your message. Please try again later', 'danger');
    }
  } else {
    show_message('Please fill in all fields.', 'danger');
  }
}
?>
<div class="head-top text-md-center">
  <h1>Get in Touch</h1>
  <p>Send me a message, and I'll get back to you as soon as I can.</p>
</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">
  <?php if (isset($_SESSION['message'])) : ?>
    <div id="message">
      <?php echo $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
  <?php endif; ?>
  <div class="row g-3">
    <div class="col-md-6">
      <img src="<?php echo $imgs ?>collaboration.webp" class="img-contact" width="100%" alt="image" />
    </div>
    <div class="col-md-6">
      <div class="form-floating mb-3">
        <input type="text" class="form-control" name="name" id="name" required="required" />
        <label for="name">Full Name *</label>
      </div>
      <div class="form-floating mb-3">
        <input type="email" class="form-control" name="email" id="email" required="required" />
        <label for="email">Email Address *</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" name="subject" id="subject" required="required" />
        <label for="subject">Subject *</label>
      </div>
      <div class="form-floating mb-3">
        <textarea type="text" class="form-control" name="message" id="message" style="height: 9rem;" required="required"></textarea>
        <label for="message">Message *</label>
      </div>
      <div class="d-grid gap-2">
        <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> Send Message</button>
      </div>
      <p class="m-0">* All fields are required.</p>
    </div>
  </div>
</form>
<?php
include $tpl . 'footer.php'; ?>