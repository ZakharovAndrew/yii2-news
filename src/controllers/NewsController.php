<?php

namespace ZakharovAndrew\news\controllers;

use Yii;
use ZakharovAndrew\news\models\News;
use ZakharovAndrew\news\models\NewsRoles;
use ZakharovAndrew\news\models\NewsReaction;
use ZakharovAndrew\news\models\Comment;
use ZakharovAndrew\news\models\Category;
use ZakharovAndrew\user\models\Roles;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * NewsController implements the CRUD actions for News model.
 * 
 * @author Andrew Zakharov https://github.com/ZakharovAndrew
 */
class NewsController extends \ZakharovAndrew\user\controllers\ParentController
{
    
    public $auth_access_actions = ['index', 'view'];
            
    /**
     * Lists all News models.
     *
     * @return string
     */
    public function actionIndex($category = null)
    {        
        // admin and news editor has access
        if (\Yii::$app->user->identity->hasRole(['admin', 'news_editor'])) {
            $query = News::find()->orderBy(['created_at' => SORT_DESC]);
        } else {
            $query = News::find()
                    ->innerJoin('news_roles', 'news_roles.news_id = news.id')
                    ->leftJoin('user_roles', 'user_roles.id = news_roles.role_id AND `user_roles`.`user_id` = '.Yii::$app->user->id)
                    ->groupBy('news.id')
                    ->orderBy(['created_at' => SORT_DESC]);
        }
        
        // filter by category
        if ($category) {
            if (($category_id = Category::findOne(['url' => $category])) === null) {
                throw new NotFoundHttpException('The requested news does not exist.');
            }
            $query->innerJoin('news_category_links', 'news_category_links.news_id = news.id AND news_category_links.category_id = '.$category_id->id);
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
        $model->views++;
        $model->save(false);
        $modelComment = new Comment();

        return $this->render('view', [
            'model' => $model,
            'modelComment' => $modelComment,
            'reactions' => \ZakharovAndrew\news\models\Reaction::find()->all()
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
        $model->user_id = \Yii::$app->user->id;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $model->saveRoles(\Yii::$app->request->post()['News']['roles'] ?? []);
            $model->saveCategories(\Yii::$app->request->post()['News']['categories'] ?? []);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => Roles::getRolesList(),
            'categories' => Category::find()->all()
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
            $model->saveRoles(\Yii::$app->request->post()['News']['roles'] ?? []);
            $model->saveCategories(\Yii::$app->request->post()['News']['categories'] ?? []);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => Roles::getRolesList(),
            'categories' => Category::find()->all()
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
    
    /**
     * Adding or removing a reaction to the news.
     * @return string|\yii\web\Response
     */
    public function actionReact()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $newsId = Yii::$app->request->post('news_id');
        $reactionId = Yii::$app->request->post('reaction_id');
        $userId = Yii::$app->user->id;

        $reaction = NewsReaction::find()->where([
            'news_id' => $newsId,
            'reaction_id' => $reactionId,
            'user_id' => $userId,
        ])->one();

        if ($reaction) {
            // If the reaction already exists, we remove it
            $reaction->delete();
            $userReacted = false;
        } else {
            // If there is no reaction, we create a new one.
            $reaction = new NewsReaction([
                'news_id' => $newsId,
                'reaction_id' => $reactionId,
                'user_id' => $userId,
            ]);
            $reaction->save();
            $userReacted = true;
        }

        // Getting the new number of reactions
        $newCount = NewsReaction::find()->where([
            'news_id' => $newsId,
            'reaction_id' => $reactionId,
        ])->count();

        return [
            'success' => true,
            'new_count' => $newCount,
            'user_reacted' => $userReacted,
        ];
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
            if ($model->user_id == \Yii::$app->user->id) {
                return $model;
            }

            // admin and news editor has access
            if (Yii::$app->user->identity->hasRole(['admin', 'news_editor'])) {
                return $model;
            }

            $newsRoles = NewsRoles::find()
                    ->leftJoin('user_roles', 'user_roles.id = news_roles.role_id   AND `user_roles`.`user_id` = '.Yii::$app->user->id)
                    ->where(['news_roles.news_id' => $model->id])
                    ->one();
                    
            if ($newsRoles) {
                return $model;    
            }
            
            throw new NotFoundHttpException('У вас нет доступа к этой новости');
        }

        throw new NotFoundHttpException('The requested news does not exist.');
    }
}
