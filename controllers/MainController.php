<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Similarity; // Adjust the namespace and model names
use app\models\Jaccard;    // to match your Yii application.
use app\models\Hadits;
use app\models\Tfidf; // Create a model for your TF-IDF calculations if not already done.

class MainController
{
    private $praprosesDocument = [];
    private $praprosesQuery = [];
    private $cosine_result = [];
    private $jaccard_result = [];
    private $rank_cosine = [];
    private $rank_jaccard = [];
    public $preprocessing;
    private $tfidf;
    public $hadits;
    public $cosine;
    public $jaccard;


    public function __construct($id, $module, $config = [])
    {
        // parent::__construct($id, $module, $config);

        $this->preprocessing = new PreprocessingController($id, $module, $config);
        $this->tfidf = new CountVecController($id, $module, $config);
        $this->hadits = new Hadits();
        $this->cosine = new Similarity();
        $this->jaccard = new Jaccard();
    }
    
    // public function init()
    // {
    //     $this->preprocessing = new PreprocessingController();
    //     $this->tfidf = new TfidfController();
    //     $this->hadits = new Hadits();
    //     $this->cosine = new Similarity();
    //     $this->jaccard = new Jaccard();
    // }

    public function init($keyword, $similarity)
    {
        $this->preprocessingQuery($keyword);
        $this->preprocessingDocument();

        if ($similarity === 'cosine') {
            $this->cosSimilarity();
            $this->rankingCosine();
            $this->inputCosineSimilarity($keyword);
            $hasil = $this->rank_cosine;
        } elseif ($similarity === 'jaccard') {
            $this->jacSimilarity();
            $this->rankingJaccard();
            $this->inputJaccardSimilarity($keyword);
            $hasil = $this->rank_jaccard;
        }

        return $hasil;
    }

    public function preprocessingQuery($keyword)
    {
        $praprosesQuery = $this->preprocessing->init($keyword, 'text');
        $this->praprosesQuery = $praprosesQuery;
        var_dump($this->praprosesQuery);
        return $this->praprosesQuery;
    }

    public function preprocessingDocument()
    {
        // Implement the logic to retrieve and preprocess documents here.
        // You can use Yii models and database queries.
    }

    private function cosSimilarity()
    {
        $similarity = $this->tfidf->init($this->praprosesDocument, $this->praprosesQuery, "cosine");
        $this->cosine_result = $similarity;
    }

    private function jacSimilarity()
    {
        $similarity = $this->tfidf->init($this->praprosesDocument, $this->praprosesQuery, "jaccard");
        $this->jaccard_result = $similarity;
        var_dump($this->jaccard_result);
    }

    private function rankingCosine()
    {
        $doc = $this->cosine_result;
        arsort($doc);
        foreach ($doc as $keys => $val) {
            if ($doc[$keys] > 0) {
                $this->rank_cosine[] = $keys + 1;
            }
        }
    }

    public function rankingJaccard()
    {
        $doc = $this->jaccard_result;
        var_dump($doc);exit;
        arsort($doc);
        foreach ($doc as $key => $val) {
            if ($doc[$key] > 0) {
                $this->rank_jaccard[] = $key + 1;
            }
        }
    }

    private function inputCosineSimilarity($keyword)
    {
        $results = $this->cosine->where(['keyword' => $keyword])->all();
        $doc = $this->cosine_result;
        arsort($doc);
        if (empty($results)) {
            $input = [];
            foreach ($doc as $keys => $values) {
                if ($doc[$keys] > 0) {
                    $input[] = [
                        'keyword' => $keyword,
                        'id_document' => $keys + 1,
                        'cosine_similarity' => $doc[$keys],
                    ];
                }
            }
            $this->cosine->batchInsert($input);
        }
    }

    private function inputJaccardSimilarity($keyword)
    {
        $results = $this->jaccard->where(['keyword' => $keyword])->all();
        $doc = $this->jaccard_result;
        arsort($doc);
        $time = Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd HH:mm:ss');
        if (empty($results)) {
            $input = [];
            foreach ($doc as $keys => $values) {
                if ($doc[$keys] > 0) {
                    $input[] = [
                        'keyword' => $keyword,
                        'id_document' => $keys + 1,
                        'jaccard_similarity' => $doc[$keys],
                        'created_at' => $time,
                        'updated_at' => $time,
                    ];
                }
            }
            $this->jaccard->batchInsert($input);
        }
    }
}
