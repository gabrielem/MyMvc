<?php
/*
$a['TEMPLATE_DIR'] is SET at _CORE/init.php
by the function: _CORE::templateSelect

In the function $a['TEMPLATE_DIR'] can be:
- set from MODELS & CONTROLLER (SUB too!)
- AUTO-Set from Model Name, if a directory named _NameModel is present
- set to Default Value: "TEMPLATE_DIR" define at _CORE/init.php && rootWWW."/_config/template" 

*/

require($a['TEMPLATE_DIR']."head.php");
require($a['TEMPLATE_DIR']."body.php");
require($a['TEMPLATE_DIR']."down.php");