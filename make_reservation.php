<?php 
    include "function/user_function.php";
    if(is_logged_user()==false)
    {
        redirect("user_login.php");
    }
    else if(!isset($_POST['book']))
    {
        redirect("index.php");
    }
    include "header_footer/e_travel_header.php";
?>
<body>
    <h1 id="first">E-Travel Management System</h1>
       
       <!--navigation bar---->
        <?php website_navbar(["","","",""]); ?>
    <div class="container">  
        <div class="col-sm-6">
            <form action="make_reservation.php" method="post">
               <?php 
                    if(isset($_POST['Confirm']))
                    {
                        confirm_bookings_details();
                    }
                ?>
                <h3>Please confirm the information</h3>
               <div class="form-group">
                   <label for="">Bus number</label>
                   <input type="text" name="bus_number" class="form-control" value="<?php echo $_POST['bus_number']; ?>" readonly>
               </div>
               
                <div class="form-group">
                   <label for="">Date</label>
                   <input type="text" name="date" class="form-control" value="<?php echo $_POST['date']; ?>" readonly>
               </div>
                
                <div class="form-group">
                  <label for="">Time</label> 
                  <input type="text" name="time" class="form-control" value="<?php echo $_POST['time']; ?>" readonly>
               </div>
               
               <div class="form-group">
                  <label for="">Route</label> 
                  <input type="text" name="route" class="form-control" value="<?php echo $_POST['route']; ?>" readonly>
               </div>
               
               <div class="form-group">
                  <label for="">Type</label> 
                  <input type="text" name="type" class="form-control" value="<?php echo $_POST['type']; ?>" readonly>
               </div>
                
                <div class="form-group">
                  <label for="">schedule_id</label> 
                  <input type="text" name="schedule_id" class="form-control" value="<?php echo $_POST['schedule_id']; ?>" readonly>
               </div>
                
                <input type="submit" name="Confirm" class="btn btn-primary" value="Confirm">
            </form>
        </div>
    </div>
    <br>
    <?php include "header_footer/e-travel_footer.php"; ?>
</body>
</html>