<?php

namespace FloatApi\Writer;

use Twig_Environment;
use FloatApi\Writer\WriterInterface;
use Facebook\InstantArticles\Elements;

class SimpleWriter implements WriterInterface
{
    const ERROR_UNABLE_TO_WRITE_AMP = 'Unable to write Simple Amp Article';
    /**
     * @param Twig_Environment $twig
     * @param string           $blankTemplate
     * @param string           $prefix
     * @param string           $fileNameTemplate
     * @param int              $number
     * @param array            $params
     */
    //TODO Remove all dependencies that are constants and just reference them directly
    public function writeAMPPage(
        Twig_Environment $twig,
        $blankTemplate,
        $prefix,
        $fileNameTemplate,
        $number,
        $params)
    {
        $template = $twig->render($blankTemplate, $params);
        // Create File name
        $filename = $prefix.sprintf($fileNameTemplate, $number);
        //Create Template
        $file = fopen($filename, 'w');
        if (fwrite($file, $template) === false) {
            new \Exception(self::ERROR_UNABLE_TO_WRITE_AMP);
        }
    }
    public function writeFBPage($number)
    {
        $filename = 'simple_' . $number . '.html';
        $article =
            Elements\InstantArticle::create()
                ->withCanonicalUrl('http://float.press/articles/fb/' . $filename)
                ->withHeader(
                    Elements\Header::create()
                        ->withTitle('Big Top Title')
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
                                ->withName('Author Name')
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
                        ->appendText('Some text to be within a paragraph for testing.')
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
