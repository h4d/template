<?php
spl_autoload_register(function ($className)
{
    if (false == class_exists($className, false))
    {
        $partialClassName = str_replace('H4D\\Template\\', '', $className);
        $defaultClassesDirectory = __DIR__.'/../src';
        $fileName = $defaultClassesDirectory . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $partialClassName) . '.php';
        if (file_exists($fileName) && is_readable($fileName))
        {
            /** @noinspection PhpIncludeInspection */
            include_once($fileName);
        }
    }
});