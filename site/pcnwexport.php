<?php 

defined('_JEXEC') or die('Restricted access');
$controller = JControllerLegacy::getInstance('pcnwexport');

$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

$controller->redirect();



?>


















