<?php 
session_start();
$noNavbar = '';
$pageTitle = 'Homepage';
//print_r($_SESSION);
include 'init.php';
?>

<div class="center">
<div class="title">Welcome to Al-baha Tourism</div>
<div class="sub_title">Please choose the appropriate browsing button for you</div>
<div class="btns">
  <button><a href="welcome.php">Home</a></button>
  <button><a href="profile.php">profile</a></button>
</div>
</div>
<style>

 a{
    text-decoration: none;
    color: #fff;
 }
.center{
  position: absolute;
  top: 52%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
  padding: 0 20px;
  text-align: center;
}
.center .title{
  color: black;
  font-size: 45px;
  font-weight: 600;
}
.center .sub_title{
  color:#1f68a4;
  font-size: 30px;
  font-weight: 400;
}
.center .btns{
  margin-top: 20px;
}
.center .btns button{
  height: 55px;
  width: 170px;
  border-radius: 5px;
  border: none;
  margin: 0 10px;
  border: 2px solid #1f68a4;
  font-size: 20px;
  font-weight: 500;
  padding: 0 10px;
  cursor: pointer;
 
  color: #1f68a4;
  background: #1f68a4;
}


</style>
<?php
include $tpl . 'footer.php';

?>