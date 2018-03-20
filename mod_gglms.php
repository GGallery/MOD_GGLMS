<?php

defined('_JEXEC') or die;

$session = JFactory::getSession();
$step = $session->get('step');

$app = JFactory::getApplication();
$menu   = $app->getMenu()->getActive();

$alert = (($menu->component != 'com_wizard') && $step!= ''  ) ? 1 : 0;

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::root(true) ."/modules/mod_wizard/mod_wizard.css");

require_once dirname(__FILE__) . '/helper.php';
require JModuleHelper::getLayoutPath('mod_wizard', $params->get('layout', $params->get('tipo')));


?>