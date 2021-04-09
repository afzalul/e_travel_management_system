<?php 
    include "function/user_function.php";
    include "header_footer/e_travel_header.php";
?>
<body>
    <div id="back">
       <h1 id="first">E-Travel Management System</h1>
       
       <!--navigation bar---->
        <?php website_navbar(["active","","",""]); ?>
        
         <!--image of buses--->
          <div>
              <img src="image/Desh-Travel-Bus.jpg" width="160" height="150" >
               <img src="image/Hanif-Paribahan.jpg" width="160" height="150" >
               <img src="image/unique-bus.jpg" width="160" height="150" >
               <img src="image/soudia-bus.jpg" width="160" height="150" >
               <img src="image/shohaq-bus.jpg" width="160" height="150" >
               <img src="image/shyamoli-bus.jpg" width="160" height="150" >
               <img src="image/green%20line%20bus.jpg" width="160" height="150">
               <img src="image/tr-trvels.jpg" width="160" height="150" >
          </div>
          <br>
          <!--form for input-->
          <div class="container">  
        <div class="col-sm-6">
           <?php 
                if(isset($_POST['Search']))
                {
                    $start=strip_tags($_POST['start']);
                    $end=strip_tags($_POST['end']);
                    $route=$start."-".$end;
                    $date=strip_tags($_POST['date']);
                    $type=strip_tags($_POST['type']);
                    if($start==$end)
                    {
                        show_error_message("Starting & Destination can't be same.");
                    }
                    else if(strtotime($date) < time())
                    {
                        show_error_message("Please select current date.");
                    }
                    else
                    {
                        redirect("search_bus_schedule.php?route=".$route."&date=".$date."&type=".$type);
                    }
                }
            ?>
            <form action="index.php" method="post">
              
               <div class="form-group">
                   <label for="">From</label>
                   <select class="form-control" name="start">
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
                   <select class="form-control" name="end">
                      <option value="Dhaka">Dhaka</option>
                      <option value="Chittagong">Chittagong</option>
                      <option value="Khulna">Khulna</option>
                      <option value="Rajshahi">Rajshahi</option>
                      <option value="Sylhet">Sylhet</option>
                      <option value="Comilla">Comilla</option>
                  </select>
               </div>
                
                <div class="form-group">
                  <label for="">Date</label> 
                  <input type="date" name="date" class="form-control" required placeholder="Enter city">
               </div>
               
               <div class="form-group">
                  <label for="">Type</label> <br>
                  <input type="radio" name="type"  required value="AC">AC     
                  <input type="radio" name="type"  required value="NON-AC">NON-AC
               </div>
                
                <input type="submit" name="Search" class="btn btn-primary" value="Search">
            </form>
        </div>
    </div>
        <?php include "header_footer/e-travel_footer.php"; ?>
    </div>
    
    
</body>
</html>