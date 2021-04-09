<?php
    include "function/user_function.php";
    if(is_logged_user()==false)
    {
        redirect("user_login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php include "header_footer/header.php"; ?>
<body>
    <?php user_navbar(["","","","","active",""]); ?>
    <?php
        
        if(isset($_POST['DELETE']))
        {
            delete_user_notification();
        }
        else
        {
            $page=isset($_GET['page'])? (int)strip_tags($_GET['page']):1;
            $page= $page==0?1:$page;
            read_notification($page-1);
            $previous=($page-1)>0?$page-1:1;
            $next=$page+1;
            echo '<ul class="pager">';
            echo '<li class="previous"><a position="left" href="user_notification.php?page='.$previous.'">Previous</a></li>';
            echo '<li class="next"><a href="user_notification.php?page='.$next.'">Next</a></li>
            </ul>';
        }
        include "header_footer/e-travel_footer.php";
    ?>
</body>
</html>