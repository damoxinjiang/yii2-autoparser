<?php

namespace deka6pb\autoparser\controllers;

use deka6pb\autoparser\models\OptionsProvider;
use Yii;
use deka6pb\autoparser\models\providers;
use yii\data\ActiveDataProvider;
use yii\helpers\BaseJson;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProvidersController implements the CRUD actions for providers model.
 */
class ProvidersController extends Controller
{
    public $layout='main';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all providers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => providers::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single providers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelOptions = new OptionsProvider();

        $modelOptions->attributes = $model->getOptionsToArray();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelOptions' => $modelOptions,
        ]);
    }

    /**
     * Creates a new providers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Providers();
        $modelOptions = new OptionsProvider();

        if ($modelOptions->load(Yii::$app->request->post()) && $modelOptions->validate()) {
            $model->name = $modelOptions->name;
            $model->options = BaseJson::encode($modelOptions->attributes);
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelOptions' => $modelOptions,
            ]);
        }
    }

    /**
     * Updates an existing providers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelOptions = new OptionsProvider();

        if ($modelOptions->load(Yii::$app->request->post()) && $modelOptions->validate()) {
            $model->name = $modelOptions->name;
            $model->options = BaseJson::encode($modelOptions->attributes);
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelOptions' => $modelOptions,
            ]);
        }
    }

    /**
     * Deletes an existing providers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the providers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return providers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Providers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}