<?php

namespace H4D\Template;

use H4D\Template\Exceptions\FileNotFoundException;
use H4D\Template\Exceptions\FileNotReadableException;
use H4D\Template\Exceptions\TemplateException;

trait TemplateTrait
{
    /**
     * @var array
     */
    protected $templateVars = [];

    /**
     * @param array $vars Associative array
     *
     * @return $this
     */
    public function setTemplateVars(array $vars)
    {
        $this->templateVars = array();
        foreach($vars as $key => $value)
        {
            $this->addTemplateVar($key, $value);
        }

        return $this;

    }

    /**
     * setTemplateVars alias
     *
     * @param array $vars Associative array
     *
     * @return $this
     */
    public function setVars(array $vars)
    {
        return $this->setTemplateVars($vars);
    }

    /**
     * @param array $vars Associative array
     *
     * @return $this
     */
    public function addTemplateVars(array $vars)
    {
        foreach($vars as $key => $value)
        {
            $this->addTemplateVar($key, $value);
        }

        return $this;

    }

    /**
     * addTemplateVars alias
     * @param array $vars Associative array
     *
     * @return $this
     */
    public function addVars(array $vars)
    {
        return $this->addTemplateVars($vars);

    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function addTemplateVar($name, $value)
    {
        $this->templateVars[$name] = $value;

        return $this;
    }

    /**
     * addTemplateVar alias
     *
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function addVar($name, $value)
    {
        return $this->addTemplateVar($name, $value);
    }

    /**
     * @return array
     */
    public function getTemplateVars()
    {
        return $this->templateVars;
    }

    /**
     * getTemplateVars alias
     * @return array
     */
    public function getVars()
    {
        return $this->getTemplateVars();
    }


    /**
     * @param string $templatePath
     *
     * @return string
     * @throws FileNotFoundException
     * @throws FileNotReadableException
     * @throws TemplateException
     */
    public function render($templatePath)
    {
        if(!is_file($templatePath) || !is_readable($templatePath))
        {
            throw new FileNotFoundException(sprintf('Template file "%s" does not exists.',
                                                    $templatePath));
        }
        if (!is_readable($templatePath))
        {
            throw new FileNotReadableException(sprintf('Template file "%s" is not readable.',
                                                       $templatePath));
        }
        try
        {
            extract($this->getTemplateVars());
            ob_start();
            /** @noinspection PhpIncludeInspection */
            require $templatePath;
            $contents = ob_get_clean();
        }
        catch(\Exception $e)
        {
            ob_clean();
            throw new TemplateException(sprintf('Error rendering template. %s', $e->getMessage()));
        }

        return $contents;
    }
}
