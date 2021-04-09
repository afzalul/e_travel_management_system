<?php 

 /*_______DATABASE CONNECTION BLOCK________*/   

    $connection=mysqli_connect('localhost','root','','e_travel');
    if(!$connection)
        echo "connection failed";

/*_______DATABASE CONNECTION BLOCK END________*/ 

    session_start();
    ob_start();
    $record=10;
    $seat_number=40;
    $session_user_username ='etravel_user_username';
    $session_user_user_id='etravel_user_user_id';

    $session_admin_username='etravel_admin_username';
    $session_admin_id='etravel_admin_id';
    
/*_______COMMON FUNCTION________*/


    function website_navbar($active)
    {
        global $session_user_username;
        $username=is_logged_user()==true? "<b><u><i>".$_SESSION[$session_user_username]."</i></u></b>" : "User Login";
        echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">
              <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                  <a class="nav-item nav-link '.$active[0].' " href="index.php">Home <span class="sr-only">(current)</span></a>
                  <a class="nav-item nav-link '.$active[1].' " href="admin_login.php">Admin Login</a>
                  <a class="nav-item nav-link '.$active[2].' "" href="user_login.php">'.$username.'</a>
                  <a class="nav-item nav-link '.$active[3].' "" href="contact_us.php">Contact Us</a>
                </div>
              </div>
      </nav>
      <br><br>';
    }
    
    function receive_user_feedback()
    {
        global $connection;
        $name=strip_tags($_POST['name']);
        $mobile=strip_tags($_POST['mobile_no']);
        $mgs=strip_tags($_POST['mgs']);
        $date=date("y.m.d");
        $time=date('h:i:s A', time()+14400); 
        $date=$date." ".$time;
        $stmt = mysqli_prepare($connection, "insert into message values(NULL,?,?,?,?) ");
        mysqli_stmt_bind_param($stmt, "ssss", $name,$mobile,$mgs,$date);
        $result=mysqli_stmt_execute($stmt);
        if($result)
        {
           show_success_message("We received your message."); 
        }
        else
        {
            echo mysqli_error($connection);
        }
    }
    /*####Redirect to new Page####*/
    function redirect($address)
    {
        return header("Location: http://localhost/e_travel_management/$address");
    }

    /*####showing error message####*/
    function show_error_message($error)
    {
        echo'<div class="alert alert-danger" role="alert">'.$error.'</div>';
    }

    /*####showing success message####*/
    function show_success_message($success)
    {
        echo'<div class="alert alert-success" role="alert">'.$success.'</div>';
    }
    function info_view($info)
    {
        echo'<div class="alert alert-dark" role="alert">'.$info.'</div>';
    }
    /*####encrypt password####*/
    function encrypt($password)
    {
        $salt="bangladesh";
        return crypt($password,$salt);
    }

    /*####login verification###*/
    function bool_login_verification($username,$password,$table_name)
    {
        global $connection;
        $user_data=[-9999,""];
        $stmt = mysqli_prepare($connection, "SELECT * FROM $table_name WHERE username=? and password=?");
        mysqli_stmt_bind_param($stmt, "ss", $username,$password);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($read_result)==1)
        {
            $row=mysqli_fetch_row($read_result);
            $user_data[0]=$row[0];
            $user_data[1]=$username;
        }
        return $user_data;
    }
    function is_logged_in()
    {
        global $session_admin_username;
        return isset($_SESSION[$session_admin_username]);
    }
    function is_logged_user()
    {
        global $session_user_username;
        return isset($_SESSION[$session_user_username]);
    }

/*_____END OF COMMON FUNCTION____*/



?>