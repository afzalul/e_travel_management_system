<?php   
    include "function/user_function.php";
    include "header_footer/e_travel_header.php"; 
    if(is_logged_user()==true)
    {
        redirect("user_notification.php");
    } 
?>
<body>
    
        <h1 id="first">E-Travel Management System</h1>
        
        <?php website_navbar(["","","active",""]); ?>
        
        <div class="container">
        <div class="col-sm-6">
           <h2>User Login</h2>
            <form action="user_login.php" method="post">
              <?php    
                    if(isset($_POST['submit']))
                    {
                        login_verification_user();
                    }
                ?>
               <div class="form-group">
                   <label for="username">Username</label>
                   <input type="text" name="username" class="form-control" required>
               </div>
                
                <div class="form-group">
                  <label for="password">Password</label> 
                  <input type="password" name="password" class="form-control" required>
               </div>
               
                
                <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Sign in">
            </form>
            <br>
            <p><a href="user_password_recover.php">Forgot Password?</a></p>
            <br>
            <p><a href="user_signup.php">Not Registered?</a></p>
            
        </div>
    </div>
        
        <?php include "header_footer/e-travel_footer.php"; ?>
    </div>
</body>
</html>