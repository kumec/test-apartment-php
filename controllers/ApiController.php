<?php

namespace app\controllers;

use app\models\Apartment;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class ApiController extends ActiveController
{
    public $modelClass = 'app\models\Apartment';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // use AJAX
        $behaviors['corsFilter' ] = [
            'class' => \yii\filters\Cors::className(),
        ];

        // use JSON
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    public function actions() {

        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'indexDataProvider'];
        $actions['view']['findModel'] = [$this, 'findModel'];

        return $actions;
    }


    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'update' || $action === 'delete') {
            if ($model->access_token !== \Yii::$app->request->get('token')){
                throw new \yii\web\ForbiddenHttpException(sprintf('You can only %s lease that you\'ve created.', $action));
            }
        }
    }

    public function indexDataProvider() {

        $model = new $this->modelClass;

        $resultsObj = \Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $model::find()->select($model->sendAttributes()),

        ]);
        return $resultsObj;
    }

    public function findModel($id) {
        if($id){
            $model = new $this->modelClass;
            return $model::find()->select($model->sendAttributes())->where(['id' => $id])->one();
        }
    }

}
