<?php
include("../connection.php");
$book_category = mysqli_query($connection,"SELECT * FROM category");
?>
<select class="form-control" name="cat" id="cat">
	<option class="form-control" value="" name="cat">Book Category</option>
	<?php while($row =mysqli_fetch_array($book_category)):; ?>
	<option class="form-control" name="cat" value="<?php echo $row[1];?>"> <?php echo $row[1];?> </option>
	<?php endwhile;?>
</select>
