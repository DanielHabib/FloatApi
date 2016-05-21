<?php

namespace FloatApi\Writer;

use Twig_Environment;

interface WriterInterface
{
    /**
     * @param Twig_Environment $twig
     * @param string           $blankTemplate
     * @param string           $prefix
     * @param string           $fileNameTemplate
     * @param int              $number
     * @param array            $params
     */
    public function writeAMPPage(Twig_Environment $twig, $blankTemplate, $prefix, $fileNameTemplate, $number, $params);
    public function writeFBPage();
}
