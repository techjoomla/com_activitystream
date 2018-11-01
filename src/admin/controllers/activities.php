<?php
/**
 * @package    ActivityStream
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2017 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */
// No direct access to this file
defined('_JEXEC') or die;
use Joomla\Utilities\ArrayHelper;

/**
 * Activity Stream Controller
 *
 * @since  1.0.2
 */
class ActivityStreamControllerActivities extends JControllerAdmin
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
	 * @since   1.0.2
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
	 * @since   1.0.2
	 */
	public function getActivities()
	{
		// Load component tables
		JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_activitystream/tables');

		// Variable to store activity data fetched
		$result = array();

		// Variable to store request response
		$result_arr = array();

		$ActivityStreamModelActivities = $this->getModel('Activities');

		$jinput = JFactory::getApplication()->input;
		$type   = $jinput->get("type", '', 'STRING');

		// Return result related to specified activity type
		if (empty($type))
		{
			$result_arr['success'] = false;
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ERROR_ACTIVITY_TYPE");

			echo json_encode($result_arr);

			jexit();
		}

		$actor_id  = $jinput->get('actor_id', '', 'CMD');
		$object_id = $jinput->get('object_id', '', 'CMD');
		$target_id = $jinput->get('target_id', '', 'STRING');
		$from_date = $jinput->get('from_date', '');
		$limit     = $jinput->get('limit') ? $jinput->get('limit'): 0;

		// Set model state
		$ActivityStreamModelActivities->setState("type", $type);
		$ActivityStreamModelActivities->setState("actor_id", $actor_id);
		$ActivityStreamModelActivities->setState("object_id", $object_id);
		$ActivityStreamModelActivities->setState("target_id", $target_id);
		$ActivityStreamModelActivities->setState("from_date", $from_date);
		$ActivityStreamModelActivities->setState("limit", $limit);
		$ActivityStreamModelActivities->setState("access", "1");
		$ActivityStreamModelActivities->setState("state", '1');

		$result['results'] = $ActivityStreamModelActivities->getItems();

		// If no activities found then return the error message
		if (empty($result['results']))
		{
			$result_arr['success'] = false;
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_NO_ACTIVITY");
		}
		else
		{
			$result_arr['success']       = true;
			$result_arr['data']          = $result;
			$result_arr['data']['total'] = $ActivityStreamModelActivities->getTotal();
		}

		echo json_encode($result_arr);

		jexit();
	}

	/**
	 * Function to delete the activity
	 *
	 * @return  void
	 *
	 * @since 1.1.0
	 */

	public function delete()
	{
		$input  = JFactory::getApplication()->input;
		$client = $input->get('client', '', 'STRING');
		$id     = JFactory::getApplication()->input->get('cid', array(), 'array');

		if (!is_array($id) || count($id) < 1)
		{
			JLog::add(JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), JLog::WARNING, 'jerror');
		}
		else
		{
			// Get the model.
			$model = $this->getModel('activity');

			// Make sure the item ids are integers
			jimport('joomla.utilities.arrayhelper');
			ArrayHelper::toInteger($id);

			// Remove the activity.
			if ($model->delete($id))
			{
				$this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DELETED', count($id)));

				if (isset($client))
				{
					$this->setRedirect(JRoute::_('index.php?option=com_activitystream&view=activities&client=' . $client, false));
				}
				else
				{
					$this->setRedirect(JRoute::_('index.php?option=com_activitystream&view=activities', false));
				}
			}
			else
			{
				$this->setMessage($model->getError());

				if (isset($client))
				{
					$this->setRedirect(JRoute::_('index.php?option=com_activitystream&view=activities&client=' . $client, false));
				}
				else
				{
					$this->setRedirect(JRoute::_('index.php?option=com_activitystream&view=activities', false));
				}
			}
		}
	}
}
