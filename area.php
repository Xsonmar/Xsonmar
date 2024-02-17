<?php 

//print_r($_SESSION);
include 'init.php';

?>

        <div class="con" >
            <h1 class="" style="text-align: center;"></h1>
          <div class="row">
          <div class="panel-body" style="font-size:15px;">
                <?php  
                foreach(getvillages($_GET['pageid']) as $village){
                    echo '<div class="col-sm-4 col-md-3">';
                        echo '<div class="thumbnail">';
                        echo '<img src="shada.jpg" alt="" />';
                        echo '<div class="caption">';
                                echo '<h3> <a href="village.php?villageid='.$village['Village_ID'].'">'.$village['Name'].'</a></h3>';
                                echo '<p>'.$village['Description'].'</p>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
                ?>
        </div>
        </div>
</div>



<?php

include $tpl . 'footer.php';
?>