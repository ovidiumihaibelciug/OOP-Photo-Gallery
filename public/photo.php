<?php
require_once '../includes/initialize.php';

if (empty($_GET['id'])) {
	$session->message("No photo ID was provided");
	redirect_to('index.php');
}

$photo = Photograph::find_by_id($_GET['id']);
$message = "";
if (isset($_POST['submit'])) {
	$author = htmlentities(trim($_POST['user']));
	$body = htmlentities(trim($_POST['body']));
	$new_comment = Comment::make($photo->id, $author, $body);

	if($new_comment && $new_comment->save()){
		redirect_to("photo.php?id={$photo->id}");
	} else {
		$message = "There was a problem";
	}
} else {
	$author = "";
	$body = "";
}
$comments = Comment::find_comments_on($photo->id);

?>
<?php include_layout_template('header.php'); ?>

<div style="margin:0 auto; margin-left:5%">
	<a href="index.php"><button class="btn btn-outline-danger" style="margin-bottom: 5px">Back</button></a>
	<div class="">
		<div>
			<img src="<?php echo $photo->image_path(); ?>" style="max-width: 100vh; max-height: 100vh" alt="">
			<p><?php echo $photo->caption; ?></p>
		</div>
	</div>
	<?php foreach ($comments as $comment): ?>
	<div class="media" style="padding: 10px; max-width: 50%" >
	  <div class="media-body">
	    <h5 class="mt-0"><?php echo htmlentities($comment->author); ?></h5>
	   	<p><?php echo htmlentities($comment->body); ?></p>
	   	<p><?php echo htmlentities($comment->created); ?></p>	
	  </div>
	</div>
<?php endforeach ?>
<?php if (empty($comments)) {
	echo "No comments";
	} ?>
	<?php echo output_message($message); ?>
	<div class="comment-form">
		<h3>New Comment</h3>
		<form action="photo.php?id=<?php echo $photo->id; ?>" method="POST">
			<div class="form-group">
				<label for="user"><strong>Your name:</strong></label>
				<input type="text" class="form-control" name="user" id="user">
			</div>
			<div class="form-group">
				<label for="body"><strong>Your comment:</strong></label>	
				<textarea name="body" id="body" style="width: 100%" rows="10"></textarea>			
			</div>
			<input type="submit" name="submit" id="submit" class="btn btn-outline-success" value="Submit comment">
		</form>
	</div>
	
</div>


<?php include_layout_template('footer.php'); ?>
    