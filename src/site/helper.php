<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Activitystream
 * @author     Parth Lawate <contact@techjoomla.com>
 * @copyright  2016 Parth Lawate
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

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
		JText::script('COM_ACTIVITYSTREAM_POST_TEXT_ACTIVITY_REMAINING_TEXT_LIMIT', true);
	}
}
