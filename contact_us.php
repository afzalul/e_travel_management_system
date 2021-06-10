<?php 
    include "function/user_function.php";
    include "header_footer/e_travel_header.php";
?>
<script src="1_data_valid.js">   </script>
<body>
    <div id="back">
       <h1 id="first">E-Travel Management System</h1>
       
       <!--navigation bar---->
        <?php website_navbar(["","","","active"]); ?>
        
         <div class="container">
        <div class="col-sm-6">
           
            <form action="contact_us.php" method="post" name="contact">
              <?php    
                    if(isset($_POST['submit']))
                    {
                        receive_user_feedback();
                    }
                ?>
               <div class="form-group">
                   <label for="username">Name</label>
                   <input type="text" name="name" class="form-control" required onchange="validate_name('contact','name')">
                   <h5 id="name"></h5>
               </div>
                
                <div class="form-group">
                  <label for="">Mobile No</label> 
                  <input type="text" name="mobile_no" class="form-control" required onchange="validate_mobile_no('contact','mobile_no')">
                    <h5 id="mobile_no"></h5>
               </div>
               <div class="form-group">
                   <label for="">Message</label>
                   <textarea rows="4" cols="72" name="mgs" placeholder="Enter your message" maxlength="200" required></textarea>
               </div>
                
                
                <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Send">
            </form>
        </div>
    </div>
         <br>
          
        <?php include "header_footer/e-travel_footer.php"; ?>
    </div>
    
    
</body>
</html>