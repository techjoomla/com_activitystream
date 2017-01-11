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

var outputData = "";

function initActivities(ele)
{
	var type = jQuery(ele).attr("tj-activitystream-type");
	var actor_id = jQuery(ele).attr("tj-activitystream-actor-id");
	var object_id = jQuery(ele).attr("tj-activitystream-object-id");
	var target_id = jQuery(ele).attr("tj-activitystream-target-id");
	var from_date = jQuery(ele).attr("tj-activitystream-from-date");
	var view = jQuery(ele).attr("tj-activitystream-bs");
	var theme = jQuery(ele).attr("tj-activitystream-theme");
	var limit = jQuery(ele).attr("tj-activitystream-limit");
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

	if (typeof limit != 'undefined')
	{
		url += "&limit="+limit;
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
			var itemsProcessed = 0;
			jQuery.each(result.data.results, function(i, val){

				var templatePath = '';

				if (!val.template)
				{
					templatePath = root_url+"media/com_activitystream/themes/"+theme+"/templates/"+view+"/default.mustache";
				}
				else
				{
					templatePath = root_url+"media/com_activitystream/themes/"+theme+"/templates/"+view+"/"+val.template;
				}

				jQuery("#tj-activitystream").load(templatePath+" #template",function(){

					if (!val.template)
					{
						var template = document.getElementById('template').innerHTML;
						var formatted_text = Mustache.render(val.formatted_text, {actor : val.actor, object: val.object, target: val.target});
						val.formatted_text = formatted_text;
						var html = Mustache.render(template, val);
					}
					else
					{
						var template = document.getElementById('template').innerHTML;
						var html = Mustache.render(template, val);
					}

					outputData += html;

					itemsProcessed++;

					if(itemsProcessed === result.data.results.length)
					{
						printData();
					}
				});
			});
		}
	});
}

function printData()
{
	jQuery("#tj-activitystream").html(outputData);
}
