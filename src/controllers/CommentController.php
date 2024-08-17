<?php

namespace ZakharovAndrew\news\controllers;

use ZakharovAndrew\news\models\Comment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CommentController
 * 
 * @author Andrew Zakharov https://github.com/ZakharovAndrew
 */
class CommentController extends Controller
{
    /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the news page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($news_id, $parent_id = null)
    {
        $model = new Comment();
        $model->news_id = $news_id;
        $model->parent_id = $parent_id;
        $model->author_id = Yii::$app->user->id;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['news/view', 'id' => $news_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'news_id' => $news_id,
        ]);
    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the news page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['news/view', 'id' => $model->news_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Comment model.
     * If deletion is successful, the browser will be redirected to the news page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $news_id = $model->news_id;
        
        // delete comment
        $model->delete();
        
        return $this->redirect(['news/view', 'id' => $news_id]);
    }
    
    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested comment does not exist.');
    }
}