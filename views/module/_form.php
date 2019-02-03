<?php

use kdn\yii2\JsonEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Module */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="module-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'package')->textInput(['disabled' => false === empty($model->package)]) ?>

    <?= $form->field($model, 'uploadedFile')->fileInput(['disabled' => false === $model->getIsNewRecord()]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?= $form->field($model, 'extrasStr')->widget(JsonEditor::class, [
        'clientOptions' => ['modes' => ['code', 'tree']],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
