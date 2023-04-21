<?php
include "connect.php";
// Routes
$tpl = 'includes/templates/'; // templates directory
$lang = 'includes/languages/'; // language directory
$func = 'includes/functions/'; // functions directory
$func = 'includes/functions/'; // functions directory
$css = 'layout/css/'; // Css directory
$js = 'layout/js/'; //  Js directory 
$imgs = 'layout/images/'; //  Images directory 
// Include The Important Files
include $func . "functions.php";
include $lang . "English.php";
include $tpl . "header.php";
include 'Parsedown.php';
// Navbar On All Pages Expect The One with $noNavbar variable
if (!isset($noNavbar)) {
  include $tpl . "navbar.php";
} ?>