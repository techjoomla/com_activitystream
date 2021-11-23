<?php
/**
 * @version    SVN: <svn_id>
 * @package    ActivityStream
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2017 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

// No direct access
defined('_JEXEC') or die();
use Joomla\CMS\Factory;

/**
 * Products helper for quick2cart backend.
 *
 * @package     Quick2cart
 * @subpackage  com_quick2cart
 * @since       2.2
 */
class ActivityStreamHelperActivities
{
	/**
	 * Function to mapp json data inside array as array
	 *
	 * @param   MIXED    $value      Array with nested json data
	 *
	 * @param   BOOLEAN  $recursive  mapping method
	 *
	 * @return  Mapped array
	 */
	public function json_mapper($value, $recursive = true)
	{
		if (!empty($value) && is_string($value) && $decoded = json_decode($value, true))
		{
			return $decoded;
		}
		elseif (is_array($value) && $recursive)
		{
			return array_map('json_mapper', $value);
		}
		else
		{
			return $value;
		}
	}

	/**
	 * Function to mapp json data inside array as array
	 *
	 * @param   MIXED  $value  Array with nested json data
	 *
	 * @return  Mapped array
	 */
	public function json_mapper_norecurse($value)
	{
		return $this->json_mapper($value, false);
	}

	/**
	 * Function to conver nested json data to array in given array upto 3 levels
	 *
	 * @param   MIXED    $array      Array with nested json data
	 *
	 * @param   BOOLEAN  $recursive  mapping method
	 *
	 * @return  Mapped Array
	 */
	public function json_to_array($array, $recursive = true)
	{
		// Convert the value provided as array
		if (!is_array($array))
		{
			$array = array($array);
		}

		$jsonMapper = $recursive ? 'ActivityStreamHelperActivities::json_mapper' : 'ActivityStreamHelperActivities::json_mapper_norecurse';

		return array_map($jsonMapper, $array);
	}

	/**
	 * Function to build safe query for IN clause
	 *
	 * @param   string  $filterString  filter string
	 *
	 * @return  string
	 */
	public function buildActivityFilterQuery($filterString)
	{
		$db = Factory::getDbo();

		// Check if $filterString is comma separated string.
		if ((strpos($filterString, ',') !== false))
		{
			// Remove single and double quotes from string.
			$filterString 	= str_replace(array('\'', '"'), '', $filterString);

			// Create an array of string.
			$filterArray 	= explode(',', $filterString);

			// Joomla $db->quote every element of array.
			$filterArray 	= array_map(array($db, 'quote'), $filterArray);

			// Create safe string of array.
			$filterString 	= implode(',', $filterArray);
		}
		else
		{
			// Remove single and double quotes from string.
			$filterString 	= str_replace(array('\'', '"'), '', $filterString);

			// Joomla $db->quote $filterString.
			$filterString 	= $db->quote($filterString);
		}

		return $filterString;
	}
}
