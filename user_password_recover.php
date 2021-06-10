<?php   
    include "function/user_function.php";
    include "header_footer/e_travel_header.php"; 
    if(is_logged_user())
    {
        redirect("user_bookings.php");
    } 
?>
<script src="1_data_valid.js">   </script>

<body>
        <h1 id="first">E-Travel Management System</h1>
        
        <?php website_navbar(["","","active",""]); ?>
        
        <div class="container">
        <div class="col-sm-6">
           <h2>User Password Recover</h2>
            <form action="user_password_recover.php" method="post" name="reset_password">
              <?php 
                 if(isset($_POST['submit']))
                    {
                        reset_user_password();
                    }
                ?>
               <div class="form-group">
                   <label for="username">Enter Username</label>
                   <input type="text" name="username" class="form-control" required maxlength="30" onchange="validate_username('reset_password','username')">
                   <h5 id="username"></h5>
               </div>
                
                <div class="form-group">
                  <label for="">Enter Mobile No</label> 
                  <input type="text" name="mobile_no" class="form-control" required minlegth="11" maxlength="11" onchange="validate_mobile_no('reset_password','mobile_no')">
                    <h5 id="mobile_no"></h5>
               </div>
               
               <div class="form-group">
                   <label for="username">Enter New Password</label>
                   <input type="password" name="password" class="form-control" required onchange="validate_password('reset_password','password','confirm_password')">
                   <h5 id="password"></h5>
               </div>
                
                <div class="form-group">
                  <label for="">Confirm New Password</label> 
                  <input type="password" name="confirm_password" class="form-control" required  onchange="validate_password('reset_password','password','confirm_password')">
                    <h5 id="confirm_password"></h5>
               </div>
                
                <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Submit">
            </form>
            
        </div>
    </div>
        
        <?php include "header_footer/e-travel_footer.php"; ?>
    </div>
</body>
</html>