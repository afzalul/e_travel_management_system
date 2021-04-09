<?php 
    include "function/common_function.php";

   function get_admin_session_name()
   {
       global $session_admin_username;
       return $_SESSION[$session_admin_username];
   }
   function set_admin_session_name($admin_username)
   {
       global $session_admin_username;
       $_SESSION[$session_admin_username]=$admin_username;
   }

    function get_admin_session_id()
   {
       global $session_admin_id;
       return $_SESSION[$session_admin_id];
   }
   function set_admin_session_id($admin_id)
   {
       global $session_admin_id;
       $_SESSION[$session_admin_id]=$admin_id;
   }
    function login_verification_admin()
    {
        global $connection;
        $username=strip_tags($_POST['username']);
        $password=strip_tags($_POST['password']);
        $password=encrypt($password);
        $admin_data=bool_login_verification($username,$password,'admin');
        if ( $admin_data[0] >0 )
        {
            set_admin_session_id($admin_data[0]);
            set_admin_session_name($admin_data[1]);
            redirect("admin_feedback.php");
        }
        else
        {
            show_error_message("Incorrect Username or Password");
        }   
    }
/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     ADMIN UPDATE FUNCTION BLOCK                                       |
  |                                                                                       | 
  |_______________________________________________________________________________________| */
    function update_admin()
    {
        global $connection;
        $admin_id=get_admin_session_id();
        $old_username=strip_tags(get_admin_session_name());
        $old_password=strip_tags($_POST['old_password']);
        $new_username=strip_tags($_POST['new_username']);
        $new_password=strip_tags($_POST['new_password']);
        $confirm_new_password=strip_tags($_POST['confirm_new_password']);
        $old_password=encrypt($old_password);
        $admin_data=bool_login_verification($old_username,$old_password,'admin');
        if($admin_id!=$admin_data[0])//invalid login
        { 
            show_error_message("Wrong old username or password");
            return;
        }
        if($confirm_new_password!=$new_password)
        {
            show_error_message("New password mismatch");
            return;
        }
        if($old_username!=$new_username)
        {
            $stmt = mysqli_prepare($connection, "SELECT * FROM admin WHERE username=?");
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
        $stmt = mysqli_prepare($connection, "UPDATE admin SET username=?,password=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sss", $new_username,$new_password,$admin_id);
        $update_result=mysqli_stmt_execute($stmt);

        if(!$update_result)
        {
            show_error_message("Update failed");
            return;
        }
        set_admin_session_name($new_username);
        show_success_message("Update successful");
    }
    
/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     ADMIN ADD FUNCTION BLOCK                                          |
  |                                                                                       | 
  |_______________________________________________________________________________________| */
    function insert_new_admin()
    {
         global $connection;
        $re_password= strip_tags($_POST['re_password']) ;
        $password= strip_tags($_POST['password'] ) ;
       if($password!=$re_password)
       {
           show_error_message("Password mismatch");
           return;
       }
        $full_name=strip_tags($_POST['full_name']);
        $username=strip_tags($_POST['username']);

        $stmt = mysqli_prepare($connection, "SELECT * FROM admin WHERE username=?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($read_result)!=0)//username already taken
        {
            show_error_message("Username already taken,Please enter another Username.");
            return;
        }
        $encrypted_password=encrypt($password);
        $stmt = mysqli_prepare($connection, "INSERT INTO admin(name,username,password) VALUES (?,?,?)");
        mysqli_stmt_bind_param($stmt, "sss", $full_name,$username,$encrypted_password);
        $insert_result=mysqli_stmt_execute($stmt);

        if($insert_result)
        {
            show_success_message("Registration Succesful.");
        }
        else
        {
            show_error_message("registration failed.");
        }
    }

/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     ADMIN DRIVER FUNCTION BLOCK                                       |
  |                                                                                       | 
  |_______________________________________________________________________________________| */

    function read_driver_list($page)
    {
        global $connection,$record;
        $page*=$record;
        $query="SELECT * FROM driver_info limit $page,$record";
        $read_result = mysqli_query($connection,$query);
        if(!$read_result)
        {
            show_error_message("Read failed.");
            echo mysqli_error($connection);
            return;
        }
        fetch_row_driver($read_result);
    }

    function search_driver()
    {
        global $connection;
        $search=strip_tags($_POST['search']);
        $stmt = mysqli_prepare($connection, "select * from driver_info where name like concat('%',?,'%') or company like concat('%',?,'%') or admin_id like concat('%',?,'%') ");
        mysqli_stmt_bind_param($stmt, "sss", $search,$search,$search);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        
        if(!$read_result)
        {
            show_error_message("Search failed.");
            echo mysqli_error($connection);
            return;
        }
        fetch_row_driver($read_result);
    }
    
    function fetch_row_driver($read_result)
    {
        echo '<form action="driver_list.php" method="post">
        <table border="1" width=60%>
         <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Company</th>
            <th>Experience(year)</th>
            <th>Admin ID</th>
            <th><input type="submit" name="delete" class="btn btn-primary" value="Delete"></th>
            <th> </th>
        </tr>';   
        while ($row = mysqli_fetch_row($read_result))
        {
            echo '
            <tr>
                <td >'.$row[0].'</td>
                <td>'.$row[1].'</td>
                <td>'.$row[2].'</td>
                <td>'.$row[3].'</td>
                <td>'.$row[4].'</td>
                <td><input class="form-check-input" type="checkbox" name="selected_driver_id[]" value="'.$row[0].'"></td>
                <td><a href="driver_edit.php?id='.$row[0].'&name='.$row[1].'&company='.$row[2].'&experience='.$row[3].'">Edit</a></td>
            </tr>';

        } 
        echo'</table><br><br>
        </form>';  
    }

    function insert_new_driver()
    {
        global $connection;
        $name=strip_tags($_POST['name']);
        $company=strip_tags($_POST['company']);
        $experience=strip_tags($_POST['exp']);
        $admin_id=strip_tags(get_admin_session_id());
        $stmt = mysqli_prepare($connection, "insert into driver_info(name,company,experiance,admin_id) values(?,?,?,?) ");
        mysqli_stmt_bind_param($stmt, "ssss", $name,$company,$experience,$admin_id);
        $success_result=mysqli_stmt_execute($stmt);
        if($success_result)
        {
            show_success_message("Insert Succesful.");
            header( "refresh:2;url=driver_list.php" );
        }
        else
        {
            show_error_message("Insert failed.");
            echo mysqli_error($connection);
        }
    }

    function update_driver()
    {
        global $connection;
        $id=strip_tags($_POST['id']);
        $name=strip_tags($_POST['name']);
        $company=strip_tags($_POST['company']);
        $exp=strip_tags($_POST['exp']);
        $stmt = mysqli_prepare($connection, "update driver_info set name=?,company=?,experiance=? where id=? ");
        mysqli_stmt_bind_param($stmt, "sssi", $name,$company,$exp,$id);
        $success_result=mysqli_stmt_execute($stmt);
                
        if($success_result)
        {
            show_success_message("Update Succesful.");
            header( "refresh:2;url=driver_list.php" );
            //redirect("driver_list.php");
        }
        else
        {
            show_error_message("Update failed.");
            //echo mysqli_error($connection);
        }
    }
    
    function delete_driver()
    {
        global $connection;
        $selected_driver_id=$_POST['selected_driver_id'];
        foreach($selected_driver_id as $driver_id)
        {
            $query="delete from driver_info where id=$driver_id ";
            $result=mysqli_query($connection,$query);
        }
        redirect("driver_list.php");
    }
/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     ADMIN BUS FUNCTION BLOCK                                          |
  |                                                                                       | 
  |_______________________________________________________________________________________| */
    function read_bus_list($page)
    {
        global $connection,$record;
        $page*=$record;
        $query="SELECT * FROM bus_info limit $page,$record ";
        $read_result = mysqli_query($connection,$query);
        if(!$read_result)
        {
            show_error_message("Read failed.");
            echo mysqli_error($connection);
            return;
        }   
        fetch_row_bus($read_result);
    }

    function search_bus()
    {
        global $connection;
        $search=strip_tags($_POST['search']);
        $stmt = mysqli_prepare($connection, "select * from bus_info where number like concat('%',?,'%')  or company like concat('%',?,'%')  or type like concat('%',?,'%')  or admin_id like concat('%',?,'%') ");
        mysqli_stmt_bind_param($stmt, "ssss", $search,$search,$search,$search);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        
        if(!$read_result)
        {
            show_error_message("Search failed.");
            echo mysqli_error($connection);
            return;
        }
        fetch_row_bus($read_result); 
    }
    
    function fetch_row_bus($read_result)
    {
        echo '<form action="bus_list.php" method="post">
        <table border="1" width=60% >
         <tr>
            <th>ID</th>
            <th>Number</th>
            <th>Type</th>
            <th>Company</th>
            <th>Admin ID</th>
            <th><input type="submit" name="delete" class="btn btn-primary" value="Delete"></th>
            <th> </th>
        </tr>';
        while ($row = mysqli_fetch_row($read_result))
        {
            echo '
            <tr>
                <td>'.$row[0].'</td>
                <td>'.$row[1].'</td>
                <td>'.$row[2].'</td>
                <td>'.$row[3].'</td>
                <td>'.$row[4].'</td>
                <td><input class="form-check-input" type="checkbox" name="selected_bus_number[]" value="'.$row[0].'"></td>
                <td><a href="bus_edit.php?bus_id='.$row[0].'&bus_number='.$row[1].'&type='.$row[2].'&company='.$row[3].'">Edit</a></td>
            </tr>';
        } 
        echo'</table><br><br>
        </form>'; 
    }
    function insert_new_bus()
    {
        global $connection;
        $number=strip_tags($_POST['number']);
        $company=strip_tags($_POST['company']);
        $type=strip_tags($_POST['type']);
        $admin_id=strip_tags(get_admin_session_id());
        
        $stmt = mysqli_prepare($connection, "select * from bus_info where number=?");
        mysqli_stmt_bind_param($stmt, "s", $number);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($read_result)!=0)
        {
            show_error_message("Bus already exist in DB.");
            return;
        }
            
        $stmt = mysqli_prepare($connection, "insert into bus_info(number,type,company,admin_id) values(?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "ssss", $number,$type,$company,$admin_id);
        $insert_result=mysqli_stmt_execute($stmt);

        if($insert_result)
        {
            show_success_message("Insert Succesful.");
            header( "refresh:1;url=bus_list.php" );
        }
        else
        {
            show_error_message("Insert failed.");
            //echo mysqli_error($connection);
        }
    }
    
    function update_bus()
    {
        global $connection;
        $bus_id=strip_tags($_POST['bus_id']);
        $number=strip_tags($_POST['bus_number']);
        $company=strip_tags($_POST['company']);
        $type=strip_tags($_POST['type']);
        
        $find_stmt = mysqli_prepare($connection, "select id from bus_info where number=? ");
        mysqli_stmt_bind_param($find_stmt, "s", $number);
        mysqli_stmt_execute($find_stmt);
        $read_result=mysqli_stmt_get_result($find_stmt);
        if(mysqli_num_rows($read_result)!=0)
        {
            $row=mysqli_fetch_row($read_result);
            if($bus_id!=$row[0])
            {
                show_error_message("Bus already exist in DB.");
                return;
            }
        }
        $stmt = mysqli_prepare($connection, "update bus_info set type=?,company=?,number=? where id=? ");
        mysqli_stmt_bind_param($stmt, "sssi", $type,$company,$number,$bus_id);
        $update_result=mysqli_stmt_execute($stmt);
        
        if($update_result)
        {
            show_success_message("Update successful.");
            header( "refresh:1;url=bus_list.php" );
        }
        else
        {
            show_error_message("update failed.");
            echo mysqli_error($connection);
        }
    }
    
    function delete_bus()
    {
        global $connection;
        $selected_bus_id=$_POST['selected_bus_number'];
        foreach($selected_bus_id as $bus_id)
        {
            $stmt = mysqli_prepare($connection, "delete from bus_info where id=?");
            mysqli_stmt_bind_param($stmt, "s", $bus_id);
            mysqli_stmt_execute($stmt);
        }
        redirect("bus_list.php"); 
    }

/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     ADMIN SCHEDULE FUNCTION BLOCK                                     |
  |                                                                                       | 
  |_______________________________________________________________________________________| */

    function insert_new_schedule()
    {
        global $connection,$seat_number;
        $bus_number=strip_tags($_POST['bus_number']);
        $stmt = mysqli_prepare($connection, "select * from bus_info where number=? ");
        mysqli_stmt_bind_param($stmt, "s", $bus_number);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($read_result)==0)
        {
            show_error_message("Bus number Doesn't Exist in bus_info Table");
            return;
        }
        $bus_data=mysqli_fetch_row($read_result);
        $route=strip_tags($_POST['start'])."-".strip_tags($_POST['end']);
        $date=strip_tags($_POST['date']);
        $time=strip_tags($_POST['time']);
        $admin_id=strip_tags(get_admin_session_id());

        $stmt = mysqli_prepare($connection, "select * from daily_schedule where bus_id=? and date=?");
        mysqli_stmt_bind_param($stmt, "ss", $bus_data[0],$date);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result)!=0)
        {
            show_error_message("Bus number & Date already in Schedule.");
            return;
        }
        $stmt = mysqli_prepare($connection, "insert into daily_schedule(bus_id,route,date,time,total_seat_available,admin_id) values(?,?,?,?,$seat_number,?)" );
        mysqli_stmt_bind_param($stmt, "sssss", $bus_data[0],$route,$date,$time,$admin_id);
        $result=mysqli_stmt_execute($stmt);

        if($result)
        {
            show_success_message("Succesfully Added");
        }
        else
        {
            show_error_message("Add failed.");
            echo mysqli_error($connection);
        }
    }
    function notify_user_about_schedule_change($prevous_bus_number,$bus_number,$prevous_time,$time,$route,$date,$schedule_id)
    {
        global $connection;
        
        $message='<h3 style="color:red;">You Booking details changed</h3> <br>Previous Bus Number='.$prevous_bus_number.'  <i style="color:red;">New Bus Number='.$bus_number.'</i><br>Route='.$route.'<br>Date='.$date.'<br>Previous Time='.$prevous_time.'  <i style="color:red;">New Time='.$time.'</i>';
        
        $query="select user_id from bookings where schedule_id=$schedule_id";
        $read_result=mysqli_query($connection,$query);
        while($row=mysqli_fetch_row($read_result))
        {
            $query="insert into user_notification values(NULL,$row[0],0,'$message')";
            $result=mysqli_query($connection,$query);
        }
        
    }
    function update_schedule()
    {
        global $connection;
        $schedule_id=strip_tags($_POST['schedule_id']);
        $bus_number=strip_tags($_POST['bus_number']);
        $route=strip_tags($_POST['route']);
        $date=strip_tags($_POST['date']);
        $time=strip_tags($_POST['time']);
        
        $stmt = mysqli_prepare($connection, "select bus_info.number,daily_schedule.time from bus_info inner join daily_schedule on bus_info.id=daily_schedule.bus_id WHERE daily_schedule.id=? ");
        mysqli_stmt_bind_param($stmt, "i", $schedule_id);
        mysqli_stmt_execute($stmt);
        $read_result_dbs=mysqli_stmt_get_result($stmt);
        $row=mysqli_fetch_row($read_result_dbs);
        $prevous_bus_number=$row[0];
        $prevous_time=$row[1];
        
        if($prevous_bus_number==$bus_number and $prevous_time==$time)
        {
            show_success_message("Succesfully updated");
            return;
        }
        $stmt = mysqli_prepare($connection, "select * from bus_info where number=?");
        mysqli_stmt_bind_param($stmt, "s", $bus_number);
        mysqli_stmt_execute($stmt);
        $read_result_bus=mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($read_result_bus)==0)
        {
            show_error_message("Bus doesn't exist in Bus table");
            return;
        }
        $row_bus=mysqli_fetch_row($read_result_bus);
        
        if($row_bus[1]!=$bus_number)
        {
            $stmt = mysqli_prepare($connection, "select * from daily_schedule where date=? and time=? and bus_id=? ");
            mysqli_stmt_bind_param($stmt, "ssi", $date,$time,$row_bus[0]);
            mysqli_stmt_execute($stmt);
            $read_result_ds=mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($read_result_ds)>=1)
            {
                show_error_message("Bus number & Date already in Schedule.");
                return;
            }
        }
        $stmt = mysqli_prepare($connection, "update daily_schedule set bus_id=?,route=?,date=?,time=? where id=? ");
        mysqli_stmt_bind_param($stmt, "issss", $row_bus[0],$route,$date,$time,$schedule_id);
        $result=mysqli_stmt_execute($stmt);
        
        if($result)
        {
            show_success_message("Succesfully updated");
            notify_user_about_schedule_change($prevous_bus_number,$bus_number,$prevous_time,$time,$route,$date,$schedule_id);
        }
        else
        {
            show_error_message("update failed.");
            echo mysqli_error($connection);
        }
    }

    function read_schedule($page)
    {
        global $connection,$record;
        $page*=$record;
        $query="SELECT ds.id, bus_info.number, ds.route, bus_info.company, bus_info.type, ds.date, ds.time, ds.total_seat_available, ds.admin_id FROM daily_schedule as ds inner join bus_info on ds.bus_id=bus_info.id order by ds.id desc limit $page,$record ";
        $read_result = mysqli_query($connection,$query);
        if(!$read_result)
        {
            show_error_message("Read failed.");
            echo mysqli_error($connection);
            return;
        }
        fetch_row_schedule($read_result);
    }

    function search_schedule()
    {
        global $connection;
        $route=strip_tags($_POST['route']);
        $date=strip_tags($_POST['date']);
        
        $stmt = mysqli_prepare($connection, "SELECT ds.id, bus_info.number, ds.route, bus_info.company, bus_info.type, ds.date, ds.time, ds.total_seat_available, ds.admin_id FROM daily_schedule as ds inner join bus_info on ds.bus_id=bus_info.id where route like concat('%',?,'%') and date like concat('%',?,'%') ");
        mysqli_stmt_bind_param($stmt, "ss", $route,$date);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        
        if(!$read_result)
        {
            show_error_message("Search failed.");
            echo mysqli_error($connection);
            return;
        }
        fetch_row_schedule($read_result);
    }
    function fetch_row_schedule($read_result)
    {
        echo '<form action="admin_schedule.php" method="post">
        <table border="1" width=60%>
         <tr>
            <th>ID</th>
            <th>Bus number</th>
            <th>Route</th>
            <th>Company</th>
            <th>Type</th>
            <th>Date</th>
            <th>Time</th>
            <th>Seat Available</th>
            <th>Admin ID</th>
            <th><input type="submit" name="delete" class="btn btn-primary" value="Delete"></th>
            <th> </th>
        </tr>';
        while ($row = mysqli_fetch_row($read_result))
        {
            echo '<tr>
                    <td>'.$row[0].'</td>
                    <td>'.$row[1].'</td>
                    <td>'.$row[2].'</td>
                    <td>'.$row[3].'</td>
                    <td>'.$row[4].'</td>
                    <td>'.$row[5].'</td>
                    <td>'.$row[6].'</td>
                    <td>'.$row[7].'</td>
                    <td>'.$row[8].'</td>
                    <td><input class="form-check-input" type="checkbox" name="selected_schedule_id[]" value="'.$row[0].'"></td>
                    <td><a href="admin_schedule_edit.php?schedule_id='.$row[0].'&bus_number='.$row[1].'&route='.$row[2].'&date='.$row[5].'&time='.$row[6].'">Edit</a></td>
                </tr>';
        } 
        echo'</table><br><br>
        </form>';
    }

    function delete_schedule()
    {
        global $connection;
        $selected_schedule_id=$_POST['selected_schedule_id'];
        foreach($selected_schedule_id as $schedule_id)
        {
            $query="delete from daily_schedule where id=$schedule_id";
            $result = mysqli_query($connection,$query);
        }
        redirect("admin_schedule.php");
    }
/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     ADMIN USER BOOKINGS FUNCTION BLOCK                                |
  |                                                                                       | 
  |_______________________________________________________________________________________| */

    function read_bookings($page)
    {
        global $connection,$record;
        $page*=$record;
        $query="select bookings.booking_id, bookings.user_id, dsb.number, dsb.route, dsb.company, dsb.type, dsb.date, dsb.time from bookings INNER JOIN (SELECT ds.id, bus_info.number, ds.route, bus_info.company, bus_info.type, ds.date, ds.time FROM daily_schedule as ds inner join bus_info on ds.bus_id=bus_info.id) as dsb on dsb.id=bookings.schedule_id order by booking_id desc limit $page,$record ";
        $result=mysqli_query($connection,$query);
        if(!$result)
        {
            show_error_message("Search failed.");
            echo mysqli_error($connection);
            return;
        }
        fetch_row_bookings($result);
    }

    function search_bookings()
    {
        global $connection;
        $bus_number=strip_tags($_POST['bus_number']);
        $date=strip_tags($_POST['date']);
        
        $stmt = mysqli_prepare($connection, "select bookings.booking_id, bookings.user_id, dsb.number, dsb.route, dsb.company, dsb.type, dsb.date, dsb.time from bookings INNER JOIN (SELECT ds.id, bus_info.number, ds.route, bus_info.company, bus_info.type, ds.date, ds.time FROM daily_schedule as ds inner join bus_info on ds.bus_id=bus_info.id) as dsb on dsb.id=bookings.schedule_id where number like concat('%',?,'%')  and date like concat('%',?,'%') order by booking_id desc ");
        mysqli_stmt_bind_param($stmt, "ss", $bus_number,$date);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        
        if(!$read_result)
        {
            show_error_message("Search failed.");
            echo mysqli_error($connection);
            return;
        }
        $total=mysqli_num_rows($read_result);
        echo '<h3 style="text-align:center"><b>Total Seat Booked='.$total.'</b></h3>';
        fetch_row_bookings($read_result);
    }
    
    function fetch_row_bookings($read_result)
    {
        echo '<table border="1" width=60%>
         <tr>
            <th>Booking ID</th>
            <th>User_id</th>
            <th>Bus number</th>
            <th>Route</th>
            <th>Company</th>
            <th>Type</th>
            <th>Date</th>
            <th>Time</th>
        </tr>';
        while ($row = mysqli_fetch_assoc($read_result))
        {
            echo '<tr>
                    <td>'.$row['booking_id'].'</td>
                    <td>'.$row['user_id'].'</td>
                    <td>'.$row['number'].'</td>
                    <td>'.$row['route'].'</td>
                    <td>'.$row['company'].'</td>
                    <td>'.$row['type'].'</td>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['time'].'</td>
                </tr>';
        } 
        echo'</table><br><br>'; 
    }

/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     ADMIN USER JOIN REQUEST FUNCTION BLOCK                            |
  |                                                                                       | 
  |_______________________________________________________________________________________| */


    function total_request()
    {
        global $connection;
        $query="select * from user where account_status=0"; 
        $result=mysqli_query($connection,$query);
        return mysqli_num_rows($result);
    }

    function read_join_request($page)
    {
        global $connection,$record;
        $page*=$record;
        $query="select * from user where account_status=0 limit $page,$record "; 
        $read_result=mysqli_query($connection,$query);
        if(!$read_result)
        {
            show_error_message("read failed.");
            echo mysqli_error($connection);
            return;
        }
        fetch_row_join_request($read_result);
    }

    function search_join_request()
    {
        global $connection;
        $search=strip_tags($_POST['search']);
        
        $stmt = mysqli_prepare($connection, "select * from user where account_status=0 and (username like concat('%',?,'%') or name like concat('%',?,'%') or mobile_no like concat('%',?,'%') or user_id like concat('%',?,'%') )");
        mysqli_stmt_bind_param($stmt, "sssi", $search,$search,$search,$search);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
    
        if(!$read_result)
        {
            show_error_message("Search failed.");
            echo mysqli_error($connection);
            return;
        }
        fetch_row_join_request($read_result);
    }
    
    function fetch_row_join_request($read_result)
    {
        echo '<form action="admin_user_join_request.php" method="post">
        <table border="1" width=60%>
         <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Password</th>
            <th>Mobile No</th>
            <th>
                <select name="operation">
                  <option value="add">ADD</option>
                  <option value="delete">DELETE</option>
                </select>
                <input type="submit" name="DO" class="btn btn-primary" value="DO">
            </th>
        </tr>';
        while ($row = mysqli_fetch_row($read_result))
        {
            echo '<tr>
                    <td>'.$row[0].'</td>
                    <td>'.$row[1].'</td>
                    <td>'.$row[2].'</td>
                    <td>'.$row[3].'</td>
                    <td>'.$row[4].'</td>
                    <td><input class="form-check-input" type="checkbox" name="selected_id[]" value="'.$row[0].'"></td>
                </tr>';
        } 
        echo'</table><br><br>
        </form>';  
    }

    function add_or_delete_join_request()
    {
        $operation=$_POST['operation'];
        echo $operation;
        $selected_id=$_POST['selected_id'];
        global $connection;
        foreach($selected_id as $id)
        {
            if($operation=="delete") 
            {
                $query="delete from user where user_id=$id and account_status=0 "; 
                $result=mysqli_query($connection,$query);
            }
            else if($operation=="add")
            {
                $query1="update user set account_status=1 where user_id=$id ";
                $read_result=mysqli_query($connection,$query1);

            }
            
        }
        //echo mysqli_error($connection);
        redirect("admin_user_join_request.php");
    }

/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     ADMIN USER FUNCTION BLOCK                                         |
  |                                                                                       | 
  |_______________________________________________________________________________________| */


    function read_user($page)
    {
        global $connection,$record;
        $page*=$record;
        $query="select * from user where account_status=1 limit $page,$record "; 
        $read_result=mysqli_query($connection,$query);
        if(!$read_result)
        {
            show_error_message("read failed.");
            echo mysqli_error($connection);
            return;
        }
        fetch_row_user_list($read_result);
    }

    function search_user()
    {
        global $connection;
        $search=strip_tags($_POST['search']);
        $stmt = mysqli_prepare($connection, "select * from user where account_status=1 and (username like concat('%',?,'%') or name like concat('%',?,'%') or mobile_no like concat('%',?,'%') or user_id like concat('%',?,'%') )");
        mysqli_stmt_bind_param($stmt, "sssi", $search,$search,$search,$search);
        mysqli_stmt_execute($stmt);
        $read_result=mysqli_stmt_get_result($stmt);
        if(!$read_result)
        {
            show_error_message("search failed.");
            echo mysqli_error($connection);
            return;
        }
        fetch_row_user_list($read_result);
    }
    
    function fetch_row_user_list($read_result)
    {
        echo '<table border="1" width=60%>
         <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Password</th>
            <th>Mobile No</th>
        </tr>';
        while ($row = mysqli_fetch_row($read_result))
        {
            echo '
            <tr>
                <td>'.$row[0].'</td>
                <td>'.$row[1].'</td>
                <td>'.$row[2].'</td>
                <td>'.$row[3].'</td>
                <td>'.$row[4].'</td>
            </tr>';
        } 
        echo'</table><br><br>';
    }

/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     ADMIN MESSAGE FROM USER BLOCK                                     |
  |                                                                                       | 
  |_______________________________________________________________________________________| */


    function read_message($page)
    {
        global $connection,$record;
        $page*=$record;
        $query="select * from message order by  id desc limit $page,$record ";
        $result=mysqli_query($connection,$query);
        if(!$result)
        {
            echo mysqli_error($connection);
            return;
        }
        echo '<form action="admin_feedback.php" method="post" >
        <div class="form-check">
            <table border="1" width=60%>
              <tr>
                <td align="center"><b>ID<b></td>
                <td align="center"><b>Name<b></td>
                <td align="center"><b>Mobile<b></td>
                <td align="center"><b>Message<b></td>
                <td align="center"><b>Date and Time<b></td>
                <td align="center"><b><input type="submit" name="Delete" class="btn btn-primary" value="Delete"></b></td>
             </tr> ';
        while ($row = mysqli_fetch_row($result))
        {
            echo '
            <tr>
                <td align="center">'.$row[0].'</td>
                <td align="center">'.$row[1].'</td>
                <td align="center">'.$row[2].'</td>
                <td align="center">'.$row[3].'</td>
                <td align="center">'.$row[4].'</td>
                <td align="center"><input class="form-check-input" type="checkbox" name="delete_id[]" value="'.$row[0].'"></td>
            </tr>';

        }
        echo '</table><br><br>  
        </div>
        </form>';

    }

    function delete_message()
    {
        $delete_id=$_POST['delete_id'];  
        global $connection;
        foreach($delete_id as $id ) 
        {
            $query="delete from message where id=$id ";
            $result=mysqli_query($connection,$query);
            if(!$result)
                break; 
        }
        redirect("admin_feedback.php");
    }


/*
  _________________________________________________________________________________________
  |                                                                                       |
  |                     ADMIN NAVIGATION BAR FUNCTION BLOCK                               |
  |                                                                                       | 
  |_______________________________________________________________________________________| */

    function admin_navbar($active)
    {
        $join_request=total_request();
        $admin_username=get_admin_session_name();
        
        echo '<div class="alert alert-success" role="alert" text-align:center>
        <h1>WELCOME '.$admin_username.'</h1>
        </div>
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link '.$active[0].'" href="admin_update.php">Update profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link '.$active[1].'" href="admin_sign_up.php">Add Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link '.$active[2].'"  href="driver_list.php">Driver List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link '.$active[3].'"  href="bus_list.php">Bus List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link '.$active[4].'"  href="admin_schedule.php">Create Schedule</a>
          </li>
          <li class="nav-item">
            <a class="nav-link '.$active[5].'"  href="admin_bookings.php">Bookings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link '.$active[6].'"  href="admin_user_join_request.php">Join request('.$join_request.')</a>
          </li>
          <li class="nav-item">
            <a class="nav-link '.$active[7].'"  href="admin_user_no.php">User</a>
          </li>
         <li class="nav-item">
            <a class="nav-link '.$active[8].'"  href="admin_feedback.php">Message</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_logout.php">Logout</a>
          </li>
        </ul>
        <br><br>';
    }

?>
