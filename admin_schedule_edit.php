<?php
    include "function/admin_function.php";
    if(is_logged_in()==false)
    {
        redirect("admin_login.php");
    }
      include "header_footer/header.php";  
?>
<body>
    <?php  admin_navbar(["","","","","active","","","","",""]); ?>
        
        <div class="container">  
        <div class="col-sm-6">
           <h3>Edit Schedule</h3>
            <form action="admin_schedule_edit.php" method="post">
              
               <?php 
                    if(isset($_POST['submit']))
                    {
                        update_schedule();
                    }
                ?>
                <div class="form-group">
                   <label for="name">Schedule ID</label>
                   <input type="text" name="schedule_id" class="form-control" value="<?php echo strip_tags($_GET['schedule_id']); ?>" readonly>
               </div>
               
               <div class="form-group">
                   <label for="name">Bus Number</label>
                   <input type="text" name="bus_number" class="form-control" value="<?php echo strip_tags($_GET['bus_number']); ?>">
               </div>
               
                <div class="form-group">
                   <label for="">Route</label>
                   <input type="text" name="route" class="form-control" required value="<?php echo strip_tags($_GET['route']); ?>" readonly>
               </div>
                
               <div class="form-group">
                  <label for="">Date</label> 
                  <input type="text" name="date" class="form-control" required value="<?php echo strip_tags($_GET['date']); ?>" readonly>
               </div>
               <div class="form-group">
                  <label for="">Time</label> 
                  <input type="text" name="time" class="form-control" required value="<?php echo strip_tags($_GET['time']); ?>">
               </div>
                
                <input type="submit" name="submit"class="btn btn-primary" value="Update">
            </form>
        </div>
    </div>
    <?php include "header_footer/e-travel_footer.php"; ?>
</body>
</html>