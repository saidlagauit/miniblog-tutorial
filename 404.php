<?php
session_start();
include 'init.php';
?>
<div class="mt-5">
  <div class="row">
    <div class="col-md-6 mx-auto text-md-center">
      <h1 class="mt-5">404 - Page Not Found</h1>
      <p>The requested page could not be found.</p>
    </div>
  </div>
</div>
<?php
include $tpl . 'footer.php'; ?>