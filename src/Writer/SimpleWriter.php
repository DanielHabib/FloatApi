<?php

namespace FloatApi\Writer;

use Twig_Environment;

class SimpleWriter
{
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
        fwrite($file, $template);
    }
    public function writeFBPage()
    {

    }

}
