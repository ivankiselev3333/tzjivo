<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use app\models\UsersIntegrationsJivositeApi;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;


class SiteController extends Controller
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

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */


    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $LoginFormModel = new LoginForm();

        $UsersIntegrationsJivositeApiModel = new UsersIntegrationsJivositeApi();

        if ($LoginFormModel->load(Yii::$app->request->post()) && $LoginFormModel->login()) {

            return $this->redirect(['user/form', 'model' => $UsersIntegrationsJivositeApiModel])->send();


        }

        return $this->render('login', [
            'model' => $LoginFormModel,
        ]);
    }


    public function actionSignup()
    {
        $SignupFormModel = new SignupForm();

        try {

            if ($SignupFormModel->load(Yii::$app->request->post())) {

                if ($user = $SignupFormModel->signup()) {

                    if (Yii::$app->getUser()->login($user)) {
                        return $this->goHome();

                    }
                }
            }
        } catch (Exception $exception) {
            if (!Yii::$app->user->isGuest) {

                return $this->goHome();

            }

            $LoginFormModel = new LoginForm();

            $UsersIntegrationsJivositeApiModel = new UsersIntegrationsJivositeApi();

            if ($LoginFormModel->load(Yii::$app->request->post()) && $LoginFormModel->login()) {

                return $this->redirect(['user/form', 'model' => $UsersIntegrationsJivositeApiModel])->send();

            }

            return $this->render('login', [
                'model' => $LoginFormModel,
            ]);
            echo Yii::warning(" Email already exists! ");
        }


        return $this->render('signup', [
            'model' => $SignupFormModel,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {

            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
