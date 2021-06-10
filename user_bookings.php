<?php
    include "function/user_function.php";
    if(is_logged_user()==false)
    {
        redirect("user_login.php");
    }
    include "header_footer/header.php";
?>
<body>
    
    <?php user_navbar(["","active","","","",""]); ?>
        <ul>
            <li>
                <form action="user_bookings.php" method="post">
                    <input type="date" name="date" required> 
                    <input type="submit" name="Search" class="btn btn-primary" value="Search">
                </form>
            </li>
        </ul>
    
    
    <?php 
        if(isset($_POST['Search']))
        {
            search_user_bookings();
        }
        else if(isset($_POST['Cancel']))
        {
           cancel_user_bookings();
        }
        else
        {
            $page=isset($_GET['page'])? (int)strip_tags($_GET['page']):1;
            $page= $page==0?1:$page;
            read_user_bookings($page-1);
            $previous=($page-1)>0?$page-1:1;
            $next=$page+1;
            echo '<ul class="pager">';
            echo '<li class="previous"><a position="left" href="user_bookings.php?page='.$previous.'">Previous</a></li>';
            echo '<li class="next"><a href="user_bookings.php?page='.$next.'">Next</a></li>
            </ul>';
        }
        include "header_footer/e-travel_footer.php";  
    ?>
</body>
</html>