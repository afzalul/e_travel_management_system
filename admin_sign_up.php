<?php
    include "function/admin_function.php";
    if(is_logged_in()==false)
    {
        redirect("admin_login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php include "header_footer/header.php"; ?>
<body>
    <?php  admin_navbar(["","active","","","","","","","",""]); ?>
    <div class="container">  
        <div class="col-sm-6">
            <form action="admin_sign_up.php" method="post">
              
               <?php 
                    if(isset($_POST['submit']))
                    {
                        insert_new_admin();
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
                
                <input type="submit" name="submit"class="btn btn-primary" value="ADD">
            </form>
        </div>
    </div>
        <?php include "header_footer/e-travel_footer.php"; ?>
</body>
</html>