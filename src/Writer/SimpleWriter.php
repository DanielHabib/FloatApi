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
    public function writeAMPPage(
        Twig_Environment $twig,
        $number,
        $params)
    {
        $template = $twig->render(TEMPLATE_SIMPLE_AMP, $params);
        // Create File name
        $filename = FILE_NAME_TEMPLATE_PREFIX.sprintf(FILE_NAME_SIMPLE_AMP, $number);
        //Create Template
        $file = fopen($filename, 'w');
        if (fwrite($file, $template) === false) {
            new \Exception(self::ERROR_UNABLE_TO_WRITE_AMP);
        }
    }
    public function writeFBPage($number, $requestBody)
    {
        $headline = $requestBody['headline'];
        $author = $requestBody['author'];
        $body = $requestBody['body'];

        $filename = 'simple_' . $number . '.html';
        $article =
            Elements\InstantArticle::create()
                ->withCanonicalUrl('http://float.press/articles/fb/' . $number)
                ->withHeader(
                    Elements\Header::create()
                        ->withTitle($headline)
                        ->withSubTitle('Smaller SubTitle')
                        ->withPublishTime(
                            Elements\Time::create(Elements\Time::PUBLISHED)
                                ->withDatetime(
                                    \DateTime::createFromFormat(
                                        'j-M-Y G:i:s',
                                        '14-Aug-1984 19:30:00'
                                    )
                                )
                        )
                        ->withModifyTime(
                            Elements\Time::create(Elements\Time::MODIFIED)
                                ->withDatetime(
                                    \DateTime::createFromFormat(
                                        'j-M-Y G:i:s',
                                        '10-Feb-2016 10:00:00'
                                    )
                                )
                        )
                        ->addAuthor(
                            Elements\Author::create()
                                ->withName($author)
                                ->withDescription('Author more detailed description')
                        )
                        ->addAuthor(
                            Elements\Author::create()
                                ->withName('Author in FB')
                                ->withDescription('Author user in facebook')
                                ->withURL('http://facebook.com/author')
                        )
                        ->withKicker('Some kicker of this article')
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
                        ->withCredits('Some plaintext credits.')
                );

        $file = fopen($filename, 'w');
        $template = $article->render('<!doctype html>');
        if (fwrite($file, $template) === false) {
            new \Exception(self::ERROR_UNABLE_TO_WRITE_AMP);
        }
    }
}
