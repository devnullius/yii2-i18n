<?php

use devnullius\helper\helpers\FlagHelper;
use devnullius\i18n\models\Language;
use devnullius\i18n\Module;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

assert($this instanceof View);
assert($form instanceof Language);

$this->title = Module::t('Update: {language}', ['language' => $form->name]);
$this->params['breadcrumbs'][] = ['label' => Module::t('Translations'), 'url' => ['/translations']];
$this->params['breadcrumbs'][] = ['label' => Module::t('Languages'), 'url' => ['/translations/language']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="card card-outline card-success">
    <div class="card-header">
        <?= Html::a(
            Html::tag('i', '', ['class' => 'fa fa-arrow-left']),
            ['index'],
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
        <div class="row">
            <div class="col-6">
                <?php $activeForm = ActiveForm::begin(); ?>

                <?= $activeForm->field($form, 'language_id')->textInput() ?>
                <?= $activeForm->field($form, 'language')->textInput() ?>
                <?= $activeForm->field($form, 'country')->textInput() ?>
                <?= $activeForm->field($form, 'name')->textInput() ?>
                <?= $activeForm->field($form, 'name_short')->textInput() ?>
                <?= $activeForm->field($form, 'name_ascii')->textInput() ?>
                <?= $activeForm->field($form, 'name_ascii_short')->textInput() ?>
                <?= $activeForm->field($form, 'default')->dropDownList(
                    FlagHelper::isDefaultList(),
                    ['prompt' => '', 'value' => (string)(int)$form->default]
                ) ?>
                <?= $activeForm->field($form, 'status')->dropDownList(
                    FlagHelper::isEnabledList(),
                    ['prompt' => '', 'value' => (string)(int)$form->status]
                ) ?>


                <div class="form-group">
                    <?= Html::submitButton(Module::t('Update'), ['class' => 'btn btn-success']) ?>
                </div>

                <?php $activeForm::end(); ?>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">

    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
