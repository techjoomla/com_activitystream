(function( $ ) {

techjoomla.jQuery(document).ready(function(){
	jQuery('#tj-activitystream').getActivities();
});

var getActivities = {}

$.fn.getActivities = function(){
	jQuery('[tj-activitystream-widget]').each(function(){
		var this_container = jQuery(this);
		initActivities(this);
	});
}

})( jQuery );

var i = 0;

function initActivities(ele)
{
	var type = jQuery(ele).attr("tj-activitystream-type");
	var actor_id = jQuery(ele).attr("tj-activitystream-actor-id");
	var object_id = jQuery(ele).attr("tj-activitystream-object-id");
	var target_id = jQuery(ele).attr("tj-activitystream-target-id");
	var from_date = jQuery(ele).attr("tj-activitystream-from-date");
	var view = jQuery(ele).attr("tj-activitystream-bs");
	var theme = jQuery(ele).attr("tj-activitystream-theme");
	var url = root_url+"index.php?option=com_activitystream&task=activities.getActivities";

	if (typeof type != 'undefined')
	{
		url += "&type="+type;
	}

	if (typeof actor_id != 'undefined')
	{
		url += "&actor_id="+actor_id;
	}

	if (typeof object_id != 'undefined')
	{
		url += "&object_id="+object_id;
	}

	if (typeof target_id != 'undefined')
	{
		url += "&target_id="+target_id;
	}

	if (typeof from_date != 'undefined')
	{
		url += "&from_date="+from_date;
	}

	jQuery.ajax({
		url: url,
		type: 'GET',
		dataType: 'json',
		async:false,
		success: function(result)
		{
			replaceTemplate(result.data.results,theme,view);
		}
	});
}

function replaceTemplate(activitiesData,theme,view)
{
	val = activitiesData[i];
	var html = '';
	
	var templatePath = '';

	if (!val.template)
	{
		templatePath = root_url+"media/com_activitystream/themes/"+theme+"/templates/"+view+"/default.mustache";
	}
	else
	{
		templatePath = root_url+"media/com_activitystream/themes/"+theme+"/templates/"+view+"/"+val.template;
	}

	jQuery.ajax({
	method: 'GET',
	url: templatePath,
	success: function(res,stat,xhr)
		{
			if (!val.template)
			{
				var formatted_text = Mustache.render(val.formatted_text, {actor : val.actor, object: val.object, target: val.target});
				val.formatted_text = formatted_text;
				html = Mustache.render(res, val);
			}
			else
			{
				html = Mustache.render(res, val);
			}
		}
	}).done( function(){
		
		jQuery("#tj-activitystream").append(html);
		
		i++;
		
		if(i < activitiesData.length)
		{
			replaceTemplate(activitiesData,theme,view);
		}
	}
	);

	return html;
}
