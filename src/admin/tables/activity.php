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
	public function __construct(&$db)
	{
		$this->setColumnAlias('published', 'state');
		parent::__construct('#__tj_activities', 'id', $db);
	}

	/**
	 * Function to check data
	 *
	 * @return  boolean
	 */
	public function check()
	{
		$db = JFactory::getDbo();
		$errors = array();

		// Actor and actor_id should not be empty
		if (empty($this->actor_id) || empty($this->actor))
		{
			$errors['actor'] = $errors['actor_id'] = 'Both actor & actor_id are mandatory';
		}

		// Object and object_id should not be empty
		if (empty($this->object_id) || empty($this->object))
		{
			$errors['object'] = $errors['object_id'] = 'Both object & object_id are mandatory';
		}

		// If there is data in target then target_id should not be empty
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
