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
	 * @since   0.0.1
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'state',
				'access',
				'actor_id',
				'object_id',
				'target_id'
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
		$from_date = $this->getState('from_date');

		$result_arr = array();

		// Return result related to specified activity type
		if (!empty($type) && $type != 'all')
		{
			$query->where($db->quoteName('type') . ' IN (' . implode(',', $type) . ')');
		}

		// Get all filters
		$filters = $this->get('filter_fields');

		foreach ($filters as $filter)
		{
			if (!empty($this->getState($filter)))
			{
				$query->where($db->quoteName($filter) . ' = ' . $db->quote($this->getState($filter)));
			}
		}

		// Return results from specified date
		if (!empty($from_date))
		{
			$query->where($db->quoteName('created_date') . ' >= ' . $from_date);
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
	 * @since   0.0.1
	 */
	public function getItems()
	{
		$items = parent::getItems();

		return $items;
	}
}
