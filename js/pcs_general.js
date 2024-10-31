var pcs_actualslider = new Array();
var pcs_totalslides = new Array();
var pcs_i = new Array();
var pcs_total_posts = new Array();
var pcs_blog_address;
var pcs_termid = new Array();
var pcs_endaction = new Array(); // when this variable is set as true, the system doens't make requests for more posts
var pcs_current_ids = new Array();
var pcs_order_posts = new Array();
var pcs_width_image = new Array();
jQuery(document).ready(function(){
	jQuery(".pcs_widget_showdata .sharedaddy").remove();
	jQuery(".pcs_widget_showdata").each(function(){
		var id = jQuery(this).attr("id").split("-")[1];
		jQuery(this).find("ul li.mainRotate:first-child").show();
		jQuery(this).find("div.pcs-container-posts").css("position","relative");
		jQuery(this).find("div.pcs-container-posts").css("height",parseInt(jQuery(this).find("input.pcs_height_box").val()));
		pcs_total_posts[id] = jQuery(this).find(".pcs_total_posts").val();
		jQuery(this).find("li").css("position","absolute");
		pcs_totalslides[id] = jQuery(this).find("li.mainRotate").length;
		pcs_actualslider[id] = 1;
		pcs_order_posts[id] = jQuery(this).find("input.pcs_order_posts").val();
 		pcs_i[id] = setInterval("pcs_changepost("+id+")", parseInt(jQuery(this).find(".pcs_exhibition_time").val()));
		pcs_termid[id] = jQuery(this).find(".pcs_term_id").val();
		pcs_width_image[id] = jQuery(this).find(".pcs_width_image").val();
		pcs_blog_address = jQuery(this).find(".pcs_blog_address").val();
		pcs_endaction[id] = false;
		var cont = 0;
		jQuery("#pcs_widget_showdata-"+id).find("input.pcs-input-id").each(function(){
			if (cont==0)
				pcs_current_ids[id] = jQuery(this).attr("value");
			else
				pcs_current_ids[id] = pcs_current_ids[id]+","+jQuery(this).attr("value");
			cont++;
		})
	})
})

function pcs_changepost(id){
	pcs_current_ids[id] = "";
	var total_li = jQuery("#pcs_widget_showdata-"+id).find("li.mainRotate").length;
	if (!pcs_endaction[id]){
		var data = {
			action: "pcs_load_posts",
			total_li: total_li,
			total_posts: pcs_total_posts[id],
			term_id: pcs_termid[id],
			current_ids: pcs_current_ids[id],
			order_posts: pcs_order_posts[id],
			pcs_width_image: pcs_width_image[id]
		};
		jQuery.post(pcs_blog_address+"/wp-admin/admin-ajax.php", data, function(resp, textStatus) {
			if (resp == "endaction-1" || resp == "endaction-2" || !resp){
				pcs_endaction[id] = true;
			} else {
				jQuery("#pcs_widget_showdata-"+id).find("ul").append(resp);
				pcs_totalslides[id]++;
				pcs_changepost_afterajax(id);
			}
		});
	}
	else
	{
		pcs_changepost_afterajax(id);
	}
	jQuery(".pcs_widget_showdata .sharedaddy").remove();
	var cont = 0;
	jQuery("#pcs_widget_showdata-"+id).find(".pcs-input-id").each(function(){
		if (cont==0){
			pcs_current_ids[id] = jQuery(this).attr("value");
		} else {
			pcs_current_ids[id] = pcs_current_ids[id]+","+jQuery(this).attr("value");
		}
		cont++;
	})
}

function pcs_changepost_afterajax(id){
	jQuery("#pcs_widget_showdata-"+id+" div.pcs-post-"+pcs_actualslider[id]).closest("li").fadeOut();
	pcs_actualslider[id]++;
	if (pcs_actualslider[id] > pcs_totalslides[id])
		pcs_actualslider[id] = 1;
	jQuery("#pcs_widget_showdata-"+id+" div.pcs-post-"+pcs_actualslider[id]).closest("li").fadeIn();
}
