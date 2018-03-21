<?php

namespace app\controllers;

use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use app\models\Dishes;
use app\models\DishesSearch;
use app\models\IngredientsSearch;
use app\models\Ingredients;
use app\models\DishesIngredients;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DishesController implements the CRUD actions for Dish model.
 */
class DishesController extends MasterController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Dishes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DishesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dishes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dishes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model       = new Dishes();
        $searchModel = new IngredientsSearch();

        $ingredientsIds = $this->getIngredientsIds();
        $dataProvider   = $searchModel->search(Yii::$app->request->queryParams, $ingredientsIds);
        $model->ingredientsIds = $ingredientsIds;

        if ($model->load(Yii::$app->request->post()) && $model->save() && DishesIngredients::createDish($model->id, $ingredientsIds)) {
            Yii::$app->session->remove('ingredients');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $ingredients = Ingredients::findAll($ingredientsIds);

        return $this->render('create', [
            'ingredients'  => $ingredients,
            'model'        => $model,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Dishes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new IngredientsSearch();

        if ($addIngredientId = Yii::$app->request->post('add-ingredient')) {
            $model->addIngredient($addIngredientId);
        }

        if ($removeIngredientId = Yii::$app->request->post('remove-ingredient')) {
            $model->removeIngredient($removeIngredientId);
        }

        $ingredientsIds = $model->getIngredientsIds();

        $dataProvider   = $searchModel->search(Yii::$app->request->queryParams, $ingredientsIds);
        $model->ingredientsIds = $ingredientsIds;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'ingredients'  => $model->ingredients,
            'model'        => $model,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Dishes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (Exception $e) {

        } catch (\Throwable $e) {

        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dishes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dishes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dishes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
