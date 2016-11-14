<?php
/**
 * @package     Com_Activitystream
 * @subpackage  com_activitystream
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;

/**
 * ActivityStreamList Model
 *
 * @since  0.0.1
 */
class ActivityStreamModelActivities extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'type',
				'state'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('*')
			->from($db->quoteName('#__tj_activities'));

		// Filter: like / search
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			$like = $db->quote('%' . $search . '%');
			$query->where('type LIKE ' . $like);
		}

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('state = ' . (int) $published);
		}

		$type = $this->getState('type');
		$actor_id = $this->getState('actor_id');
		$object_id = $this->getState('object_id');
		$target_id = $this->getState('target_id');
		$from_date = $this->getState('from_date');
		$access = $this->getState('access');
		$state = $this->getState('state');

		$result_arr = array();

		// Return result related to specified activity type
		if (!empty($type) && $type != 'all')
		{
			$query->where($db->quoteName('type') . ' IN (' . implode(',', $type) . ')');
		}

		// Return result related to specified actor
		if (!empty($actor_id))
		{
			$query->where($db->quoteName('actor_id') . ' = ' . $actor_id);
		}

		// Return result related to specified object
		if (!empty($object_id))
		{
			$query->where($db->quoteName('object_id') . ' = ' . $object_id);
		}

		// Return result related to specified target
		if (!empty($target_id))
		{
			$query->where($db->quoteName('target_id') . ' = ' . $target_id);
		}

		// Return results from specified date
		if (!empty($from_date))
		{
			$query->where($db->quoteName('created_date') . ' >= ' . $from_date);
		}

		// Return results from specified access
		if (isset($access))
		{
			$query->where($db->quoteName('access') . ' = ' . $access);
		}

		// Return published activities only
		if (isset($state))
		{
			$query->where($db->quoteName('state') . ' = ' . $state);
		}

		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'created_date');
		$orderDirn = $this->state->get('list.direction', 'desc');

		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

		return $query;
	}

	/**
	 * Method to get a list of activities.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 *
	 * @since   1.6.1
	 */
	public function getItems()
	{
		$type = $this->getState('type');

		$result_arr = array();

		// Return result related to specified activity type
		if (empty($type))
		{
			$result_arr['success'] = false;
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ERROR_ACTIVITY_TYPE");

			return $result_arr;
		}

		$items['results'] = parent::getItems();

		// If no activities found then return the error message
		if (empty($items))
		{
			$result_arr['success'] = false;
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_NO_ACTIVITY");
		}
		else
		{
			$result_arr['success'] = true;
			$result_arr['data'] = $items;
		}

		return $result_arr;
	}
}
