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
class TjactivityApiResourceActivities extends ApiResource
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
		$result_arr = array();

		// Return result related to specified activity type
		if (empty($type))
		{
			$result_arr['status'] = "101";
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ERROR_ACTIVITY_TYPE");
			$this->plugin->setResponse(json_encode($result_arr));

			return false;
		}

		$ActivityStreamModelActivities = new ActivityStreamModelActivities;

		$result = $ActivityStreamModelActivities->getItems();

		// If no activities found then return the error message
		if (empty($result))
		{
			$result_arr['status'] = "100";
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_NO_ACTIVITY");
		}
		else
		{
			$result_arr['status'] = "success";
			$result_arr['result'] = $result;
		}

		$this->plugin->setResponse($result_arr);
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
		$jinput = JFactory::getApplication()->input;
		$result_arr = array();
		$activityData = array();

		$id = $jinput->get('id', '', "INT");

		// If id is provided then update the activity
		if (!empty($id))
		{
			$activityData['id'] = $jinput->get('id');
		}

		$activityData['actor'] = $jinput->get('actor');
		$activityData['actor_id'] = $jinput->get('actor_id');
		$activityData['object'] = $jinput->get('object');
		$activityData['object_id'] = $jinput->get('object_id');
		$activityData['target'] = $jinput->get('target');
		$activityData['target_id'] = $jinput->get('target_id');
		$activityData['type'] = $jinput->get('type');
		$activityData['template'] = $jinput->get('template');
		$activityData['access'] = $jinput->get('access');
		$activityData['state'] = $jinput->get('state');
		$activityData['location'] = $jinput->get('location');
		$activityData['latitude'] = $jinput->get('latitude');
		$activityData['longitude'] = $jinput->get('longitude');

		$cdate = JFactory::getDate('now');

		if (empty($id))
		{
			$activityData['created_date'] = $cdate->toSQL();
		}

		$activityData['updated_date'] = $cdate->toSQL();

		$ActivityStreamModelActivity = new ActivityStreamModelActivity;

		$result = $ActivityStreamModelActivity->save($activityData);

		if ($result == true)
		{
			$result_arr['status'] = "200";
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ACTIVITY_ADDED");
		}
		else
		{
			$result_arr['status'] = "201";
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ACTIVITY_NOT_ADDED");
		}

		$this->plugin->setResponse($result_arr);
	}

	/**
	 * Delete ActivityStream Data
	 *
	 * @return  json ActivityStream details
	 *
	 * @since   1.0
	 */
	public function delete()
	{
		$jinput = JFactory::getApplication()->input;
		$result_arr = array();
		$ids = $jinput->get('id', '', "ARRAY");
		$ActivityStreamModelActivity = new ActivityStreamModelActivity;

		$result = $ActivityStreamModelActivity->delete($ids);

		if ($result == true)
		{
			$result_arr['status'] = "300";
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ACTIVITY_DELETED");
		}
		else
		{
			$result_arr['status'] = "301";
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ACTIVITY_NOT_DELETED");
		}

		$this->plugin->setResponse($result_arr);
	}
}
