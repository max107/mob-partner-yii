<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ModuleConsts;

/* @var $this yii\web\View */
/* @var $model app\models\Module */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="module-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'package')->dropDownList([
        ModuleConsts::PACKAGE_AD => ModuleConsts::PACKAGE_AD,
        ModuleConsts::PACKAGE_PROXY => ModuleConsts::PACKAGE_PROXY,
    ], ['disabled' => true]) ?>

    <?= $form->field($model, 'data')->textarea(['disabled' => false === $model->getIsNewRecord()]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
