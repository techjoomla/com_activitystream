<?php
/**
 * @package     Com_Activitystream
 * @subpackage  com_activitystream
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Hello Table class
 *
 * @since  0.0.1
 */
class ActivityStreamTableActivity extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  A database connector object
	 */
	function __construct(&$db)
	{
		$this->setColumnAlias('published', 'state');
		parent::__construct('#__tj_activities', 'id', $db);
	}

	function check()
	{
		$db = JFactory::getDbo();
		$errors = array();

		// If there is data in actor then actor_id should not be empty
		if (!empty($this->actor))
		{
			if (empty($this->actor_id))
			{
				$errors['actor_id'] = "Actor Id can't be empty";
			}
		}
		else
		{
			$errors['actor'] = "Actor can't be empty";
		}

		// If there is data in object then object_id should not be empty
		if (!empty($this->object))
		{
			if (empty($this->object_id))
			{
				$errors['object_id'] = "Object Id can't be empty";
			}
		}
		else
		{
			$errors['object'] = "Object can't be empty";
		}

		// If there is data in actor then actor_id should not be empty
		if (!empty($this->target))
		{
			if (empty($this->target_id))
			{
				$errors['target_id'] = "Target Id can't be empty";
			}
		}

		if (count($errors))
		{
			$this->setError(implode($errors, ', '));
			return false;
		}

		return true;
	}
}
