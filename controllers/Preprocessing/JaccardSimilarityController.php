<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class JaccardSimilarityController extends Controller
{
    public $jacSimilarity = [];

    public function actionJac($documents, $docVector, $vectorQuery, $dotProduct)
    {
        $this->computeJaccardSimilarity($documents, $docVector, $vectorQuery, $dotProduct);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->jacSimilarity;
    }

    private function computeJaccardSimilarity($documents, $docVector, $vectorQuery, $dotProduct)
    {
        foreach ($documents as $key => $doc) {
            if ($dotProduct[$key] == 0) {
                $this->jacSimilarity[$key] = 0;
            } else {
                $this->jacSimilarity[$key] = $dotProduct[$key] / (($docVector[$key] + $vectorQuery[$key]) - $dotProduct[$key]);
            }
        }
    }
}


// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class JaccardSimilarityController extends Controller
// {
//     public $jacSimilarity = [];

//     public function jac($documents, $docVector, $vectorQuery, $dotProduct){
//          foreach ($documents as $key => $doc) {
//             if ($dotProduct[$key] == 0)
//                 $this->jacSimilarity[$key] = 0;
//             else{
//                 $this->jacSimilarity[$key] =
//                 $dotProduct[$key] / (($docVector[$key] + $vectorQuery[$key])-$dotProduct[$key]);
//             }
//         }
//         return $this->jacSimilarity;
//     }
// }
