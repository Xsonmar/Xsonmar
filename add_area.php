<?php 
session_start();
$pageTitle = 'New Add Village';
//print_r($_SESSION);
include 'init.php';
if(isset($_SESSION['user'])){

    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $formError=array();

        $name= $_POST['name'];
        $desc= $_POST['description'];
        $img= $_POST['image'];
        $area_add=$_POST['area'];

        if(empty($formError)){
            //Insert info village in database 
            $stmt = $con->prepare("INSERT INTO 
            village (Name ,Description, Add_Date, image,Area_ID,Member_ID) 
        VALUES(:zname, :zdesc, now(), :zimage, :zarea, :zmember)");
    //any user in database have 1 ==> will be admin
        $stmt->execute(array(
            'zname'  => $name,
            'zdesc'  => $desc,
            'zimage'  => $img,
            'zarea'  => $area_add,
            'zmember'=> $_SESSION['uid']
         
        ));
        
            //echo success message
            if($stmt){
         echo 'Village Add';
                }
            }
   }
?>

<h1 class="text-center">Create New Village</h1>
<div class="containers areas">
          
<div class="information block">
    <div class="containers">
        <div class="panel panel-primary">
            <div class="panel-heading">Create New Village</div>
                <div class="panel-body">
                    <div class="row">
                    <div class="col-md-8"> 
                                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"> 
                    <!-- Start Name Field --> 
                    <div class="form-group"> <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-20"> <input type="text" name="name" class="form-control live-name" autocomplete="off" data-calss=".live-title"/> 
                </div> </div> 
                    <!-- End Name Field --> 
                    
                    <!-- Start Description Field --> 
                    <div class="form-group"> <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-20"> <input type="text" name="description" class="form-control live-desc" autocomplete="off" data-calss=".live-desc"/> 
                </div> </div> 
                    <!-- End Description Field -->
                <!-- Start image Field --> 
                <div class="form-group"> <label class="col-sm-2 control-label">image</label>
                    <div class="col-sm-20"> <input type="file" name="image" class="form-control live-img" autocomplete="off" data-calss=".live-img"/> 
                </div> </div> 
                    <!-- End image Field -->
                        <!-- Start area Field --> 
                        <div class="form-group"> <label class="col-sm-2 control-label">Area</label>

                        <div class="option" style="font-size: large;">
                            <select name="area" >
                                <option value="0">...</option>
                                <?php 
                                $stmt = $con->prepare("SELECT * FROM area");
                                $stmt->execute();
                                $area1 = $stmt->fetchAll();
                                foreach($area1 as $area){
                                    echo "<option value='". $area['ID'] ."' >". $area['Name'] ."</option>";
                                }
                                ?>
                            </select>
                        </div>

                </div> 
                    <!-- End area Field -->
                

                        <!-- Start Submit Field --> 
                        <div class="form-group"> 
                    <div class="col-sm-10"> <input type="submit" value="Add Village" class="btn btn-primary" /> 
                </div> </div> 
                    <!-- End Submit Field --> 

                </form>
                  </div>
                    <div class="col-md-4">
                       <div class="thumbnail item-box live-preview">
                        <img src="" alt="" class="img-responsive">
                        <div class="caption">
                            <h3>Title</h3>
                            <p>Description</p>
                        </div>
                       </div>
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