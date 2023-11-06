<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\preprocessing\Hadits; // Make sure to import your model classes.
use app\controllers\preprocessing\MainController; // Import other controller classes if needed.
use app\controllers\preprocessing\RecallPrecisionController; // Import other controller classes if needed.
use app\controllers\preprocessing\TfidfController; // Import other controller classes if needed.
use app\models\preprocessing\Jaccard; // Make sure to import your model classes.
use app\models\preprocessing\Result; // Make sure to import your model classes.
use app\models\preprocessing\Similarity; // Make sure to import your model classes.

class ViewController extends Controller
{
    private $keyword = [];
    private $total_cos;
    private $total_jac;
    private $rank_cosine = [];
    private $rank_jaccard = [];
    private $cos;
    private $jac;
    private $time_cosine;
    private $time_jaccard;
    private $averageCosine;
    private $averageJaccard;
    private $similarity;

    public function init()
    {
        $this->similarity = new MainController(); // Initialize your controller instances.
        $this->results = new RecallPrecisionController(); // Initialize your controller instances.
    }

    public function actionIndex()
    {
        return $this->render('search');
    }

    public function actionResult()
    {
        $request = Yii::$app->request;
        $searchKeyword = $request->post('search');

        if ($searchKeyword !== null) {
            $this->keyword = $searchKeyword;
            $this->jaccard();
            $this->cosine();

            $cos = $this->cos;
            $jac = $this->jac;
            $totalCos = $this->total_cos;
            $totalJac = $this->total_jac;
            $timeCosine = $this->time_cosine;
            $timeJaccard = $this->time_jaccard;
            $keywords = $this->similarity->preprocessingQuery($searchKeyword);

            $this->results->input($searchKeyword);

            return $this->render('result', [
                'cos' => $cos,
                'jac' => $jac,
                'total_cos' => $totalCos,
                'total_jac' => $totalJac,
                'time_cosine' => $timeCosine,
                'time_jaccard' => $timeJaccard,
                'keywords' => $keywords,
            ]);
        } else {
            return 'Masukan Keyword';
        }
    }

    public function actionSimilarity()
    {
        // Implement your similarity action.
        $cosine = $this->similarity->cosine->paginate(10, ['*'], 'page1');
        $jaccard = $this->similarity->jaccard->paginate(10, ['*'], 'page2');

        // Calculate averageCosine and averageJaccard here.

        $cosine->render();
        $jaccard->render();

        return $this->render('similarity', [
            'cosine' => $cosine,
            'jaccard' => $jaccard,
            'averageCosine' => $averageCosine,
            'averageJaccard' => $averageJaccard,
        ]);
    }

    public function actionTable()
    {
        // Implement your table action.
        // Retrieve the table data and calculate the values for the table view.

        return $this->render('table', [
            'table' => $table,
            'recall_cosine' => $recall_cosine,
            'recall_jaccard' => $recall_jaccard,
            'precision_cosine' => $precision_cosine,
            'precision_jaccard' => $precision_jaccard,
        ]);
    }

    public function actionDiagram()
    {
        // Implement your diagram action.
        // Calculate and retrieve the values needed for the diagram view.

        return $this->render('diagram', [
            'recall_cosine' => $recall_cosine,
            'recall_jaccard' => $recall_jaccard,
            'precision_cosine' => $precision_cosine,
            'precision_jaccard' => $precision_jaccard,
            'time_cos' => $time_cos,
            'time_jac' => $time_jac,
            'averageCosine' => $averageCosine,
            'averageJaccard' => $averageJaccard,
        ]);
    }

    public function actionCosine()
    {
        // Implement your cosine action.
        // Calculate cosine similarity and return the view.

        return $this->render('cosine', [
            'cos' => $cos,
            'totalCos' => $totalCos,
            'timeCosine' => $timeCosine,
        ]);
    }

    public function actionJaccard()
    {
        // Implement your jaccard action.
        // Calculate jaccard similarity and return the view.

        return $this->render('jaccard', [
            'jac' => $jac,
            'totalJac' => $totalJac,
            'timeJaccard' => $timeJaccard,
        ]);
    }

    public function actionDeleteResult()
    {
        // Implement your deleteResult action.
        // Delete results and return the appropriate view or redirect.

        return $this->redirect(['table']);
    }

    public function actionDeleteSimilarity()
    {
        // Implement your deleteSimilarity action.
        // Delete similarity data and return the appropriate view or redirect.

        return $this->redirect(['similarity']);
    }
}
