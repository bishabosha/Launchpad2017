<?php
namespace frontend\controllers;

use common\models\Event;
use common\models\User;
use frontend\models\EventCreateForm;
use Yii;
use yii\helpers\ArrayHelper;
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
                        'actions' => ['index', 'create', 'view', 'all', 'subscribe', 'accept'],
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

    public function actionSubscribe($id) {

        $userId = \yii::$app->user->id;
        $event = Event::find()->where(['eventId' => $id])->one();

        if (!isset($event) || $userId == $event->hostId) {
            $this->goBack();
        }

        $requests = $event->requestArray;

        if (!in_array($userId, $requests)) {
            $requests[] = $userId;
        }

        $event->requests = json_encode($requests);

        $event->save();

        $this->redirect(['/event/view', 'id' => $id]);
    }

    public function actionAccept($eventId, $userId) {

        $event = Event::find()->where(['eventId' => $eventId])->one();

        if (!isset($event) || $userId == $event->hostId) {
            $this->goBack();
        }

        $attending = $event->attendingArray;
        $requests = $event->requestArray;

        if (!in_array($userId, $attending) && in_array($userId, $requests)) {
            $attending[] = (integer)$userId;
            ArrayHelper::removeValue($requests, (integer)$userId);

            $event->requests = json_encode($requests);
            $event->attending = json_encode($attending);
            $event->save();

            $user = User::findIdentity($userId);
            $user->events_attended = $user->events_attended + 1;
            $user->save();
        }

        $this->redirect(['/profile']);
    }

    public function actionView($id) {
        return $this->render('view', [
            'event' => Event::find()->where(['eventId' => $id])->one()
        ]);
    }

    public function actionAll() {
        return $this->render('viewAll', [
            'events' => Event::find()->all()
        ]);
    }
}
