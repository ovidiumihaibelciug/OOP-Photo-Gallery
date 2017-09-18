<?php
require_once '../../includes/initialize.php';
if (!$session->is_logged_in()) { redirect_to("login.php"); }

include_layout_template('admin_header.php'); 
$photos = Photograph::find_all();

?>

<div id="header">
	
</div>
<div id="main" style="width: 80%; margin: 0 auto; ">
	<?php echo output_message($message); ?>
	<table class="table table-bordered">
		<thead class="thead-inverse">
		  <tr>
		    <th>Image</th>
		    <th>Filename</th>
		    <th>Type</th> 
		    <th>Size</th>
		    <th>Caption</th>
		    <th></th>
		  </tr>
		</thead>
	  <?php foreach ($photos as $photo): ?>
	  	<tr>
		    <td><img src="<?php echo "../".$photo->image_path(); ?>" alt="" style="max-height: 100px; max-width: 100px;"></td>
		    <td><?php echo $photo->filename; ?></td> 
		    <td><?php echo $photo->type; ?></td>
		    <td><?php echo $photo->size_as_text(); ?></td>
		    <td><?php echo $photo->caption; ?></td>
		    <td><a href="delete_photo.php?id=<?php echo $photo->id; ?>"><button class="btn btn-outline-danger">Delete</button></a></td>
	  	</tr>
	  <?php endforeach ?>
	</table>
	  <a href="photo_upload.php">Upload new photograph</a>
</div>

<?php include_layout_template('admin_footer.php'); ?>
    