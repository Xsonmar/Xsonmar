<?php 
    session_start();
 
    if (isset($_SESSION['user'])){
        $pageTitle = 'about';
        
    include 'init.php';
    ?>

<div class="about">
      <div class="containers">
        <div class="row">
          <div class="flex">
            <div class="title">About Al-Baha Tourism </div> 
            <br><br><br>
            <h3>Al-baha Tourism</h3>
            <p> 
              Tourism in Saudi Arabia is considered one of the emerging 
              sectors with rapid growth, and represents one of the important axes 
              of the Saudi Vision 2030. In addition to the historical and heritage treasure
              and the natural and cultural diversity that the Kingdom of Saudi Arabia enjoys,
              Al-Baha Tourism therefore provides complete information about the tourist areas that
              represent the villages surrounding the Al-Baha region. We display the different regions
              from which the visitor can choose what suits him. All of this is to win the hearts and minds
              of people by opening our doors to the world through a tourism sector that focuses on the heritage 
              and beauty of the southern regions.
            </p>
          </div>
          <div class="flex">
            <img src=".\layout\images\Albaha_about_as.jpg" alt="about Al baha">
           </div>
        </div>
      </div>
     </div>
<?php

    // print_r($_SESSION);
 
    include $tpl . 'footer.php';
    }
    else{
        header('Location: index.php');
        exit();
    }