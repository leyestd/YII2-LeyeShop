<?php

namespace frontend\controllers;

use common\models\Product;
use yii\data\ActiveDataProvider;
use common\models\Category;

class CatalogController extends \yii\web\Controller {

    
    
    public function actionList($id = NULL) {
        $tree=[];
        $categoryTree=[];
        $ids=[];
        
        $productsQuery = Product::find();

        $categories = Category::find()->all();
        $this->getCategoryTree($categories,$tree);

        if($id!=NULL) {
            $ids[]=$id;
            $this->getCategoryTree($categories,$categoryTree, $id);
            foreach ($categoryTree as $c) {
                $ids[]=$c->id;
            }
            
            $productsQuery->andwhere(['category_id'=>$ids]);
        }
       
        $productsDataProvider = new ActiveDataProvider([
            'query' => $productsQuery,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        
        return $this->render('list', [
                    'productsDataProvider' => $productsDataProvider,
                    'categories' => $tree,              
        ]);
    }
   
    public function getCategoryTree($categories,&$tree,$parent_id=NULL) {
        foreach ($categories as $category) {
            if($category->parent_id==$parent_id) {
                $tree[]=$category;             
                
                if($parent_id==NULL) {
                    foreach ($categories as $category2) {
                        if($category2->parent_id == $category->id) {
                            $tree[]=$category2;
                        }
                    }
                }else {
                    $this->getCategoryTree($categories,$tree,$category->id);
                }
            }
        }      
    }
    
    
    
//
//    //递归查询所有子元素
//    private function getCategoryIds($categories, $categoryId, &$categoryIds) {
//
//        $temp = [];
//
//        foreach ($categories as $category) {
//            if ($category->parent_id == $categoryId) {
//                $temp[] = $category->id;
//            }
//        }
//
//        if (sizeof($temp) != 0) {
//            foreach ($temp as $t) {
//                $this->getCategoryIds($categories, $t, $categoryIds);
//            }
//            $categoryIds = array_merge_recursive($categoryIds, $temp);
//        }
//    }
//
//    //查询菜单顶层
//    private function getTopMenu($categories) {
//        $menuItems = [];
//        foreach ($categories as $category) {
//            if ($category->parent_id == NULL) {
//                $menuItems[$category->id] = $this->getMenuItems($categories, $category->id);
//            }
//        }
//        return $menuItems;
//    }
//
//    //查询所有顶层菜单下的子菜单
//    private function getMenuItems($categories, $categoryId) {
//        $temp = [];
//        foreach ($categories as $category) {
//            if ($category->parent_id == $categoryId) {
//                $temp[] = $category->id;
//            }
//        }
//
//        if (sizeof($temp) != 0) {
//            return $temp;
//        } else {
//            return  $categoryId;
//        }
//    }

}
