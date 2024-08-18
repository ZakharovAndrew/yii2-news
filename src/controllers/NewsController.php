<?php

namespace ZakharovAndrew\news\controllers;

use ZakharovAndrew\news\models\News;
use ZakharovAndrew\user\models\Roles;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * NewsController implements the CRUD actions for News model.
 * 
 * @author Andrew Zakharov https://github.com/ZakharovAndrew
 */
class NewsController extends Controller
{
    /**
     * Lists all News models.
     *
     * @return string
     */
    public function actionIndex()
    {
        // admin and news editor has access
        if (Yii::$app->user->identity->hasRole(['admin', 'news_editor'])) {
            $query = News::find()->orderBy(['created_at' => SORT_DESC]);
        } else {
            $query = News::find()
                    ->innerJoin('news_roles', 'news_roles.news_id = news.id')
                    ->leftJoin('user_roles', 'user_roles.id = news_roles.role_id')
                    ->where(['user_roles.user_id' => Yii::$app->user->id])
                    ->orderBy(['created_at' => SORT_DESC]);
        }
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $news = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        
        Url::remember('', 'news_index');

        return $this->render('index', [
            'news' => $news,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Displays a single News model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new News();
        $model->user_id = Yii::$app->user->id;
        $roles = Roles::find()->all();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $model->saveRoles(\Yii::$app->request->post('roles'));
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => $roles
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Url::previous('news_index') ?? ['index']);
    }
    
    public function actionReact($news_id, $reaction_id)
    {
        $params = [
            'news_id' => $news_id,
            'user_id' => Yii::$app->user->id,
            'reaction_id' => $reaction_id
        ];
        
        $model = NewsReaction::find()->where()->one($params);
        
        if ($model) {
            Yii::$app->session->setFlash('error', "Нельзя повторно зарегистрировать реакцию");
            return $this->redirect(['view', 'id' => $news_id]);
        }
        
        $model = new NewsReaction($params);
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', "Реакция добавлена"); 
        } else {
            Yii::$app->session->setFlash('error', "Не удалось сохранить реакцию");
        }

        return $this->redirect(['view', 'id' => $news_id]);
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
        if (($model = News::findOne(['id' => $id])) !== null) {
            
            // the author has access to the news
            if ($news->user_id == Yii::$app->user->id) {
                return true;
            }

            // admin and news editor has access
            if (Yii::$app->user->identity->hasRole(['admin', 'news_editor'])) {
                return true;
            }

            $userRoles = Roles::getRolesByUserId(Yii::$app->user->id);
            $newsRoles = $news->getRoles();

            foreach ($userRoles as $userRole) {
                foreach ($newsRoles as $newsRole) {
                    if ($userRole->id === $newsRole->id) {
                        return $model;
                    }
                }
            }
            
            throw new NotFoundHttpException('У вас нет доступа к этой новости');
        }

        throw new NotFoundHttpException('The requested news does not exist.');
    }
}