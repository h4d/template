<?php


namespace H4D\Template;

class Template extends AbstractTemplate
{
    /**
     * @param string $tpl Template path
     *
     * @return Template
     */
    public static function create($tpl)
    {
        return (new self([]))->setTemplateFile($tpl);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        try
        {
            $string = $this->render($this->getTemplateFile());
        }
        catch(\Exception $e)
        {
            $string = $e->getMessage();
        }
        return $string;
    }
}