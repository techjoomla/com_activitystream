<?php
/**
 * @package     Activitystream
 * @subpackage  Com_Activitystream
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2016 - 2021 Techjoomla. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;

/**
 * Class ActivitystreamHelper
 *
 * @since  3.3
 */
class ComActivityStreamHelper
{
	/**
	 * Function to get language constants for JS
	 *
	 * @return null
	 *
	 * @since   2.2
	 */
	public function getLanguageConstantForJs()
	{
		Text::script('COM_ACTIVITYSTREAM_POST_TEXT_ACTIVITY_REMAINING_TEXT_LIMIT');
		Text::script('COM_ACTIVITYSTREAM_LOAD_MORE_ACTIVITIES');
	}
}
