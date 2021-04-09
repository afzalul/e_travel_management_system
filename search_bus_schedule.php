<?php
    include "function/user_function.php";
    include "header_footer/e_travel_header.php";
    if(is_logged_user()==false)
    {
        redirect("user_login.php");
    }
    else if(! ( isset($_GET['route']) and isset($_GET['date']) and isset($_GET['type']) )  )
    {
        redirect("index.php");
    }
?>
<body>
    <div id="back">
       <h1 id="first">E-Travel Management System</h1>
       
       <!--navigation bar---->
        <?php website_navbar(["","","",""]); ?>
    </div>
        <br>
    <?php
    
        search();
        include "header_footer/e-travel_footer.php";
    ?>
</body>
</html>