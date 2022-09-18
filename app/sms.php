<?php
	require '../config/config.php';
	if(empty($_SESSION['username']))
		header('Location: login.php');	

		try {
			$stmt = $connect->prepare('SELECT * FROM users');
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) {
			$errMsg = $e->getMessage();
		}

		 try {
			$stmt = $connect->prepare('SELECT * FROM room_rental_registrations');
			$stmt->execute();
			$dataroom = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) {
			$errMsg = $e->getMessage();
		}

		if(isset($_POST['sms_alert'])) {
			try {
				print_r($_POST);
				foreach ($_POST['check'] as $key => $value) {
					# code...
					//echo '<br>'.$value.'<br>';
					//send sms api code here
				}

				exit();
				header('Location: sms.php');
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}


		// print_r($data);	
?>
<?php include '../include/header.php';?>
	<!-- Header nav -->	
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#212529;" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="../index.php">Bungoma County</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav text-uppercase ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="login.php"><?php echo $_SESSION['fullname']; ?> <?php if($_SESSION['role'] == 'admin'){ echo "(Admin)"; } ?></a>
            </li>
            <li class="nav-item">
              <a href="../auth/logout.php" class="nav-link">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
	<!-- end header nav -->
<?php include '../include/side-nav.php';?>
<section class="wrapper" style="margin-left:16%;margin-top: -11%;">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php
					if(isset($errMsg)){
						echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
					}
				?>
				<h2>List Of Usres</h2>  <button style="background: dodgerblue; margin: 4px; outline: none; border-radius: 5px; padding-right: 8px; padding-left: 8px;">Print</button>
				<div class="table-responsive text-center">
					<form action="" method="post">
						<table class="table table-bordered">
						  <thead>
						    <tr>
						      <!-- <th><input type="checkbox" name="" id="selectAll"></th> -->
						      <th>Full Name</th>
						      <th>Moblie</th>
						      <th>Email</th>
						      <th>Date created</th>
						      <th>Role</th>
						      <!-- <th>Username</th> -->
						      <!-- <th>Role</th> -->
						      <!-- <th>Action</th> -->
						    </tr>
						  </thead>
						  <tbody>
						  	<?php 
						  		foreach ($data as $key => $value) {
						  			# code...				  			
								   echo '<tr>';
								      // echo '<th scope="row"><input type="checkbox" name="check[]" value="'.$value['mobile'].'" id="selectAll$key"></th>';
								      echo '<td>'.$value['fullname'].'</td>';
								      echo '<td>'.$value['mobile'].'</td>';
								      echo '<td>'.$value['email'].'</td>';
								      echo '<td>'.$value['created_at'].'</td>';
								      echo '<td>'.$value['role'].'</td>'; 
								   echo '</tr>';
						  		}
						  	?>
						  </tbody>
						</table>
						<br>
						
					</form>
				</div>


					<h2>List Of Rooms</h2> <button style="background: dodgerblue; margin: 4px; outline: none; border-radius: 5px; padding-right: 8px; padding-left: 8px;" onclick="printPage();">Print</button>
				<div class="table-responsive text-center">
					<form action="" method="post">
						<table class="table table-bordered" id="tblrooms">
						  <thead>
						    <tr>
						      <!-- <th><input type="checkbox" name="" id="selectAll"></th> -->
						      <th>Full Name</th>
						      <th>Moblie</th>
						      <th>Country</th>
						      <th>State</th>
						      <th>City</th>
						      <th>Rent</th>
						      <th>Status</th>
						      <!-- <th>Username</th> -->
						      <!-- <th>Role</th> -->
						      <!-- <th>Action</th> -->
						    </tr>
						  </thead>
						  <tbody>
						  	<?php 
						  		foreach ($dataroom as $key => $value) {
						  			# code...				  			
								   echo '<tr>';
								      // echo '<th scope="row"><input type="checkbox" name="check[]" value="'.$value['mobile'].'" id="selectAll$key"></th>';
								      echo '<td>'.$value['fullname'].'</td>';
								      echo '<td>'.$value['mobile'].'</td>';
								      echo '<td>'.$value['country'].'</td>';
								      echo '<td>'.$value['state'].'</td>';
								      echo '<td>'.$value['city'].'</td>'; 
								      echo '<td>'.$value['rent'].'</td>';
								      echo '<td>'.$value['vacant'].'</td>';
								   echo '</tr>';
						  		}
						  	
						  		
						  	?>
						  </tbody>
						</table>
						<br>
						
					</form>
				</div>




			</div>
		</div>
	</div>
</section>
<?php include '../include/footer.php';?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js" ></script>
<script type="text/javascript">

	$('#selectAll').click(function(){
		console.log("Welcome to sms alert"+$(this).prop("checked"));	
		$("input:checkbox").prop('checked', $(this).prop("checked"));	
		//alert("Confirm Before sending SMS");
		//event.preventDefault();	
	});
	
	
</script>

<script type="text/javascript">
 function printPage(){
        var tableData = '<table border="1">'+document.getElementsByTagName("table")[0].innerHTML+'</table>';
        var data = '<button onclick="window.print()">Print this page</button>'+tableData;       
        myWindow=window.open('','','width=800,height=600');
        myWindow.innerWidth = screen.width;
        myWindow.innerHeight = screen.height;
        myWindow.screenX = 0;
        myWindow.screenY = 0;
        myWindow.document.write(data);
        myWindow.focus();



   

             
    };
 </script>