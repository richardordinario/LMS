<?php
include("../connection.php");


session_start();

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
    <script>
      var _URL = window.URL || window.webkitURL;
      function displayPrev(files) {
        var file = files[0]
        var img = new Image();
        var sizeKB = file.size /1024;
        img.onload = function() {
          $('#preview').html(img);
        }
        img.src = _URL.createObjectURL(file);
      }

       var _URL2 = window.URL || window.webkitURL;
      function displayPrev2(files) {
        var file = files[0]
        var img = new Image();
        var sizeKB = file.size /1024;
        img.onload = function() {
          $('#preview2').html(img);
        }
        img.src = _URL.createObjectURL(file);
      }

    </script>
</head>
<style>
img{height: 150px;}
td{padding: 5px;}
.head{font-weight: bold;color:#555;font-size: 12px;}
</style>
<body>
 
  <div id="mySidebar" class="sidebar">
    <a style="background-color: #333;padding: 14px 25px; font-weight: bold;color: #999;font-size: 16px;"><span class="glyphicon glyphicon-book"></span>&nbsp;Librarian Panel</a>
    <a href="" style="padding: 15px; float: left;"><img src="../image/man-128.png" class="img-responsive" width="27%">
    <span style="float: right;margin-top: -40px; margin-left:-50px;font-size: 12px;color: #999;font-weight: bold;"><?php echo $n;?></span>
    <span style="float: left;margin-top: -20px; margin-left: 50px; font-size: 12px;color: #999;font-weight: bold;margin-bottom: 10px;">
      <span class="dot"></span>&nbsp;Online</span>
    </a>
    
    <a href="index.php" style="padding-top: 10px;"><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;Dashboard</a>
    <a href="manage" style="padding-top: 10px;"><span class="glyphicon glyphicon-lock"></span>&nbsp;&nbsp;Manage Password</a>
    <a href="student" style="padding-top: 10;background-color: #222;"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Manage Student</a>
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
    <p style="color: #777; font-size: 28px;"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Students  <span style="font-size: 13px">/ Control Panel</span>
    <span style="float: right; font-size:13px;"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</span>
    </p>
    <div style="background-color: #fff;padding: 10px; border-top: 2px solid #ccc;border-radius: 5px;">
    <div align="right" id="btnAdd">
    <button style="font-size: 12px;" data-toggle="modal" data-target="#studModal" role="button" id="addbtn" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;<strong>Students</strong></button>

    </div >
    <div id="alert_student_message" style="margin-top: 10px;"></div><br/>        
        <div class="table-responsive" style="font-size: 14px;" id="table-content">
          <table id="student_data" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Library ID.</th>
                <th>Student ID.</th>
                <th>Fullname</th>
                <th>Birthdate</th>
                <th>Grade Level</th>
                <th>Section</th>
                <th>Address</th>
                <th width="2px" data-orderable="false" class="sorting_asc"></th>
                <th width="2px" data-orderable="false" class="sorting_asc"></th>
                <th width="2px" data-orderable="false" class="sorting_asc"></th>
              </tr>
            </thead>
          </table>
        </div>
    </div> 
  </div>


<!--ADD MODAL-->
    <div id="studModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="student_cancel_2" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="s-title"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Add Student</h4>
          </div>
          <div class="modal-body">
            <div id="alert_student"></div>
        <form id="student_form" method="POST"autocomplete="OFF" enctype="multipart/form-data">
            
            <div class="form-group row">
              <div class="col-lg-4">
                <label>Firstname</label>
                <div class="input-group">
                  <input type="text" name="fname" id="fname" placeholder="Enter Firstname" class="form-control">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                </div>
              </div>
              <div class="col-lg-4">
                <label>Middle Name</label>
                <div class="input-group">
                  <input type="text" name="mi" id="mi" placeholder="Enter Middle Name" class="form-control">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                </div>
              </div>
              <div class="col-lg-4">
                <label>Lastname</label>
                <div class="input-group">
                  <input type="text" name="lname" id="lname" placeholder="Enter Lastname" class="form-control">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <label>Student ID Number</label>
                <div class="input-group">
                  <input type="text" name="studid" id="studid" placeholder="Enter ID number" class="form-control">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                </div>
              </div>
              <div class="col-md-4">
                <label>Address</label>
                <div class="input-group">
                  <input type="text" name="address" id="address" placeholder="Enter Present Address" class="form-control">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                </div>   
              </div>
              <div class="col-md-4">
                <label>Contact Number</label>
                <div class="input-group">
                  <input type="text" name="contact" id="contact" placeholder="Enter Contact Number" class="form-control">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                </div>
              </div>
            </div>
                        
            <div class="forms-group row">
              <div class="col-lg-3">
                 <label>Gender</label>
                  <div class="input-group">
                  <select name="gender" id="gender" class="form-control">
                    <option>--Select Gender--</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  </div>
              </div>
              <div class="col-lg-3">
                <label>Grade Level</label>
                  <div class="input-group">
                  <select name="ylevel" id="ylevel" class="form-control">
                    <option>--Select Grade Level--</option>
                    <option value="Grade 7">Grade 7</option>
                    <option value="Grade 8">Grade 8</option>
                    <option value="Grade 9">Grade 9</option>
                    <option value="Grade 10">Grade 10</option>
                    <option value="Grade 11">Grade 11</option>
                    <option value="Grade 12">Grade 12</option>
                  </select>
                  <span class="input-group-addon"><i class="glyphicon glyphicon-stats"></i></span>
                  </div>
              </div>
              <div class="col-lg-3">
                <label>Birthdate</label>
                  <div class="input-group">
                    <input type="date" name="bdate" id="bdate" class="form-control">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
              </div>
              <div class="col-lg-3">
                <label>Section</label>
                <div class="input-group">
                  <input type="text" name="section" id="section" placeholder="Enter Section" class="form-control">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                </div>
              </div>
            </div>
            <br>
            <div class="form-group row"> 
              <div class="col-md-4">
                <div class="form-group">
                  <div align="center"><span id="preview"></span></div>
                  <label id="sel_img">Select Image</label>
                  <input type="file" name="image" id="image" onchange="displayPrev(this.files);">
                  <input type="hidden" name="action" id="action" value="insert">
                  <input type="hidden" name="dbid" id="dbid">
                </div>
              </div>
              <div class="col-md-4"></div>
              <div class="col-md-4"></div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success btn-sm" id="student_add" value="Save">
                <input type="submit" class="btn btn-danger btn-sm" id="student_cancel" value="Cancel">
            </div>
            </form>
          </div>
          <div class="modal-footer">
           
          </div>
        </div>

      </div>
    </div>

<!--VIEW MODAL -->
     <div id="viewModal" class="modal fade" role="dialog">
      <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="close-book" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="mod-title"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Student Information</h4>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-lg-5">
                <img src="" id="img" class="img-responsive img-thumbnail">
                <p style="font-size: 14px;margin-top: 5px;"></p>
              </div>
              <div class="col-lg-7">
                <table class="table-bordered table-striped table-responsive">
                  <tr>
                    <td><span class="head">School ID: </span></td>
                    <td><i><span id="stud_id" style="color: #900;font-weight: bold;font-size: 12px;"></span></i></td>
                    <td><span class="head">Library ID: </span></td>
                    <td><i><span id="library_id" style="color: #900;font-weight: bold;font-size: 12px;"></span></i></span></td>
                  </tr>
                  <tr>
                    <td><span class="head" style="font-weight: bold;">Name: </span></td>
                    <td colspan="3"><p><span id="dbName" style="font-size: 14px;font-weight: bold;color: #333;"></span></p></td>
                  </tr>
                  <tr>
                    <td><p><span class="head" style="font-weight: bold;">Gender: </span></p></td>
                    <td colspan="3"><p><span id="dbGender" style="font-weight: bold;color: #333;font-size: 12px;"></span></p></td>
                  </tr>
                  <tr>
                    <td><p><span class="head" style="font-weight: bold;">Grade Level: </span></p></td>
                    <td colspan="3"><p><span id="dbGrade" style="font-weight: bold;color: #333;font-size: 12px;"></span></p></td>
                  </tr>
                  <tr>
                    <td><p><span class="head" style="font-weight: bold;">Section: </span></p></td>
                    <td colspan="3"><p><span id="dbSection" style="font-weight: bold;color: #333;font-size: 12px;"></span></p></td>
                  </tr>
                  <tr>
                    <td><p><span class="head" style="font-weight: bold;">Contact No.: </span></p></td>
                    <td colspan="3"><p><span id="dbContact" style="font-weight: bold;color: #333;font-size: 12px;"></span></p></td>
                  </tr>
                  <tr>
                    <td><p><span class="head" style="font-weight: bold;">Address: </span></p></td>
                    <td colspan="3"><p><span id="dbAddress" style="font-weight: bold;color: #333;font-size: 12px;"></span></p></td>
                  </tr>
                </table>
              </div>
            </div>
           
            <br>
            <form id="view_form" method="POST" autocomplete="OFF" action="print.php" target="_blank" enctype="multipart/form-data">
             <input type="hidden" name="id" id="id">
          </div>
          <div class="modal-footer">
              <div class="form-group">
                <button type="submit" name="sub" class="btn btn-success glyphicon glyphicon-print"></button>
                <button type="button" class="btn btn-default btn-sm close-book" data-dismiss="modal" id="close">Close</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>


    <div id="picModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="close-book" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="mod-title"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Change Picture</h4>
          </div>
          <div class="modal-body">

             <p style="color: #555;font-weight: bold">Student Name:<br> <i><span id="studname" style="color: blue;font-weight: bold;font-size: 16px;"></span></i></p>  
             <p style="color: #555;font-weight: bold">Library Id:<br> <i><span id="libid" style="color: maroon;font-weight: bold;font-size: 16px;"></span></i></p>  
             <hr>
              <div id="alert_pic"></div>
            <form id="pic_form" method="POST" autocomplete="OFF" enctype="multipart/form-data">
              <div align="center"><span id="preview2"></span></div>
              <input type="hidden" name="picid" id="picid">
              <label id="sel_img2">Select Image</label>
                  <input type="file" name="image2" id="image2" onchange="displayPrev2(this.files);">
                
          </div>
          <div class="modal-footer">
              <div class="form-group">
                <button type="submit" name="sub" class="btn btn-success" id="pic_save">Submit</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

<!-- Navigation --> 
<script>
  
  open();
  function open() {
    document.getElementById("mySidebar").style.width = "200px";
    document.getElementById("main").style.marginLeft = "200px";
    document.getElementById("main").style.width = "85%";
    document.getElementById("table-content").style.width = "100%";
    document.getElementById("student_data").style.width = "100%";
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
      document.getElementById("student_data").style.width = "100%";
      document.getElementById("nav-top").style.marginLeft = "200px";
      document.getElementById("logout").style.marginRight = "200px";
      document.getElementById("slide-on").innerHTML = "☰ ";
    }
    else {
      document.getElementById("mySidebar").style.width = "0";
      document.getElementById("main").style.margin= "auto";
      document.getElementById("student_data").style.width = "100%";
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