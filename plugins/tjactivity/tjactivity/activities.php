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

		$result = $ActivityStreamModelActivity->saveActivity($post);

		$this->plugin->setResponse($result);
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

		$result = $ActivityStreamModelActivity->deleteActivity($id);

		$this->plugin->setResponse($result);
	}
}
