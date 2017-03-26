<?php
namespace frontend\controllers;

use common\models\Address;
use common\models\Event;
use common\models\GeoCoder;
use common\models\User;
use frontend\models\EventCreateForm;
use Yii;
use yii\base\Exception;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class EventController extends Controller
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
                        'actions' => ['index', 'create', 'view', 'test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
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
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new EventCreateForm();
        $event = null;
        if ($model->load(Yii::$app->request->post()) && ($event = $model->create())) {
            return $this->redirect(['event/view', 'id' => $event->eventId]);
        }

        return $this->render('create', [
            'model' => $model,
            'addresses' => User::findIdentity(yii::$app->user->id)->formattedAddresses
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
            'event' => Event::find()->where(['eventId' => $id])->one()
        ]);
    }

    public function actionTest() {
        $coder = new GeoCoder();

        $arr = $coder->makeLatLngFromAddress(Address::find()->where(['addressId' => 1])->one());
        throw new Exception(VarDumper::dumpAsString($arr));
    }
}
