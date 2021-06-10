<?php
    include "function/admin_function.php";
    if(is_logged_in()==false)
    {
        redirect("admin_login.php");
    }
     include "header_footer/header.php";    
?>
<body>
    <?php  admin_navbar(["","","","","","","active","","",""]); ?>
        <ul>
            <li>
              <form action="admin_user_join_request.php" method="post">
               <input type="text" name="search" required placeholder="enter">
               <input type="submit" name="Search" class="btn btn-primary" value="Search">
                
             </form>
            </li>
        </ul>
        
    <?php 
        
        if(isset($_POST['Search']))
        {
            search_join_request();
        }
        else if(isset($_POST['DO']))
        {
            add_or_delete_join_request();
        }
        else
        {
            $page=isset($_GET['page'])? (int)strip_tags($_GET['page']):1;
            $page= $page==0?1:$page;
            read_join_request($page-1);
            $previous=($page-1)>0?$page-1:1;
            $next=$page+1;
            echo '<ul class="pager">';
            echo '<li class="previous"><a position="left" href="admin_user_join_request.php?page='.$previous.'">Previous</a></li>';
            echo '<li class="next"><a href="admin_user_join_request.php?page='.$next.'">Next</a></li>
            </ul>';
        }
        include "header_footer/e-travel_footer.php";
    ?>
</body>
</html>