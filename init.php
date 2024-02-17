<?php 
$sessionUser='';
if(isset($_SESSION['user'])){
  $sessionUser = $_SESSION['user'];
}
include 'admin/connect.php';
   //Routes
 $tpl='includes/templates/'; //template مسار
 $lang = 'includes/languages/';//language مسار
 $func = 'includes/functions/';//function مسار
 $css = 'layout/css/';//css مسار
 $css = 'layout/js/';//js مسار
 

 include $func . 'functions.php';

//include 'includes/languages/arabic.php';
  include $lang . 'english.php';
  
 //include the important files
 include $tpl . 'header.php'; 

  //include the important files
