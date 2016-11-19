<?php

namespace H4D\Template\Tests\Unit;

class MyTemplateWithRequiredOptions extends \H4D\Template\Template
{
    /**
     * @var array
     */
    protected $requiredConstructorOptions = ['requiredOption-01', 'requiredOption-02'];

}