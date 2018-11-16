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
 * ActivityStream View
 *
 * @since  0.0.1
 */
class ActivityStreamViewActivities extends JViewLegacy
{
	protected $input;

	/**
	 * Display the ActivityStream view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return   mixed  A string if successful, otherwise an Error object.
	 */

	public function display($tpl = null)
	{
		// To show all types of activity in list view
		$activitiesModel     = $this->getModel();
		$activitiesModel->setState("type", 'all');
		$this->input         = JFactory::getApplication()->input;
		$this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		// Set the tool-bar and number of found items
		$this->addToolBar();

		// Display the template
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar()
	{
		$title        = JText::_('Activity Stream');
		$languageFile = JFactory::getLanguage();
		$extension    = JFactory::getApplication()->input->get('client', '', 'STRING');
		$base_dir     = JPATH_BASE;

		// Load the language file for particular extension

		if ($extension)
		{
			$languageFile->load($extension, $base_dir);
		}

		/*if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}*/

		JToolBarHelper::title($title, 'list');
		JToolBarHelper::addNew('activity.add');
		JToolBarHelper::editList('activity.edit');
		JToolBarHelper::publish('activity.publish');
		JToolBarHelper::unpublish('activity.publish');
		JToolBarHelper::deleteList('', 'activities.delete');
	}

	/**
	 * Method to order fields
	 *
	 * @return void
	 */
	protected function getSortFields()
	{
		return array(
			'id'           => JText::_('COM_ACTIVITYSTREAM_ACTIVITY_ID'),
			'state'        => JText::_('COM_ACTIVITYSTREAM_ACTIVITY_STATE'),
			'type'         => JText::_('COM_ACTIVITYSTREAM_ACTIVITY_TYPE'),
			'created_date' => JText::_('COM_ACTIVITYSTREAM_ACTIVITY_CREATED_DATE'),
			'updated_date' => JText::_('COM_ACTIVITYSTREAM_ACTIVITY_UPDATED_DATE')
		);
	}
}
