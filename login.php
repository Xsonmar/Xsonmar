<?php 
session_start();
$noNavbar = '';
$pageTitle='Login';


if (isset($_SESSION['user'])){
    header('Location: index.php'); // redirect to dashbord page
  }
  include 'init.php';
  //check if user coming from http post request
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['login'])){
    $user = $_POST['user'];
    $pass = $_POST['password'];
    $hashedPass = sha1($pass);
    
    //check if the user has already in database
    $stmt = $con->prepare("SELECT UserID,Username,Password FROM users WHERE Username = ? AND Password = ?");
    $stmt->execute(array($user,$hashedPass));
    $get = $stmt->fetch();
    $count = $stmt->rowCount();
    
    //if acount > 0 this mean the database contain  record about this username 
    if($count > 0){
      //register session name
        $_SESSION['user'] = $user; //register session name
        $_SESSION['uid'] = $get['UserID'];
        header('Location: index.php');//direct to dashbord page
        exit();
    }
  } else{
    $formError=array();
   $getname = $_POST['username'];
   $getpass = $_POST['password'];
   $getemail= $_POST['email'];

   if(empty($formError)){
    //check if the user alridy exit in database || $value ==> $user
    $check = chechVillage("Username","users",$getname);
    if($check == 1){
        $TheMsg = '<div class="alert alert-danger" role="alert" >Sorry this user is exit</div>';
  }
        else{
        
              //Insert info user in database 
                        $stmt = $con->prepare("INSERT INTO 
                        users (Username ,Password,Email,RegStatus,Date) 
                        VALUES(:zuser, :zpass, :zemail,0,now()) ");
                        //any user in database have 1 ==> will be admin
                        $stmt->execute(array(
                            'zuser'  => $getname,
                            'zpass'  => sha1($getpass),
                            'zemail' => $getemail
                        ));

                //echo success message
                header('Location: index.php');//direct to dashbord page
              }
    }


  }
}


?>

  <div class="center-box">
 <div class="wrapper">
         <div class="title-text">
            <div class="title login">
               Login 
            </div>
            <div class="title signup">
               Signup 
            </div>
         </div>
           <!--              login page               -->
         <div class="form-container">
            <div class="slide-controls">
               <input type="radio" name="slide" id="login" checked>
               <input type="radio" name="slide" id="signup">
               <label for="login" class="slide login">Login</label>
               <label for="signup" class="slide signup">Signup</label>
               <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="login">
                  <div class="field">
                  <i class="fas fa-user"></i>
              <input type = "text" id ="firstName" name  = "user" placeholder="Username"/>                       </div>
                  <div class="field">
                  <i class="fas fa-lock"></i>
              <input type = "password" id ="password" placeholder="Password" name  = "password" />                   
                  </div>
                 
                  <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" name="login" value="Login">
                  </div>
                  <div class="signup-link">
                     Not a member? <a href="">Signup now</a>
                  </div>
               </form>



               <!--              sign up page               -->


            
              
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="signup">
                  <div class="field">
                  <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="username"/>   
                  </div>
                  <div class="field">
                  <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password"/>                  </div>
                  <div class="field">
                  <i class="fas fa-envelope"></i>
              <input type="email" id="email" name="email" placeholder="email"  />                  </div>
                  <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" class="btn" name="signup" value="Sign up" />
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="the-errors text-center">
                <?php
                if(!empty($formError)){
                  foreach($formError as $error){
                    echo '<div class="msg error">' . $error.'</div>';
                  }
                }
                if(isset($succesmsg)){
                  echo '<div class="msg success">' . $succesmsg.'</div>';
                }
                ?>
               </div>
      </div>
      

      <script>
         const loginText = document.querySelector(".title-text .login");
         const loginForm = document.querySelector("form.login");
         const loginBtn = document.querySelector("label.login");
         const signupBtn = document.querySelector("label.signup");
         const signupLink = document.querySelector("form .signup-link a");
         signupBtn.onclick = (()=>{
           loginForm.style.marginLeft = "-50%";
           loginText.style.marginLeft = "-50%";
         });
         loginBtn.onclick = (()=>{
           loginForm.style.marginLeft = "0%";
           loginText.style.marginLeft = "0%";
         });
         signupLink.onclick = (()=>{
           signupBtn.click();
           return false;
         });
      </script>
      
<style>
  html,body{
    display: grid;
    height: 100%;
    width: 100%;
    place-items: center;
    background: -webkit-linear-gradient(left, #5856F5, #4462DB, #7FB0F5, #3CA9E8);
  }
  ::selection{
    color: #0099ff;
    background: #e0eeff;
    margin: 0;
    padding: 0;
  }
 
  .wrapper{
    display: grid;
    overflow: hidden;
    max-width: 390px;
    background: #fff;
    padding: 30px;
    border-radius: 5px;
    box-shadow: 0px 15px 20px rgba(0,0,0,0.1);
  }
  .wrapper .title-text{
    display: flex;
    width: 200%;
  }
  .wrapper .title{
    width: 50%;
    font-size: 35px;
    font-weight: 600;
    text-align: center;
    transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
  }
  .wrapper .slide-controls{
    position: relative;
    display: flex;
    height: 50px;
    width: 100%;
    overflow: hidden;
    margin: 30px 0 10px 0;
    justify-content: space-between;
    border: 1px solid lightgrey;
    border-radius: 5px;
  }
  .slide-controls .slide{
    height: 100%;
    width: 100%;
    color: #fff;
    font-size: 18px;
    font-weight: 500;
    text-align: center;
    line-height: 48px;
    cursor: pointer;
    z-index: 1;
    transition: all 0.6s ease;
  }
  .slide-controls label.signup{
    color: #000;
  }
  .slide-controls .slider-tab{
    position: absolute;
    height: 100%;
    width: 50%;
    left: 0;
    z-index: 0;
    border-radius: 5px;
    background: -webkit-linear-gradient(left, #5856F5, #4462DB, #3CA9E8);
    transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
  }
  input[type="radio"]{
    display: none;
  }
  #signup:checked ~ .slider-tab{
    left: 50%;
  }
  #signup:checked ~ label.signup{
    color: #fff;
    cursor: default;
    user-select: none;
  }
  #signup:checked ~ label.login{
    color: #000;
  }
  #login:checked ~ label.signup{
    color: #000;
  }
  #login:checked ~ label.login{
    cursor: default;
    user-select: none;
  }
  .wrapper .form-container{
    width: 100%;
    overflow: hidden;
  }
  .form-container .form-inner{
    display: flex;
    width: 200%;
  }
  .form-container .form-inner form{
    width: 50%;
    transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
  }
  .form-inner form .field{
    height: 50px;
    width: 100%;
    margin-top: 20px;
  }
  .form-inner form .field input{
    height: 100%;
    width: 100%;
    outline: none;
    padding-left: 15px;
    border-radius: 5px;
    border: 1px solid lightgrey;
    border-bottom-width: 2px;
    font-size: 17px;
    transition: all 0.3s ease;
  }
  .form-inner form .field input:focus{
    border-color: #fc83bb;
    /* box-shadow: inset 0 0 3px #fb6aae; */
  }
  .form-inner form .field input::placeholder{
    color: #999;
    transition: all 0.3s ease;
  }
  form .field input:focus::placeholder{
    color: #b3b3b3;
  }
  .form-inner form .pass-link{
    margin-top: 5px;
  }
  .form-inner form .signup-link{
    text-align: center;
    margin-top: 30px;
  }
  .form-inner form .pass-link a,
  .form-inner form .signup-link a{
    color: #14B0F5;
    text-decoration: none;
  }
  .form-inner form .pass-link a:hover,
  .form-inner form .signup-link a:hover{
    text-decoration: underline;
  }
  form .btn{
    height: 50px;
    width: 100%;
    border-radius: 5px;
    position: relative;
    overflow: hidden;
  }
  form .btn .btn-layer{
    height: 100%;
    width: 300%;
    position: absolute;
    left: -100%;
    background: -webkit-linear-gradient(right, #5856F5, #4462DB, #7FB0F5, #3CA9E8);
    border-radius: 5px;
    transition: all 0.4s ease;;
  }
  form .btn:hover .btn-layer{
    left: 0;
  }
  form .btn input[type="submit"]{
    height: 100%;
    width: 100%;
    z-index: 1;
    position: relative;
    background: none;
    border: none;
    color: #fff;
    padding-left: 0;
    border-radius: 5px;
    font-size: 20px;
    font-weight: 500;
    cursor: pointer;
  }
  /*end login and sign up*/
 </style>
<?php include $tpl . 'footer.php'; ?>