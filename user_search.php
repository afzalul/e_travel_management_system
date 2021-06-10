<?php
    include "function/user_function.php";
    if(is_logged_user()==false)
    {
        redirect("user_login.php");
    }
include "header_footer/header.php";
?>
<body>
    <?php user_navbar(["","","","active","",""]); ?>
        <form action="user_search.php" method="post">
               <ul>
                  <h5>Select:</h5>
                   <li><input type="radio" name="option" value="driver_info" required>Driver</li>
                   <li><input type="radio" name="option" value="bus_info" required>Bus</li>
                   <li>
                       <input type="text" name="search" required placeholder="enter what to search">
                    <input type="submit" name="submit" class="btn btn-primary" value="Search">
                 </li>
               </ul>   
        </form>
    <?php 
        if(isset($_POST['submit']))
        {
            find_info();
        }
        include "header_footer/e-travel_footer.php";
    ?>
</body>
</html>