<?php
    include "function/admin_function.php";
    if(is_logged_in()==false)
    {
        redirect("admin_login.php");
    }   
    include "header_footer/header.php";
?>
<body>
    <?php  admin_navbar(["","","","","","active","","","",""]); ?>
        <ul>
            <li>
                <form action="admin_bookings.php" method="post">
                   <input type="text" name="bus_number" required placeholder="enter bus number">
                   <input type="date" name="date" required placeholder="enter date">
                   <input type="submit" name="Search" class="btn btn-primary" value="Search">
                </form>
            </li>
        </ul>
        
    <?php 
        
         if(isset($_POST['Search']))
         {
            search_bookings();
         }
         else
         {
             $page=isset($_GET['page'])? (int)strip_tags($_GET['page']):1;
            $page= $page==0?1:$page;
            read_bookings($page-1);
            $previous=($page-1)>0?$page-1:1;
            $next=$page+1;
            echo '<ul class="pager">';
            echo '<li class="previous"><a position="left" href="admin_bookings.php?page='.$previous.'">Previous</a></li>';
            echo '<li class="next"><a href="admin_bookings.php?page='.$next.'">Next</a></li>
            </ul>';
         }
         include "header_footer/e-travel_footer.php";
    ?>
</body>
</html>