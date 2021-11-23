<?php
/**
 * @version    SVN: <svn_id>
 * @package    ActivityStream
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2017 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */
// No direct access to this file
defined('_JEXEC') or die;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

/**
 * HelloWorlds Controller
 *
 * @since  0.0.1
 */
class ActivityStreamControllerActivities extends AdminController
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Activity', $prefix = 'ActivityStreamModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	/**
	 * Function to get activities internaly
	 *
	 * @return  object  activities
	 *
	 * @since   1.6
	 */
	public function getActivities()
	{
		// Load component tables
		Table::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_activitystream/tables');

		// Variable to store activity data fetched
		$result = array();

		// Variable to store request response
		$result_arr = array();

		$ActivityStreamModelActivities = $this->getModel('Activities');

		$jinput = Factory::getApplication()->input;
		$type = $jinput->get("type", '', 'STRING');

		// Return result related to specified activity type
		if (empty($type))
		{
			$result_arr['success'] = false;
			$result_arr['message'] = Text::_("COM_ACTIVITYSTREAM_ERROR_ACTIVITY_TYPE");

			echo json_encode($result_arr);

			jexit();
		}

		$actor_id = $jinput->get('actor_id', '', 'CMD');
		$object_id = $jinput->get('object_id', '', 'CMD');
		$target_id = $jinput->get('target_id', '', 'STRING');
		$from_date = $jinput->get('from_date', '');
		$start = $jinput->get('start', '0');
		$limit = $jinput->get('limit');
		$filter_condition = $jinput->get('filter_condition', '', 'STRING');

		// Set model state
		$ActivityStreamModelActivities->setState("type", $type);
		$ActivityStreamModelActivities->setState("actor_id", $actor_id);
		$ActivityStreamModelActivities->setState("object_id", $object_id);
		$ActivityStreamModelActivities->setState("target_id", $target_id);
		$ActivityStreamModelActivities->setState("from_date", $from_date);
		$ActivityStreamModelActivities->setState("list.limit", $limit);
		$ActivityStreamModelActivities->setState("access", "1");
		$ActivityStreamModelActivities->setState("state", '1');
		$ActivityStreamModelActivities->setState("list.start", $start);
		$ActivityStreamModelActivities->setState("filter_condition", $filter_condition);

		$result['results'] = $ActivityStreamModelActivities->getItems();

		// If no activities found then return the error message
		if (empty($result['results']))
		{
			$result_arr['success'] = false;
			$result_arr['message'] = Text::_("COM_ACTIVITYSTREAM_NO_ACTIVITY");
		}
		else
		{
			$result_arr['success'] = true;
			$result_arr['data'] = $result;
			$result_arr['data']['total'] = $ActivityStreamModelActivities->getTotal();
		}

		echo json_encode($result_arr);

		jexit();
	}
}
