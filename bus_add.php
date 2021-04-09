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
           <h3>Add bus</h3>
            <form action="bus_add.php" method="post">
              
               <?php 
                    if(isset($_POST['submit']))
                    {
                        insert_new_bus();
                    }
                ?>
               <div class="form-group">
                   <label for="name">Number</label>
                   <input type="text" name="number" class="form-control" required>
               </div>
               
                <div class="form-group">
                   <label for="">Type</label>
                   <select class="form-control" name="type" required>
                      <option value="AC">AC</option>
                      <option value="NON-AC">NON-AC</option>
                  </select>
               </div>
                
                <div class="form-group">
                   <label for="">Company</label>
                   <select class="form-control" name="company" required>
                      <option value="Unique">Unique</option>
                      <option value="Hanif">Hanif</option>
                      <option value="Desh Travels">Desh Travels</option>
                      <option value="Soudia">Soudia</option>
                      <option value="Shohagh">Shohagh</option>
                      <option value="Shymoli">Shymoli</option>
                      <option value="Green Line">Green Line</option>
                      <option value="Tr Travels">Tr Travels</option>
                  </select>
               </div>
               
               <div class="form-group">
                  <label for="password">Admin username</label> 
                  <input type="text" name="ad_username" class="form-control" required value="<?php echo get_admin_session_name(); ?>" readonly>
               </div>
                
                <input type="submit" name="submit" class="btn btn-primary" value="ADD">
            </form>
        </div>
    </div>
    <?php include "header_footer/e-travel_footer.php"; ?>
</body>
</html>