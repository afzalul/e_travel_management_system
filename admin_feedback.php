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
    <?php 
        admin_navbar(["","","","","","","","","active",""]);          
        if(isset($_POST['Delete']))
        {
            delete_message();
        }
        else
        {
            $page=isset($_GET['page'])? (int)strip_tags($_GET['page']):1;
            $page= $page==0?1:$page;
            read_message($page-1);
            $previous=($page-1)>0?$page-1:1;
            $next=$page+1;
            echo '<ul class="pager">';
            echo '<li class="previous"><a position="left" href="admin_feedback.php?page='.$previous.'">Previous</a></li>';
            echo '<li class="next"><a href="admin_feedback.php?page='.$next.'">Next</a></li>
            </ul>';
        }
        include "header_footer/e-travel_footer.php";   
    ?>      
</body>
</html>