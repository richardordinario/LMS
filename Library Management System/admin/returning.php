<?php
include("../connection.php");
session_start();
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d');
//echo $date;
if(isset($_SESSION["user"])) {
  $user = $_SESSION["user"];
  $auth = mysqli_query($connection,"SELECT * FROM user WHERE username = '$user'");
  $fetch = mysqli_fetch_assoc($auth);
  $acctype = $fetch["usertype"];
  $n = $fetch["name"];
  if($acctype != "Admin"){
      echo "<script>window.location.href='../forbidden2';</script>";
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
      <a href="borrowing" id="transContent" >&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Borrowing</a>
      <a href="returning" id="transContent2" style="background-color: #222;">&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Returning</a>
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
    <p style="color: #777; font-size: 28px;"><span class="glyphicon glyphicon-book"></span>&nbsp;Return Books  <span style="font-size: 13px">/ Control Panel</span>
    <span style="float: right; font-size:13px;"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</span>
    </p>
    <div style="background-color: #fff;padding: 10px; border-top: 2px solid #ccc;border-radius: 5px;">
    
    <div id="alert_return_message" style="margin-top: 5px;"></div><br/>        
        <div class="table-responsive" style="font-size: 14px;" id="return-content">
          <table id="return_data" class="table table-striped table-bordered">
            <thead style="color:#555;">
              <tr>
                <th>Library Card #</th>
                <th>Student Name</th>
                <th>Book Name</th>
                <th>Date Borrowed</th>
                <th>Date Return</th>
                <th width="2px" data-orderable="false" class="sorting_asc"></th>
              </tr>
            </thead>
          </table>
        </div>
    </div> 
  </div>

  
  <div id="returnModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="return_close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Returning Book </h4>
          </div>
          <div class="modal-body">
            <p style="margin-top: 15px; color: #555;font-weight: bold;">Book name : <span id="book_name" style="color:#090;font-size: 20px;"></span></p>
            <div class="row">
              <div class="col-sm-6">
                <p style="color: #555;font-weight: bold">Date Borrowed : <i><span id="borrowed" style="color: green;font-weight: bold;font-size: 16px;"></span></i></p>
              </div>
              <div class="col-sm-6">
                <p align="right" style="color: #555;font-weight: bold">Date For Return : <i><span id="return" style="color: red;font-weight: bold;font-size: 16px;"></span></i></p>    
              </div>
            </div>
            <div class="alert_return"></div>
             <div class="row">
              <div class="col-sm-6">
                 <p style="color: #555;font-weight: bold" id="hold_penalty">Penalty : <i><span id="penalty" style="color: maroon;font-weight: bold;font-size: 16px;"></span></i></p>
              </div>
              <form class="form return_form" autocomplete="off">
              <div class="col-sm-6">
                 <label id="payment"></label>
                    <input type="hidden" name="pay" id="pay" class="form-control" placeholder="Input payment">
              </div>
            </div>
            
            <hr>
            
            

              <input type="hidden" name="book_id" id="book_id">
              <input type="hidden" name="count" id="count">
              <input type="hidden" name="bookn" id="bookn">
              <input type="hidden" name="stat" id="stat">
              <input type="hidden" name="borrowid" id="borrowid">
              <input type="hidden" name="studid" id="studid">
               <input type="hidden" name="penalty_txt" id="penalty_txt">
              <input type="hidden" name="date" id="date" value="<?php echo $date;?>">
               <p style="color: blue;font-weight: bold;font-size: 18px;">Borrower Details</p>
              <div class="form-group row">
                <div class="col-sm-8">
                 
                    <p style="color: #555;font-weight: bold">Name : <br><i><span id="studname" style="color: #333;font-weight: bold;font-size: 14px;"></span></i></p>  
                </div> 
                <div class="col-sm-4">
                      <p style="color: #555;font-weight: bold">Library Card :<br> <i><span id="libid" style="color: #333;font-weight: bold;font-size: 14px;"></span></i></p>              
                </div>  
              </div>
           
          </div>
          <div class="modal-footer">
            <input type="submit" name="sub_return" id="sub_return" class="btn btn-success btn-md" value="Submit">
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
    document.getElementById("return-content").style.width = "100%";
    document.getElementById("return_data").style.width = "100%";
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
      document.getElementById("return-content").style.width = "100%";
      document.getElementById("return_data").style.width = "100%";
      document.getElementById("nav-top").style.marginLeft = "200px";
      document.getElementById("logout").style.marginRight = "200px";
      document.getElementById("slide-on").innerHTML = "☰ ";
    }
    else {
      document.getElementById("mySidebar").style.width = "0";
      document.getElementById("main").style.margin= "auto";
      document.getElementById("return_data").style.width = "100%";
      document.getElementById("main").style.width = "90%";
      document.getElementById("return-content").style.width = "100%";
      document.getElementById("nav-top").style.marginLeft= "0";
      document.getElementById("logout").style.marginRight = "0";
      document.getElementById("slide-on").innerHTML = "☰  Library Management System";
    }
 
}
</script>
   
</body>
</html>