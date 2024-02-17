<?php 
session_start();
$pageTitle = 'show village';
//print_r($_SESSION);
include 'init.php';

// check if get requst villageid is numeric & get the integer value of it
$villageid = isset($_GET['villageid']) && is_numeric($_GET['villageid']) ? intval($_GET ['villageid']) : 0;
                    
                    
//select all data depend on this id 
        $stmt = $con->prepare("SELECT village.*,
        area.Name AS area_name, 
        users.Username
        FROM village
        INNER JOIN area ON area.ID = village.Area_ID
        INNER JOIN users ON users.UserID = village.Member_ID 
        WHERE Village_ID = ?
        "); 
        
// execute query
$stmt->execute(array($villageid));

$count=$stmt->rowCount();
if($count >0){
    

//fetch the data ==> get the data       
$village = $stmt->fetch();
?>
<h1 class="text-center"><?php echo $village['Name']; ?> </h1>






<div class="latest">
   <div class="containers">
       <div class="row"> 
       <div class="col-md-3"> 
                <div class="panel panel-default">
              
                <br>
                <div class="panel-body" style="font-size:15px;">
                <div class="panel-heading col-sm-8"><img src="shada.jpg" alt="" /></div>

                    <ul class="list-unstyled">
                       
                <li> 
                    <span>Name: </span><?php echo $village['Name'] ?>
                </li> 
                <li> 
                    <span>Add Village Date: </span> :<?php echo $village['Add_Date'] ?>
                </li> 
                    <li><span> Area :</span> <a href="area.php?pageid=<?php echo $village['Area_ID']?>"><?php echo $village['area_name'] ?></a> 
                </li> 
                <li><span> Add by :</span><?php echo $village['Username'] ?></a> 
                </li>   
                    </ul>
                   
               </div>
            </div>
          </div> 
          <div class="col-md-3"> 
                <div class="panel panel-default">
              
                <br>
                <div class="panel-body" style="font-size:15px;">

                    <p><span>Description: </span><?php echo $village['Description'] ?></p>
                   
               </div>
            </div>
          </div>
      
        </div>
        <hr class="custm-hr">
        <!--start comment-->
<?php if(isset($_SESSION['user'])){ ?>
    
        <div class="row">
            <div class="col-md-3">
            <div class="add-comment">
                <h3>Add You Comment</h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] .'?villageid='.$village['Village_ID'] ?>" method="POST">
                    <textarea name="comment" cols="60" rows="5">
                    </textarea>
                    <input type="submit" value="Add Comment" class="btn btn-primary">
                </form>


                <?php


if($_SERVER['REQUEST_METHOD'] == 'POST'){    //GET info comment from the form
    $comment =   $_POST['comment'];
    $villageids =   $village['Village_ID'];
    $userids =   $_SESSION['uid'];
    $formError = array();
    if(!empty($comment)){
   //update the database with this information
   $stmt = $con->prepare("INSERT INTO comments(comment,comment_date,village_id,user_id)
          VALUES(:zcomments, now(), :zvillageis, :zuserid)");
                //any user in database have 1 ==> will be admin
                    $stmt->execute(array(
                        'zcomments'  => $comment,
                        'zvillageis'  => $villageids,
                        'zuserid'  =>  $userids
                        
                        
                    ));
   if($stmt){
    echo '<div class="alert-success">Comment Added</div>';
}
    }

   


    
    
} 
             

                ?>
</div>
            </div>
        </div>
        <?php } else{

            echo '<a href="login.php">Login</a> or <a href="login.php">Register </a> to Add Comment';
        } ?>
        <hr class="custm-hr">
        <div class="row">
        <div class="col-md-9">
           
        <?php
                       $stmt = $con->prepare("SELECT comments.*,users.Username AS Member
                       FROM comments
                       INNER JOIN users
                       ON users.UserID = comments.user_id
                       WHERE village_id = ?
                       ORDER BY c_id DESC ");
                       $stmt->execute(array($village['Village_ID']));
                       // assign to varibale
                       $comments =  $stmt->fetchAll();
                  
                      
                       
                      ?>
  
   <?php 
        foreach($comments as $comment){ ?>
            <div class="wrap">
    <img class="imgs" src="user.png" />
    <div class="comment" data-owner="<?php echo $comment['Member']?>">
        <p><?php echo $comment['comment']?></p>
        <ol class="postscript">
            <li class="date"><?php echo $comment['comment_date'] ?></li>
        </ol>
    </div>
</div>


        <?php   }  ?>
       

       <!--end comment-->

    <br><br>
    </div>


<style>
      
      div.wrap {
      width: 50%;
      margin: 12 auto 2em auto;
      position: relative; /* the image will be absolutely-positioned relative to this */
  }
  
  div.wrap:first-child {
      margin-top: 1em; /* just for aesthetic reasons, adjust or remove, to taste */
  }
  
  div.comment {
      font-size: 1em;
      position: relative; /* the arrow on the left side of the div positioned relative to this element */
      margin-left: 60px; /* allows a 10px gutter for the arrow to fit into */
      border-radius: 0.75em 0.75em 0.75em 0.75em;
      background-color: #ccc;
      line-height: 1.4em;
      font-family: Helvetica; /* or whatever... */
  }
  
  div.comment::before { /* requires a fairly modern browser */
      content: attr(data-owner); /* displays the name of the comment-owner */
      border-radius: 0.75em 0.75em 0 0;
      background-color: #e3e3e3;
      display: block;
      text-indent: 10%; /* adjust to taste */
      border-bottom: 2px solid #e6e6e6;
  }
  
  div.comment::after { /* again, requires a fairly modern browser */
      content: ''; /* this property is necessary, even if only an empty string */
      position: absolute;
      top: 50%;
      left: 0;
      border: 10px solid transparent;
      border-right: 10px solid #ccc; /* forms the 'arrow' */
      margin: -10px 0 0 -20px;
  }
  
  div.comment p { /* or whatever, adjust to taste */
      width: 90%;
      margin: 0 auto 1em auto;
      padding-bottom: 1em;
  }
  
  .imgs {
      position: absolute;
      top: 50%;
      width: 50px;
      float: left;
      border-radius: 10px;
      margin-top: -25px;
  }​
  
  p + ol.postscript {
      width: 80%;
      font-size: 0.8em;
      margin: -0.5em auto 0 auto;
  }
  ol.postscript::after {
      content: '';
      height: 0.5em;
      display: block;
      clear: both;
  }
  ol.postscript li {
      float: left;
      margin-right: 0.5em;
  }
  ol.postscript li.date {
      float: right;
      margin-right: 0;
  }
  
  .wrap a:link,
  .wrap a:visited {
      color: #909090;
      text-decoration: none;
      border-bottom: 1px solid #999999;
  }
  
</style>


<?php
}
else{
    echo '';
}
include $tpl . 'footer.php';

?>