<div class="image-gallery">

	<?php
		$item_title = $item_obj->item_title;

		$count = 0;

		foreach($gallery_pics as $gallery_pic) {
			$count++;
			$pic_path = $gallery_dir.$gallery_pic;
			$alt_text = $item_title. ' - picture '.$count;

			if ($count == 1) {
				echo '<img class="image-gallery-main" src="'. $pic_path.'" alt="'.$item_title.'">';
			}
			echo '<img class="thumb" src="'.$pic_path.'" alt="'.$alt_text.'">';
		}
	 ?>
</div>