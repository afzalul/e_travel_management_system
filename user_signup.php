<?php 
    include "function/user_function.php";
    include "header_footer/e_travel_header.php"; 
        
?>
<body>
         <h1 id="first">E-Travel Management System</h1>
         
        <?php website_navbar(["","","active",""]); ?>
        
    <div class="container">  
        <div class="col-sm-6">
           <h1>Sign Up</h1>
            <form action="user_signup.php" method="post">
              
               <?php 
                    if(isset($_POST['submit']))
                    {
                        insert_new_user();
                    }
                ?>
               <div class="form-group">
                   <label for="name">Name</label>
                   <input type="text" name="full_name" class="form-control" required>
               </div>
               
                <div class="form-group">
                   <label for="username">Username</label>
                   <input type="text" name="username" class="form-control" required>
               </div>
                
                <div class="form-group">
                  <label for="password">Password</label> 
                  <input type="password" name="password" class="form-control" required>
               </div>
               
               <div class="form-group">
                  <label for="password">Confirm Password</label> 
                  <input type="password" name="re_password" class="form-control" required>
               </div>
                <div class="form-group">
                  <label for="password">Mobile no</label> 
                  <input type="tel" name="mobile_no" pattern="^\d{3}\d{4}\d{4}$" class="form-control" required maxlength="11">
               </div>
                <input type="submit" name="submit" class="btn btn-primary" value="Apply">
            </form>
            <br>
            <a href="user_login.php">Registered?</a>
        </div>
        
    </div>
    <?php include "header_footer/e-travel_footer.php"; ?>
</body>
</html>