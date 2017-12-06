<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\ContactForm;

class SiteController extends Controller
{
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

    public function beforeAction($action) {
        $this->enableCsrfValidation = ($action->id !== "index"); // <-- here
        return parent::beforeAction($action);
    }

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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('map/index');
        }

        if (Yii::$app->request->isPost && $token = Yii::$app->request->post('token')) {
            if (function_exists('file_get_contents') && ini_get('allow_url_fopen')){

                $result = file_get_contents('http://ulogin.ru/token.php?token=' . $token .
                    '&host=' . $_SERVER['HTTP_HOST']);

                //если недоступна file_get_contents, пробуем использовать curl
            } elseif (in_array('curl', get_loaded_extensions())){

                $request = curl_init('http://ulogin.ru/token.php?token=' . $token .
                    '&host=' . $_SERVER['HTTP_HOST']);
                curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($request);

            }

            $data = $result ? json_decode($result, true) : array();

            //проверяем, чтобы в ответе были данные, и не было ошибки
            if (!empty($data) and !isset($data['error']) && $data['identity']){

                if(!$user = User::findByIdentity($data['identity'])) {
                    $user = new User();
                    $user->identity = $data['identity'];
                    $user->email = isset($data['email']) ? $data['email']: '';
                    $user->username = trim("{$data['first_name']}, {$data['last_name']}", ',');
                    if (!$user->save()) {
                        var_dump($user->errors);die();
                    }
                    $user = User::findIdentity($user->id);
                }

                Yii::$app->user->login($user, 3600*24*30);
            } else {
                $user = new User();
                $user->username = 'demo';
                if (!$user->save()) {
                    var_dump($user->errors);die();
                }

                $user = User::findIdentity($user->id);

                Yii::$app->user->login($user, 3600*24*30);
            }

            return $this->goBack();
        }
        return $this->render('index');
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
