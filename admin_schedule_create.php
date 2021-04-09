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
    <?php  admin_navbar(["","","","","active","","","","",""]); ?>
        
        <div class="container">  
        <div class="col-sm-6">
            <form action="admin_schedule_create.php" method="post">
              
               <?php 
                    if(isset($_POST['submit']))
                    {
                        insert_new_schedule();
                    }
                ?>
               <div class="form-group">
                   <label for="name">Bus Number</label>
                   <input type="text" name="bus_number" class="form-control" required>
               </div>
               
               <div class="form-group">
                   <label for="">From</label>
                   <select class="form-control" name="start" required>
                      <option value="Dhaka">Dhaka</option>
                      <option value="Chittagong">Chittagong</option>
                      <option value="Khulna">Khulna</option>
                      <option value="Rajshahi">Rajshahi</option>
                      <option value="Sylhet">Sylhet</option>
                      <option value="Comilla">Comilla</option>
                  </select>
               </div>
                <div class="form-group">
                   <label for="">To</label>
                   <select class="form-control" name="end" required>
                     <option value="Chittagong">Chittagong</option>
                      <option value="Dhaka">Dhaka</option>
                      <option value="Khulna">Khulna</option>
                      <option value="Rajshahi">Rajshahi</option>
                      <option value="Sylhet">Sylhet</option>
                      <option value="Comilla">Comilla</option>
                  </select>
               </div>

               <div class="form-group">
                  <label for="">Date</label> 
                  <input type="date" name="date" class="form-control" required>
               </div>
               <div class="form-group">
                  <label for="">Time</label> 
                  <input type="text" name="time" class="form-control" required>
               </div>
               <div class="form-group">
                  <label for="password">Admin username</label> 
                  <input type="text" name="ad_username" class="form-control" required value="<?php echo get_admin_session_name(); ?>" readonly>
               </div>
                
                <input type="submit" name="submit"class="btn btn-primary" value="Create">
            </form>
        </div>
    </div>
    <?php include "header_footer/e-travel_footer.php"; ?>
</body>
</html>