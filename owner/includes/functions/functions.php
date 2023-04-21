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

function countItems($name, $table)
{
  global $con;
  $stmt = $con->prepare("SELECT COUNT(`$name`) FROM `$table`");
  $stmt->execute();
  return $stmt->fetchColumn();
}

function getLatest($select, $table, $order, $limit = 13)
{
  global $con;
  $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
  $getStmt->execute();
  $rows = $getStmt->fetchAll();
  return $rows;
}

function show_message($message, $type = 'success')
{
  if ($type == 'success') {
    $_SESSION['message'] = '<div class="alert alert-success">' . $message . '</div>';
  } else {
    $_SESSION['message'] = '<div class="alert alert-danger">' . $message . '</div>';
  }
}