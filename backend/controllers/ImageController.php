<?php

namespace backend\controllers;

use Yii;
use common\models\Image;
use backend\models\SearchImage;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\MultipleUploadForm;
use common\models\ProductSku;
use yii\web\UploadedFile;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends Controller
{
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
     * Lists all Image models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        if(!ProductSku::find()->where(['id'=>$id])->exists()) {
             throw new NotFoundHttpException();
        }
        
        $form = new MultipleUploadForm();
        $searchModel = new SearchImage();
        $searchModel->productSku_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if (Yii::$app->request->isPost) {
            $form->files = UploadedFile::getInstances($form, 'files');
            
            if ($form->files && $form->validate()) {
                foreach ($form->files as $file) {
                    $image = new Image();
                    $image->productSku_id = $id;
                    
                    if ($image->save()) {
                        $file->saveAs($image->getPath());
                        \yii\imagine\Image::thumbnail($image->getPath(), 320, 320)
                                ->save($image->getThumbnailPath(), ['quality' => 80]);
                    }
                }

            }
        }
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploadForm' => $form,
        ]);
    }

    /**
     * Deletes an existing Image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $image = $this->findModel($id);
        $productSkuId = $image->productSku_id;
        $image->delete();

        return $this->redirect(['index','id' => $productSkuId]);
    }
    
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}
