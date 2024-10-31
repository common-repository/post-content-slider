<?php
	echo "<li class=\"mainRotate\">";
		echo "<div class='pcs-post pcs-post-".$i."'>";
			echo "<input type='hidden' class='pcs-input-id' value='".get_the_ID()."'>";
			if (get_the_post_thumbnail(get_the_ID(), array($pcs_width_image,9999))){
				echo get_the_post_thumbnail(get_the_ID(), array($pcs_width_image,9999));
				echo "<br/>";
			}
			echo "<a class='pcs-post-title' href='".get_permalink()."'>".get_the_title()."</a>";
			echo "<a class='pcs-post-excerpt' href='".get_permalink()."'>".the_excerpt()."</a>";
		echo "</div>";
	echo "</li>";
?>