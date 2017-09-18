<?php
require_once '../../includes/initialize.php';
if (!$session->is_logged_in()) { redirect_to("login.php"); }


$max_file_size = 10485760;
$message = "";
if (isset($_POST['submit'])) {
	$photo = new Photograph();
	$photo->caption = htmlentities($_POST['caption']);
	$photo->attach_file($_FILES['file_upload']);
	if ($photo->save()) {
		$session->message("Photo uploaded successfully");
		redirect_to('list_photos.php');
	} else {
		$message = join("<br>", $photo->errors);
	}

}


include_layout_template('admin_header.php'); 
?>

<div id="header">
	
</div>
<div id="main">
	<div class="box">
		<?php if (!empty($message)): ?>
			<div class="alert alert-warning">
				<?php echo $message; ?>
			</div>		
		<?php endif ?>

		<h1>Photo Upload</h1>
		<form action="photo_upload.php" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="100000000">
			<div class="form-group">
				<label for="caption">Caption:</label>
				<input type="text" name="caption" id="caption">	
			</div>
			<div class="form-group">
				<label for="file_upload">File</label>
				<input type="file" name="file_upload" id="file_upload">
			</div>
			<input type="submit" name="submit" value="Upload" class="btn btn-success">
		</form>
		<a href="list_photos.php">List of photos</a>
	</div>
</div>
<?php include_layout_template('admin_footer.php'); ?>