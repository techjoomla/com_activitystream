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
 * HelloWorld Controller
 *
 * @package     Com_Activitystream
 * @subpackage  com_activitystream
 * @since       0.0.9
 */
class ActivityStreamControllerActivity extends JControllerForm
{
	/**
	 * Function to save text activity
	 *
	 * @return  object  activities
	 *
	 * @since   1.6
	 */
	public function addPostedActivity()
	{
		$input = JFactory::getApplication()->input;

		$activityData = array();
		$postText = $input->get('activity-post-text', '', 'STRING');
		$cid = $input->get('cid', '0', 'INT');
		$activityData['postData'] = $postText;
		$activityData['type'] = 'text';
		$activityData['cid'] = $cid;

		if (!empty($activityData['postData']))
		{
			// Trigger jgiveactivity plugin to add test activity
			$dispatcher = JDispatcher::getInstance();
			JPluginHelper::importPlugin('system');

			$result = $dispatcher->trigger('postActivity', array($activityData));
		}
	}
}
