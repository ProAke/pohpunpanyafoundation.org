<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");



$tpl = new TemplatePower("./template/_tp_master_error.html");
$tpl->assignInclude("body", "template/_tp_404.html");
$tpl->prepare();


FRONTLANGUAGE(1);
FRONTPAGESEO('1',1);

$tpl->printToScreen();
