<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\UserIdentity;
use app\models\ContactForm;
use yii\web\BadRequestHttpException;

class SiteController extends BaseController
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
                    'logout' => ['get'],
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
        if (!$this->user->isGuest) {
            $village = $this->currentUser->getVillage();
            if (!$village) {
                $this->commandVillageCreate->execute($this->currentUser);
                return $this->goBack();
            }
            return $this->redirect(Url::to(['map/index', 'x' => $village->map->x, 'y' => $village->map->y]));
        }

        if ($this->request->isPost && $token = $this->request->post('token')) {
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

                if(!$user = UserIdentity::findByIdentity($data['identity'])) {
                    $user = new UserIdentity();
                    $user->identity = $data['identity'];
                    $user->email = isset($data['email']) ? $data['email']: '';
                    $user->username = trim("{$data['first_name']}, {$data['last_name']}", ',');
                    $user->save();

                    $this->commandVillageCreate->execute($user);
                    $user = UserIdentity::findIdentity($user->id);
                }
                $this->user->login($user, 3600*24*30);
            } else {
                throw new BadRequestHttpException("Login failed");
            }

            return $this->goBack();
        }
        return $this->render('index');
    }

	
    public function actionTask() {
        $this->commandTaskCheck->execute();
        die('done');
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
