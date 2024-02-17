<?php 
session_start();
$pageTitle = 'Profile';
//print_r($_SESSION);
include 'init.php';
if(isset($_SESSION['user'])){
$getUser = $con->prepare("SELECT * FROM users WHERE Username = ? ");
$getUser->execute(array($sessionUser));
$info = $getUser->fetch();
?>
<h1 class="text-center">My Profile</h1>
<div class="latest">
   <div class="containers">
       <div class="row"> 
       <div class="col-sm-6"> 
                <div class="panel panel-default"> 
                   <div class="panel-heading" style="font-size:17px; font-weight:bold;">
                <div class="panel-heading"><i class="fa fa-users"></i> &nbsp;My information</div>
                </div>
                <br>
                <div class="panel-body" style="font-size:15px;">
                <ul class="list-unstyled">    
                <li> <i class="fa fa-unlock-alt fa-fw"></i>
                    <span>Name: </span> : <?php echo $info['Username']; ?>
                </li> 
                <li> <i class="fa fa-envelope-o fa-fw"></i>
                    <span>email: </span> :  <?php echo $info['Email']; ?>
                </li> 
                <li> <i class="fa fa-calendar fa-fw"></i>
                    <span>Register Date: </span> : <?php echo $info['Date']; ?>
                </li>   
                </ul>
               
                   
               </div>
            </div>
          </div> 
          <!--start--> 
          <div class="col-sm-6"> 
                <div class="panel panel-default">
                <div class="panel-heading" style="font-size:17px; font-weight:bold;">
                <div class="panel-heading"><i class="fa fa-comments"></i> &nbsp;My comments</div>
                </div>
                
                <br>
                <div class="panel-body" style="font-size:17px; font-weight:bold; color:#00ccff;">
                <?php 
            $stmt = $con->prepare("SELECT comment FROM comments WHERE user_id=?");

            $stmt->execute(array($info['UserID']));
            // assign to varibale
            $comments =  $stmt->fetchAll();

            if(!empty($comments)){

                foreach($comments as $comment){
                    echo '<p>'.$comment['comment'].'</p>';
                }

            }
            else{
                echo 'there is no comment to show';
            }
            
                    ?>
                   
               </div>
            </div>
          </div>  
          
        </div>
      </div>    
  </div>

<?php
}
else{
    header('Location:login.php');
    exit();
}
include $tpl . 'footer.php';

?>