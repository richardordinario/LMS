$(document).ready(function(){

	student_data();

	function student_data()
	{
		var dataTable = $("#student_data").DataTable({
			"processing":true,
			"serverSide":true,
			"ajax" : {
				"url":"../admin/student-fetch.php",
				"type": "POST"
			},
			
		});
	}

	book_data();
	
	function book_data()
	{
		var dataTable = $("#book_data").DataTable({
			"processing":true,
			"serverSide":true,
			"ajax" : {
				"url":"../admin/book-fetch.php",
				"type": "POST"
			},
			
		});
	}

	borrow_data();
	
	function borrow_data()
	{
		var dataTable = $("#borrow_data").DataTable({
			"processing":true,
			"serverSide":true,
			"ajax" : {
				"url":"../admin/borrow-fetch.php",
				"type": "POST"
			},

		});

	}

	return_data();
	
	function return_data()
	{
		var dataTable = $("#return_data").DataTable({
			"processing":true,
			"serverSide":true,
			"ajax" : {
				"url":"../admin/return-fetch.php",
				"type": "POST"
			},
		});
	}

	reserve_data();
	
	function reserve_data()
	{
		var dataTable = $("#reserve_data").DataTable({
			"processing":true,
			"serverSide":true,
			"ajax" : {
				"url":"../admin/reservation_fetch.php",
				"type": "POST"
			},
		});
	}

	load_cat();

	function load_cat()
	{
		
		$('.drop_cat').load('../admin/cat-load.php');
		
	}

	

	function load_stat()
	{
		
		window.load('../admin/load_status.php');
		
	}

	category_data();
	
	function category_data()
	{
		var dataTable = $("#cat_data").DataTable({
			"processing":true,
			"serverSide":true,
			"ajax" : {
				"url":"../admin/cat-fetch.php",
				"type": "POST"
			},
			
		});
	}

	fetch_data();
	
	function fetch_data()
	{
		var dataTable = $("#user_data").DataTable({
			"processing":true,
			"serverSide":true,
			"ajax" : {
				"url":"../admin/fetch.php",
				"type": "POST"
			},
			
		});
	}


	$(document).on('click','.delete', function(){

		var id = $(this).attr("id");
		if(confirm("Delete Selected Records?"))
		{
			$.ajax({
				url:"../admin/delete.php",
				method:"POST",
				data:{id:id},
				success:function(data){
					$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
					$('#user_data').DataTable().destroy();
					fetch_data();
				}
			})
			setInterval(function(){
				$('#alert_message').html('');
			},5000);
		}
	})

	$(document).on('click','.edit', function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		if(confirm("Update Selected Records?"))
		{
			$.ajax({
				url:"../admin/update.php",
				method:"POST",
				data:{id:id},
				dataType:"json",
				success:function(data){
					$('#name').val(data.name);
					$('#username').val(data.username);
					$('#password').val(data.password);
					$('#retype-password').val(data.password);
					$('#user').val(data.usertype);
					$('#id').val(data.id);
					$('#insert').val("Update");
					$('#m-title').html('<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Update Account');
					$('#addModal').modal('show');
				}
			})
		}
	})

	
	$('#insert').click(function(event) { //------------Add Acount Function---------
		event.preventDefault();
		if($('#name').val()=="")
		{
			$('#alert_message2').html('<div class="alert alert-warning">Fullname is Required!</div>');
			setInterval(function(){
				$('#alert_message2').html('');
			},3000);

		}
		else if($('#username').val()=="")
		{
			$('#alert_message2').html('<div class="alert alert-warning">Username is Required!</div>');
			setInterval(function(){
				$('#alert_message2').html('');
			},3000);
		}
		else if($('#password').val()=="")
		{
			$('#alert_message2').html('<div class="alert alert-warning">Password is Required!</div>');
			setInterval(function(){
				$('#alert_message2').html('');
			},3000);
		}
		else if($('#retype-password').val()=="")
		{
			$('#alert_message2').html('<div class="alert alert-warning">Retype password is Required!</div>');
			setInterval(function(){
				$('#alert_message2').html('');
			},3000);
		}
		else if($('#user').val()=="") 
		{
			$('#alert_message2').html('<div class="alert alert-warning">Usertype is Required!</div>');
			setInterval(function(){
				$('#alert_message2').html('');
			},3000);
		}
		else
		{
			var pass = $('#password').val();
			var repass = $('#retype-password').val();

			if(pass == repass)
			{
				$.ajax({
					url:"../admin/insert.php",
					method:"POST",
					data:$('.insert-form').serialize(),
					success:function(data){
						$('.insert-form')[0].reset();
						$('#addModal').modal('hide');
						$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
						$('#user_data').DataTable().destroy();
						fetch_data();
					}
				})
				setInterval(function(){
				$('#alert_message').html('');
				},5000);
			}
			else
			{
				$('#alert_message2').html('<div class="alert alert-warning">Password is not match!</div>');
				$('#password').val("");
				$('#retype-password').val("");
				setInterval(function(){
					$('#alert_message2').html('');
				},3000);
			}
			
		}
	})

	function displayAcc() {
		document.getElementById("accContent").style.display = "block";
		document.getElementById("accContent2").style.display = "block";
		document.getElementById("accBtn").style.color = "#999";
	}
	function hideAcc() {
		document.getElementById("accContent").style.display = "none";
		document.getElementById("accContent2").style.display = "none";
		document.getElementById("accBtn").style.color = "#777";
	}
	var x = 1;
	$('#accBtn').click(function() {
		if(x == 1){
			displayAcc();
			x = 2;
		}
		else 
		{
			hideAcc();
			x = 1;
		}
	})
	
	

	function displayTrans() {
		document.getElementById("transContent").style.display = "block";
		document.getElementById("transContent2").style.display = "block";
		document.getElementById("transContent3").style.display = "block";
		document.getElementById("transBtn").style.color = "#999";
	}
	function hideTrans() {
		document.getElementById("transContent").style.display = "none";
		document.getElementById("transContent2").style.display = "none";
		document.getElementById("transContent3").style.display = "none";
		document.getElementById("transBtn").style.color = "#999";
	}
	var y = 1;

	$('#transBtn').click(function() {
		if(y == 1){
			displayTrans();
			y = 2;
		}
		else 
		{
			hideTrans();
			y = 1;
		}
	})

	

	function closeNav() {

	}
	$('#cancel').click(function(event) {
		event.preventDefault();
		$('.insert-form')[0].reset();
		$('#insert').val("Save");
		$('#m-title').html("<span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Add Account");
		$('#addModal').modal('hide');
	})
	$('#cancel_book').click(function(event) {
		event.preventDefault();
		$('.book_form')[0].reset();
		$('#stock-label').show();
		$('#stock').show();
		$('#insert_book').val("Save");
		$('#mod-title').html("<span class='glyphicon glyphicon-book'></span>&nbsp;&nbsp;Add Book");
		$('#bookModal').modal('hide');
	})
	$('#cat_close').click(function(event){//-------------------------Close naman ng Category
		event.preventDefault();
		$('.cat_form')[0].reset();
		$('#catModal').modal('hide');
	})
	$('.cat_close').click(function(event){
		event.preventDefault();
		$('.cat_form')[0].reset();
		$('#insert_cat').val("Add");
		$('#catModal').modal('hide');
	})

	$('#cancel_cat').click(function(event){
		event.preventDefault();
		//alert('napindot');
		$('.cat_form')[0].reset();
		$('#insert_cat').val("Add");
		$('#catModal').modal('hide');
	})
	
	$('.close-book').click(function(event) {//------------------------Close Button Ng Modal For Addbook
		event.preventDefault();
		$('.book_form')[0].reset();
		$('#stock').show();
		$('#stock-label').show();
		$('#insert_book').val("Save");
		$('#mod-title').html("<span class='glyphicon glyphicon-book'></span>&nbsp;&nbsp;Add Book");
		$('#bookModal').modal('hide');
	})
	$('#close-book').click(function(event) {
		event.preventDefault();
		$('.book_form')[0].reset();
		$('#stock').show();
		$('#stock-label').show();
		$('#insert_book').val("Save");
		$('#mod-title').html("<span class='glyphicon glyphicon-book'></span>&nbsp;&nbsp;Add Book");
		$('#bookModal').modal('hide');
	})

	$('#btn_cls').click(function(event) {
		event.preventDefault();
		$('.insert-form')[0].reset();
		$('#insert').val("Save");
		$('#m-title').html("<span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Add Account");
		$('#addModal').modal('hide');
	})

	$('#student_cancel').click(function(event) {
		event.preventDefault();
		$('#student_add').val("Save");
		$('#preview').html('');
		$('#action').val("insert");
		$('#sel_img').html("Select image");
      	$('#student_form')[0].reset();
      	$('#image').show();
	    $('#sel_img').show();
      	$('#s-title').html("<span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Add Student");
      	$('#studModal').modal("hide");
	})
	$('#student_cancel_2').click(function(event) {
		event.preventDefault();
		$('#student_add').val("Save");
		$('#preview').html('');
		$('#action').val("insert");
		$('#sel_img').html("Select image");
		$('#image').show();
	    $('#sel_img').show();
      	$('#student_form')[0].reset();
      	$('#s-title').html("<span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Add Student");
      	$('#studModal').modal("hide");
	})

	$('#borrow_close').click(function(event) {
		event.preventDefault();
      	$('.borrow_form')[0].reset();
      	$('#borrowModal').modal("hide");
	})

	
	

	//Function for adding books----------

	$('#insert_book').click(function(event){
		event.preventDefault();
		if($('#bookName').val()=="")
		{
			$('#alert_books').html('<div class="alert alert-warning">Book name is Required!</div>');
			setInterval(function(){
				$('#alert_books').html('');
			},3000);
		}
		else if($('#description').val()=="")
		{
			$('#alert_books').html('<div class="alert alert-warning">Book description is Required!</div>');
			setInterval(function(){
				$('#alert_books').html('');
			},3000);
		}
		else if($('#author').val()=="")
		{
			$('#alert_books').html('<div class="alert alert-warning">Book author is Required!</div>');
			setInterval(function(){
				$('#alert_books').html('');
			},3000);
		}
		else if($('#stock').val()=="")
		{
			$('#alert_books').html('<div class="alert alert-warning">Book Quantity is Required!</div>');
			setInterval(function(){
				$('#alert_books').html('');
			},3000);
		}
		else if($('#cat').val()=="")
		{
			$('#alert_books').html('<div class="alert alert-warning">Book category is Required!</div>');
			setInterval(function(){
				$('#alert_books').html('');
			},3000);
		}
		else 
		{
			$.ajax({
				url:"../admin/insert-book.php",
				method:"POST",
				data:$('.book_form').serialize(),
				success:function(data){
					$('.book_form')[0].reset();
					$('#bookModal').modal('hide');
					$('#alert_book_message').html('<div class="alert alert-success">'+data+'</div>');
					$('#book_data').DataTable().destroy();
					book_data();
				}

			})
			setInterval(function(){
			$('#alert_book_message').html('');
			},5000);
		}
	})
	//-----------------------------------Delete Book ---------------------------
	$(document).on('click','.delete_book', function(){

		var id = $(this).attr("id");
		if(confirm("Delete Selected Book?"))
		{
			$.ajax({
				url:"../admin/delete_book.php",
				method:"POST",
				data:{id:id},
				success:function(data){
					$('#alert_book_message').html('<div class="alert alert-success">'+data+'</div>');
					$('#book_data').DataTable().destroy();
					book_data();
				}
			})
			setInterval(function(){
				$('#alert_book_message').html('');
			},5000);
		}
	})
	
	$(document).on('click','.edit_book', function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		if(confirm("Update Selected Records?"))
		{
			$.ajax({
				url:"../admin/update_book.php",
				method:"POST",
				data:{id:id},
				dataType:"json",
				success:function(data){
					$('#bookName').val(data.book_name);
					$('#description').val(data.book_dis);
					$('#author').val(data.author);
					$('#cat').val(data.book_cat);
					$('#stock').val(data.stock);
					//$('#stock-label').hide();
					//$('#stock').hide();
					$('#id').val(data.id);
					$('#insert_book').val("Update");
					$('#mod-title').html("<span class='glyphicon glyphicon-book'></span>&nbsp;&nbsp;Update Book");
					$('#bookModal').modal('show');
				}
			})
		}
	})
	
	//--------------Function Category-----------------------
	$('#insert_cat').click(function(event){
		
		event.preventDefault();
		if($('#book-category').val()=="")
		{
			$('#alert_category').html('<div class="alert alert-warning">Category name is Required!</div>');
			setInterval(function(){
				$('#alert_category').html('');
			},3000);
		}
		else if($('#book-desc').val()=="")
		{
			$('#alert_category').html('<div class="alert alert-warning">Category description is Required!</div>');
			setInterval(function(){
				$('#alert_category').html('');
			},3000);
		}
		else 
		{
			$.ajax({
				url:"../admin/insert-category.php",
				method:"POST",
				data:$('.cat_form').serialize(),
				success:function(data){

					$('.cat_form')[0].reset();
					$('#insert_cat').val("Add");
					$('#alert_category').html('<div class="alert alert-success">'+data+'</div>');
					$('#cat_data').DataTable().destroy();
					category_data();	
					load_cat();

				}
			})
			setInterval(function(){
			$('#alert_category').html('');
			},5000);
		}
	})

	$(document).on('click','.delete_cat', function(){
		var id = $(this).attr("id");
		if(confirm("Delete Selected Category?"))
		{
			$.ajax({
				url:"../admin/delete_cat.php",
				method:"POST",
				data:{id:id},
				success:function(data){
					$('#alert_category').html('<div class="alert alert-success">'+data+'</div>');
					$('#cat_data').DataTable().destroy();
					category_data();
					load_cat();
				}
			})
			setInterval(function(){
				$('#alert_category').html('');
			},5000);
		}
	})

	$(document).on('click','.edit_cat', function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		if(confirm("Update Selected Category?"))
		{
			$.ajax({
				url:"../admin/update_cat.php",
				method:"POST",
				data:{id:id},
				dataType:"json",
				success:function(data){
					$('#book-category').val(data.category_name);
					$('#book-desc').val(data.category_disc);
					$('#cat-id').val(data.id);
					$('#insert_cat').val("Update");
					//$('#mod-title').html("<span class='glyphicon glyphicon-book'></span>&nbsp;&nbsp;Update Book");
					//$('#catModal').modal('show');
				}
			})
		}
	})


	//------------------------ADdd number Books--------------------------------

	$(document).on('click','.add_book', function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		if(confirm("Add number of books ?"))
		{
			$.ajax({
				url:"../admin/update_book.php",
				method:"POST",
				data:{id:id},
				dataType:"json",
				success:function(data){
					$('#book_name').html(data.book_name);
					$('#book_count').html(data.stock);
					$('#book_id').val(data.id);
					$('#addbookModal').modal('show');
				}
			})
		}
	})

	$('#insert_addbook').click(function(event){
		event.preventDefault();
		if($('#booknum').val()=="")
		{
			$('.alert_addbooks').html('<div class="alert alert-warning">Input number of book first!</div>');
			setInterval(function(){
				$('.alert_addbooks').html('');
			},3000);
		}
		else 
		{
			$.ajax({
				url:"../admin/insert-addbook.php",
				method:"POST",
				data:$('.addbook_form').serialize(),
				success:function(data){

					$('.addbook_form')[0].reset();
					$('#addbookModal').modal('hide');
					$('#alert_book_message').html('<div class="alert alert-success">'+data+'</div>');
					$('#book_data').DataTable().destroy();
					book_data();	

				}
			})
			setInterval(function(){
			$('#alert_book_message').html('');
			},5000);
		}

	})

	//-----------------------------Add student------------------------------

	$('#student_form').submit(function(event){
      event.preventDefault();

      var image_name = $('image').val();
      if($('#action').val()=="insert"){
      	if($('#fname').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Firstname is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }
	      else if($('#lname').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Lastname is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }  
	      else if($('#studid').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student ID number is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      } 
	      else if($('#address').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student address is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }  
	      else if($('#bdate').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Birth Date is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }    
	      else if($('#ylevel').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Year Level is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }   
	       else if($('#section').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Section is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }
	       else if($('#bdate').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Birth Date is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }  
	      else if($('#contact').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Contact Number is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }
	      else if($('#gender').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Gender is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }  
	       else if(image_name =='')
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Image is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	        return false;
	      }   
	      else
	      {
	        var extension = $('#image').val().split('.').pop().toLowerCase();
	        if(jQuery.inArray(extension,['jpeg','jpg','gif','png']) == -1)
	        {
	           $('#preview').html('');
	           $('#alert_student').html('<div class="alert alert-warning">Invalid Image Type!</div>');
	           $('#image').val('');
	            setInterval(function(){
	              $('#alert_student').html('');
	            },3000);
	           
	        }
	        else
	        {
	          $.ajax({
	            url: "../admin/add_student.php",
	            method: "POST",
	            data:new FormData(this),
	            contentType:false,
	            processData:false,
	            success:function(data)
	            {
	              $('#alert_student_message').html('<div class="alert alert-success">'+data+'</div>');
	              $('#preview').html('');
	              $('#student_form')[0].reset();
	              $('#studModal').modal("hide");
	              $('#student_data').DataTable().destroy();
	              student_data();
	            }
	          })
	          setInterval(function(){
	            $('#alert_student_message').html('');
	          },5000);
	        }
	      }
      }
      else if($('#action').val()=="update")
      {
      	//alert("napindot");
  		if($('#fname').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Firstname is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }
	      else if($('#lname').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Lastname is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }  
	      else if($('#studid').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student ID number is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      } 
	      else if($('#address').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student address is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }  
	      else if($('#bdate').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Birth Date is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }    
	      else if($('#ylevel').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Year Level is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }   
	       else if($('#section').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Section is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }
	       else if($('#bdate').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Birth Date is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }  
	      else if($('#contact').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Contact Number is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }
	      else if($('#gender').val()=="")
	      {
	        $('#alert_student').html('<div class="alert alert-warning">Student Gender is Required!</div>');
	        setInterval(function(){
	          $('#alert_student').html('');
	        },3000);
	      }  
	        
	      else
	      {
	        
	          $.ajax({
	            url: "../admin/add_student.php",
	            method: "POST",
	            data:new FormData(this),
	            contentType:false,
	            processData:false,
	            success:function(data)
	            {
	              $('#alert_student_message').html('<div class="alert alert-success">'+data+'</div>');
	              $('#preview').html('');
	              $('#student_form')[0].reset();
	              $('#studModal').modal("hide");
	              $('#student_data').DataTable().destroy();
	              student_data();
	            }
	          })
	          setInterval(function(){
	            $('#alert_student_message').html('');
	          },5000);
	        $('#image').show();
	        $('#sel_img').show();
	      }    	
      }
      
    });

    $(document).on('click','.view_student', function(){

		var id = $(this).attr("id");
		if(confirm("View Student Records?"))
		{
			
			$.ajax({
				url:"../admin/view_student.php",
				method:"POST",
				data:{id:id},
				dataType:"json",
				success:function(data){
					
					var lname = data.lname.toLowerCase();
					var ln = lname.charAt(0).toUpperCase() + lname.slice(1);
					var mi = data.mi.toLowerCase();
					var m = mi.charAt(0).toUpperCase() + mi.slice(1);
					var fname = data.fname.toLowerCase();
					var fn = fname.charAt(0).toUpperCase() + fname.slice(1);

					var name = fn + " " + m + " " + ln;

					$('#img').attr('src',data.img);
					$('#dbName').html(name);
					$('#dbGender').html(data.gender);
					$('#dbGrade').html(data.ylevel);
					$('#dbSection').html(data.section);
					$('#dbContact').html(data.contact);
					$('#dbAddress').html(data.address);
					$('#library_id').html(data.libraryid);
					$('#stud_id').html(data.studentid);
					$('#id').val(data.id);						
					$('#viewModal').modal('show');
				}
			})
		}
	})

	$(document).on('click','.delete_student', function(){
		var id = $(this).attr("id");
		if(confirm("Delete Selected Student?"))
		{
			$.ajax({
				url:"../admin/delete_student.php",
				method:"POST",
				data:{id:id},
				success:function(data){
					$('#alert_student_message').html('<div class="alert alert-success">'+data+'</div>');
					$('#student_data').DataTable().destroy();
					student_data();
				}
			})
			setInterval(function(){
				$('#alert_student_message').html('');
			},5000);
		}
	})

	$(document).on('click','.edit_student', function(){

		var id = $(this).attr("id");
		if(confirm("Edit Student Records?"))
		{
			
			$.ajax({
				url:"../admin/view_student.php",
				method:"POST",
				data:{id:id},
				dataType:"json",
				success:function(data){
					var g = data.ylevel.toLowerCase();
					var fg = g.charAt(0).toUpperCase() + g.slice(1);

					$('#student_add').val("Update");
					$('#s-title').html("<span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Update Student");
					$('#fname').val(data.fname);
					$('#lname').val(data.lname);
					$('#mi').val(data.mi);
					$('#studid').val(data.studentid);
					$('#bdate').val(data.bdate);
					$('#section').val(data.section);
					//$('#section').val(fg);
					$('#ylevel').val(fg);
					$('#address').val(data.address);
					$('#contact').val(data.contact);
					$('#gender').val(data.gender);
					//$('#image').val('');
					//$('#sel_img').hide();
					//$('#preview').html('<img src='+data.img+'>');
					$('#dbid').val(id);
					$('#action').val("update");
					//$('#image').hide();
              		$('#studModal').modal("show");

              		
				}
				
			})
		}
	})

	$(document).on('click','.borrow_book', function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		if(confirm("Borrow Selected Book?"))
		{
			$.ajax({
				url:"../admin/borrow_book.php",
				method:"POST",
				data:{id:id},
				dataType:"json",
				success:function(data){
					$('#borrow_name').html(data.book_name);
					//$('#description').val(data.book_dis);
					//$('#author').val(data.author);
					//$('#cat').val(data.book_cat);
					$('#stock').html(data.stock);
					$('#count').val(data.stock);
					$('#bookn').val(data.book_name);
					//$('#stock').hide();
					$('#book_id').val(data.id);
					$('#borrowModal').modal('show');
				}
			})
		}
	})

	var pending;
	var cardid;

	$('#sub_borrow').click(function(event){
		
		event.preventDefault();
		if($('#libraryid').val()=="")
		{
			$('.alert_borrow').html('<div class="alert alert-warning">Library Card Number Required</div>');
			setInterval(function(){
				$('.alert_borrow').html('');
			},3000);
		}
		else if($('#days').val()=="")
		{
			$('.alert_borrow').html('<div class="alert alert-warning">Days is Required</div>');
			setInterval(function(){
				$('.alert_borrow').html('');
			},3000);
		}
		else 
		{
			
					
			$.ajax({
			url:"../admin/insert-borrow.php",
			method:"POST",
			data:$('.borrow_form').serialize(),
			success:function(data){

				$('.borrow_form')[0].reset();

				$('#alert_borrow_message').html(data);
				$('#borrowModal').modal('hide');
				$('#borrow_data').DataTable().destroy();
				borrow_data();	
				//$('#return_data').DataTable().destroy();
				//return_data();
				}
			})
				setInterval(function(){
				$('#alert_borrow_message').html('');
				},5000);	
			
		}
	})

	$(document).on('click','.return_book', function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		if(confirm("Return Selected Book?"))
		{
			$.ajax({
				url:"../admin/return_book.php",
				method:"POST",
				data:{id:id},
				dataType:"json",
				success:function(data){
					var datereturn = data.datereturn;
					var bookname = data.bname;

					if ($('#date').val() > datereturn) 
					{
						$('#bookn').val(data.bname);
						$('#book_name').html(data.bname);
						$('#borrowed').html(data.dateborrow);
						$('#return').html(datereturn);
						$('#studname').html(data.studname);
						$('#libid').html(data.libraryid);
						$('#studid').val(data.libraryid);
						$('#borrowid').val(data.id);
						$('#pay').attr("type","text");
						$('#payment').html("Payment");
						$('#stat').val("penalty");
						$('#penalty').html(data.penalty);	
						$('#penalty_txt').val(data.penalty);
						$('#book_id').val(data.bookid);
						$('#returnModal').modal('show');
					}
					else
					{
						$('#stat').val("clear");
						$('#pay').attr("type","hidden");
						$('#payment').html("");
						$('#bookn').val(data.bname);
						$('#book_name').html(data.bname);
						$('#borrowed').html(data.dateborrow);
						$('#return').html(datereturn);
						$('#studname').html(data.studname);
						$('#libid').html(data.libraryid);
						$('#studid').val(data.libraryid);
						$('#borrowid').val(data.id);
						$('#book_id').val(data.bookid);
						$('#penalty').html('');	
						$('#returnModal').modal('show');
					}
					
	

				}
			})
		}
	})

	$('#return_close').click(function(event) {
		event.preventDefault();
		$('#stat').val("clear");
      	$('#pay').attr("type","hidden");
		$('#payment').html("");
		$('#penalty').html("");	
		$('#book_name').html("");
		$('#borrowed').html("");
		$('#return').html("");
		$('#studname').html("");
		$('#libid').html("");
			$('.return_form')[0].reset();
      	$('#returnModal').modal("hide");
	})

	$('#sub_return').click(function(event){
		
		event.preventDefault();
		var pen = parseInt($('#penalty_txt').val());


		if($('#stat').val() == "penalty") 
		{
			var inputpay =  parseInt($('#pay').val()); 

			if($('#pay').val() == "")
			{
				$('.alert_return').html('<div class="alert alert-warning">Payment Required</div>');
				setInterval(function(){
					$('.alert_return').html('');
				},3000);
			}
			else 
			{
				if(inputpay < pen)
				{
					$('.alert_return').html('<div class="alert alert-warning">Payment not enough</div>');
				setInterval(function(){
					$('.alert_return').html('');
				},3000);

				}
				else
				{
					$.ajax({
					url:"../admin/insert-return.php",
					method:"POST",
					data:$('.return_form').serialize(),
					success:function(data){

						$('.return_form')[0].reset();

						$('#alert_return_message').html(data);
						$('#returnModal').modal('hide');
						$('#return_data').DataTable().destroy();
						return_data();	

						}
					})
						setInterval(function(){
						$('#alert_return_message').html('');
						},5000);
				}

				
			}
		}else {
			$.ajax({
				url:"../admin/insert-return.php",
				method:"POST",
				data:$('.return_form').serialize(),
				success:function(data){

					$('.return_form')[0].reset();
					$('#alert_return_message').html(data);
					$('#returnModal').modal('hide');
					$('#return_data').DataTable().destroy();
					return_data();	

					}
				})
					setInterval(function(){
					$('#alert_return_message').html('');
			},5000);

		}		
				
	})
	$(document).on('click','.reserve_btn', function(event){
		//alert('napindot');
		event.preventDefault();
		var id = $(this).attr("id");
		if(confirm("Reserve Selected Book?"))
		{

			$.ajax({
				url:"../admin/reserve_book.php",
				method:"POST",
				data:{id:id},
				dataType:"json",
				success:function(data){
					
					$('#borrow_name').html(data.book_name);
					
					$('#stock').html(data.book_left);
					//$('#count').val(data.stock);
					$('#bookn').val(data.book_name);
					
					$('#book_id').val(data.id);

					$('#resModal').modal('show');
				}	
			});
		}
		else
		{

		}
	})

	$('#sub_reserve').click(function(event){
		
		event.preventDefault();
	
			if($('#libraryid').val() == "")
			{
				$('.alert_reserve').html('<div class="alert alert-warning">Card Number Required</div>');
				setInterval(function(){
					$('.alert_reserve').html('');
				},3000);

			}
			else 
			{
				
				$.ajax({
				url:"../admin/insert-reserve.php",
				method:"POST",
				data:$('.reserve_form').serialize(),
				success:function(data){

					$('.reserve_form')[0].reset();

					$('#alert_reserve_message').html(data);
					$('#resModal').modal('hide');
					$('#result_book').html('');
					$('#reserve_data').DataTable().destroy();
					reserve_data();	

					}
				})
					setInterval(function(){
					$('#alert_reserve_message').html('');
					},5000);
		
		}		
				
	})

	$(document).on('click','.borrow2_book', function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		//$('#hiddenborrow').val(id);
		if(confirm("Borrow The Pending Reserved Book?"))
		{
			$.ajax({
				url:"../admin/borrow2_book.php",
				method:"POST",
				data:{id:id},
				dataType:"json",
				success:function(data){
					$('#borrow_name2').html(data.bname);
					//$('#description').val(data.book_dis);
					//$('#author').val(data.author);
					//$('#cat').val(data.book_cat);
					//$('#stock2').html(data.stock);
					//$('#count2').val(data.stock);
					$('#bookn2').val(data.bname);
					$('#res_id').val(id);
					//$('#stock').hide();
					$('#book_id2').val(data.bookid);
					$('#libraryid3').html(data.libraryid);
					$('#libraryid2').val(data.libraryid);
					$('#studname2').val(data.studname);
					$('#studname3').html(data.studname);
					$('#borrowModal2').modal('show');
				}
			})
		}
	})

	$('#sub_borrow2').click(function(event){
		
		event.preventDefault();
		
		if($('#days').val()=="")
		{
			$('.alert_borrow2').html('<div class="alert alert-warning">Days is Required</div>');
			setInterval(function(){
				$('.alert_borrow2').html('');
			},3000);
		}
		else 
		{	
					
			$.ajax({
			url:"../admin/insert-borrow2.php",
			method:"POST",
			data:$('.borrow_form2').serialize(),
			success:function(data){

				$('.borrow_form2')[0].reset();

				$('#alert_reserve_message').html(data);
				$('#borrowModal2').modal('hide');
				$('#reserve_data').DataTable().destroy();
				reserve_data();	
				
				}
			})
				setInterval(function(){
				$('#alert_reserve_message').html('');
				},5000);	
			
		}
	})

	$('#transContent3').click(function(event){

  
  		$.ajax({
			url:"../admin/delete_reserve.php",
			method:"POST",
			success:function(data)
			{
				$('#reserve_data').DataTable().destroy();
				reserve_data();	
			}
		})
  	})

  	$(document).on('click','.cancel_book', function(event){
		event.preventDefault();
		var id = $(this).attr("id");
		//$('#hiddenborrow').val(id);
		if(confirm("Cancel Reserved Book?"))
		{
			$.ajax({
				url:"../admin/cancel_reserve.php",
				method:"POST",
				data:{id:id},
				dataType:"text",
				success:function(data){
					
					$('#reserve_data').DataTable().destroy();
					reserve_data();	
					$('#alert_reserve_message').html(data);
				}

			})
			setInterval(function(){
				$('#alert_reserve_message').html('');
				},5000);	
			
		}
	})



	
})