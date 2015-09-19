<?php

namespace H4D\Template;

use H4D\Template\Exceptions\RequiredOptionMissedException;

abstract class AbstractTemplate
{
    use TemplateTrait;

    /**
     * @var array
     */
    protected $constructorOptions = [];
    /**
     * @var array
     */
    protected $requiredConstructorOptions = [];
    /**
     * @var string
     */
    protected $templateFile;

    /**
     * @param array $options
     *
     * @throws RequiredOptionMissedException
     */
    public function __construct(array $options = [])
    {
        $this->checkRequiredConstructorOptions($options);
        $this->constructorOptions = $options;
    }

    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * @param array $options
     *
     * @throws RequiredOptionMissedException
     */
    protected function checkRequiredConstructorOptions(array $options)
    {
        $missingOptions = [];
        foreach($this->requiredConstructorOptions as $optionName)
        {
            if (!isset($options[$optionName]))
            {
                $missingOptions[] = $optionName;
            }
        }
        if (count($missingOptions)>0)
        {
            throw new RequiredOptionMissedException(
                sprintf('Required options missed ("%s").', implode(', ', $missingOptions)));
        }
    }

    /**
     * @return string|null
     */
    public function getTemplateFile()
    {
        return $this->templateFile;
    }

    /**
     * @param string $template
     *
     * @return $this
     */
    public function setTemplateFile($template)
    {
        $this->templateFile = $template;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasTemplateFileDefined()
    {
        return !is_null($this->templateFile);
    }

}