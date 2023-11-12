<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'action' => ['controller/result'], // Ganti 'controller' sesuai dengan nama controller yang Anda gunakan
    'method' => 'post',
]);
?>

<?= $form->field($model, 'search')->textInput(['placeholder' => 'Search'])->label(false) ?>

<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>