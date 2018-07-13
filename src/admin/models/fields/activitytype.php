<?php

/**
 * @version    SVN: <svn_id>
 * @package    Com_Tjlms
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2015 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

// No direct access.
defined('_JEXEC') or die();

JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of courses
 *
 * @since  1.0.0
 */
class JFormFieldActivityType extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'activitytype';

	/**
	 * Fiedd to decide if options are being loaded externally and from xml
	 *
	 * @var		integer
	 * @since	2.2
	 */
	protected $loadExternally = 0;

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 *
	 * @since   11.4
	 */
	protected function getOptions()
	{
		$db     = JFactory::getDbo();
		$input  = JFactory::getApplication()->input;
		$client = $input->get('client', '', 'STRING');
		$filter = JFilterInput::getInstance();

		$query = $db->getQuery(true);
		$query->select('distinct l.type');
		$query->from('#__tj_activities AS l');
		$query->where($db->quoteName('client') . ' = ' . $db->quote($client));
		$query->order($db->escape('l.type ASC'));
		$db->setQuery($query);

		// Send filter values
		$allUsers  = $db->loadObjectList();
		$options   = array();
		$options[] = JHtml::_('select.option', 'all', JText::_('COM_ACTIVITYSTREAM_SEARCH_FILTER'));

		foreach ($allUsers as $u)
		{
			$tempArr     = implode("_", explode('.', $u->type));
			$filterValue = $client . '_activity_type_' . $tempArr;
			$filterText  = strtoupper($filterValue);
			$options[]   = JHtml::_('select.option', $u->type, JText::_($filterText));
		}

		return $options;
	}
}
