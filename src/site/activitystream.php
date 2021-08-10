<?php
/**
 * @package     Activitystream
 * @subpackage  Com_Activitystream
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2016 - 2021 Techjoomla. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Activitystream', JPATH_COMPONENT);
JLoader::register('ActivitystreamController', JPATH_COMPONENT . '/controller.php');

$lang = Factory::getLanguage();
$lang->load('com_activitystream', JPATH_SITE);

// Execute the task.
$controller = BaseController::getInstance('Activitystream');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
