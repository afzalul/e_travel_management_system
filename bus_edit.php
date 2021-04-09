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
    <?php  admin_navbar(["","","","active","","","","","",""]); ?>
        
        <div class="container">  
        <div class="col-sm-6">
           <h3>Edit Bus</h3>
            <form action="bus_edit.php" method="post">
              
               <?php 
                    if(isset($_POST['submit']))
                    {
                        update_bus();
                    }
                ?>
                <div class="form-group">
                   <label for="name">Bus ID</label>
                   <input type="text" name="bus_id" class="form-control" value="<?php echo strip_tags($_GET['bus_id']); ?>" readonly>
               </div>
               
               <div class="form-group">
                   <label for="name">Bus Number</label>
                   <input type="text" name="bus_number" class="form-control" value="<?php echo strip_tags($_GET['bus_number']); ?>">
               </div>
               
                <div class="form-group">
                   <label for="">Type</label>
                   <input type="text" name="type" class="form-control" required value="<?php echo strip_tags($_GET['type']); ?>">
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