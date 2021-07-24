<?php

   error_reporting(~E_NOTICE);
   
   use App\User;
   use App\Uploader;
   
   include_once('inc/header.php');
   include_once('vendor/autoload.php');

   $directory = 'inc/assets/files/';
   $user = [];
   $flag = false;
   
   if(isset($_POST['submit'])) {
      $user['first_name'] = $_POST['first_name']; 
      $user['last_name'] = $_POST['last_name'];
      $user['email'] = $_POST['email'];
      $user['password'] = $_POST['password'];
      $user['conf_password'] = $_POST['conf_password'];
      $user['dob'] = $_POST['dob'];G
      $user['country'] = $_POST['country'];
      $user['terms'] = $_POST['terms'] ?? null;
      
      /** Create user object, validate and insert into database */
      $userObj = new User($user);
      $error = $userObj->validate();
      
      if (!is_uploaded_file($_FILES['photo']['tmp_name'])){
         $error .= "<li>Profile photo cannot be left blank.</li>";
      }

      if(!$error) {
         $uploader = new Uploader();
         $uploader->setDir($directory);
         $uploader->setExtensions(array('jpg','jpeg','png','gif'));  //allowed extensions list//
         $uploader->setMaxSize(1); //set max file size to be allowed in MB//

         if($uploader->uploadFile('photo')){     
            $image = $uploader->getUploadName(); //get uploaded file name, renames on upload//
            $userObj->setPhoto($image);
         } else{
            $uploader->getMessage(); //get upload error message 
         }

         $result = $userObj->insert();
         $flag = true;
      }
   }
?>
<div class="signup-form">
    <form method="post" action="index.php" enctype="multipart/form-data">
		<h2>Register</h2>
		<p class="hint-text">Create your account. It's free and only takes a minute.</p>
      <div class="form-group">
        <?php if(isset($error)): ?>
        <div class="row">
            <div class="form-group">
               <div class="alert alert-danger" role="alert">
                  <ul>
                     <?=$error ?>
                  </ul>
               </div>
            </div>
         </div>
         <?php elseif($flag): ?>
            <div class="row">
               <div class="form-group">
                  <div class="alert alert-success" role="alert">
                     Registration successful. Click here to login
                  </div>
               </div>
            </div>
         <?php endif; ?>
			<div class="row">
				<div class="col"><input required <?php if(isset($user['first_name'])) { echo 'value="'.$user['first_name'].'"'; } ?> type="text" class="form-control" name="first_name" placeholder="First Name" ></div>
				<div class="col"><input required <?php if(isset($user['last_name'])) { echo 'value="'.$user['last_name'].'"'; } ?> type="text" class="form-control" name="last_name" placeholder="Last Name" ></div>
			</div>        	
        </div>
        <div class="form-group">
        	<input type="email" required <?php if(isset($user['email'])) { echo 'value="'.$user['email'].'"'; } ?> class="form-control" name="email" placeholder="Email" >
        </div>
		<div class="form-group">
            <input type="password" required <?php if(isset($user['password'])) { echo 'value="'.$user['password'].'"'; } ?> class="form-control" name="password" placeholder="Password" >
      </div>
		<div class="form-group">
            <input type="password" required <?php if(isset($user['conf_password'])) { echo 'value="'.$user['conf_password'].'"'; } ?> class="form-control" name="conf_password" placeholder="Confirm Password" >
      </div>
      <div class="form-group">
            <input type="date" required <?php if(isset($user['dob'])) { echo 'value="'.$user['dob'].'"'; } ?> class="form-control" name="dob" placeholder="Date of Birth" >
      </div>
      <div class="form-group">
            <input type="text" required <?php if(isset($user['country'])) { echo 'value="'.$user['country'].'"'; } ?> class="form-control" name="country" placeholder="Country" >
      </div>
      <div class="form-group">
            <input type="file" required class="form-control" name="photo" placeholder="Your Photo">
      </div>
      <div class="form-group">
			<label class="form-check-label"><input required <?php if(isset($user['terms'])) { echo 'checked'; } ?> type="checkbox" name="terms">&nbsp;I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
		</div>
		<div class="form-group">
            <input type="submit" name="submit" class="btn btn-success btn-lg btn-block" value="Register Now">
        </div>
    </form>
	<div class="text-center">Already have an account? <a href="#">Sign in</a></div>
</div>
<?php 
   include_once('inc/footer.php');
?>
   