<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;

class TfidfController extends Controller
{
    private $docTf;
    private $tfIdfWeight = [];
    private $cosSimiliarity = [];
    private $jacSimiliarity = [];
    private $tfQuery;
    private $queryWeight;
    private $df;
    private $idf;
    private $indexterm;
    private $tfidf = [];
    private $queryVector = [];
    private $dotProduct = [];

    public function actionInit($documents, $terms, $similarity)
    {
        $this->buildIndex($terms, $documents);
        $this->df();
        $this->tfIdfCalculator($this->docTf);
        $this->tfQueryCalculator($terms);
        $this->queryWeightCalculator();
        $this->tfidf = $this->data();
        $this->documentVector($this->tfidf);
        $this->queryVector($this->tfidf);
        $this->dotProductCalc($this->tfidf);

        if ($similarity === 'cosine') {
            $this->cosineSimilarity($documents);
            return $this->cosSimiliarity;
        } elseif ($similarity === 'jaccard') {
            $this->jaccardSimilarity($documents);
            return $this->jacSimiliarity;
        }
    }

    private function buildIndex($terms, $documents)
    {
        $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
        $vectorizer->fit($documents);
        $vectorizer->transform($documents);
        $this->tfDocuments($documents);
        $this->indexterm = $vectorizer->getVocabulary();
    }

    private function tfDocuments($documents)
    {
        $this->docTf = $documents;
    }

    private function df()
    {
        $index = $this->indexterm;
        $tfdocument = $this->tfIdfWeight;

        for ($i = 0; $i < count($index); $i++) {
            $temp = 0;
            for ($j = 0; $j < count($tfdocument); $j++) {
                if ($tfdocument[$j][$i] > 0) {
                    $temp += 1;
                }
            }
            $df[$i] = $temp;
        }
        $this->df = $df;
    }

    private function data()
    {
        $tfidf = [];

        foreach ($this->indexterm as $index => $indexvalue) {
            $tfidf['tfidfquery'] = $this->queryWeight;
            $tfidf['tfidfdocument'] = $this->tfIdfWeight;
        }

        return $tfidf;
    }

    private function tfIdfCalculator($arr)
    {
        $val = $arr;
        $transformer = new TfIdfTransformer($val);
        $transformer->transform($val);
        $this->tfIdfWeight = $val;
        $this->idf = $transformer->get_idf();
    }

    private function cosineSimilarity($documents)
    {
        $cosine = new CosineSimilarityController();
        $this->cosSimiliarity = $cosine->cos($documents, $this->docVector, $this->queryVector, $this->dotProduct);
    }

    private function jaccardSimilarity($documents)
    {
        $jaccard = new JaccardSimilarityController();
        $this->jacSimiliarity = $jaccard->jac($documents, $this->docVector, $this->queryVector, $this->dotProduct);
    }

    private function tfQueryCalculator($query)
    {
        $tfquery = array_fill(0, count($this->indexterm), 0);

        foreach ($query as $q) {
            foreach ($this->indexterm as $index => $value) {
                if ($value == $q) {
                    $tfquery[$index] += 1;
                }
            }
        }
        $this->tfQuery = $tfquery;
    }

    private function queryWeightCalculator()
    {
        $tfquery = $this->tfQuery;
        $idf = $this->idf;
        $hasil = [];

        foreach ($tfquery as $key => $value) {
            $hasil[] = $value * $idf[$key];
        }

        $this->queryWeight = $hasil;
    }

    private function dotProductCalc($tfidf)
    {
        $eachDot = 0;
        $tfidfd = $tfidf['tfidfdocument'];
        $tfidfq = $tfidf['tfidfquery'];

        for ($i = 0; $i < count($tfidfd); $i++) {
            for ($j = 0; $j < count($tfidfq); $j++) {
                $eachDot += $tfidfd[$i][$j] * $tfidfq[$j];
            }
            $this->dotProduct[$i] = $eachDot;
            $eachDot = 0;
        }
    }

    private function documentVector($tfidf)
    {
        $eachDoc = 0;
        $tfidfd = $tfidf['tfidfdocument'];
        $tfidfq = $tfidf['tfidfquery'];

        for ($i = 0; $i < count($tfidfd); $i++) {
            for ($j = 0; $j < count($tfidfq); $j++) {
                $eachDoc += $tfidfd[$i][$j] * $tfidfd[$i][$j];
            }
            $this->docVector[$i] = $eachDoc;
            $eachDoc = 0;
        }
    }

    private function queryVector($tfidf)
    {
        $eachQuery = 0;
        $tfidfd = $tfidf['tfidfdocument'];
        $tfidfq = $tfidf['tfidfquery'];

        for ($i = 0; $i < count($tfidfd); $i++) {
            for ($j = 0; $j < count($tfidfq); $j++) {
                $eachQuery += $tfidfq[$j] * $tfidfq[$j];
            }
            $this->queryVector[$i] = $eachQuery;
            $eachQuery = 0;
        }
    }
}
