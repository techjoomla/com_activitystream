<?php
/**
 * @package    ActivityStream
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2017 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
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
		require_once JPATH_ADMINISTRATOR . '/components/com_activitystream/helpers/activities.php';

		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'state',
				'access',
				'type',
				'actor_id',
				'object_id',
				'target_id',
				'created_date',
				'updated_date'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   1.0.1
	 */
	protected function populateState($ordering = 'id', $direction = 'desc')
	{
		// Initialise variables.
		$jinput = JFactory::getApplication()->input;

		// Client filter
		$extension = $jinput->get("client", '', 'STRING');
		$this->setState('extension', $extension);

		// Set activities limit
		$listlimit = $jinput->input->get('limit', '', 'INT');

		if ($listlimit != '' || $listlimit == '0')
		{
			$this->setState('list.limit', $listlimit);
		}

		// Load filter published
		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		// Load the filter search
		$search = $this->getUserStateFromRequest($this->context . 'filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		// List state information.
		parent::populateState($ordering, $direction);
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
		$query->select($this->getState('list.select', '*'))
			->from($db->quoteName('#__tj_activities'));

		// Filter by client
		$extension = $this->getState('extension');

		if (!empty($extension))
		{
			$query->where($db->quoteName('client') . ' = ' . $db->quote($extension));
		}

		// Filter: like / search
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			$like = $db->quote('%' . $search . '%');
			$query->where('type LIKE ' . $like);
		}

		// Filter by published state
		$published = $this->getState('filter.published');

		if (is_numeric($published))
		{
			$query->where('state = ' . (int) $published);
		}

		$listlimit = $this->getState('list.limit');

		// Default pagination for first page load
		if ($listlimit == '' && $listlimit != '0')
		{
			$listlimit = 20;
		}

		$this->setState('list.limit', $listlimit);

		$type      = $this->getState('filter.activitytype');

		// Return result related to specified activity type
		if (!empty($type) && $type != 'all')
		{
			$query->where($db->quoteName('type') . ' = ' . $db->quote($type));
		}

		// Get all filters
		$filters = $this->get('filter_fields');

		foreach ($filters as $filter)
		{
			if (!empty($this->getState($filter) && $filter != 'type'))
			{
				$query->where($db->quoteName($filter) . ' IN (' . $this->getState($filter) . ')');
			}
		}

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'created_date');
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

		$activities = array();

		$activityStreamActivitiesHelper = new ActivityStreamHelperActivities;

		if (!empty($items))
		{
			foreach ($items as $k => $item)
			{
				// Get date in local time zone
				$item->created_date = JHtml::date($item->created_date, 'Y-m-d h:i:s');
				$item->updated_date = JHtml::date($item->updated_date, 'Y-m-d h:i:s');

				// Get extra date info
				$items[$k]->created_day = date_format(date_create($item->created_date), "D");
				$items[$k]->created_date_month = date_format(date_create($item->created_date), "d, M");

				// Convert item data into array
				$itemArray = (array) $item;

				// Convet all the json data to array
				$itemArray = $activityStreamActivitiesHelper->json_to_array($itemArray, true);

				foreach ($itemArray as $key => $itemSubArray)
				{
					if (is_array($itemSubArray))
					{
						// Convet all the json data to array
						$itemArray[$key] = $activityStreamActivitiesHelper->json_to_array($itemSubArray, true);
					}
				}

				// Create array of item objects
				$activities[] = (object) $itemArray;
			}
		}

		return $activities;
	}
}
