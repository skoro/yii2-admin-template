<?php

use app\base\grid\DeleteColumn;
use app\helpers\UserHelper;
use app\widgets\Box;
use app\widgets\Modal;
use app\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $userProvider yii\data\ActiveDataProvider */
/** @var $register app\forms\user\Register */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin([
    
]) ?>
    <?php Pjax::begin([
        'modal' => true,
    ]) ?>
        <div class="btn-group">
            <?php if (Yii::$app->user->can('createUser')): ?>
            <?php Modal::begin([
                'header' => '<b>' . Yii::t('app', 'Create a new user') . '</b>',
                'toggleButton' => [
                    'label' => Yii::t('app', 'Create'),
                    'class' => ['btn btn-flat btn-default'],
                ],
            ]) ?>
                <?= $this->render('_create_modal', ['register' => $register]) ?>
            <?php Modal::end() ?>
            <?php endif ?>
        </div>
        <?= GridView::widget([
            'dataProvider' => $userProvider,
            'columns' => [
                'id',
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return UserHelper::userLink($model, ['data-pjax' => 0]);
                    },
                ],
                'email',
                [
                    'header' => Yii::t('app', 'Roles'),
                    'format' => 'html',
                    'value' => function ($user) {
                        return Html::ul(ArrayHelper::getColumn($user->getRoles(), 'name'));
                    },
                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($model) {
                        return UserHelper::status($model);
                    },
                ],
                'created_at:relativeTime',
                'logged_at:relativeTime',
                [
                    'class' => DeleteColumn::className(),
                    'visible' => Yii::$app->user->can('deleteAnyUser'),
                ],
            ],
        ]) ?>
    <?php Pjax::end() ?>
<?php Box::end() ?>
