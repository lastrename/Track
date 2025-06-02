<?php

namespace app\modules\api\controllers;

use app\models\Track;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class TrackController extends ActiveController
{
    public $modelClass = Track::class;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'matchCallback' => function () {
                        return !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin();
                    },
                    'denyCallback' => function () {
                        throw new ForbiddenHttpException('You are not allowed to access this page.');
                    }
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider(): ActiveDataProvider
    {
        $request = Yii::$app->request;
        $query = Track::find();

        if ($status = $request->get('status')) {
            $query->andWhere(['status' => $status]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionBatchUpdateStatus(): void
    {
        $request = Yii::$app->request;
        $trackIds = $request->post('track_ids', []);
        $status = $request->post('status');

        if (empty($trackIds) || empty($status)) {
            throw new BadRequestHttpException('track_ids and status are required');
        }

        if (!in_array($status, Track::STATUS_LIST)) {
            throw new BadRequestHttpException('Invalid status');
        }

        Track::updateAll(
            ['status' => $status],
            ['id' => $trackIds]
        );

        Yii::$app->response->setStatusCode(200);
    }

    /**
     * @throws UnauthorizedHttpException
     */
    public function checkAccess($action, $model = null, $params = []): void
    {
        if (Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
            throw new UnauthorizedHttpException('Authentication required');
        }
    }
}