<?php
/**
 * @version    SVN: <svn_id>
 * @package    Com_ActivityStream
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2016 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die;
jimport('joomla.plugin.plugin');

/**
 * Class for get ActivityStream
 *
 * @package     Com_ActivityStream
 * @subpackage  component
 * @since       1.0
 */
class TjactivityApiResourceGetActivityStream extends ApiResource
{
	/**
	 * Get ActivityStream Data
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function get()
	{
		$jinput = JFactory::getApplication()->input;
		$type = $jinput->get('type', '', 'STRING');
		$actor_id = $jinput->get('actor_id', '', 'INT');
		$object_id = $jinput->get('object_id', '', 'INT');
		$target_id = $jinput->get('target_id', '', 'INT');
		$result_arr = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__tj_activities');

		// Return result related to specified activity type
		if (empty($type))
		{
			$result_arr['status'] = "101";
			$result_arr['message'] = JText::_("PLG_API_TJACTIVITY_ERROR_ACTIVITY_TYPE");
			$this->plugin->setResponse(json_encode($result_arr));

			return false;
		}

		// Return result related to specified actor
		if (empty($actor_id))
		{
			$result_arr['status'] = "102";
			$result_arr['message'] = JText::_("PLG_API_TJACTIVITY_ERROR_ACTIVITY_ACTOR");
			$this->plugin->setResponse(json_encode($result_arr));

			return false;
		}

		// Return result related to specified object
		if (empty($object_id))
		{
			$result_arr['status'] = "103";
			$result_arr['message'] = JText::_("PLG_API_TJACTIVITY_ERROR_ACTIVITY_OBJECT");
			$this->plugin->setResponse(json_encode($result_arr));

			return false;
		}

		$ActivityStreamModelActivities = new ActivityStreamModelActivities;

		$result = $ActivityStreamModelActivities->getItems();

		// If no activities found then return the error message
		if (empty($result))
		{
			$result_arr['status'] = "100";
			$result_arr['message'] = JText::_("PLG_API_TJACTIVITY_NO_ACTIVITY");
		}
		else
		{
			$result_arr['status'] = "success";
			$result_arr['result'] = $result;
		}

		$result_json = json_encode($result_arr);

		$this->plugin->setResponse($result_json);
	}

	/**
	 * Get ActivityStream Data
	 *
	 * @return  json ActivityStream details
	 *
	 * @since   1.0
	 */
	public function post()
	{
		$this->plugin->setResponse(JText::_("PLG_API_TJACTIVITY_ERROR_POST"));
	}
}
