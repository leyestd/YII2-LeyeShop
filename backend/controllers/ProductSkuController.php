<?php

namespace backend\controllers;

use Yii;
use common\models\ProductSku;
use common\models\ProductSkuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Sku;

/**
 * ProductSkuController implements the CRUD actions for ProductSku model.
 */
class ProductSkuController extends Controller {

    public function behaviors() {
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
     * Lists all ProductSku models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductSkuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductSku model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductSku model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $path=Yii::getAlias('@frontend').'/web';
        $model = new ProductSku();
        $model->product_id = Yii::$app->request->get('id');

        $skusInfo = $this->getSkuInfo($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $dom = new \DOMDocument;
            $dom->loadHTML('<?xml encoding="utf-8" ?>' .$model->description);

            $domImgs = [];

            foreach ($dom->getElementsByTagName('img') as $img) {
                $src = $img->attributes->getNamedItem("src")->value;
                if (substr($src, 0, 1) !== 'h') {
                    $newFile=  str_replace('/wallytmp', '', $src);  //把原来的图片路径换掉
                    
                    //$img->setAttribute('src',$newFile);
                    
                    $pathinfo=pathinfo($newFile)['dirname'];
                    
                    $pathinfo=$path.$pathinfo;
                    
                    if(!file_exists($pathinfo)) {
                        mkdir($pathinfo, 0777,TRUE); 
                    }
                    rename($path.$src, $path.$newFile);
                   
                    $domImgs[] = $newFile;
                }
            }
            $model->description=str_replace('/wallytmp', '', $model->description);
            
            $model->attachment = implode('|', $domImgs);
            $model->save(false);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'skuInfo' => $skusInfo[0],
                        'skuName' => $skusInfo[1]
            ]);
        }
    }

    /**
     * Updates an existing ProductSku model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $path=Yii::getAlias('@frontend').'/web';

        
        $model = $this->findModel($id);
        $skusInfo = $this->getSkuInfo($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $dom = new \DOMDocument;
            $dom->loadHTML('<?xml encoding="utf-8" ?>' .$model->description);

            $domImgs = [];

            foreach ($dom->getElementsByTagName('img') as $img) {
                $src = $img->attributes->getNamedItem("src")->value;
                if (substr($src, 0, 1) !== 'h') {
                    $domImgs[] = $src;
                    //$img->setAttribute('src',str_replace('/wallytmp', '', $src));
                }     
   
            }
            
            $model->description=str_replace('/wallytmp', '', $model->description);
            
            $attachment=$model->attachment;
            
            $attachmentArray=  array_filter(explode('|', $attachment));
            
            //不在里面的旧图删除
            foreach ($attachmentArray as $value) {
                if(!in_array($value, $domImgs)) {
                    unlink($path.$value);
                }
            }
            
            //不在里面的新图移入
            foreach ($domImgs as &$value) {
                 if(!in_array($value, $attachmentArray)) {
                    $newFile=  str_replace('/wallytmp', '', $value);
                    $pathinfo=pathinfo($newFile)['dirname'];
                    
                    $pathinfo=$path.$pathinfo;
                    
                    if(!file_exists($pathinfo)) {
                        mkdir($pathinfo, 0777,TRUE); 
                    }
                    
                    rename($path.$value, $path.$newFile);
                    
                    $value=$newFile;
                    //从缓存中移动正式目录*-
                }
            }
            
            $model->attachment = implode('|', $domImgs);
            $model->save(false);



            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'skuInfo' => $skusInfo[0],
                        'skuName' => $skusInfo[1]
            ]);
        }
    }

    /**
     * Deletes an existing ProductSku model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductSku model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductSku the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductSku::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getSkuInfo($model) {
        //$skus=Product::find()->where(['id'=>$model->product_id])->one()->skus;

        $skus = Sku::find()->where(['product_id' => $model->product_id])->orderBy(['id' => SORT_ASC])->all();

        $skuName = "";

        foreach ($skus as $sku) {
            $skuName.="." . $sku->name;
        }
        $skuName = ltrim($skuName, '.');


        $sql = '';
        $strName = 'CONCAT(t.name';
        $strContent = 'CONCAT(t.content';
        $skuInfo = [];

        for ($i = 1; $i < count($skus); $i++) {
            $t = 't' . $i;
            $strName.=",'-'," . "$t.name";
            $strContent.=",'-'," . "$t.content";
        }

        $strName.=') as c1,';
        $strContent.=') as c2';

        //$str=rtrim($str, ", ");

        $sql = "select " . $strName . $strContent . " from sku_attr as t";

        for ($i = 1; $i < count($skus); $i++) {
            $sql.=", ( select * from sku_attr where sku_id=" . $skus[$i]->id . ") as t" . $i;
        }

        if (count($skus) >= 1) {
            $sql.=" where t.sku_id=" . $skus[0]->id;
        } else {
            $sql = "";
        }



        if ($sql != null) {
            $connection = Yii::$app->db;
            $command = $connection->createCommand($sql);
            $skuInfo = $command->queryAll();
        }
        return [$skuInfo, $skuName];
    }

}
