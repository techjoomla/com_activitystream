<?php
/**
 * @package     com_activitystream
 * @subpackage  com_activitystream
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

/**
 * General Controller of ActivityStream component
 *
 * @package     com_activitystream
 * @subpackage  com_activitystream
 * @since       0.0.7
 */
class ActivityStreamController extends JControllerLegacy
{
	/**
	 * The default view for the display method.
	 *
	 * @var string
	 * @since 12.2
	 */
	protected $default_view = 'activities';
}
