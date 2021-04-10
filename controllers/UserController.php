<?php

namespace app\controllers;

use app\models\Users;
use app\models\UsersIntegrationsJivositeApi;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * Login action.
     *
     * @return Response|string
     */

    public function actionValidate()
    {
        $model = new Users();
        $user = $model::findByUserEmail(Yii::$app->user->identity->email);
        $userModelItem = UsersIntegrationsJivositeApi::findByUserId(Yii::$app->user->identity->getId());
        $model = $userModelItem;
        $request = Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

    }

    public function actionSave()
    {
        $model = new Users();
        $user = $model::findByUserEmail(Yii::$app->user->identity->email);
        $userModelItem = UsersIntegrationsJivositeApi::findByUserId(Yii::$app->user->identity->getId());
        $model = $userModelItem;
        $request = Yii::$app->getRequest();
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($request->isPost && $model->load($request->post())) {
            return ['success' => $model->save()];
        }
        return $this->renderAjax('form', [
            'model' => $userModelItem,
            'user' => $user
        ]);
    }

    /*
        public function actionCreatewidget(){
            return $this->render('Jivo',[
                'email'=>Yii::$app->user->identity->email,
                'user_id' => Users::findByUserEmail(Yii::$app->user->identity->id)]
            );
        }
      */

    public function actionForm()
    {


        if (Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->user->loginUrl)->send();

        }

        $UsersIntegrationsJivositeApiModel = new UsersIntegrationsJivositeApi();

        $id = Yii::$app->user->identity->getId();
        $email = Yii::$app->user->identity->email;
        $model = new Users();


        $user = $model::findByUserEmail($email);

        if (!UsersIntegrationsJivositeApi::find()->where(['user_id' => $id])->exists()) {

            $sql = "INSERT INTO `users_integrations_jivosite_api` (`user_id`, `js`) VALUES ('$id', 'code');";

            Yii::$app->db->createCommand($sql)->execute();
        }
        $UsersIntegrationsJivositeApi = UsersIntegrationsJivositeApi::findByUserId($id);


        if ($user->load(Yii::$app->request->post()) && $user->login()) {

            return $this->redirect(['user/form', 'model' => $UsersIntegrationsJivositeApi, 'user' => $user]);

        }


        return $this->render('form', [
            'model' => $UsersIntegrationsJivositeApi,
            'user' => $user
        ]);

    }


}
