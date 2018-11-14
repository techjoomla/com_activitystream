<?php

/**
 * @package    Com_Activitystream
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
 * @since  __DEPLOY_VERSION__
 */
class JFormFieldActivityType extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.1.0
	 */
	protected $type = 'activitytype';

	/**
	 * Fiedd to decide if options are being loaded externally and from xml
	 *
	 * @var		integer
	 * @since	1.1.0
	 */
	protected $loadExternally = 0;

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 *
	 * @since   1.1.0
	 */
	protected function getOptions()
	{
		$db     = JFactory::getDbo();
		$client = JFactory::getApplication()->input->get('client', '', 'STRING');
		$query  = $db->getQuery(true);

		$query->select('distinct l.type')
				->from($db->quoteName('#__tj_activities') . 'as l')
				->where($db->quoteName('client') . ' = ' . $db->quote($client));
		$query->order($db->escape('l.type ASC'));
		$db->setQuery($query);

		// Send filter values
		$activityType = $db->loadObjectList();
		$options      = array();
		$options[]    = JHtml::_('select.option', 'all', JText::_('COM_ACTIVITYSTREAM_SEARCH_FILTER'));

		foreach ($activityType as $type)
		{
			$temp        = implode("_", explode('.', $type->type));
			$filterValue = $client . '_activity_type_' . $temp;
			$filterText  = strtoupper($filterValue);
			$options[]   = JHtml::_('select.option', $type->type, JText::_($filterText));
		}

		return $options;
	}
}
