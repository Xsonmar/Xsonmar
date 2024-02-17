<?php 
    session_start();
 
    if (isset($_SESSION['Username'])){
        $pageTitle = 'Dashboard';
        
    include 'init.php';
    /*start Dashboard page */
    $numusers = 10; // number of latest users 10
    $latestUsers = getLatest("*","users","UserID",$numusers); // the latest user array 
    $numvillage = 10; // number of latest village 10
    $latestvillage = getLatest("*","village","Village_ID",$numvillage); // the latest village array 

      
      ?>

        <div class="containers home-stats">
            <h1 style="text-align: center;">Dshboard</h1>
            <div style="text-align: center; " class="row" >
                <div class="col-md-3">
                <div class="stat st-members"> Total Members 
                    <span><a href="members.php"><?php echo countVillag('UserID','users'); ?></a> </span> </div>
                </div> 
               
                <div class="col-md-3">
                <div class="stat st-pending"> Total village
                    <span><a href="village.php"><?php echo countVillag('Village_ID','village'); ?></a> </span> </div>
            </div>
      
                <div class="col-md-3">
                <div class="stat st-area"> Total Areas 
                    <span><a href="area.php"><?php echo countVillag('ID','area'); ?></a> </span> 
                  </div>
                </div> 
                <div class="col-md-3">
                <div class="stat st-comment"> Total Comments 
                    <span><a href="comment.php"><?php echo countVillag('c_id','comments'); ?></a> </span> 
                    </div>
                </div> 
            </div>
        </div>
<br>
<br>


<div class="latest">
   <div class="containers">
       <div class="row"> 
       <div class="col-sm-6"> 
                <div class="panel panel-default">
                   
                   <div class="panel-heading" style="font-size:17px; font-weight:bold;">
                <i class="fa fa-users"></i>&nbsp; Latest <?php echo $numusers; ?> Registerd user
                </div>
                <br>
                <div class="panel-body" style="font-size:15px;">
                    <ul class="list-unstyled latest-users">
                       <?php 
                       
                     foreach ($latestUsers as $user){
                        echo ' <li> ' ;
                          echo $user['Username'];
                           echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . ' ">';
                            echo '<span class="btn btn-success pull-right"> ';
                                echo '<i class="fa fa-edit"> </i> Edit ';
                                if($user['RegStatus'] == 0){
                                    echo " <a href='members.php?do=Activate&userid=". $user['UserID'] ."' class='btn btn-info pull-right' style='height: auto;
                                     width: auto;'> <i class= 'fa fa-close'> </i> Activate </a> ";
                                  }             
                            echo ' </span> ';
                           echo ' </a> ';
                        echo ' </li> ' ;
                     }
                    ?>  
                    </ul>
                   
               </div>
            </div>
          </div> 
          <!--start--> 
          <div class="col-sm-6"> 
                <div class="panel panel-default">
                   <div class="panel-heading" style="font-size:17px; font-weight:bold;">
                <i class="fa fa-comments"></i>&nbsp; Latest Comments
                </div>
                <br>
                <div class="panel-body" style="font-size:15px;">
                    <ul class="list-unstyled latest-users">
                      <?php
                       $stmt = $con->prepare("SELECT comments.*,users.Username AS Member
                       FROM comments
                       INNER JOIN users
                       ON users.UserID = comments.user_id");
                       $stmt->execute();
                       // assign to varibale
                       $comments =  $stmt->fetchAll();
                       foreach($comments as $comment){
                        echo '<div class="comment-box">';
                           echo '<span class="member-n">'.$comment['Member'].'</span>';
                           echo '<p class="member-c">'.$comment['comment'].'</p>';

                        echo '</div>';
                       }
                      ?>
                    </ul>
                   
               </div>
            </div>
          </div>  
          <!--end-->

          <div class="col-sm-6"> 
                <div class="panel panel-default">
                   <div class="panel-heading" style="font-size:17px; font-weight:bold;">
                   <i class="fa fa-city"></i>&nbsp; Latest <?php echo $numvillage; ?> Village
                </div>
                <br>
                <div class="panel-body" style="font-size:15px;">
                <ul class="list-unstyled latest-users">
                       <?php 
                       
                     foreach ($latestvillage as $village){
                        echo ' <li> ' ;
                          echo $village['Name'];
                           echo '<a href="members.php?do=Edit&villageid=' . $village['Village_ID'] . ' ">';
                            echo '<span class="btn btn-success pull-right"> ';
                                echo '<i class="fa fa-edit"> </i> Edit ';
                                         
                            echo ' </span> ';
                           echo ' </a> ';
                        echo ' </li> ' ;
                     }
                    ?>  
                    </ul>
               </div>
            </div>
          </div>  
        </div>
      </div>    
  </div>

      



<?php
        //end dashbors page
    
 
    include $tpl . 'footer.php';
    }
    else{
        header('Location: index.php');
        exit();
    }