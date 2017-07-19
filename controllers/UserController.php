<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 17/5/12
 * Time: 下午3:10
 */

namespace app\controllers;

use YII;
use yii\helpers\Url;
use app\models\User;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\bootstrap\ActiveForm;
use app\models\form\LoginForm;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 登录
     * @return array|int|string
     */
    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest){
            return $this->goBack();
        }
        
        $this->layout = 'form';
        $model = new LoginForm();
        $request = Yii::$app->request;

        if($request->isAjax && $model->load($request->post())){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($request->isPost){
            if($model->load($request->post()) && $model->login()){
                return $this->goBack();
            }
        }
        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goBack();
    }

    public function actionRegister()
    {

    }
    
}