<?php
    include "function/admin_function.php";
    if(is_logged_in()==false)
    {
        redirect("admin_login.php");
    }
        
?>
<!DOCTYPE html>
<html lang="en">
<?php include "header_footer/header.php"; ?>
<body>
    <?php  admin_navbar(["","","","","active","","","","",""]); ?>
        <ul>
            <li><a href="admin_schedule_create.php">Create</a></li>
                <br>
            <li>
              <form action="admin_schedule.php" method="post">
               <input type="text" name="route" required placeholder="enter route">
               <input type="date" name="date" required placeholder="enter date">
               <input type="submit" name="Search" class="btn btn-primary" value="Search">
              </form>
            </li>
        </ul>
        
    <?php 
        
        if(isset($_POST['Search']))
        {
            search_schedule();
        }
        else if(isset($_POST['delete']))
        {
            delete_schedule();
        }
         else
         {
             $page=isset($_GET['page'])? (int)strip_tags($_GET['page']):1;
            $page= $page==0?1:$page;
            read_schedule($page-1);
            $previous=($page-1)>0?$page-1:1;
            $next=$page+1;
            echo '<ul class="pager">';
            echo '<li class="previous"><a position="left" href="admin_schedule.php?page='.$previous.'">Previous</a></li>';
            echo '<li class="next"><a href="admin_schedule.php?page='.$next.'">Next</a></li>
            </ul>';
         }
         include "header_footer/e-travel_footer.php"; 
    ?>
</body>
</html>