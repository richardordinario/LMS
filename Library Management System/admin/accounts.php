<?php
include("../connection.php");


session_start();

if(isset($_SESSION["user"])) {
  $user = $_SESSION["user"];
  $auth = mysqli_query($connection,"SELECT * FROM user WHERE username = '$user'");
  $fetch = mysqli_fetch_assoc($auth);
  $acctype = $fetch["usertype"];
  $n = $fetch["name"];
  if($acctype != "Admin"){
      echo "<script>window.location.href='../forbidden';</script>";
  }
}else {
   echo "<script>window.location.href='../hack';</script>";
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
    <link rel="stylesheet" type="text/css" href="../style/modal.css">
    <link rel="stylesheet" type="text/css" href="../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.min.css"/>
    <script src="../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="../DataTables/DataTables-1.10.18/js/dataTables.bootstrap.min.js"></script>
    <script src="../jscript/main.js"></script>
</head>
<style>

</style>
<body>
 
  <div id="mySidebar" class="sidebar">
    <a style="background-color: #333;padding: 14px 25px; font-weight: bold;color: #999;font-size: 16px;"><span class="glyphicon glyphicon-book"></span>&nbsp;Librarian Panel</a>
    <a href="#" style="padding: 15px; float: left;"><img src="../image/man-128.png" class="img-responsive" width="27%">
    <span style="float: right;margin-top: -40px; margin-left:-50px;font-size: 12px;color: #999;font-weight: bold;"><?php echo $n;?></span>
    <span style="float: left;margin-top: -20px; margin-left: 50px; font-size: 12px;color: #999;font-weight: bold;margin-bottom: 10px;">
      <span class="dot"></span>&nbsp;Online</span>
    </a>
    
    <a href="index.php" style="padding-top: 10px;"><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;Dashboard</a>
    <a href="manage" style="padding-top: 10px;"><span class="glyphicon glyphicon-lock"></span>&nbsp;&nbsp;Manage Password</a>
    <div class="dropdown">
      <a href="#" class="dropbtn" id="accBtn"><span class="glyphicon glyphicon-tasks"></span>&nbsp;&nbsp;Accounts&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="caret"></span></a>
      <div class="dropdown-content">
      <a href="student.php" id="accContent">&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Student</a>
      <a href="accounts.php" id="accContent2" style="background-color: #222;">&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Admin</a>
      </div>
    </div>
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
    <p style="color: #777; font-size: 28px;"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Accounts  <span style="font-size: 13px">/ Control Panel</span>
    <span style="float: right; font-size:13px;"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</span>
    </p>
    <div style="background-color: #fff;padding: 10px; border-top: 2px solid #ccc;border-radius: 5px;">
    <div align="right" id="btnAdd">
    <button style="font-size: 12px;" data-toggle="modal" data-target="#addModal" role="button" id="addbtn" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;<strong> Account</strong></button>
    </div >
    <div id="alert_message" style="margin-top: 10px;"></div><br/>        
        <div class="table-responsive" style="font-size: 14px;" id="table-content">
          <table id="user_data" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Name</th>
                <th>Username</th>
                <th width="10px">Password</th>
                <th>Usertype</th>
                <th width="2px" data-orderable="false" class="sorting_asc"></th>
                <th width="2px" data-orderable="false" class="sorting_asc"></th>
              </tr>
            </thead>
          </table>
        </div>
    </div> 
  </div>

    <div id="addModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="btn_cls" data-dismiss="modal">&times;</button>
            <h4 id="m-title" class="modal-title" ><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Add Account</h4>
          </div>
          <div class="modal-body">
            <div id="alert_message2"></div>

            <form class="form insert-form" autocomplete="OFF">
            <label>Enter Fullname</label>
            <div class="form-group">
              <input type="text" name="name" id="name" placeholder="Enter Fullname" class="form-control">
            </div>
            <label>Enter Username</label>
            <div class="form-group">
              <input type="text" name="username" id="username" placeholder="Enter Username" class="form-control">
            </div>
            <label>Enter Password</label>
            <div class="form-group">
              <input type="password" name="password" id="password" placeholder="Enter password" class="form-control">
            </div>
            <label>Enter Retype-password</label>
            <div class="form-group">
              <input type="password" name="retype-password" id="retype-password" placeholder="Retype password" class="form-control">
            </div>
            <div class="form-group row">
              <div class="col-xs-5">
                <label>Enter Usertype</label>
                <div class="form-group">
                  <select class="form-control input-sm" name="user" id="user">
                    <option value="" name="user">--Select Usertype--</option>
                    <option value="User"  name="user">User</option>
                    <option value="Admin" name="user">Admin</option>
                  </select>
                </div>
              </div>
               <input type="hidden" name="id" id="id">
              <div class="col-xs-7"></div>
              <div class="col-xs-7" align="right">
                <input type="submit" class="btn btn-success btn-sm" id="insert" value="Save">
                <input type="submit" class="btn btn-danger btn-sm" id="cancel" value="Cancel">
              </div>
            </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm button_style" data-dismiss="modal" id="close">Close</button>
          </div>
        </div>

      </div>
    </div>

<script>
  

  open();

  function open() {
    document.getElementById("mySidebar").style.width = "200px";
    document.getElementById("main").style.marginLeft = "200px";
    document.getElementById("main").style.width = "85%";
    document.getElementById("table-content").style.width = "100%";
    document.getElementById("user_data").style.width = "100%";
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
        document.getElementById("table-content").style.width = "100%";
        document.getElementById("user_data").style.width = "100%";
        document.getElementById("nav-top").style.marginLeft = "200px";
        document.getElementById("logout").style.marginRight = "200px";
        document.getElementById("slide-on").innerHTML = "☰ ";
      }
      else {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.margin= "auto";
        document.getElementById("user_data").style.width = "100%";
        document.getElementById("main").style.width = "90%";
        document.getElementById("table-content").style.width = "100%";
        document.getElementById("nav-top").style.marginLeft= "0";
        document.getElementById("logout").style.marginRight = "0";
        document.getElementById("slide-on").innerHTML = "☰  Library Management System";
      }
  }

</script>
   
</body>
</html>