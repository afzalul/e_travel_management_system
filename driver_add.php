<?php
    include "function/admin_function.php";
    if(is_logged_in()==false)
    {
        redirect("admin_login.php");
    }
      include "header_footer/header.php";  
?>
<body>
    <?php  admin_navbar(["","","active","","","","","","",""]); ?>
        
        <div class="container">  
        <div class="col-sm-6">
           <h3>Add driver</h3>
            <form action="driver_add.php" method="post">
              
               <?php 
                    if(isset($_POST['submit']))
                    {
                        insert_new_driver();
                    }
                ?>
               <div class="form-group">
                   <label for="name">Name</label>
                   <input type="text" name="name" class="form-control" required>
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
                  <label for="password">Experience</label> 
                  <input type="int" name="exp" class="form-control" required maxlength="2">
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