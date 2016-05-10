<?php

namespace FloatApi\Writer;

use League\Route\Http\Exception;
use Twig_Environment;

class SimpleWriter
{
    const ERROR_UNABLE_TO_WRITE_AMP = "Unable to write Simple Amp Article";
    /**
     * @param Twig_Environment $twig
     * @param string $blankTemplate
     * @param string $prefix
     * @param string $fileNameTemplate
     * @param int $number
     * @param array $params
     */
    public function writeAMPPage(Twig_Environment $twig, $blankTemplate, $prefix, $fileNameTemplate, $number, $params)
    {
        $template = $twig->render($blankTemplate, $params);
        // Create File name
        $filename = $prefix.sprintf($fileNameTemplate, $number);
        //Create Template
        $file = fopen($filename, "w");
        if(fwrite($file, $template) === false)
        {
            new \Exception(self::ERROR_UNABLE_TO_WRITE_AMP);
        }

    }
    public function writeFBPage()
    {

    }

}
