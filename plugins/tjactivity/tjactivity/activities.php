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
		$ActivityStreamModelActivities = new ActivityStreamModelActivities;

		$result = $ActivityStreamModelActivities->getItems();

		$this->plugin->setResponse($result);
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
		$result_arr = array();

		$jinput = JFactory::getApplication()->input;

		$post = $jinput->post->getArray();

		if (!empty($post['id']))
		{
			$id = $post['id'];
		}

		$cdate = JFactory::getDate('now');

		if (empty($id))
		{
			$post['created_date'] = $cdate->toSQL();
		}

		$post['updated_date'] = $cdate->toSQL();

		$ActivityStreamModelActivity = new ActivityStreamModelActivity;

		$result = $ActivityStreamModelActivity->save($post);
		$error = $ActivityStreamModelActivity->getError();

		if (!empty($error))
		{
			$result_arr['error'] = '201';
			$result_arr['message'] = $error;
		}
		else
		{
			$result_arr['success'] = 'success';
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ACTIVITY_ADDED");
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
		$id = $jinput->get('id', '', "CMD");

		$ActivityStreamModelActivity = new ActivityStreamModelActivity;

		$result = $ActivityStreamModelActivity->delete($id);

		if (!empty($result))
		{
			$result_arr['success'] = "success";
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ACTIVITY_DELETED");
		}
		else
		{
			$result_arr['error'] = "301";
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ACTIVITY_NOT_DELETED");
		}

		$this->plugin->setResponse($result_arr);
	}
}
