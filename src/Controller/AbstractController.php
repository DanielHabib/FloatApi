<?php

namespace FloatApi\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AbstractController
{
    const ERROR_MESSAGE_UNAUTHORIZED = 'Unauthorized, please check your credentials';
    const ERROR_ARTICLE_NOT_FOUND = 'Article Not Found';

    const TEMPLATE_CONTEXT_MAPPING = [
        CONTEXT_AMP => FILE_NAME_SIMPLE_AMP,
        CONTEXT_FB => FILE_NAME_SIMPLE_FB,
    ];
    /**
     * @return int
     */
    public function getInc()
    {
        $inc = file('inc.txt')[0];
        $inc += 1;
        if (!$inc) {
            $inc = 1;
        }
        $file = fopen(FILE_NAME_INCREMENTER, 'w+');
        fwrite($file, $inc);

        return $inc;
    }

    /**
     * @param Response $response
     * @param $responseJSON
     *
     * @return Response
     */
    public function writeResponse(Response $response, $responseJSON)
    {
        $response->getBody()->write($responseJSON);

        return $response->withHeader('Access-Control-Allow-Origin', '*')->withHeader('Access-Control-Allow-Headers', 'Content-Type');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getBody(Request $request)
    {
        return json_decode($request->getBody()->getContents(), true);
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function checkAuth(Request $request)
    {
        // TODO: Make this based off of cookies?
//        $cookies = $request->getCookieParams();
//        if (array_key_exists('logged_in', $cookies)) {
//            if ($cookies['logged_in'] === 'true') {
//                return true;
//            }
//        }

        $body = $this->getBody($request);
        if (array_key_exists('userId', $body)) {
            if ($body['userId'] !== null) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $response
     *
     * @return mixed
     */
    protected function renderNotFound($response)
    {
        return $response->withStatus(404, self::ERROR_ARTICLE_NOT_FOUND);
    }
}
