<?php
require_once '../../includes/initialize.php';
if (!$session->is_logged_in()) { redirect_to("login.php"); }

include_layout_template('admin_header.php'); 

$user = new User();
$user->username  = 'asda';
$user->password  = 'asda';
$user->lastname  = 'asda';
$user->firstname = 'asda';
$user->create();

 
?>

<div id="header">
<h1>Photo Gallery</h1>
</div>
<div id="main">
	<h2>Menu</h2>
	<a href="list_photos.php">List of photos</a>
	<a href="sign_out.php">Sign out</a>
</div>

<?php include_layout_template('admin_footer.php'); ?>
    