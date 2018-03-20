<?php

defined('_JEXEC') or die;

$session = JFactory::getSession();
$step = $session->get('step');

$app = JFactory::getApplication();
$menu   = $app->getMenu()->getActive();

$alert = (($menu->component != 'com_gglms') && $step!= ''  ) ? 1 : 0;

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::root(true) ."/modules/mod_gglms/mod_gglms.css");

require_once dirname(__FILE__) . '/helper.php';
require JModuleHelper::getLayoutPath('mod_gglms', $params->get('layout', $params->get('tipo')));


?>