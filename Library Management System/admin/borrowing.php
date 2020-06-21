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
      <a href="accounts.php" id="accContent2">&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Admin</a>
      </div>
    </div>
    <a href="books.php"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Books</a>
    <div class="dropdown">
      <a id="transBtn" style="cursor: pointer;"><span class="glyphicon glyphicon-tasks"></span>&nbsp;&nbsp;Transactions&nbsp;&nbsp;&nbsp;&nbsp;<span class="caret"></span></a>
      <div class="dropdown-content">
      <a href="borrowing" id="transContent"  style="background-color: #222;">&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Borrowing</a>
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
    <p style="color: #777; font-size: 28px;"><span class="glyphicon glyphicon-book"></span>&nbsp;Borrow Books  <span style="font-size: 13px">/ Control Panel</span>
    <span style="float: right; font-size:13px;"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</span>
    </p>
    <div style="background-color: #fff;padding: 10px; border-top: 2px solid #ccc;border-radius: 5px;">
    
    <div id="alert_borrow_message" style="margin-top: 5px;"></div><br/>        
        <div class="table-responsive" style="font-size: 14px;" id="borrow-content">
          <table id="borrow_data" class="table table-striped table-bordered">
            <thead style="color:#555;">
              <tr>
                <th>Book Name</th>
                <th>Book Description</th>
                <th>Book Category</th>
                <th>Book Author</th>
                <th>Left</th>
                <th>Quantity</th>
                <th width="2px" data-orderable="false" class="sorting_asc"></th>
              </tr>
            </thead>
          </table>
        </div>
    </div> 
  </div>

  
  <div id="borrowModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="borrow_close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Book checkout </h4>
          </div>
          <div class="modal-body">
            <p style="margin-top: 15px; color: #555;font-weight: bold;">Book name : <span id="borrow_name" style="color:#090;font-size: 20px;"></span></p>
            <p style="color: #555;font-weight: bold">Instock : <i><span id="stock" style="color: #ff0000;font-weight: bold;font-size: 16px;"></span></i></p>
            <hr>
            <div class="alert_borrow"></div>
            <form class="form borrow_form" autocomplete="off">
              <input type="hidden" name="book_id" id="book_id">
              <input type="hidden" name="count" id="count">
              <input type="hidden" name="bookn" id="bookn">
              <div class="form-group row">
                <div class="col-sm-6">
                  <label>Library Card Number</label>
                  <input type="text" name="libraryid" id="libraryid" placeholder="Input library id" class="form-control">
                </div>
                <div class="col-sm-6">
                  <label>Days</label>
                  <select name="days" id="days" class="form-control">
                    <option>--Select Days--</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                    <option value="4">Four</option>
                    <option value="5">Five</option>
                  </select>
                  
                </div>  
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" name="sub_borrow" id="sub_borrow" class="btn btn-success btn-md" value="Submit">
          </div>

          </form>
        </div>

      </div>
    </div>

<script>

  open();
  function open() {
    document.getElementById("mySidebar").style.width = "200px";
    document.getElementById("main").style.marginLeft = "200px";
    document.getElementById("main").style.width = "85%";
    document.getElementById("borrow-content").style.width = "100%";
    document.getElementById("borrow_data").style.width = "100%";
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
      document.getElementById("borrow-content").style.width = "100%";
      document.getElementById("borrow_data").style.width = "100%";
      document.getElementById("nav-top").style.marginLeft = "200px";
      document.getElementById("logout").style.marginRight = "200px";
      document.getElementById("slide-on").innerHTML = "☰ ";
    }
    else {
      document.getElementById("mySidebar").style.width = "0";
      document.getElementById("main").style.margin= "auto";
      document.getElementById("borrow_data").style.width = "100%";
      document.getElementById("main").style.width = "90%";
      document.getElementById("borrow-content").style.width = "100%";
      document.getElementById("nav-top").style.marginLeft= "0";
      document.getElementById("logout").style.marginRight = "0";
      document.getElementById("slide-on").innerHTML = "☰  Library Management System";
    }
 
}
</script>
   
</body>
</html>