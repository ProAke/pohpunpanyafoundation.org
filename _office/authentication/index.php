<?php
error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :16/09/2023
Author : worapot pilabut (pros.ake)
E-mail : worapot.bhi@gmail.com
# Index Check Session
*****************************************************************/

include_once("../../include/config.inc.php");
include_once("../../include/class.inc.php");
include_once("../../include/class.TemplatePower.inc.php");
include_once("../../include/function.inc.php");


$tpl = new TemplatePower("../template/_tp_login.html");
$tpl->assignInclude("body", "_tp_index.html");
$tpl->prepare();
$tpl->newBlock("FORM");



$tpl->printToScreen();
?>