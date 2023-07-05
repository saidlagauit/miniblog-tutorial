<?php
function getTitle()
{
  global $pageTitle;
  if (isset($pageTitle)) {
    echo $pageTitle;
  } else {
    echo 'Default';
  }
}
function cleanInput($input)
{
  $search = array(
    '@<script[^>]*?>.*?</script>@si',
    '@<[\/\!]*?[^<>]*?>@si',
    '@<style[^>]*?>.*?</style>@siU',
    '@<![\s\S]*?--[ \t\n\r]*>@'
  );
  $output = preg_replace($search, '', $input);
  $output = trim($output);
  $output = stripslashes($output);
  $output = htmlspecialchars($output);
  return $output;
}

function show_message($message, $type = 'success')
{
  if ($type == 'success') {
    $_SESSION['message'] = '<div class="alert alert-success">' . $message . '</div>';
  } else {
    $_SESSION['message'] = '<div class="alert alert-danger">' . $message . '</div>';
  }
}
