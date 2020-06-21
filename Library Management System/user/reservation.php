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
  if($acctype != "User"){
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
    <a href="student" style="padding-top: 10px;"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Manage Student</a>
    <a href="books.php"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Books</a>
    <div class="dropdown">
      <a id="transBtn" style="cursor: pointer;"><span class="glyphicon glyphicon-tasks"></span>&nbsp;&nbsp;Transactions&nbsp;&nbsp;&nbsp;&nbsp;<span class="caret"></span></a>
      <div class="dropdown-content">
      <a href="borrowing" id="transContent" >&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Borrowing</a>
      <a href="returning" id="transContent2">&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Returning</a>
      <a href="reservation" id="transContent3" style="background-color: #222;">&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Reservation</a>
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
    <p style="color: #777; font-size: 28px;"><span class="glyphicon glyphicon-book"></span>&nbsp;Book Reservation  <span style="font-size: 13px">/ Control Panel</span>
    <span style="float: right; font-size:13px;"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</span>
    </p>
    <div style="background-color: #fff;padding: 10px; border-top: 2px solid #ccc;border-radius: 5px;">
      <div id="alert_reserve_message"></div>
      <div class="row">
        <div class="col-sm-4">
          <h2>Search Books</h2>
          <br>
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">Search</span>
              <input type="text" name="search_text" id="search_text" placeholder="Search By Book Name" class="form-control" autocomplete="off">
            </div>
          </div>
          <br>
              <div id="result_book"></div> 
        </div>
        <div class="col-sm-8">
          <h2>Reservation Data</h2>
          
          <br>
          <div class="table-responsive" style="font-size: 14px;" id="reserve-content">
          <table id="reserve_data" class="table table-striped table-bordered">
            <thead style="color:#555;">
              <tr>
                <th>Library Card #</th>
                <th>Student Name</th>
                <th>Book Name</th>
                <th>Date Reserved</th>
                <th width="2px" data-orderable="false" class="sorting_asc"></th>
                 <th width="2px" data-orderable="false" class="sorting_asc"></th>
              </tr>
            </thead>
          </table>
        </div>

        </div>
 
            
      </div>

     
    </div> 
  </div>

  <div id="resModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="reserve_close" data-dismiss="modal">&times;</button>
            <h6 class="modal-title"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Book Reservation </h6>
          </div>
          <div class="modal-body">
            <p style="margin-top: 15px; color: #555;font-weight: bold;">Book name : <span id="borrow_name" style="color:#090;font-size: 20px;"></span></p>
            <p style="color: #555;font-weight: bold">Instock : <i><span id="stock" style="color: #ff0000;font-weight: bold;font-size: 16px;"></span></i></p>
            <hr>
            <div class="alert_reserve"></div>
            <form class="form reserve_form" autocomplete="off">
              <input type="hidden" name="book_id" id="book_id">
              <input type="hidden" name="count" id="count">
              <input type="hidden" name="bookn" id="bookn">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label>Library Card Number</label>
                  <input type="text" name="libraryid" id="libraryid" placeholder="Input library id" class="form-control">
                </div>
              </div>
              <hr>
              <p> <strong>Note:</strong> <i>Book must be borrowed by tommorow to avoid canceling of reservation.</i></p>
          </div>
          <div class="modal-footer">
            <input type="submit" name="sub_borrow" id="sub_reserve" class="btn btn-success btn-md" value="Submit">
          </div>

          </form>
        </div>

      </div>
    </div>

<div id="borrowModal2" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="borrow_close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Book checkout </h4>
          </div>
          <div class="modal-body">
            <p style="margin-top: 15px; color: #555;font-weight: bold;">Book name : <span id="borrow_name2" style="color:#090;font-size: 16px;"></span></p>
            <p style="color: #555;font-weight: bold;font-size: 12px;">Library Card No : <i><span id="libraryid3" style="color: #ff0000;font-weight: bold;font-size: 14px;"></span></i></p>
             <p style="color: #555;font-weight: bold;font-size: 12px;">Student Name : <i><span id="studname3" style="color: maroon;font-weight: bold;font-size: 12px;"></span></i></p>

            <hr>
            <div class="alert_borrow2"></div>
            <form class="form borrow_form2" autocomplete="off">
              <input type="hidden" name="book_id2" id="book_id2">
              <input type="hidden" name="res_id" id="res_id">
          
              <input type="hidden" name="bookn2" id="bookn2">
              <input type="hidden" name="libraryid2" id="libraryid2">
              <input type="hidden" name="studname2" id="studname2">
              <div class="form-group row">
               
                <div class="col-sm-12">
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
            <input type="submit" name="sub_borrow" id="sub_borrow2" class="btn btn-success btn-md" value="Submit">
          </div>

          </form>
        </div>

      </div>
    </div>

<script>

  $(document).ready(function(){

    $('#search_text').keyup(function(){
      var txt = $(this).val();
      if(txt!='')
      {
        $.ajax({
          url:"reserv_fetch.php",
          method:"post",
          data:{search:txt},
          dataType:"text",
          success:function(data)
          {
            $('#result_book').html(data);
          }
        })
      }
      else
      {
        $('#result_book').html('');
      }
    })

  })


  open();
  function open() {
    document.getElementById("mySidebar").style.width = "200px";
    document.getElementById("main").style.marginLeft = "200px";
    document.getElementById("main").style.width = "85%";
    document.getElementById("reserve-content").style.width = "100%";
    document.getElementById("reserve_data").style.width = "100%";
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
      document.getElementById("reserve-content").style.width = "100%";
      document.getElementById("reserve_data").style.width = "100%";
      document.getElementById("nav-top").style.marginLeft = "200px";
      document.getElementById("logout").style.marginRight = "200px";
      document.getElementById("slide-on").innerHTML = "☰ ";
    }
    else {
      document.getElementById("mySidebar").style.width = "0";
      document.getElementById("main").style.margin= "auto";
      document.getElementById("reserve_data").style.width = "100%";
      document.getElementById("main").style.width = "90%";
      document.getElementById("reserve-content").style.width = "100%";
      document.getElementById("nav-top").style.marginLeft= "0";
      document.getElementById("logout").style.marginRight = "0";
      document.getElementById("slide-on").innerHTML = "☰  Library Management System";
    }
 
}
</script>
   
</body>
</html>