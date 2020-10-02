<?php include("config.php");
if(!loggedin()){
header("Location: login.php");
exit();
}
?>

<!-------- User Section ----->
<?php
if(isset($_POST['userID'])) {
	
$get_user_id = $_POST['userID'];

$query_select = $con->query("SELECT * FROM `users` WHERE `user_id` = '{$get_user_id}' LIMIT 1");
$row_select = mysqli_fetch_array($query_select);

$user_id = $row_select['user_id'];
$user_name = $row_select['user_name'];
$user_password = $row_select['user_password'];
$user_email = $row_select['user_email'];
$user_phone = $row_select['user_phone'];
$user_image = $row_select['user_image'];
$user_type = $row_select['user_type'];

if($query_select) {
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card-box"> 									
			<form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
				<input type="hidden" name="userID_update" id="userID_update" parsley-trigger="change" required value="<?php echo $user_id; ?>" class="form-control">
				<div class="form-group">
					<label for="userName">Name*</label>
					<input type="text" name="userName_update" id="userName_update" parsley-trigger="change" required value="<?php echo $user_name; ?>" class="form-control">
				</div>
				<div class="form-group">
					<label for="userName">Email*</label>
					<input type="text" name="userEmail_update" id="userEmail_update" parsley-trigger="change" required value="<?php echo $user_email; ?>" class="form-control">
				</div>
				<div class="form-group">
					<label for="userName">Password*</label>
					<input type="text" name="userPassword_update" id="userPassword_update" parsley-trigger="change" required value="<?php echo $user_password; ?>" class="form-control">
				</div>
				<div class="form-group">
					<label for="userName">Phone*</label>
					<input type="text" name="userPhone_update" id="userPhone_update" parsley-trigger="change" required value="<?php echo $user_phone; ?>" class="form-control">
				</div>
				<div class="form-group">
					<label for="userName">User Type*</label>
					<select class="form-control" name="userType_update" id="userType_update" required parsley-trigger="change">
						<?php if($user_type == 1) { ?>						
						<option selected value="1">Manager</option>
						<option value="2">Employee</option>
						<?php } else { ?>
						<option selected value="2">Employee</option>
						<option value="1">Manager</option>
						<?php } ?>
					</select>					
				</div>
				<div class="form-group">
					<label for="userName">Image*</label>
					<input type="text" name="userImage_update" id="userImage_update" parsley-trigger="change" required value="<?php echo $user_image; ?>" class="form-control">
				</div>				
				<div class="form-group text-right m-b-0">
					<button class="btn btn-primary waves-effect waves-light" type="submit" name="user_update" id="updateUser">Update</button>
				</div>
			</form>
													
		</div>
	</div>
</div>
<?php } } ?>