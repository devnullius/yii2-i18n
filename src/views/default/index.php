<?php

use devnullius\i18n\models\search\SourceMessageSearch;
use devnullius\i18n\models\SourceMessage;
use devnullius\i18n\Module;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

assert($this instanceof View);
assert($searchModel instanceof SourceMessageSearch);
assert($dataProvider instanceof ActiveDataProvider);

$this->title = Module::t('Translations');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/translations']];
?>
<!-- Default box -->
<div class="card card-outline card-success">
    <div class="card-header">
        <?= Html::a(
            Html::tag('i', '', ['class' => 'fa fa-language']),
            ['/translations/language'],
            ['class' => 'btn btn-primary', 'title' => Module::t('Language')]
        ) ?>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <?php try {
            echo GridView::widget([
                'id' => 'translationsGrid',
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'showFooter' => false,
                'tableOptions' => ['class' => 'table table-bordered table-responsive-md table-striped'],
                'footerRowOptions' => ['class' => 'box box-success', 'style' => 'font-weight:bold;'],
                'columns' => [
                    [
                        'attribute' => 'id',
                        'value' => static function ($model, $index, $dataColumn) {
                            return $model->id;
                        },
                    ],
                    [
                        'attribute' => 'message',
                        'format' => 'raw',
                        'value' => static function ($model, $index, $widget) {
                            return Html::a($model->message, ['update', 'id' => $model->id], ['data' => ['pjax' => 0]]);
                        },
                    ],
                    'translation',
                    [
                        'attribute' => 'category',
                        'value' => static function ($model, $index, $dataColumn) {
                            return $model->category;
                        },
                        'filter' => ArrayHelper::map($searchModel::getCategories(), 'category', 'category'),
                    ],
                    [
                        'attribute' => 'status',
                        'value' => static function ($model, $index, $widget) {
                            assert($model instanceof SourceMessage);

                            return $model->isTranslated() ? 'Translated' : 'Not translated';
                        },
                        'filter' => $searchModel::getStatus(),
                    ],
                ],
            ]);
        } catch (Exception $e) {
            Yii::$app->errorHandler->logException($e);
            echo $e->getMessage();
        }
        ?>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">

    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
