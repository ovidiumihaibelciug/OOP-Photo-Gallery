<?php 

require_once './../includes/initialize.php';

$page  = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$per_page = 3;
$total_count = Photograph::count_all();

$pagination = new Pagination($page, $per_page, $total_count);

$query = "SELECT * FROM `photographs` ";
$query.= "LIMIT {$per_page} ";
$query.= "OFFSET {$pagination->offset()}";
$photos = Photograph::find_by_sql($query);


// $photos = Photograph::find_all();
include_layout_template('header.php');


foreach ($photos as $photo): ?>
	<div class="">
		<a href=""></a>
		<div class="img-box" style="float:left; margin: 10px;">
			<a href="photo.php?id=<?php echo $photo->id; ?>">
				<img src="<?php echo $photo->image_path(); ?>" width="200" alt="">
			</a>
			<p><?php echo $photo->caption; ?></p>
		</div>
	</div>

<?php endforeach; ?>

<div class="pagination" style="clear: both;">
	<?php if ($total_count > 1): ?>
		
		<?php if ($pagination->has_previous_page()): ?>
			<a href="index.php?page=<?php echo $pagination->previous_page() ?>"> &laquo; Previous </a>&emsp;
		<?php endif ?>
		<?php for ($i=1; $i < $total_count; $i++):?>
			<?php if ($i == $page): ?>
				<span><?php echo $i; ?></span> &emsp;
			
			<?php else: ?>
				<a href="index.php?page=<?php echo $i ?>"><?php echo "{$i}"; ?></a> &emsp;
				
			<?php endif ?>
		<?php endfor; ?>

		<?php if ($pagination->has_next_page()): ?>
			<a href="index.php?page=<?php echo $pagination->next_page() ?>"> Next &raquo; </a>
		<?php endif ?>
	<?php endif ?>
</div>


<?php include_layout_template('footer.php'); ?>