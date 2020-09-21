<?php

use devnullius\helper\helpers\FlagHelper;
use devnullius\i18n\models\search\LanguageSearch;
use devnullius\i18n\Module;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

assert($this instanceof View);
assert($searchModel instanceof LanguageSearch);
assert($dataProvider instanceof ActiveDataProvider);

$this->title = Module::t('Languages');
$this->params['breadcrumbs'][] = ['label' => Module::t('Translations'), 'url' => ['/translations']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/translations/language']];
?>
<!-- Default box -->
<div class="card card-outline card-success">
    <div class="card-header">
        <?= Html::a(
            Html::tag('i', '', ['class' => 'fa fa-arrow-left']),
            ['/translations'],
            ['class' => 'btn btn-default', 'title' => Module::t('Back')]
        ) ?>
        <?= Html::a(
            Html::tag('i', '', ['class' => 'fa fa-plus']),
            ['create'],
            ['class' => 'btn btn-success', 'title' => Module::t('Create')]
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
                'id' => 'languagesGrid',
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'showFooter' => false,
                'tableOptions' => ['class' => 'table table-bordered table-responsive-md table-striped'],
                'footerRowOptions' => ['class' => 'box box-success', 'style' => 'font-weight:bold;'],
                'columns' => [
                    [
                        'attribute' => 'language_id',
                        'value' => static function ($model, $index, $dataColumn) {
                            return $model->language_id;
                        },
                    ],
                    [
                        'attribute' => 'language',
                        'format' => 'raw',
                        'value' => static function ($model, $index, $widget) {
                            return Html::a($model->language, ['update', 'languageId' => $model->language_id], ['data' => ['pjax' => 0]]);
                        },
                    ],
                    [
                        'attribute' => 'country',
                        'format' => 'raw',
                        'value' => static function ($model, $index, $widget) {
                            return Html::a($model->country, ['update', 'languageId' => $model->language_id], ['data' => ['pjax' => 0]]);
                        },
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => static function ($model, $index, $widget) {
                            return Html::a($model->name, ['update', 'languageId' => $model->language_id], ['data' => ['pjax' => 0]]);
                        },
                    ],
                    [
                        'attribute' => 'name_short',
                        'format' => 'raw',
                        'value' => static function ($model, $index, $widget) {
                            return Html::a($model->name_short, ['update', 'languageId' => $model->language_id], ['data' => ['pjax' => 0]]);
                        },
                    ],
                    [
                        'attribute' => 'name_ascii',
                        'format' => 'raw',
                        'value' => static function ($model, $index, $widget) {
                            return Html::a($model->name_ascii, ['update', 'languageId' => $model->language_id], ['data' => ['pjax' => 0]]);
                        },
                    ],
                    [
                        'attribute' => 'name_ascii_short',
                        'format' => 'raw',
                        'value' => static function ($model, $index, $widget) {
                            return Html::a($model->name_ascii_short, ['update', 'languageId' => $model->language_id], ['data' => ['pjax' => 0]]);
                        },
                    ],
                    [
                        'attribute' => 'default',
                        'format' => 'raw',
                        'value' => static function ($model, $index, $widget) {
                            return Html::a(FlagHelper::isDefaultList()[$model->default], ['update', 'languageId' => $model->language_id], ['data' => ['pjax' => 0]]);
                        },
                        'filter' => FlagHelper::isDefaultList(),
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => static function ($model, $index, $widget) {
                            return Html::a(FlagHelper::isEnabledList()[$model->status], ['update', 'languageId' => $model->language_id], ['data' => ['pjax' => 0]]);
                        },
                        'filter' => FlagHelper::isEnabledList(),
                    ],
                    //                    [
                    //                        'attribute' => 'category',
                    //                        'value' => static function ($model, $index, $dataColumn) {
                    //                            return $model->category;
                    //                        },
                    //                        'filter' => ArrayHelper::map($searchModel::getCategories(), 'category', 'category'),
                    //                    ],
                    //                    [
                    //                        'attribute' => 'status',
                    //                        'value' => static function ($model, $index, $widget) {
                    //                            assert($model instanceof SourceMessage);
                    //
                    //                            return $model->isTranslated() ? 'Translated' : 'Not translated';
                    //                        },
                    //                        'filter' => $searchModel::getStatus(),
                    //                    ],
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
