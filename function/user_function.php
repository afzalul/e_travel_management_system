<?php 
    
    include "function/common_function.php";
    
/*____START OF USER FUNCTION_____*/

   function get_user_session_id()
   {
       global $session_user_user_id;
       return $_SESSION[$session_user_user_id];
   }
   function set_user_session_id($user_id)
   {
       global $session_user_user_id;
       $_SESSION[$session_user_user_id]=$user_id;
   }
    function get_user_session_name()
   {
       global $session_user_username;
       return $_SESSION[$session_user_username];
   }
   function set_user_session_name($username)
   {
       global $session_user_username;
       $_SESSION[$session_user_username]=$username;
   }
/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     USER NAVIGATION BAR FUNCTION BLOCK                                |
  |                                                                                       | 
  |_______________________________________________________________________________________| */
    function user_navbar($active)
    {
        $username=get_user_session_name();
        echo '<div class="alert alert-success" role="alert" text-align:center>
            <h1>WELCOME '.$username.'</h1>
            </div>
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link '.$active[0].'" href="user_update.php">Update profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link '.$active[1].'" href="user_bookings.php">Bookings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link '.$active[2].'" href="index.php">Make Reservation</a>
          </li>
          <li class="nav-item">
            <a class="nav-link '.$active[3].'" href="user_search.php">Search</a>
          </li>
          <li class="nav-item">
            <a class="nav-link '.$active[4].'" href="user_notification.php">Notification</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="user_logout.php">Logout</a>
          </li>
        </ul>
        <br>';
    }

 /*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     USER LOGIN VERIFICATION FUNCTION BLOCK                            |
  |                                                                                       | 
  |_______________________________________________________________________________________| */   

    function login_verification_user()
    {
        global $connection;
        $username=strip_tags($_POST['username']);
        $password=strip_tags($_POST['password']);
        $password=encrypt($password);
        $user_data=bool_login_verification($username,$password,'user');
        if ( $user_data[0] >0 )//user_id
        {
            set_user_session_id($user_data[0]);
            set_user_session_name($user_data[1]);
            //print_r($_SESSION);
            redirect("user_notification.php"); 
        }
        else
        {
            show_error_message("Incorrect Username or Password");
        }   
    }

/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     USER PASSWORD RECOVER FUNCTION BLOCK                              |
  |                                                                                       | 
  |_______________________________________________________________________________________| */
    function reset_user_password()
    {
        global $connection;
        $username=strip_tags($_POST['username']);
        $mobile_no=strip_tags($_POST['mobile_no']);
        $password=strip_tags($_POST['password']);
        $confirm_password=strip_tags($_POST['confirm_password']);
        if($password!=$confirm_password)
        {
            show_error_message("Password mismatch.");
            return;
        }
        
        $stmt = mysqli_prepare($connection, "select * from user where username=? and mobile_no=? ");
        mysqli_stmt_bind_param($stmt, "ss", $username,$mobile_no);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($read_result)==1)
        {
            $password=encrypt($password);
            $stmt = mysqli_prepare($connection, "update user set password=? where username=?");
            mysqli_stmt_bind_param($stmt, "ss", $password,$username);
            $result=mysqli_stmt_execute($stmt);
            if(!$result)
            {
                show_error_message("Password Reset Failed.");
                return;
            }
            show_success_message("Password Reset Successful.");
        }
        else
        {
            show_error_message("No Data found.");
        }
    }
/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     USER SIGNUP FUNCTION BLOCK                                        |
  |                                                                                       | 
  |_______________________________________________________________________________________| */
    function insert_new_user()
    {
       global $connection;
       $re_password=strip_tags( $_POST['re_password'] );
       $password=strip_tags( $_POST['password'] );
       if($password!=$re_password)
       {
           show_error_message("Password mismatch");
           return;
       }
        $full_name=strip_tags($_POST['full_name']);
        $username=strip_tags($_POST['username']);
        $mobile_no=strip_tags($_POST['mobile_no']);
        
        $stmt = mysqli_prepare($connection, "SELECT * FROM user WHERE username=? or mobile_no=?");
        mysqli_stmt_bind_param($stmt, "ss", $username,$mobile_no);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        
        if( mysqli_num_rows($read_result)!=0)//username or mobile no already exist
        {
            show_error_message("Username already taken or mobile no registered");
            return;
        }
        $encrypted_password=encrypt($password);
        $stmt = mysqli_prepare($connection, "INSERT INTO user(name,username,password,mobile_no,account_status) VALUES (?,?,?,?,0) ");
        mysqli_stmt_bind_param($stmt, "ssss", $full_name,$username,$encrypted_password,$mobile_no);
        $insert_result=mysqli_stmt_execute($stmt);
        if(!$insert_result)
        {
            show_error_message("registration failed.");
            echo mysqli_error($connection);
            return;
        }
        show_success_message("Registration Succesful & Account will be active soon");
    }

/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     USER UPDATE FUNCTION BLOCK                                        |
  |                                                                                       | 
  |_______________________________________________________________________________________| */
    function update_user()
    {
        global $connection;
        $old_username=strip_tags(get_user_session_name());
        $user_id= (int) get_user_session_id();
        $old_password=strip_tags($_POST['old_password']);
        $new_username=strip_tags($_POST['new_username']);
        $new_password=strip_tags($_POST['new_password']);
        $confirm_new_password=strip_tags($_POST['confirm_new_password']);
        $old_password=encrypt($old_password);
        if($confirm_new_password!=$new_password)
        {
            show_error_message("New password mismatch");
            return;
        }
        $user_data=bool_login_verification($old_username,$old_password,'user');
        if($user_data[0] != $user_id)//invalid login
        {
            show_error_message("Wrong old password");
            return;
        } 
        if($old_username!=$new_username)
        {
            $stmt = mysqli_prepare($connection, "SELECT * FROM user WHERE username=?");
            mysqli_stmt_bind_param($stmt, "s", $new_username);
            mysqli_stmt_execute($stmt);
            $read_result=mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($read_result)!=0)
            {
                show_error_message("New username already taken");
                return;
            }
        }
        $new_password=encrypt($new_password);
        $stmt = mysqli_prepare($connection, "UPDATE user SET username=?,password=? WHERE user_id=?");
        mysqli_stmt_bind_param($stmt, "sss", $new_username,$new_password,$user_id);
        $update_result=mysqli_stmt_execute($stmt);
        if(!$update_result)
        {
            show_error_message("Update failed");
            return;
        }
        set_user_session_name($new_username);
        show_success_message("Update successful");
        
        $update_date_time=date("y.m.d")." ".date('h:i:s A', time()+14400);
        
        $message="You Have Updated Your Profile At ".$update_date_time;
        $query="insert into user_notification values(NULL,$user_id,0,'$message') ";
        $result=mysqli_query($connection,$query);       
    }
/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     USER NOTIFICATION FUNCTION BLOCK                                  |
  |                                                                                       | 
  |_______________________________________________________________________________________| */

    function read_notification($page)
    {
        global $connection,$record;
        $page*=$record;
        $user_id=get_user_session_id();
        $query="select * from user_notification where user_id=$user_id order by id desc limit $page,$record";
        $result=mysqli_query($connection,$query);
        if(!$result)
        {
            show_error_message("failed.");
            echo mysqli_error($connection);
            return;
        }
        $isempty=mysqli_num_rows($result);
        if($isempty==0)
        {
            echo '<br><br><h4 align="center">No Notification</h4>';
            return;
        }
         echo '<br><br>
         <form action="user_notification.php" method="post">
        <table border="1" width=100%>
            <tr>
                <th>SN</th>
                <th>Message</th>
                <th> <input type="submit" name="DELETE" class="btn btn-primary" value="DELETE"> </th>
            </tr>';
        $i=1;
        while($row=mysqli_fetch_row($result))
        {
            echo'<tr>
                <td>'.$i.'</td>
                <td>'.$row[3].'</td>
                <td><input class="form-check-input" type="checkbox" name="selected_id[]" value="'.$row[0].'"></td>
            </tr>';
            $i++;
        } 
        echo'</table><br><br>
        </form>';  
    }
    
    function delete_user_notification()
    {
        $delete_id=$_POST['selected_id'];  
        global $connection;
        foreach($delete_id as $id ) 
        {
            $query="delete from user_notification where id=$id ";
            $result=mysqli_query($connection,$query);
            if(!$result)
                break; 
        }
        redirect("user_notification.php");
    }
/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     USER BOOKINGS FUNCTION BLOCK                                      |
  |                                                                                       | 
  |_______________________________________________________________________________________| */

    function read_user_bookings($page)
    {
        global $connection,$record;
        $page*=$record;
        $user_id=get_user_session_id();
        $query="select bookings.booking_id, bookings.user_id, dsb.number, dsb.route, dsb.company, dsb.type, dsb.date, dsb.time from bookings INNER JOIN (SELECT ds.id, bus_info.number, ds.route, bus_info.company, bus_info.type, ds.date, ds.time FROM daily_schedule as ds inner join bus_info on ds.bus_id=bus_info.id order by ds.id desc) as dsb on dsb.id=bookings.schedule_id where user_id=$user_id order by booking_id desc limit $page,$record ";
        $result=mysqli_query($connection,$query);
        fetch_row_user_bookings($result);  
    }
    
    function search_user_bookings()
    {
        global $connection;
        $date=$_POST['date'];
        $user_id=get_user_session_id();
        $query="select bookings.booking_id, bookings.user_id, dsb.number, dsb.route, dsb.company, dsb.type, dsb.date, dsb.time from bookings INNER JOIN (SELECT ds.id, bus_info.number, ds.route, bus_info.company, bus_info.type, ds.date, ds.time FROM daily_schedule as ds inner join bus_info on ds.bus_id=bus_info.id order by ds.id desc) as dsb on dsb.id=bookings.schedule_id where user_id=$user_id and date='$date' order by booking_id desc";
        $result=mysqli_query($connection,$query);
        fetch_row_user_bookings($result); 
    }

    function fetch_row_user_bookings($result)
    {
        if(!$result)
        {
            show_error_message("failed");
            return;
        }
        if(mysqli_num_rows($result)==0)
        {
            echo '<h2 align="center">You Have No Bookings</h2>';
            return;
        }
        echo '<table border="1" width=60%>
        <tr>
            <th >Bus number</th>
            <th>Route</th>
            <th>Company</th>
            <th>Type</th>
            <th>Date</th>
            <th>Time</th>
            <th>   </th>
        </tr>';
        while ($row = mysqli_fetch_assoc($result))
        {
            $disable_value= (time()+86400) < strtotime($row['date']) ? "" : "disabled";
            echo '
            <tr>
                <td>'.$row['number'].'</td>
                <td>'.$row['route'].'</td>
                <td>'.$row['company'].'</td>
                <td>'.$row['type'].'</td>
                <td>'.$row['date'].'</td>
                <td>'.$row['time'].'</td>
                <td>
                    <form action="user_bookings.php" method="post">
                          <input type="text" name="booking_id" class="form-control" value="'.$row['booking_id'].'" hidden>
                          <input type="submit" name="Cancel" class="btn btn-primary" value="Cancel"'. $disable_value.'>
                    </form>
                </td>
            </tr>';
        } 
        echo'</table><br><br>';
    }

    function cancel_user_bookings()
    {
        global $connection;
        $booking_id=$_POST['booking_id'];

        $query="select schedule_id from bookings where booking_id=$booking_id ";
        $result=mysqli_query($connection,$query);
        $row=mysqli_fetch_row($result);
        $schedule_id=$row[0];

        $query="delete from bookings where booking_id=$booking_id ";
        $result=mysqli_query($connection,$query);
        if($result)
        {
            $query="update daily_schedule set total_seat_available=total_seat_available+1 where id=$schedule_id ";
            $result=mysqli_query($connection,$query);  
        }
        redirect("user_bookings.php");  
    }

/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     USER SEARCH FUNCTION BLOCK                                        |
  |                                                                                       | 
  |_______________________________________________________________________________________| */

    function find_info()
    {
        global $connection;
        $option=$_POST['option'];
        $search=strip_tags($_POST['search']);
        $user_id=get_user_session_id();
        $search_date_time=date("y.m.d")." ".date('h:i:s A', time()+14400);
        $message="You Have Searched Into ".$option." For Keyward=".$search."<br>Search date and time = ".$search_date_time;
        $query="insert into user_notification values(NULL,$user_id,0,'$message') ";
        $result=mysqli_query($connection,$query);
        $stmt="";
        if($option=="driver_info")
        {
            $stmt = mysqli_prepare($connection, "SELECT * FROM driver_info where name like CONCAT( '%',?,'%') or company like CONCAT( '%',?,'%') or experiance like CONCAT( '%',?,'%') ");
        }
        else
        {
            $stmt = mysqli_prepare($connection, "SELECT * FROM bus_info where number like CONCAT( '%',?,'%') or company like CONCAT( '%',?,'%') or type like CONCAT( '%',?,'%') ");
        }
        mysqli_stmt_bind_param($stmt, "sss", $search,$search,$search);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        
        if(!$result)
        {
            show_error_message("search failed.");
            echo mysqli_error($connection);
            return;
        }
        echo '<table border="1" width=60%>
            <tr>';
        if($option=="driver_info")
        {
            echo'<th >Name</th>
                <th>Company</th>
                <th>Experience</th>
            </tr>';
        }
        else
        {
            echo '<th >Bus number</th>
                <th>Type</th>
                <th>Company</th>
            </tr>';
            
        }
        while ($row = mysqli_fetch_row($result))
        {
            echo '
            <tr>
                <td>'.$row[1].'</td>
                <td>'.$row[2].'</td>
                <td>'.$row[3].'</td>
            </tr>';
        } 
        echo'</table><br><br>'; 
    }
/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     USER MAKE RESERVATION FUNCTION BLOCK                              |
  |                                                                                       | 
  |_______________________________________________________________________________________| */

    function search()
    {
        global $connection;
        $user_id=get_user_session_id();
        $route=strip_tags($_GET['route']);
        $date=strip_tags($_GET['date']);
        $type=strip_tags($_GET['type']);
        info_view("<h2 align="."center".">Available Bus list</h2>");
        
        $stmt = mysqli_prepare($connection, "SELECT ds.id, bus_info.number, ds.route, bus_info.company, bus_info.type, ds.date, ds.time, ds.total_seat_available FROM daily_schedule as ds inner join bus_info on ds.bus_id=bus_info.id where route=? and date=? and type=? order by ds.id desc");
        mysqli_stmt_bind_param($stmt, "sss", $route,$date,$type);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        
        if(!$read_result)
        {
            show_error_message("Search failed.");
            echo mysqli_error($connection);
            return;
        }
        if(mysqli_num_rows($read_result)==0)
        {
            info_view("<h3 align="."center".">No Bus Found.</h3>");
            return;
        }
        while ($row = mysqli_fetch_row($read_result))
        {
            $seat=$row[7];
            if($seat==0)
            {
                continue;
            }
            $query="select * from bookings where schedule_id=$row[0] and user_id=$user_id ";
            $read=mysqli_query($connection,$query);
            $book=mysqli_num_rows($read);
            $message_str="<br>Avaliable Seat=".$seat;
            //if($seat==0)
                //$message_str="<br>No seat Avaliable";
             if($book==1)
                $message_str="<br><u><b>You Have booked 1 Seat.</b></u>";

            info_view("Bus number=".$row[1]."<br>Route=".$row[2]."<br>Company=".$row[3]."<br>Type=".$row[4]."<br>Date=".$row[5]."<br>Time=".$row[6].$message_str);
            
            if($seat>=1 && $book==0)
            {
                echo '<form action="make_reservation.php" method="post">
                          <input type="text" name="bus_number" class="form-control" value="'.$row[1].'" hidden>
                          <input type="text" name="date" class="form-control" value="'.$row[5].'" hidden>
                          <input type="text" name="time" class="form-control" value="'.$row[6].'" hidden>
                          <input type="text" name="route" class="form-control" value="'.$row[2].'" hidden>
                          <input type="text" name="type" class="form-control" value="'.$row[4].'" hidden>
                          <input type="text" name="schedule_id" class="form-control" value="'.$row[0].'" hidden>
                          <input type="submit" name="book" class="btn btn-primary" value="Book">
                </form><br>';
            }
        
        }
    }

    function confirm_bookings_details()
    {
        global $connection;
        $user_id=get_user_session_id();
        $bus_number=$_POST['bus_number'];
        $date=$_POST['date'];
        $time=$_POST['time'];
        $route=$_POST['route'];
        $type=$_POST['type'];
        $schedule_id=$_POST['schedule_id'];

        $query="select total_seat_available from daily_schedule where id=$schedule_id ";
        $result=mysqli_query($connection,$query);
        $row=mysqli_fetch_row($result);
        if($row[0]==0)
        {
            redirect("search_bus_schedule.php?route=".$route."&date=".$date."&type=".$type);
            return;
        }
        $query="insert into bookings values(NULL,$user_id,$schedule_id)";
        $result=mysqli_query($connection,$query);
        
        $query="update daily_schedule set total_seat_available=total_seat_available-1 where id=$schedule_id ";
        $result=mysqli_query($connection,$query);
        
        $booking_date_time=date("y.m.d")." ".date('h:i:s A', time()+14400);
        
        $message="You Have Booked a Seat in <br>Bus Number=".$bus_number."<br>Route=".$route."<br>Date=".$date."<br>Time=".$time."<br><b><i>Booking date and time = ".$booking_date_time."</i></b>";
        $query="insert into user_notification values(NULL,$user_id,0,'$message')";
        $result=mysqli_query($connection,$query);
        if($result)
        {
            redirect("user_bookings.php");
        }
        else
        {
            echo mysqli_error($connection);
        } 
    }

?>