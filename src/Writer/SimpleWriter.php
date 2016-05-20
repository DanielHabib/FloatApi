<?php

namespace FloatApi\Writer;

use Twig_Environment;
use Facebook\InstantArticles\Elements;

class SimpleWriter
{
    const ERROR_UNABLE_TO_WRITE_AMP = 'Unable to write Simple Amp Article';
    /**
     * @param Twig_Environment $twig
     * @param int              $number
     * @param array            $params
     */
    //TODO Remove all dependencies that are constants and just reference them directly
    /**
     * @param Twig_Environment $twig
     * @param int $number
     * @param array $params
     * @return string
     */
    public function writeAMPPage(
        Twig_Environment $twig,
        $number,
        $params)
    {
        $params['publishDate'] = $this->getPublishDate();
        $template = $twig->render(TEMPLATE_SIMPLE_AMP, $params);
        // Create File name
        $filename = FILE_NAME_TEMPLATE_PREFIX.sprintf(FILE_NAME_SIMPLE_AMP, $number);
        //Create Template
        $file = fopen($filename, 'w');
        if (fwrite($file, $template) === false) {
            new \Exception(self::ERROR_UNABLE_TO_WRITE_AMP);
        }
        return $filename;
    }

    /**
     * @param $number
     * @param $requestBody
     * @return string
     */
    public function writeFBPage($number, $requestBody)
    {
        $headline = $requestBody['headline'];
        $author = $requestBody['author'];
        $body = $requestBody['body'];
        $filename = 'templates/fb/simple_' . $number . '.html';
        $publishDate = $this->getPublishDate();
        $article =
            Elements\InstantArticle::create()
                ->withCanonicalUrl('http://float.press/articles/fb/' . $number)
                // Header
                ->withHeader(
                    Elements\Header::create()
                        ->withTitle($headline)
                        ->withPublishTime(
                            Elements\Time::create(Elements\Time::PUBLISHED)
                                ->withDatetime(
                                    \DateTime::createFromFormat('m j, Y', $publishDate)
                                )
                        )
                        ->addAuthor(
                            Elements\Author::create()
                                ->withName($author)
                                ->withDescription('Author more detailed description')
                        )
                        ->withCover(
                            Elements\Image::create()
                                ->withURL('https://jpeg.org/images/jpegls-home.jpg')
                                ->withCaption(
                                    Elements\Caption::create()
                                        ->appendText('Some caption to the image')
                                )
                        )
                )
                // Paragraph1
                ->addChild(
                    Elements\Paragraph::create()
                        ->appendText($body)
                )
                // Footer
                ->withFooter(
                    Elements\Footer::create()
                        ->withCredits('This article was published using Float')
                );

        $file = fopen($filename, 'w');
        $template = $article->render('<!doctype html>');
        if (fwrite($file, $template) === false) {
            new \Exception(self::ERROR_UNABLE_TO_WRITE_AMP);
        }
        return $filename;
    }

    private function getPublishDate()
    {
        return date("F j, Y");
    }
}
