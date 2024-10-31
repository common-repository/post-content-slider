<?
	class pcs_widget_showdata extends WP_Widget {
		function pcs_widget_showdata() {
			$widget_ops = array(
			"classname"=> "pcs_widget_showdata",
			"description"=> "Show posts with fade animation. Developed by Polvo."
			);
			$this->WP_Widget("pcs_widget_showdata", "Post Content Slider",$widget_ops );
		}
		//build the widget settings form
		function form($instance) {
			$defaults = array("pcs_title" => "Settings", "pcs_posts_quantity" => "10", "pcs_exhibition_time" => "10", "pcs_term_id" => "0");
			$instance = wp_parse_args( (array) $instance, $defaults );
			$pcs_title = $instance["pcs_title"];
			$pcs_height_box = $instance["pcs_height_box"];
			$pcs_posts_quantity = $instance["pcs_posts_quantity"];
			$pcs_exhibition_time = $instance["pcs_exhibition_time"];
			$pcs_term_id = $instance["pcs_term_id"];
			$pcs_width_image = $instance["pcs_width_image"];
			$pcs_order_posts = $instance["pcs_order_posts"];
			?>
			<p>Title: <input class="widefat" name="<?php echo $this->get_field_name("pcs_title"); ?>" type="text" value="<?php echo esc_attr( $pcs_title ); ?>" /> </p>
			<p>Box Height (pixels): <input class="widefat" name="<?php echo $this->get_field_name("pcs_height_box"); ?>" type="text" value="<?php echo esc_attr( $pcs_height_box ); ?>" /> </p>
			<p>Image width (pixels): <input class="widefat" name="<?php echo $this->get_field_name("pcs_width_image"); ?>" type="text" value="<?php echo esc_attr( $pcs_width_image ); ?>" /> </p>
			<p>Category: <select class="widefat" name="<?php echo $this->get_field_name("pcs_term_id"); ?>">
				<option value="0"<?php echo ($pcs_term_id == 0) ? " selected=\"selected\"" : ""?>>Any</option>
				<?
					$args = array('taxonomy'=>'category','hide_empty'=>0);
					$list_categories = get_categories($args);
					foreach ($list_categories as $item){
						?>
							<option value="<?php echo $item->term_id?>"<?php echo ($pcs_term_id == $item->term_id) ? " selected=\"selected\"" : ""?>><?php echo $item->name?></option>
						<?php
					}
				?>
			</select>
			</p>
			<p>Posts quantity: <select class="widefat" name="<?php echo $this->get_field_name("pcs_posts_quantity"); ?>">
				<option value="0"<?php echo (esc_attr($pcs_posts_quantity)==0) ? " selected=\"selected\"" : ""?>>All posts</option>
				<?php
					for ($i=1;$i<=100;$i++){
						?>
							<option value="<?=$i?>"<?php echo ($i==esc_attr($pcs_posts_quantity)) ? " selected=\"selected\"" : ""?>><?php echo $i?></option>
						<?php
					}
				?>
			</select></p>
			<p>Exhibition time (seconds): <select class="widefat" name="<?php echo $this->get_field_name("pcs_exhibition_time"); ?>">
				<?php
					for ($i=1;$i<=60;$i++){
						?>
							<option value="<?php echo $i?>"<?php echo ($i==esc_attr($pcs_exhibition_time)) ? " selected=\"selected\"" : ""?>><?php echo $i?></option>
						<?php
					}
				?>
			</select></p>
			<p>Posts Order: <select class="widefat" name="<?php echo $this->get_field_name("pcs_order_posts"); ?>">
				<option value="date"<?php echo (esc_attr($pcs_order_posts) == "date") ? " selected=\"selected\"" : ""?>>Date DESC</option>
				<option value="rand"<?php echo (esc_attr($pcs_order_posts) == "rand") ? " selected=\"selected\"" : ""?>>Random</option>
			</select></p>
			<?php
		}

		//save the widget settings
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance["pcs_term_id"] = strip_tags( $new_instance["pcs_term_id"] );
			$instance["pcs_title"] = strip_tags( $new_instance["pcs_title"] );
			$instance["pcs_posts_quantity"] = strip_tags( $new_instance["pcs_posts_quantity"] );
			$instance["pcs_exhibition_time"] = strip_tags( $new_instance["pcs_exhibition_time"]);
			$instance["pcs_height_box"] = strip_tags( $new_instance["pcs_height_box"]);
			$instance["pcs_width_image"] = strip_tags( $new_instance["pcs_width_image"]);
			$instance["pcs_order_posts"] = strip_tags( $new_instance["pcs_order_posts"]);
			return $instance;
		}
		
		//display the widget
		function widget($args, $instance) {
			extract($args);
			echo $before_widget;
			$pcs_title = apply_filters( "widget_title", $instance["pcs_title"] );
			$pcs_term_id = empty( $instance["pcs_term_id"] ) ? "&nbsp;" : $instance["pcs_term_id"];
			$pcs_posts_quantity = empty( $instance["pcs_posts_quantity"] ) ? "&nbsp;" : $instance["pcs_posts_quantity"];
			$pcs_exhibition_time = empty( $instance["pcs_exhibition_time"]) ? "&nbsp;" : $instance["pcs_exhibition_time"];
			$pcs_height_box = empty( $instance["pcs_height_box"]) ? "300" : $instance["pcs_height_box"];
			$pcs_width_image = empty($instance["pcs_width_image"]) ? "200" : $instance["pcs_width_image"];
			$pcs_order_posts = empty($instance["pcs_order_posts"]) ? "date" : $instance["pcs_order_posts"];
			if (!empty($pcs_title)) {
				echo $before_title . $pcs_title . $after_title;
			};
			$args = array();
			$args["post_type"] = "post";
			$args["posts_per_page"] = 10;
			$args["orderby"] = $pcs_order_posts;
			if ($args["orderby"]=="date"){
				$args["ordem"] = "DESC";
			}
			if ($pcs_term_id)
				$args["cat"] = $pcs_term_id;
			query_posts($args);
			if (have_posts()){
				echo "<div class='pcs-container-posts'>";
				echo "<input type='hidden' class='pcs_exhibition_time' value='".($pcs_exhibition_time*1000)."'>";
				echo "<input type='hidden' class='pcs_height_box' value='".($pcs_height_box)."'>";
				echo "<input type='hidden' class='pcs_blog_address' value='".get_bloginfo("url")."'>";
				echo "<input type='hidden' class='pcs_total_posts' value='".$pcs_posts_quantity."'>";
				echo "<input type='hidden' class='pcs_term_id' value='".$pcs_term_id."'>";
				echo "<input type='hidden' class='pcs_order_posts' value='".$pcs_order_posts."'>";
				echo "<input type='hidden' class='pcs_width_image' value='".$pcs_width_image."'>";
				echo "<ul>";
				    $i = 1;
					while (have_posts()) : the_post();
						include("pcs_post_template.php");
						$i++;
					endwhile;
				echo "</ul>";
				echo "</div>";
			}
			echo $after_widget;
		}
	}
?>