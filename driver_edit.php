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
    <?php  admin_navbar(["","","active","","","","","","",""]); ?>
        
        <div class="container">  
        <div class="col-sm-6">
           <h3>Edit Driver</h3>
            <form action="driver_edit.php" method="post">
              
               <?php 
                    if(isset($_POST['submit']))
                    {
                        update_driver();
                    }
                ?>
                <div class="form-group">
                   <label for="name">ID</label>
                   <input type="text" name="id" class="form-control" value="<?php echo strip_tags($_GET['id']); ?>" readonly>
               </div>
               <div class="form-group">
                   <label for="name">Name</label>
                   <input type="text" name="name" class="form-control" value="<?php echo strip_tags($_GET['name']); ?>">
               </div>
               
                <div class="form-group">
                   <label for="">Experience</label>
                   <input type="text" name="exp" class="form-control" required value="<?php echo strip_tags($_GET['experience']); ?>">
               </div>
                
                <div class="form-group">
                  <label for="">Company</label> 
                  <input type="text" name="company" class="form-control" required value="<?php echo strip_tags($_GET['company']); ?>">
               </div>
                
                <input type="submit" name="submit" class="btn btn-primary" value="Update">
            </form>
        </div>
    </div>
    <?php include "header_footer/e-travel_footer.php"; ?>
</body>
</html>