<?php

namespace app\controllers;

use app\models\Module;
use app\models\ModuleConsts;
use app\models\ModuleSearch;
use app\models\ModuleVersionSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ModuleController implements the CRUD actions for Module model.
 */
class ModuleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Module models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $modules = Module::find()->groupBy(['package'])->all();

        return $this->render('index', [
            'modules'  => $modules,
        ]);
    }

    /**
     * Displays a single Module model.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $searchModel = new ModuleVersionSearch();
        $dataProvider = $searchModel->search(
            Yii::$app->request->queryParams,
            $model->package
        );

        return $this->render('view', [
            'model'        => $model,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param string|null $type
     *
     * @return mixed
     */
    public function actionCreate(string $type = null)
    {
        $model = new Module();
        $model->package = $type;

        if (Yii::$app->request->isPost) {
            $parameters = Yii::$app->request->post('Module');
            $model->setAttributes($this->fixUglyYiiJsonWorkload($parameters));
            if ($model->validate() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    protected function fixUglyYiiJsonWorkload(array $parameters)
    {
        if (isset($parameters['extrasStr'])) {
            $parameters['extras'] = Json::decode($parameters['extrasStr'], true);
            unset($parameters['extrasStr']);
        }
        return $parameters;
    }

    /**
     * Updates an existing Module model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $parameters = Yii::$app->request->post('Module');
            $model->setAttributes($this->fixUglyYiiJsonWorkload($parameters));
            if ($model->validate() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Module model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException        if the model cannot be found
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Module model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @return Module the loaded model
     */
    protected function findModel($id)
    {
        if (($model = Module::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
