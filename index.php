<?php 
    include "function/user_function.php";
    include "header_footer/e_travel_header.php";
?>
<script>
    
    var stat=[true,true];
    function show_message(msg,color,id)
    {
        document.getElementById(id).style.color=color;
        document.getElementById(id).innerHTML=msg;
    }
    function enable_submit()
    {
        let i=0;
        for(i=0;i<stat.length;i++)
        {
            if(!stat[i])
                break;
        }
        document.forms["search"]["Search"].disabled = i==stat.length? false : true;
    }
    function validate_date()
    {
        var selected_date = new Date( document.forms["search"]["date"].value );
        var d = new Date();
        
        var selected_seconds=selected_date.getTime() / 1000;
        var cur_sec=d.getTime() / 1000;
        
        stat[1]= cur_sec-selected_seconds<86400;
        
        if(cur_sec-selected_seconds>86400)
            show_message("select current date","red","date");
        else
            show_message("","red","date");
        
        enable_submit();
    }
    function validate_route()
    {
        var start=document.forms["search"]["start"].value;
        var end=document.forms["search"]["end"].value;
        
        if(start!="" && end!="")
        {
            stat[0]= start!=end;
            if(start==end)
              show_message("start and end can't be same","red","route");
            else
                show_message("","red","route");
        }
        enable_submit();
    }

</script>
<body>
    <div id="back">
       <h1 id="first">E-Travel Management System</h1>
       
       <!--navigation bar---->
        <?php website_navbar(["active","","",""]); ?>
        
         <!--image of buses--->
          <div>
              <img src="image/Desh-Travel-Bus.jpg" width="160" height="150" >
               <img src="image/Hanif-Paribahan.jpg" width="160" height="150" >
               <img src="image/unique-bus.jpg" width="160" height="150" >
               <img src="image/soudia-bus.jpg" width="160" height="150" >
               <img src="image/shohaq-bus.jpg" width="160" height="150" >
               <img src="image/shyamoli-bus.jpg" width="160" height="150" >
               <img src="image/green%20line%20bus.jpg" width="160" height="150">
               <img src="image/tr-trvels.jpg" width="160" height="150" >
          </div>
          <br>
          <!--form for input-->
          <div class="container">  
        <div class="col-sm-6">
           <?php 
                if(isset($_POST['Search']))
                {
                    $route=strip_tags($_POST['start'])."-".strip_tags($_POST['end']);
                    $date=strip_tags($_POST['date']);
                    $type=strip_tags($_POST['type']);
                    redirect("search_bus_schedule.php?route=".$route."&date=".$date."&type=".$type);
                }
            ?>
            <form action="index.php" method="post" name="search">
              
               <div class="form-group">
                   <label for="">From</label>
                   <select class="form-control" name="start" onclick="validate_route()">
                      <option value="Dhaka">Dhaka</option>
                      <option value="Chittagong">Chittagong</option>
                      <option value="Khulna">Khulna</option>
                      <option value="Rajshahi">Rajshahi</option>
                      <option value="Sylhet">Sylhet</option>
                      <option value="Comilla">Comilla</option>
                  </select>
               </div>
               
                <div class="form-group">
                   <label for="">To</label>
                   <select class="form-control" name="end" onclick="validate_route()">
                      
                      <option value="Chittagong">Chittagong</option>
                       <option value="Dhaka">Dhaka</option>
                      <option value="Khulna">Khulna</option>
                      <option value="Rajshahi">Rajshahi</option>
                      <option value="Sylhet">Sylhet</option>
                      <option value="Comilla">Comilla</option>
                  </select>
                    <h5 id="route"></h5>
               </div>
                
                <div class="form-group">
                  <label for="">Date</label> 
                  <input type="date" name="date" class="form-control" required onchange="validate_date()">
                  <h5 id="date"></h5>
               </div>
               
               <div class="form-group">
                  <label for="">Type</label> <br>
                  <input type="radio" name="type"  required value="AC">AC     
                  <input type="radio" name="type"  required value="NON-AC">NON-AC
               </div>
                
                <input type="submit" name="Search" class="btn btn-primary" value="Search">
            </form>
        </div>
    </div>
        <?php include "header_footer/e-travel_footer.php"; ?>
    </div>
    
    
</body>
</html>