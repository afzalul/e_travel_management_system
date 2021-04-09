<?php 
    include "function/user_function.php";
    include "header_footer/e_travel_header.php";
?>
<body>
    <div id="back">
       <h1 id="first">E-Travel Management System</h1>
       
       <!--navigation bar---->
        <?php website_navbar(["","","","active"]); ?>
        
         <div class="container">
        <div class="col-sm-6">
           
            <form action="contact_us.php" method="post">
              <?php    
                    if(isset($_POST['Send']))
                    {
                        receive_user_feedback();
                    }
                ?>
               <div class="form-group">
                   <label for="username">Name</label>
                   <input type="text" name="name" class="form-control" required>
               </div>
                
                <div class="form-group">
                  <label for="">Mobile No</label> 
                  <input type="text" name="mobile_no" class="form-control" pattern="^\d{3}\d{4}\d{4}$" required>
               </div>
               <div class="form-group">
                   <label for="username">Message</label>
               </div>
                <textarea rows="4" cols="72" name="mgs" placeholder="Enter your message" maxlength="200"></textarea>
                <div class="form-group">
                   <label></label>
               </div>
                <input type="submit" name="Send" class="btn btn-lg btn-primary btn-block" value="Send">
            </form>
        </div>
    </div>
         <br>
          
        <?php include "header_footer/e-travel_footer.php"; ?>
    </div>
    
    
</body>
</html>