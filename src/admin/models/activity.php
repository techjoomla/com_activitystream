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
 * ActivityStream Model
 *
 * @since  0.0.1
 */
class ActivityStreamModelActivity extends JModelAdmin
{
	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'activity', $prefix = 'ActivityStreamTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_activitystream.activity',
			'activity',
			array(
				'control' => 'jform',
				'load_data' => $loadData
			)
		);

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
			'com_activitystream.edit.activity.data',
			array()
		);

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

	/**
	 * Method to save activity data through API.
	 *
	 * @param   ARRAY  $data  activity data
	 *
	 * @return  mixed  status.
	 *
	 * @since   1.6
	 */
	public function saveActivity($data)
	{
		$result_arr = array();

		if (parent::save($data))
		{
			$result_arr['success'] = true;
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ACTIVITY_ADDED");
		}
		else
		{
			$error = $this->getError();

			if (!empty($error))
			{
				$result_arr['success'] = false;
				$result_arr['message'] = $error;
			}
		}

		return $result_arr;
	}

	/**
	 * Method to delete activity through API.
	 *
	 * @param   ARRAY  $id  activity id
	 *
	 * @return  mixed  status
	 *
	 * @since   1.6
	 */
	public function deleteActivity($id)
	{
		$result_arr = array();

		if (parent::delete($id))
		{
			$result_arr['success'] = true;
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ACTIVITY_DELETED");
		}
		else
		{
			$result_arr['success'] = false;
			$result_arr['message'] = JText::_("COM_ACTIVITYSTREAM_ACTIVITY_NOT_DELETED");
		}

		return $result_arr;
	}
}
