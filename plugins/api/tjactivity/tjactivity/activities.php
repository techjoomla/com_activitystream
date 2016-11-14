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
		$ActivityStreamModelActivities = JModelLegacy::getInstance('Activities', 'ActivityStreamModel');

		$jinput = JFactory::getApplication()->input;
		$type = $jinput->get("type", '', 'ARRAY');
		$actor_id = $jinput->get('actor_id', '', 'INT');
		$object_id = $jinput->get('object_id', '', 'INT');
		$target_id = $jinput->get('target_id', '', 'INT');
		$from_date = $jinput->get('from_date', '', '');

		// Set model state
		$ActivityStreamModelActivities->setState("type", $type);
		$ActivityStreamModelActivities->setState("actor_id", $actor_id);
		$ActivityStreamModelActivities->setState("object_id", $object_id);
		$ActivityStreamModelActivities->setState("target_id", $target_id);
		$ActivityStreamModelActivities->setState("from_date", $from_date);
		$ActivityStreamModelActivities->setState("access", "1");
		$ActivityStreamModelActivities->setState("state", '1');

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

		$ActivityStreamModelActivity = JModelLegacy::getInstance('Activity', 'ActivityStreamModel');

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

		$ActivityStreamModelActivity = JModelLegacy::getInstance('Activity', 'ActivityStreamModel');

		$result = $ActivityStreamModelActivity->deleteActivity($id);

		$this->plugin->setResponse($result);
	}
}
