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
        <ul>
            <li><a href="driver_add.php">Add</a></li>
            <br>
            <li><form action="driver_list.php" method="post">
               <input type="text" name="search" required placeholder="enter name or company or admin">
               <input type="submit" name="Search" class="btn btn-primary" value="Search">
                
            </form></li>
        </ul>
        
    <?php
    
        if(isset($_POST['Search']))
        {
            search_driver();
        }
        else if(isset($_POST['delete']))
        {
            delete_driver(); 
        }
         else
         {
             $page=isset($_GET['page'])? (int)strip_tags($_GET['page']):1;
            $page= $page==0?1:$page;
            read_driver_list($page-1);
            $previous=($page-1)>0?$page-1:1;
            $next=$page+1;
            echo '<ul class="pager">';
            echo '<li class="previous"><a position="left" href="driver_list.php?page='.$previous.'">Previous</a></li>';
            echo '<li class="next"><a href="driver_list.php?page='.$next.'">Next</a></li>
            </ul>';

         }
         include "header_footer/e-travel_footer.php";
    ?>
</body>
</html>