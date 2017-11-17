<?php
    require("database.php");
    if(isset($_POST['submit'])){
        $date=$_POST['date'];
        $time=$_POST['time'];
        $event=$_POST['event'];
        $comment=$_POST['comment'];
        $email =$_POST['email'];
        $sql="insert into reminder (date,time,event,comment,email_id) values('$date','$time','$event','$comment','$email')";
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
        {
             if(mysqli_query($conn,$sql)){
            echo"<script>alert('Reminder Set');</script>";
        }   
            else
            {
            echo"<script>alert('Error');</script>";
            }
        }
        else{
            echo"<script>alert('Inavlid email');</script>";
        }
        
    }
?>

<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="style.css">
</head>
<body bgcolor="#d2ff4d">
    <?php
    date_default_timezone_set('Asia/Kolkata');
    ?>
<div style="width: 100%; height: 10vh; background-color: black">
<center>
<h1 style="color: Red; font-size: 50px;">Get Notified</h1>
</center>
</div>
<div class="month">      
    <ul>
    <li><?php
        
if(isset($_GET['id']))
{
    if($_GET['id']=="prev")
    {
        $count=$_GET['count'];
        $count--;
        dateYear($count);
    }
    else
    {
        $count=$_GET['count'];
        $count++;
        dateYear($count);
    }
}
else
{
    $count=0;
    dateYear($count);
}
?>
<?php    
if(isset($_GET['id1']))
{
    $id1=$_GET['id1'];
    $sql1="delete from reminder where r_id=$id1";
    $res=mysqli_query($conn,$sql1);
       
}
?>
        <?php
        function delete($array1,$conn)
        {
        foreach($array1 as $id2)
        {
            echo"$id2";
           $sql2="delete from reminder where r_id=$id2";
           $res1=mysqli_query($conn,$sql2);
           echo"<meta http-equiv='refresh' content='0;URL=reminder.php' />";
        }
        }
       ?>

    <?php
    function dateYear($count)
    {
      if($count==0)
      {
      $month=date("M"); echo "$month <br>";
      echo"<span style='font-size:18px'>"; $year=date("Y"); echo "$year </span>";
      }
        else{
        $month=date('M', strtotime('+'.$count.' month'));
        echo "$month <br>";
        $year=date('Y', strtotime('+'.$count.' month'));
        echo"<span style='font-size:18px'>";  echo "$year </span>";
      }
    }
 
    ?></li>
    <a href="reminder.php?id=prev&count=<?php echo $count; ?>"  name="prev"><li class="prev">&#10094;</li></a>
    <a href="reminder.php?id=next&count=<?php echo $count; ?>"  name="next" id="next"><li class="next">&#10095;</li></a>
  </ul>
</div>
<ul class="weekdays">
  <li>Mo</li>
  <li>Tu</li>
  <li>We</li>
  <li>Th</li>
  <li>Fr</li>
  <li>Sa</li>
  <li>Su</li>
</ul>
<ul class="days">
    <?php
    $mon=date('m', strtotime('+'.$count.' month'));
    $year=date('Y', strtotime('+'.$count.' month'));
    $string=$year."-".$mon."-01";
    $timestamp = strtotime($string);
    $day = date('N', $timestamp);
    $d=cal_days_in_month(CAL_GREGORIAN,$mon,$year);
        For($i=1;$i<=$d+$day-1;$i++)
        {
            if($i<$day){
                echo "<li></li>";
            }
            else{
                $c=$i-$day+1;
                $newDate=$year.'-'.$mon.'-'.$c;
                echo "<li ><a style='text-decoration:none;color:black ' href='reminder.php?keyDate=".$newDate."'>".$c."</a></li>";
            }
        }
    ?>
</ul>
   <div style="float:left; width: 70%;overflow:auto; background:#1abc9c; height:350px">
           <h1 style="color: white; font-size: 30px; margin-left:80px;"> Set Reminder:</h1>
    <br>
    <?php
    echo "<form action='reminder.php' method='post'>";
    if(isset($_GET['keyDate']))
    {
     echo "<h1 style='display:inline-block; margin-left:80px;font-size: 20px;color:black'>Date:</h1>";    
     echo "<h1 style='color:#000066;width:100px; display:inline-block; font-size: 20px; margin-left:30px;'> ".$_GET['keyDate']."</h1>";
        $date=$_GET['keyDate'];
     echo "<h1 style='display:inline-block; margin-left:80px;font-size: 20px;color:black'>Choose Time:</h1>";
     echo"<input id='time' name='time' type='time' style='color: black;' required>";
     echo"<input name='date' value='$date' hidden required>";
     echo"<br><br><p1 style=' display:inline-block;color: black;width:100px; font-size: 20px; margin-left:80px;'> Select Type:<p1> 
     <select name='event' required style='display:inline-block; width:100px;color: black; padding:3px;'>
     <option value='Bday'>Bday</option>
     <option value='Anniversary'>Anniversary</option>
     <option value='Task'>Task</option>
     <option value='Other'>Other</option>
     </select>";
        echo"<label>email:</label>";
        echo"<textarea name='email' cols='40' rows='1' style='display:inline-block;'></textarea>";
        echo"<br>";
        echo"<label>comment:</label>";
     echo"<textarea name='comment' cols='50' rows='3' maxlength='30' minlength='5'></textarea>";
    echo"<br><center><input type='submit' name='submit'></center>";        
    }
    echo"</form>";
    ?>
   </div>
   <div style="float:right;width: 30%;background:#d2ff4d;height:auto">
       <?php
       $sql1="select * from reminder";
       $res=mysqli_query($conn,$sql1);
       echo"<h1 style='color: black;overflow:auto; font-size: 30px; margin-left:80px;'> Reminders:</h1>";
       while($row=mysqli_fetch_assoc($res)){
           echo "<div style='background:white;color:rebeccapurple;padding: 5px;margin: 5px;'>";
           echo "Event: ".$row['event'];
           echo "<br>";
           echo "Date: ".$row['date'];
           echo "<br>";
           echo "Time: ".$row['time'];
           echo "<br>";
           $id_date=$row['r_id'];
           echo"<center><a style='text-decoration:none;color:black ' href='reminder.php?id1=$id_date;'>Delete</a></center>";
           echo "<br>";
           echo"</div>";
       }
       ?>
       <?php
         $sql1="select * from reminder";
       $res=mysqli_query($conn,$sql1);
       $arr=array();
        while($row=mysqli_fetch_assoc($res)){
            $id=$row['r_id'];
            $timeVar=$row['date'].' '.$row['time'];
            $time=$row['time'];
            $date1 = date('Y-m-d H:i:s');
            echo"<h1>$date1</h1>";
            $date = strtotime("$timeVar");
            $current=strtotime("$date1");
            echo "<br>";
            //$diff = round(abs($date - $current) / 60,2);
           // echo"<h1>$diff</h1>";
            $event=$row['event'];
            $comment=$row['comment'];
            if($date<=$current)
            {
                echo"<audio id='xyz' src='itune.mp3' preload='auto'></audio>";
                echo"<script>document.getElementById('xyz').play();</script>";
                echo"<script>alert('You have $event reminder...$comment at $time');</script>";
                array_push($arr,$id);
            }
        }
       delete($arr,$conn);
      //header( "refresh:5;url=reminder.php" );
       ?>
<div style="clear:both"></div>
       <?php
       echo"<meta http-equiv='refresh' content='30;URL=reminder.php' />";
       ?>
</body>
</html>
