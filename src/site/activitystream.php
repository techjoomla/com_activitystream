<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Activitystream
 * @author     Parth Lawate <contact@techjoomla.com>
 * @copyright  2016 Parth Lawate
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Activitystream', JPATH_COMPONENT);
JLoader::register('ActivitystreamController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Activitystream');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
