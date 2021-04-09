<?php 
    include "function/admin_function.php";
    global $session_admin_username , $session_admin_id;
    unset($_SESSION[$session_admin_username]);
    unset($_SESSION[$session_admin_id]);
    //session_destroy();
    //session_write_close();
    redirect("admin_login.php");
?>