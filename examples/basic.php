<?php

require_once __DIR__.'/autoload.php';

// INI: Example using constructor //////////////////////////////////////////////////////////////////
// Create a template
$template = new \H4D\Template\Template();
// Add vars to the template object
$template->addVar('name', 'WORLD');
// Render using the given file as template
echo $template->render('./template.txt');
// END: Example using constructor //////////////////////////////////////////////////////////////////


// INI:  Example using static method (the fast way) ////////////////////////////////////////////////
// Create a template & set the template file
$template = \H4D\Template\Template::create('./template.txt');
// Add vars to the template object
$template->addVar('name', '(static) WORLD');
// Render template (automagically cast to string)
echo $template;
// END:  Example using static method (the fast way) ////////////////////////////////////////////////



