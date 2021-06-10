<?php 
    include "function/user_function.php";
    include "header_footer/e_travel_header.php"; 
        
?>
<script src="1_data_valid.js">   </script>
<body>
         <h1 id="first">E-Travel Management System</h1>
         
        <?php website_navbar(["","","active",""]); ?>
        
    <div class="container">  
        <div class="col-sm-6">
           <h1>Sign Up</h1>
            <form action="user_signup.php" method="post"  name="signup">
              
               <?php 

                    if(isset($_POST['submit']))
                    {
                        insert_new_user();
                    }
                ?>
               <div class="form-group">
                   <label for="name">Name</label>
                   <input type="text" name="full_name" class="form-control" required onchange="validate_name('signup','full_name')">
                   <h5 id="full_name"></h5>
               </div>
               
                <div class="form-group">
                   <label for="username">Username</label>
                   <input type="text" name="username" class="form-control" required onchange="validate_username('signup','username')">
                   <h5 id="username"></h5>
               </div>
                
                <div class="form-group">
                  <label for="password">Password</label> 
                  <input type="password" name="password" class="form-control" required onchange="validate_password('signup','password','re_password')">
                    <h5 id="password"></h5>
               </div>
               
               <div class="form-group">
                  <label for="password">Confirm Password</label> 
                  <input type="password" name="re_password" class="form-control" required onchange="validate_password('signup','password','re_password')">
                   <h5 id="re_password"></h5>
               </div>
                <div class="form-group">
                  <label for="password">Mobile no</label> 
                  <input type="tel" name="mobile_no"  class="form-control" required maxlength="11" onchange="validate_mobile_no('signup','mobile_no')">
                  <h5 id="mobile_no"></h5>
               </div>
                
                <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Apply">
            </form>
            <br>
            <a href="user_login.php">Registered?</a>
        </div>
        
    </div>
    <?php include "header_footer/e-travel_footer.php"; ?>
</body>
</html>