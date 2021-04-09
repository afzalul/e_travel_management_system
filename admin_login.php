<?php  
    include "function/admin_function.php";
    include "header_footer/e_travel_header.php"; 
    if(is_logged_in())
    {
        redirect("admin_feedback.php");
    } 
?>
<body>
        <h1 id="first">E-Travel Management System</h1>
        
        <?php website_navbar(["","active","",""]); ?>
        
        <div class="container">
        <div class="col-sm-6">
           <h2>Admin Login</h2>
            <form action="admin_login.php" method="post">
              <?php 
                 if(isset($_POST['submit']))
                    {
                        login_verification_admin();
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
            
        </div>
    </div>
      <br><br>    
    </div>
    <?php include "header_footer/e-travel_footer.php"; ?>
</body>
</html>