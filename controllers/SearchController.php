<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Hadits; // Make sure to import your model classes.
use app\controllers\MainController; // Import other controller classes if needed.
use app\controllers\RecallPrecisionController; // Import other controller classes if needed.
use app\controllers\CountVecController; // Import other controller classes if needed.
use app\models\Jaccard; // Make sure to import your model classes.
use app\models\Result; // Make sure to import your model classes.
use app\models\Similarity; // Make sure to import your model classes.
use app\models\SearchForm;

class SearchController extends Controller
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
    public $results;
    
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    
        $this->similarity = new MainController($id, $module, $config);
        $this->results = new RecallPrecisionController($id, $module, $config);
    }
    
    
    // public function init()
    // {
    //     $this->similarity = new MainController(); // Initialize your controller instances.
    //     $this->results = new RecallPrecisionController(); // Initialize your controller instances.
    // }

    public function actionIndex()
    {
        $search = new SearchForm();


        return $this->render('index', [
            'search' => $search,
        ]);
        // return $this->render('index');
    }

    public function actionResult()
    {
        
        $request = Yii::$app->request;
        // var_dump($request->get('q'));
        $searchKeyword = $request->get('q');
        

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

    public function jaccard(){
    
        $executionStartTime = microtime(true);
        $halaman = 'jaccard';
        $perPage = 10;
    
        $this->rank_jaccard = $this->similarity->init($this->keyword, $halaman);
        var_dump($this->rank_jaccard);exit;
    
        $rank_jac = implode(',',array_fill(0, count($this->rank_jaccard), '?'));
        $keyword = $this->keyword;
        $this->total_jac = count($this->rank_jaccard);
        //print_r($this->rank_jaccard);


        $this->jac = $this->similarity->hadits->whereIn('id', $this->rank_jaccard)->orderByRaw("field(id,{$rank_jac})", $this->rank_jaccard)->paginate($perPage, ['*'], 'page2');

        $executionEndTime = microtime(true);
        $this->time_jaccard = $executionEndTime - $executionStartTime;

        $this->results->resultJaccard($this->keyword, $this->total_jac, $this->time_jaccard, $this->rank_jaccard);
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