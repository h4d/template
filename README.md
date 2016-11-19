# What is this?

This is a very basic PHP library that helps you work with plain text format templates (txt, html, etc).

# Install via composer:

Install the latest version with

    $ composer require h4d/template

## Basic usage examples

### Using constructor

    <?php
    // Create a template
    $template = new \H4D\Template\Template();
    // Add vars to the template object
    $template->addVar('name', 'WORLD');
    // Render using the given file as template
    echo $template->render('./template.txt');
    
### Using static method (the fast way)
  
    <?php
    // Create a template & set the template file
    $template = \H4D\Template\Template::create('./template.txt');
    // Add vars to the template object
    $template->addVar('name', '(static) WORLD');
    // Render template (automagically cast to string)
    echo $template;
    
    