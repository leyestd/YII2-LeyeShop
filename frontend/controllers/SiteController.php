<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Auth;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client) {
        $session = Yii::$app->session;

        $attributes = $client->getUserAttributes();
        $nickname = $client->getUserInfo();
        $session->set('userinfo', $nickname['nickname']);
        $session->set('userimage', $nickname['figureurl_qq_2']);

        /** @var Auth $auth */
        $auth = Auth::find()->where([
                    'source' => $client->getId(),
                    'source_id' => $attributes['openid'],
                ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = $auth->user;
                Yii::$app->user->login($user);
            } else { // signup
                $this->redirect(['bind', 'openid' => $attributes['openid'], 'source' => $client->getId()]);
            }
        } else { // user already logged in
            if ($auth == NULL) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['openid'],
                ]);
                $auth->save();
            } else {

                if ($auth->user_id !== Yii::$app->user->id) {
                    Yii::$app->session->setFlash('error', '登入失败.');

                    unset($session['userinfo']);
                    unset($session['userimage']);
                }
            }
        }
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    public function actionAbout() {
        return $this->render('about');
    }

    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionBind($openid, $source) {
        $session = Yii::$app->session;
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->fullname = $model->fullname;
            $user->setPassword($model->password);
            $user->generateAuthKey();
            $user->generatePasswordResetToken();
            $transaction = $user->getDb()->beginTransaction();
            try {
                if ($user->save()) {
                    $auth = new Auth([
                        'user_id' => $user->id,
                        'source' => $source,
                        'source_id' => $openid,
                    ]);

                    if ($auth->save()) {
                        $transaction->commit();
                        Yii::$app->user->login($user);

                        $this->goHome();
                    } else {
                        $transaction->rollBack();
                        print_r($auth->getErrors());
                    }
                } else {

                    $session->remove('userinfo');
                    $session->remove('userimage');
                    print_r($user->getErrors());
                }
            } catch (\Exception $e) {
                $session->remove('userinfo');
                $session->remove('userimage');
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('bind', [
                    'model' => $model
        ]);
    }

    public function actionTest() {
        $html = ' <img src="http://img03.fn-mart.com/C/web/layout/index/20150710140101_kk-0.png" style="width: 160px; height: 60px;"><img border="0" src="/images/image.jpg" alt="Image" width="100" height="100" /><img border="0" src="/images/i1mage.jpg" alt="Image" width="100" height="100" /><img border="0" src="/images/image.jpg" alt="Image" width="100" height="100" />';


        $dom = new \DOMDocument;
        $dom->loadHTML($html);

        foreach ($dom->getElementsByTagName('img') as $tt) {
            echo $tt->attributes->getNamedItem("src")->value;
        }
//echo $img->attributes->getNamedItem("src")->value;
    }

}
