(function( $ ) {
techjoomla.jQuery(document).ready(function(){
	getActivities();
});

getActivities = function(){
	var widgetNumber = 0;

	jQuery('[tj-activitystream-widget]').each(function(){
		widgetNumber++;
		jQuery(this).attr('id',"tj-activitystream" + widgetNumber);
		jQuery(this).attr('activityNumber',0);
		jQuery(this).attr('activityNumber',0);
		jQuery(this).attr('start',0);
		jQuery(this).html("<a id='load-more-activity-button"+jQuery(this).attr('id')+"'></a>");

		var activity = initActivities(this);
	});
}
})(jQuery);

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
	var activityNumber = jQuery(ele).attr("activityNumber");
	var start = jQuery(ele).attr("start");
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

	var queueName = jQuery(ele).attr('id');

	jQuery.ajaxq(queueName,{
		url: url+"&start="+start,
		type: 'GET',
		dataType: 'json',
		async:false,
		success: function(result)
		{
			setTimeout(function(){ replaceTemplate(result.data.results, theme, view, lang, result.data.total, ele);; }, 3000);
		}
	});
}
function replaceTemplate(activitiesData,theme,view, lang, total, ele)
{
	var activityNumber = jQuery(ele).attr("activityNumber");
	var start = jQuery(ele).attr("start");

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
		jQuery(ele).append(html);
		jQuery(ele).children(".language").not('.'+lang).remove();

		activityNumber++;
		start++;

		jQuery(ele).attr("activityNumber", activityNumber);
		jQuery(ele).attr("start", start);

		if(activityNumber < activitiesData.length)
		{
			replaceTemplate(activitiesData,theme,view, lang, total, ele);
		}

		if (Number(start) < Number(total))
		{
			var elementId = jQuery(ele).attr('id');

			jQuery('#load-more-activity-button'+elementId).attr("onclick","loadMoreActivities('"+elementId+"')");
			jQuery('#load-more-activity-button'+elementId).attr("class",'btn btn-default btn-lg btn-block');
			jQuery('#load-more-activity-button'+elementId).html("Load More Activities");
			jQuery('#load-more-activity-button'+elementId).insertAfter(ele);
		}
		else
		{
			jQuery('#load-more-activity-button'+elementId).remove();
		}
	}
	);
}

function loadMoreActivities(eleId)
{
	jQuery('#load-more-activity-button'+eleId).remove();
	jQuery(jQuery("#"+eleId)).attr("activityNumber", 0);
	initActivities(jQuery("#"+eleId));
}
