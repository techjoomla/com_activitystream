(function( $ ) {
techjoomla.jQuery(document).ready(function(){
	jQuery('#tj-activitystream').getActivities();
	jQuery('#tj-activitystream').html("<a id='load-more-activity-button'></a>");
});
var getActivities = {}
$.fn.getActivities = function(){
	jQuery('[tj-activitystream-widget]').each(function(){
		var this_container = jQuery(this);
		initActivities(this);
	});
}
})(jQuery);

var activityNumber = 0;
var start = 0;

function initActivities(ele)
{
	var type = jQuery(ele).attr("tj-activitystream-type");
	var actor_id = jQuery(ele).attr("tj-activitystream-actor-id");
	var object_id = jQuery(ele).attr("tj-activitystream-object-id");
	var target_id = jQuery(ele).attr("tj-activitystream-target-id");
	var from_date = jQuery(ele).attr("tj-activitystream-from-date");
	var view = jQuery(ele).attr("tj-activitystream-bs");
	var theme = jQuery(ele).attr("tj-activitystream-theme");
	var lang = jQuery(ele).attr("tj-activitystream-language");
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
	if (typeof from_date != 'undefined')
	{
		url += "&from_date="+from_date;
	}
	if (typeof limit != 'undefined')
	{
		url += "&limit="+limit;
	}
	jQuery.ajax({
		url: url+"&start="+start,
		type: 'GET',
		dataType: 'json',
		async:false,
		success: function(result)
		{
			replaceTemplate(result.data.results, theme, view, lang, result.data.total);
		}
	});
}
function replaceTemplate(activitiesData,theme,view, lang, total)
{
	console.log(activitiesData);
	activityData = activitiesData[activityNumber];
	var html = '';
	var templatePath = '';
	if (!activityData.template)
	{
		templatePath = root_url+"media/com_activitystream/themes/"+theme+"/templates/"+view+"/default.mustache";
	}
	else
	{
		templatePath = root_url+"media/com_activitystream/themes/"+theme+"/templates/"+view+"/"+activityData.template;
	}
	jQuery.ajax({
	method: 'GET',
	url: templatePath,
	success: function(res,stat,xhr)
		{
			if (!activityData.template)
			{
				var formatted_text = Mustache.render(activityData.formatted_text, {actor : activityData.actor, object: activityData.object, target: activityData.target});
				activityData.formatted_text = formatted_text;
				html = Mustache.render(res, activityData);
			}
			else
			{
				html = Mustache.render(res, activityData);
			}
		}
	}).done( function(){
		jQuery("#tj-activitystream").append(html);
		jQuery("#tj-activitystream .language").not('.'+lang).remove();

		activityNumber++;
		start++;

		if(activityNumber < activitiesData.length)
		{
			replaceTemplate(activitiesData,theme,view, lang, total);
		}

		if (Number(start) < Number(total))
		{
			jQuery('#load-more-activity-button').attr("onclick",'loadMoreActivities('+start+')');
			jQuery('#load-more-activity-button').attr("class",'btn btn-default btn-lg btn-block');
			jQuery('#load-more-activity-button').html("Load More Activities");
			jQuery('#load-more-activity-button').insertAfter(jQuery('#tj-activitystream'));
		}
		else
		{
			jQuery('#load-more-activity-button').remove();
		}
	}
	);
}

function loadMoreActivities(start)
{
	activityNumber = 0;
	jQuery('[tj-activitystream-widget]').each(function(){
		initActivities(this, start);
	});
}
