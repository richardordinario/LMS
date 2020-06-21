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
    <a href="books.php" style="background-color: #222;"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Books</a>
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
    <p style="color: #777; font-size: 28px;"><span class="glyphicon glyphicon-book"></span>&nbsp;Manage Books  <span style="font-size: 13px">/ Control Panel</span>
    <span style="float: right; font-size:13px;"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</span>
    </p>
    <div style="background-color: #fff;padding: 10px; border-top: 2px solid #ccc;border-radius: 5px;">
    <div align="right" id="btnAdd">
    <button style="font-size: 12px;" data-toggle="modal" data-target="#bookModal" role="button" id="addbtn" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;<strong>Book</strong></button>
    <button style="font-size: 12px;" data-toggle="modal" data-target="#catModal" role="button" id="addbtn" class="btn btn-primary"><strong>Manage Categories</strong></button>
    </div >
    <div id="alert_book_message" style="margin-top: 10px;"></div><br/>        
        <div class="table-responsive" style="font-size: 14px;" id="table-content">
          <table id="book_data" class="table table-striped table-bordered">
            <thead style="color:#555;">
              <tr>
                <th>Book Name</th>
                <th>Book Description</th>
                <th>Book Category</th>
                <th>Book Author</th>
                <th>Left</th>
                <th>Quantity</th>
                <th width="2px" data-orderable="false" class="sorting_asc"></th>
                <th width="2px" data-orderable="false" class="sorting_asc"></th>
              </tr>
            </thead>
          </table>
        </div>
    </div> 
  </div>

    <div id="bookModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="close-book" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="mod-title"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Add Book</h4>
          </div>
          <div class="modal-body">
            <div id="alert_books"></div>
            <form class="form book_form" autocomplete="OFF">
            <label>Enter Book Name</label>
            <div class="form-group">
              <input type="text" name="bookName" id="bookName" placeholder="Enter Book Name" class="form-control">
            </div>
            <label>Enter Book Description</label>
            <div class="form-group">
              <input type="text" name="description" id="description" placeholder="Enter Book Description" class="form-control">
            </div>
            <label>Enter Book Author</label>
            <div class="form-group">
              <input type="text" name="author" id="author" placeholder="Enter Book Author" class="form-control">
            </div>
            
            <input type="hidden" name="id" id="id">
            
            <div class="form-group row">
              <div class="col-xs-6">
                <label id="stock-label">Enter Book Quantity</label>
                <div class="form-group">
                  <input type="number" name="stock" id="stock" placeholder="Enter Book Quatity" class="form-control">
                </div>
              </div>
              <div class="col-xs-6">
                <label>Enter Book Category</label>
                <div class="form-group">
                  <div class="drop_cat"></div>
                </div>
              </div>
            </div>
            <div class="form-group" align="right">
              <input type="submit" class="btn btn-success btn-sm" id="insert_book" value="Save">
              <input type="submit" class="btn btn-danger btn-sm" id="cancel_book" value="Cancel">
            </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm close-book" data-dismiss="modal" id="close">Close</button>
          </div>
        </div>

      </div>
    </div>

    <div id="catModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="cat_close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Manage Book Category</h4>
          </div>
          <div class="modal-body">
            <br>
            <div id="alert_category"></div>
            <form class="form cat_form" autocomplete="OFF">
              <input type="hidden" name="cat_id" id="cat-id">
              <div class="form-group row" style="margin: 0;padding: 0;">
              	<div class="col-md-6">
  	            	<div class="form-group">
                    <label>Category Name</label>
  	            		<input type="text" name="book_category" id="book-category" placeholder="Enter Category Name" class="form-control">
  	            	</div>
              	</div>
  				    <div class="col-md-6">
  					     <div class="form-group">
                  <label>Category Description</label>
  	            		<input type="text" name="book_desc" id="book-desc" placeholder="Enter Category Description" class="form-control">
  	            	</div>
              	</div>
              </div>		  
      			<div class="row" style="margin-top: -20px;margin-right: 0px;">
      				<div class="col-sm-8"></div>
      				<div class="col-sm-4">
      					<div class="form-group" align="right">
  	            		<input type="submit" class="btn btn-success btn-sm" id="insert_cat" value="Add">
  	            		<input type="submit" class="btn btn-danger btn-sm" id="cancel_cat"  value="Cancel">
  	           </div>
      				</div>
            </div>
            </form>
            <div class="table-responsive" style="font-size: 14px;">
            	<table id="cat_data" align="center" style="width: 100%;" class="table table-bordered table-striped">
            		<thead>
            			<tr>
            			<th>Category Name</th>
            			<th>Description</th>
            			<th data-orderable="false" class="sorting_asc"></th>
            			<th data-orderable="false" class="sorting_asc"></th>
            			</tr>
            		</thead>
            	</table>
            </div>
            <br>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm cat_close" data-dismiss="modal" id="close">Close</button>
          </div>
        </div>

      </div>
    </div>

    <div id="addbookModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="addbook_close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Manage Book Quantity</h4>
          </div>
          <div class="modal-body">
            <div class="alert_addbooks"></div>
            <p style="margin-top: 15px; color: #555;font-weight: bold;">Book name : <span id="book_name" style="color:#090;font-size: 20px;"></span></p>
            <p style="color: #555;font-weight: bold">Instock : <i><span id="book_count" style="color: #ff0000;font-weight: bold;font-size: 16px;"></span></i></p>
            
            <form class="form addbook_form" autocomplete="off">
              <input type="hidden" name="book_id" id="book_id">
              <div class="form-group" style="padding: 0;">
              <div class="form-group">
                <input type="number" name="booknum" id="booknum" placeholder="Input number of books to add" class="form-control">
              </div>
            
              <div class="form-group">
                <input type="submit" name="addbookbtn" id="insert_addbook" class="btn btn-success btn-sm" value="Add">
              </div>
            
            </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default addbook_close" data-dismiss="modal" id="close">Close</button>
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
    document.getElementById("book_data").style.width = "100%";
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
      document.getElementById("book_data").style.width = "100%";
      document.getElementById("nav-top").style.marginLeft = "200px";
      document.getElementById("logout").style.marginRight = "200px";
      document.getElementById("slide-on").innerHTML = "☰ ";
    }
    else {
      document.getElementById("mySidebar").style.width = "0";
      document.getElementById("main").style.margin= "auto";
      document.getElementById("book_data").style.width = "100%";
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