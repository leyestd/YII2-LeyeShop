<?php

namespace frontend\controllers;

use yii;
use common\models\Recipient;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
//use yii\data\ActiveDataProvider;

class RecipientController extends \yii\web\Controller {

    public function actionCreate() {
        $id = Yii::$app->user->id;
        $recipient = new Recipient;
        $recipient->user_id = $id;

        if ($recipient->load(\Yii::$app->request->post()) && $recipient->save()) {
            return $this->goBack();
        } else {
            return $this->render('create', ["model" => $recipient]);
        }
    }

    public function actionIndex() {
        $query=  Recipient::find()->where(['user_id'=>yii::$app->user->id]);
        
        $count=$query->count();
        
        if($count==0) {
            return $this->redirect(['create']);
        }
        
        $pages= new Pagination(['totalCount'=> $count]);
        $models=$query->offset($pages->offset)->limit($pages->limit)->all();
        
        return $this->render('index',[
            'models'=>$models,
            'pages'=>$pages
        ] );
    }
    
    public function actionUpdate($id) {
        $query=  Recipient::find()->where(['user_id'=>yii::$app->user->id,'id'=>$id])->one();
        if ($query) {
            if ($query->load(Yii::$app->request->post()) && $query->save()) {
                return $this->redirect(['index']);
             } else {
                return $this->render('update',['model'=>$query]);  
            }    
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionDelete($id) {
        $query=  Recipient::find()->where(['user_id'=>yii::$app->user->id,'id'=>$id])->one();
        if($query) {
            $query->delete();
            return $this->redirect(['index']);
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
