<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Hadits; // Adjust the namespace and model name to match your Yii application

class InputController extends Controller
{
    public function actionIndex()
    {
        // You can add your logic for the "index" action here.
    }

    public function actionCreate()
    {
        return $this->render('create'); // Render the "create" view file.
    }

    public function actionStore()
    {
        $model = new Hadits(); // Assuming "Hadits" is a model in your Yii application.

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data sudah berhasil di input');
            return $this->redirect(['create']);
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }
}


// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Hadits;
// use Illuminate\Support\Facades\Session;

// class InputController extends Controller
// {
//     public function index(){

//     }

//     public function create(){
//     	return view('posts.input');
//     }

//     public function store(Request $request){
//     	try{
//     		$input = $request->all();

//     		Hadits::create($input);
//             Session::flash('flash_message', 'Data sudah berhasil di input');
//             return redirect('input');

//     	} catch (\Exception $e){
//            return $e->getMessage();
//         }
//     }
// }
