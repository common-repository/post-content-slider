<?php
	/*
		Plugin Name: Post Content Slider
		Plugin URI: http://www.polvo.com.br/plugin/polvocontentslider
		Description: A plugin which shows posts (category may be chosen by the user) into a slideshow
		Version: 1.0.1
		Author: Alan Hidalgo Pagoto under Polvo Digital
		Author URI: http://www.polvo.com.br
		License: GPLv2
	*/

	// Function which runs on plugin's install	
	register_activation_hook( __FILE__, "pcs_install" );
	function pcs_install(){
		update_option("pcs_status", "1");
		register_uninstall_hook(__FILE__,"pcs_uninstall");
	}
	
	register_deactivation_hook( __FILE__, "pcs_deactivate");
	
	function pcs_deactivate(){
		update_option("pcs_status","0");
	}
	
	function pcs_uninstall(){
		delete_option("pcs_status");
	}
	
	require_once(plugin_dir_path(__FILE__)."includes/pcs_widget_showdata.php");
	
	// use widgets_init action hook to execute custom function
	add_action("widgets_init","pcs_register_widgets");
	
	//register our widget
	function pcs_register_widgets() {
		register_widget("pcs_widget_showdata");
	}
	
	add_action("init","pcs_js_add_script");
	
	function pcs_js_add_script(){
		wp_enqueue_script("jquery");
		wp_enqueue_script("pcs_general","/wp-content/plugins/post-content-slider/js/pcs_general.js");
		wp_enqueue_style("pcs_main_general","/wp-content/plugins/post-content-slider/css/main.css");
	}
	
	add_action("wp_ajax_pcs_load_posts","pcs_plugin_load_posts");
	add_action("wp_ajax_nopriv_pcs_load_posts", "pcs_plugin_load_posts");
	
	function pcs_plugin_load_posts(){
		global $wpdb;
		$total_li = $_POST['total_li'];
		$total_posts = $_POST['total_posts'];
		$term_id = $_POST['term_id'];
		$pcs_order_posts = $_POST['order_posts'];
		$current_ids = $_POST['current_ids'];
		$pcs_width_image = $_POST['pcs_width_image'];
		if ($total_li >= $total_posts && $total_posts != 0){	
			echo "endaction-1";	
			die;
		}
		$args = array();
		$args["posts_per_page"] = 1;
		$args["paged"] = $total_li+1;
		$args["orderby"] = $pcs_order_posts;
		if ($pcs_order_posts == "date"){
			$args["order"] = "DESC";
		}
		$args["post__not_in"] = explode(",",$current_ids);
		if ($term_id)
			$args["cat"] = $term_id;
		query_posts($args);
		if (!have_posts()){
			echo "endaction-2";
			die;
		}
		while (have_posts()) : the_post();
			$i = $total_li+1;
			include("includes/pcs_post_template.php");
		endwhile;
		die();
	}

?>