<?php

use devnullius\i18n\models\SourceMessage;
use devnullius\i18n\Module;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

assert($this instanceof View);
assert($model instanceof SourceMessage);

$this->title = Module::t('Update') . ': ' . $model->message;
$this->params['breadcrumbs'][] = ['label' => Module::t('Translations'), 'url' => ['/translations']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="card card-outline card-success">
    <div class="card-header">
        <?= Html::a(
            Html::tag('i', '', ['class' => 'fa fa-arrow-left']),
            ['/translations'],
            ['class' => 'btn btn-default', 'title' => Module::t('Back')]
        ) ?>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <?php $form = ActiveForm::begin(); ?>

                <?php foreach ($model->messages as $language => $message) : ?>
                    <div class="col-md-12 margin-bottom">
                        <div class="col-md-1">
                            <?= $language ?>
                        </div>
                        <div class="col-md-10">
                            <?= $form->field($model->messages[$language], '[' . $language . ']translation')->textarea(['class' => 'col-md-8'])->label(false) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($model->messages) > 0) : ?>
                <div class="form-group">
                    <?= Html::submitButton(Module::t('Update'), ['class' => 'btn btn-success']) ?>
                </div>
            <?php else : ?>
                <?= Module::t('Please activate at least one language.') ?>
            <?php endif; ?>
            <?php $form::end(); ?>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">

    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
