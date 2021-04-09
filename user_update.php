<?php
    include "function/user_function.php";
    if(is_logged_user()==false)
    {
        redirect("user_login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php include "header_footer/header.php"; ?>
<body>
    <?php user_navbar(["active","","","","",""]); ?>
        <div class="container">
        <div class="col-sm-6">
           <?php 
                if(isset($_POST['submit']))
                {
                    update_user();
                }
            ?>
            <form action="user_update.php" method="post">
                
                <div class="form-group">
                  <label for="password">Old Password</label> 
                  <input type="password" name="old_password" class="form-control" required>
               </div>
                 
                  <div class="form-group">
                   <label for="username">New Username</label>
                   <input type="text" name="new_username" class="form-control" required>
               </div>
                
                <div class="form-group">
                  <label for="password">New Password</label> 
                  <input type="password" name="new_password" class="form-control" required>
               </div>
               
               <div class="form-group">
                  <label for="password">Confirm New Password</label> 
                  <input type="password" name="confirm_new_password" class="form-control" required>
               </div>
                
                <input type="submit" name="submit" class="btn btn-primary" value="Update">
            </form>
        </div>
    </div>
</body>
</html>