<?php
/*
=============================================================
========Mange Comment Page===============
===== you can Edit | Delete |approve | comments from this page 
=============================================================
*/

      
        session_start();
        $pageTitle='Comment';


        if (isset($_SESSION['Username'])){
           
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        //start Manage page
        if($do == 'Manage'){//Manage members page 
        
          
            //get info from database == select all users except admin
            $stmt = $con->prepare("SELECT comments.*,users.Username AS Member,village.Name AS village_Name
            FROM comments
            INNER JOIN village
            ON village.Village_ID = comments.village_id
            INNER JOIN users
            ON users.UserID = comments.user_id");

            $stmt->execute();
            // assign to varibale
            $rows =  $stmt->fetchAll();
        
        ?>
           <h1 class="text-center">Manage comments</h1> 
           <div class="containers">
            <div class="table-center">
                <table class="main-table text-center table  table-bordered">  <tr>
                     <td>ID</td>
                     <td>comments</td>
                     <td>Village Name</td>
                     <td>User Name</td>
                     <td>Added Date</td>
                     <td>Control</td>
                </tr>
                <?php 
                 foreach($rows as $row){
                    echo "<tr>";
                    echo "<td>" . $row['c_id'] . "</td>";
                     echo "<td>" . $row['comment'] . "</td>";
                     echo "<td>" . $row['village_Name'] . "</td>";
                     echo "<td>" . $row['Member'] . "</td>";
                     echo "<td>" . $row['comment_date'] . "</td>";
                     echo "<td> 
                      <a href='comment.php?do=Edit&comid=". $row['c_id'] ."' class='btn btn-success' style='height: auto;
                     width: auto;' > <i class='fa fa-edit'></i> Edit </a>
                      <a href='comment.php?do=Delete&comid=". $row['c_id'] ."' class='confirm btn btn-danger' style='height: auto;
                     width: auto;'><i class= 'fa fa-close'></i> Delete </a>"; 

                    
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
                <tr>
        
               
            </table>
               
            </div>
            

        </div>
    <?php    
    
        } 
        elseif($do == 'Edit'){   //Edit page
            // check if get requst userud is numeric & get the integer value of it
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET ['comid']) : 0;
            
            
            //select all data depend on this id 
        $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ? "); 
        // execute query
        $stmt->execute(array($comid));
        //fetch the data ==> get the data       
        $row = $stmt->fetch();
        //the row count 
        $count = $stmt->rowCount();
        //if there's such id show the form

        if( $stmt->rowCount()>0) //if there id go to this code-->   
        { ?>  
                    <!--start html-->
                <br><br><br>
                <h1 class="text-center">Edit Comment</h1> <div class="containers">
                    <form class="form-horizontal" action="?do=Update" method="POST"> 
                        <input type="hidden" name="comid" value="<?php echo $comid ?>" />
                    <!-- Start comment Field --> 
                    <div class="form-group"> <label class="col-sm-2 control-label">Comment</label>
                    <div class="col-sm-20"> 
                        <textarea name="comment" cols="30" rows="10"><?php echo $row['comment'] ?></textarea>
                </div> </div> 
                    <!-- End comment Field --> 
                        <!-- Start Submit Field --> 
                        <div class="form-group"> 
                    <div class="col-sm-offset-1 col-sm-10"> <input type="submit" value="Save" class="btn btn-primary" /> 
                </div> </div> 
                    <!-- End Submit Field --> 
        
                </form> </div>
        
            <!--end html-->
            <?php   } else{ //if not id out the page and print this message --> error message

            $TheMsg =  '<div class="alert alert-danger"> there is no such id </div>';
            redirectHome($TheMsg);
            } 

            }
        

         elseif($do == 'Update'){  // update page
            echo "<h1 class='text-center'>Update Comment</h1> ";
            echo "<div class='containers'>";
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //GET variables from the form
                $comid    = $_POST['comid'];
                $comment    = $_POST['comment'];
              
               
               //update the database with this information
               $stmt = $con->prepare("UPDATE comments SET comment=? WHERE  c_id=? ");
               $stmt->execute(array($comment,$comid));
               //this message success
               $TheMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Update ';
                redirectHome($TheMsg,'back');
                 


                
                
            } 
                        else {
                $TheMsg = '<div class="alert alert-danger"> Sorry you cant browse this page directly </div>';
                redirectHome($TheMsg);
            }
            echo "</div>";

        }
        
        elseif ($do == 'Delete'){
                //delete members page
                echo "<h1 class='text-center'>Delete Comment</h1> ";
                echo "<div class='containers'>";
                
                        // check if get requst userud is numeric & get the integer value of it
                        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET ['comid']) : 0;
                            
                            
                        //select all data depend on this id 
                   // $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1"); // LIMIT 1 record out one ==<
                    $check = chechVillage('c_id', 'comments', $comid);
                    
                    // execute query
                   // $stmt->execute(array($userid));
                
                    //the row count 
                   // $count = $stmt->rowCount();
                    //if there's such id show the form

                    if( $check > 0) //if there id go to this code-->   
                    {
                        $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zid");
                        $stmt->bindParam(":zid", $comid);
                        $stmt->execute();

                        //this message success
                        $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Delete ';
                        redirectHome($TheMsg,'back');

                        }
                        else{
                            $TheMsg = '<div class="alert alert-danger"> this id is not exit</div>';
                            redirectHome($TheMsg);
                        }
                        echo '</div>';

                
            } 
           
                
        include $tpl . 'footer.php';
        }
        else{
            header('Location: index.php');
            exit();
        }
