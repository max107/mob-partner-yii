<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Modules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="module-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Create new module', ['create'], ['class' => 'btn btn-success']) ?>

    <hr>

    <h2>All available modules</h2>

    <table class="table table-bordered">
        <tbody>
        <?php foreach ($modules as $module) { ?>
            <tr>
                <td>
                    <?php echo Html::a($module->package, ['view', 'id' => $module->id]) ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
