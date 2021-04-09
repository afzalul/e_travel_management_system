<?php 
    include "function/user_function.php";
    global $session_user_username , $session_user_user_id;
    unset($_SESSION[$session_user_username]);
    unset($_SESSION[$session_user_user_id]);
    //session_destroy();
    //session_write_close();
    redirect("user_login.php");
?>