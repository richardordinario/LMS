<?php
include("../connection.php");

session_start();
$total_db = 0;
if(isset($_SESSION["user"])) {
  $user = $_SESSION["user"];
  $auth = mysqli_query($connection,"SELECT * FROM user WHERE username = '$user'");
  $fetch = mysqli_fetch_assoc($auth);
  $acctype = $fetch["usertype"];
  $n = $fetch["name"];
  if($acctype != "User"){
      echo "<script>window.location.href='../forbidden2';</script>";
  }
}else {
   echo "<script>window.location.href='../hack';</script>";
}


$books = mysqli_query($connection,"SELECT * FROM books");
//$total_books = mysqli_num_rows($books);

if(mysqli_num_rows($books) > 0) {
  while($row = mysqli_fetch_assoc($books)) 
  {
    $db_left = $row["book_left"];
    $total_db =  $total_db + $db_left;
  }
}

$borrow = mysqli_query($connection,"SELECT * FROM borrow");
$total_borrow = mysqli_num_rows($borrow);

$reserve = mysqli_query($connection,"SELECT * FROM reserve");
$total_reserve = mysqli_num_rows($reserve);

$dbuser = mysqli_query($connection,"SELECT * FROM user");
$total_dbuser = mysqli_num_rows($dbuser);

$student = mysqli_query($connection,"SELECT * FROM student");
$total_student = mysqli_num_rows($student);
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
<style>

.img_text {
  font-size: 18px;
  font-weight: bold;
  color: #fff;
 font-family: "Roboto", sans-serif;

}

</style>
<body>
 
  <div id="mySidebar" class="sidebar">
    <a style="background-color: #333;padding: 14px 25px; font-weight: bold;color: #999;font-size: 16px;"><span class="glyphicon glyphicon-book"></span>&nbsp;Librarian Panel</a>
    <a href="#" style="padding: 15px; float: left;background-color: #333;"><img src="../image/man-128.png" class="img-responsive" width="27%">
    <span style="float: right;margin-top: -40px; margin-left:-50px;font-size: 12px;color: #999;font-weight: bold;"><?php echo $n;?></span>
    <span style="float: left;margin-top: -20px; margin-left: 50px; font-size: 12px;color: #999;font-weight: bold;margin-bottom: 10px;">
      <span class="dot"></span>&nbsp;Online</span>
    </a>
    
    <a href="index" style="padding-top: 10px; color: #fff !important;"><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;Dashboard</a>
    <a href="manage" style="padding-top: 10px;"><span class="glyphicon glyphicon-lock"></span>&nbsp;&nbsp;Manage Password</a>
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
    <p style="color: #777; font-size: 28px;"><span class="glyphicon glyphicon-stats"></span>&nbsp;Dashboard    <span style="float: right; font-size:13px;"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</span>
    </p>
    <div style="background-color: #fff;padding: 10px; border-top: 2px solid #ccc;border-radius: 5px;">
      <br>  
        <div class="row">

          <div class="col-lg-4">
            <div class="well well-md" style="background-color: #01a3a4;">
              <div class="row">
              <div class="col-sm-6">
                <img src="../image/books.png" width="150px">
              </div>
             <div class="col-sm-6">
                <span style="font-size: 68px; color: #fff;font-family: "Roboto", sans-serif;"><?php echo $total_db?></span>
              <br>
              <span class="img_text">Book Count</span> 
              
              </div>
              </div>
              <p align="center" style="color: #fff;margin-top: 10px;margin-bottom: 0px;">Total number of books currently in the system.</p>
            </div>
          </div>
          <div class="col-lg-4">
              <div class="well well-md" style="background-color: #2e86de;">
              <div class="row">
              <div class="col-sm-6">
                <img src="../image/bookmark.png" width="150px">
              </div>
             <div class="col-sm-6">
                <span style="font-size: 68px; color: #fff;font-family: "Roboto", sans-serif;"><?php echo $total_borrow?></span>
              <br>
              <span class="img_text">Book Borrowed Count</span> 
              
              </div>
              </div>
              <p align="center" style="color: #fff;margin-top: 10px;margin-bottom: 0px;">Total number of books borrowed in the system.</p>
            </div>
          </div>
          <div class="col-lg-4">
             <div class="well well-md" style="background-color: #341f97;">
              <div class="row">
              <div class="col-sm-6">
                <img src="../image/notebook.png" width="150px">
              </div>
             <div class="col-sm-6">
                <span style="font-size: 68px; color: #fff;font-family: "Roboto", sans-serif;"><?php echo $total_reserve?></span>
              <br>
              <span class="img_text">Book Reserved Count</span> 
              
              </div>
              </div>
              <p align="center" style="color: #fff;margin-top: 10px;margin-bottom: 0px;">Total number of books reserved in the system.</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4">
           <div class="well well-md" style="background-color: #8395a7;">
              <div class="row">
              <div class="col-sm-6">
                <img src="../image/admin.png" width="150px">
              </div>
             <div class="col-sm-6">
                <span style="font-size: 68px; color: #fff;font-family: "Roboto", sans-serif;"><?php echo $total_dbuser?></span>
              <br>
              <span class="img_text">Admininstration / User Count</span> 
              
              </div>
              </div>
              <p align="center" style="color: #fff;margin-top: 10px;margin-bottom: 0px;">Total number of Admins / Users in the system.</p>
            </div>
          </div>
          <div class="col-lg-4">
              <div class="well well-md" style="background-color: #222f3e;">
              <div class="row">
              <div class="col-sm-6">
                <img src="../image/student.png" width="150px">
              </div>
             <div class="col-sm-6">
                <span style="font-size: 68px; color: #fff;font-family: "Roboto", sans-serif;"><?php echo $total_student?></span>
              <br>
              <span class="img_text">Student Count</span> 
              
              </div>
              </div>
              <p align="center" style="color: #fff;margin-top: 10px;margin-bottom: 0px;">Total number of students in the system.</p>
            </div>
          </div>
          <div class="col-lg-4">
              
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
      document.getElementById("main").style.width = "90%";
      document.getElementById("nav-top").style.marginLeft= "0";
      document.getElementById("logout").style.marginRight = "0";
      document.getElementById("slide-on").innerHTML = "☰  Library Management System";
    }
 
}
</script>
   
</body>
</html>