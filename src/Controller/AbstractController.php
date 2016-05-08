<?php

namespace FloatApi\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Twig_Environment;
class AbstractController
{
    public function getInc()
    {

        $inc = file('inc.txt')[0];
        $inc += 1;
        if (!$inc)
        {
            $inc = 1;
        }
        $file = fopen(FILE_NAME_INCREMENTER, 'w+');
        fwrite($file, $inc);
        return $inc;
    }
}
