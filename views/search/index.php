<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title                   = 'Search Result';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">


    <p>
        This is the Search page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>


<?php
$form = ActiveForm::begin([
    'action' => ['search/result'], // Ganti 'controller' sesuai dengan nama controller yang Anda gunakan
    'method' => 'post',
]);
?>

<?= $form->field($search, 'search')->textInput(['placeholder' => 'Masukan Keyword'])->label(false) ?>

<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
                                
                            

