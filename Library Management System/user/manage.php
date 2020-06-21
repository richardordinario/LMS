<?php
include("../connection.php");

session_start();

if(isset($_SESSION["user"])) {
  $user = $_SESSION["user"];
  $auth = mysqli_query($connection,"SELECT * FROM user WHERE username = '$user'");
  $fetch = mysqli_fetch_assoc($auth);
  $log_id = $fetch["id"];
  $acctype = $fetch["usertype"];
  $n = $fetch["name"];
  if($acctype != "User"){
      echo "<script>window.location.href='../forbidden2';</script>";
  }
}else {
   echo "<script>window.location.href='../hack';</script>";
}

$err='';

if(isset($_POST["btn_save"])) {
  if(empty($_POST["past_password"]))
  {
    $err = '<div class="alert alert-warning">Please input old password</div>';
  }
  else if(empty($_POST["new_password"]))
  {

    $err = '<div class="alert alert-warning">Please input new password</div>';
  }
  else if(empty($_POST["renew_password"]))
  {
    
    $err = '<div class="alert alert-warning">Please retype new password</div>';
  }
  else
  {
    $old = $_POST["past_password"];
    $new = $_POST["new_password"]; 
    $renew = $_POST["renew_password"];

    if($new == $renew)
    {
       $check_old = mysqli_query($connection,"SELECT * FROM user WHERE id = '$log_id' ");
    if(mysqli_num_rows($check_old) > 0)
    {
      $row_check = mysqli_fetch_assoc($check_old);
      $db_pass = $row_check["password"];

      if($old == $db_pass)
      {
        mysqli_query($connection,"UPDATE user SET password = '$renew' WHERE id = '$log_id'");
        $err = '<div class="alert alert-success">Password Successfully Updated!</div>';
      }
      else
      {
        $err = '<div class="alert alert-warning">Old password is incorrect!</div>';
      }
    }
    }
    else
    {
      
       $err = '<div class="alert alert-warning">Password Not Match!</div>';
    }
   
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Library Management System</title>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device=width, initial-scale = 1">
    <link rel="stylesheet" href="../style/bootstrap-3.3.7/css/bootstrap.min.css">
    <script src="../style/js/jquery-3.3.1.min.js"></script>
    <script src="../style/js/jQuery.js"></script>
    <script src="../style/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../style/global.css">
    <link rel="stylesheet" type="text/css" href="../style/sidebar.css">
    <link rel="stylesheet" type="text/css" href="../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.min.css"/>
    <script src="../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="../DataTables/DataTables-1.10.18/js/dataTables.bootstrap.min.js"></script>
    <script src="../jscript/main.js"></script>
    
</head>

<body>
 
  <div id="mySidebar" class="sidebar">
    <a style="background-color: #333;padding: 14px 25px; font-weight: bold;color: #999;font-size: 16px;"><span class="glyphicon glyphicon-book"></span>&nbsp;Librarian Panel</a>
    <a href="#" style="padding: 15px; float: left;"><img src="../image/man-128.png" class="img-responsive" width="27%">
    <span style="float: right;margin-top: -40px; margin-left:-50px;font-size: 12px;color: #999;font-weight: bold;"><?php echo $n;?></span>
    <span style="float: left;margin-top: -20px; margin-left: 50px; font-size: 12px;color: #999;font-weight: bold;margin-bottom: 10px;">
      <span class="dot"></span>&nbsp;Online</span>
    </a>
    
    <a href="index" style="padding-top: 10px;"><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;Dashboard</a>
    <a href="" style="padding-top: 10px;background-color: #222;"><span class="glyphicon glyphicon-lock"></span>&nbsp;&nbsp;Manage Password</a>
    <a href="student" style="padding-top: 10px;"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Manage Student</a>
    <a href="books.php"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Books</a>
    <div class="dropdown">
      <a id="transBtn" style="cursor: pointer;"><span class="glyphicon glyphicon-tasks"></span>&nbsp;&nbsp;Transactions&nbsp;&nbsp;&nbsp;&nbsp;<span class="caret"></span></a>
      <div class="dropdown-content">
      <a href="borrowing" id="transContent">&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Borrowing</a>
      <a href="returning" id="transContent2">&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Returning</a>
       <a href="reservation" id="transContent3">&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Reservation</a>
      </div>
    </div>
    <a href="../logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a>
  </div>
  <div id="nav-top">
    <ul>
      <li id="header"><a id="slide-on" onclick="openNav()" href="#home" style="color: #999;">☰  Library Management System</a></li>
      <li id="logout" style="float: right;" ><a href="../logout"><span class="glyphicon glyphicon-log-out"></span></a></li>
      
    </ul>
  </div>
  <div id="main"> 
   <br /><br /><br />
    <p style="color: #777; font-size: 28px;"><span class="glyphicon glyphicon-lock"></span>&nbsp;Manage Password  <span style="font-size: 13px">/ Control Panel</span>
    <span style="float: right; font-size:13px;"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</span>
    </p>
    <div style="background-color: #fff;padding: 10px; border-top: 2px solid #ccc;border-radius: 5px;">
      <br>  
      <div class="row">
        <div class="col-sm-6">

          
          <form method="POST" action="#" autocomplete="off">
            <label>Old Password</label>
            <input type="Password" name="past_password" class="form-control"  placeholder="Type old password">
            <br>
            <label>New Password</label>
            <input type="Password" name="new_password" class="form-control"  placeholder="Type new password">
            <br>
            <label>Retype New Password</label>
            <input type="Password" name="renew_password" class="form-control"  placeholder="Type new password">
            <br>
            <span id="err"><?php echo $err;?></span>
            <input type="submit" name="btn_save" value="Save" class="btn btn-primary" id="btn_save">
          </form>
        </div>
      </div>
    </div> 
  </div>

    
<script>

  setInterval(function(){
    $('#err').html('');
  },2000);
 
  
  open();

  function open() {
     document.getElementById("mySidebar").style.width = "200px";
      document.getElementById("main").style.marginLeft = "200px";
      document.getElementById("main").style.width = "85%";
      document.getElementById("nav-top").style.marginLeft = "200px";
      document.getElementById("logout").style.marginRight = "200px";
      document.getElementById("slide-on").innerHTML = "☰ ";
  }

function openNav() {
   
    var x = document.getElementById("slide-on").innerHTML;
    if( x == "☰  Library Management System") {
      document.getElementById("mySidebar").style.width = "200px";
      document.getElementById("main").style.marginLeft = "200px";
      document.getElementById("main").style.width = "85%";
      document.getElementById("nav-top").style.marginLeft = "200px";
      document.getElementById("logout").style.marginRight = "200px";
      document.getElementById("slide-on").innerHTML = "☰ ";
    }
    else {
      document.getElementById("mySidebar").style.width = "0";
      document.getElementById("main").style.margin= "auto";
      document.getElementById("main").style.width = "70%";
      document.getElementById("nav-top").style.marginLeft= "0";
      document.getElementById("logout").style.marginRight = "0";
      document.getElementById("slide-on").innerHTML = "☰  Library Management System";
    }
 
}
</script>
   
</body>
</html>