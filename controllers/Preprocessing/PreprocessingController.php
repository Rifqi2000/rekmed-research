<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\FileHelper;

class PreprocessingController extends Controller
{
    public function actionInit($text, $tes)
    {
        $casefolding = $this->casefolding($text);
        $tokenizing = $this->tokenizing($casefolding);
        $stopword = $this->stopword($tokenizing);

        if ($tes == 'text') {
            $stemming = $this->stemming($stopword);
        } elseif ($tes == 'document') {
            $stemming = $this->stemmingD($stopword);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $stemming;
    }

    private function casefolding($texts)
    {
        $text = strtolower($texts);
        return $text;
    }

    private function tokenizing($texts)
    {
        $text = preg_split('/\s+/', $texts);
        return $text;
    }

    private function stopword($texts)
    {
        $stopword = FileHelper::readFile('stopwords-id.txt');
        $texts = array_filter($texts, function ($text) use ($stopword) {
            return !in_array($text, preg_split('/\s+/', $stopword));
        });

        return $texts;
    }

    private function stemming($keywords)
    {
        $stemmer = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer = $stemmer->createStemmer();

        $output = implode(" ", $keywords);
        $output = $stemmer->stem($output);
        $keywords = explode(" ", $output);

        return $keywords;
    }

    private function stemmingD($keywords)
    {
        $stemmer = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer = $stemmer->createStemmer();

        $output = implode(" ", $keywords);
        $output = $stemmer->stem($output);

        return $output;
    }
}