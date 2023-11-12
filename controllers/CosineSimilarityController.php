<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class CosineSimilarityController extends Controller
{
    private $cosSimilarity = [];

    public function actionCos($documents, $docVector, $vectorQuery, $dotProduct)
    {
        $this->computeCosineSimilarity($documents, $docVector, $vectorQuery, $dotProduct);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->cosSimilarity;
    }

    private function computeCosineSimilarity($documents, $docVector, $vectorQuery, $dotProduct)
    {
        foreach ($documents as $key => $doc) {
            if ($dotProduct[$key] == 0) {
                $this->cosSimilarity[$key] = 0;
            } else {
                $this->cosSimilarity[$key] = $dotProduct[$key] / (sqrt($docVector[$key] * $vectorQuery[$key]));
            }
        }
    }
}
