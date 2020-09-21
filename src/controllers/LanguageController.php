<?php
declare(strict_types=1);

namespace devnullius\i18n\controllers;

use devnullius\i18n\models\Language;
use devnullius\i18n\models\search\LanguageSearch;
use devnullius\i18n\Module;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LanguageController extends Controller
{
    public function actionIndex(): string
    {
        $searchModel = new LanguageSearch();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->get());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new Language();
        try {
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                Language::persist($form);
                Yii::$app->session->setFlash('success', Module::t('Language successfully created.'));
            }
        } catch (Exception $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->render('create', ['form' => $form]);
    }

    public function actionUpdate(string $languageId)
    {
        $form = Language::find()->andWhere(['language_id' => $languageId])->one();
        if ($form === null) {
            throw new NotFoundHttpException(Module::t('Language with such ID - {id} not found.', ['id' => $languageId]));
        }
        try {
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                Language::persist($form);
                Yii::$app->session->setFlash('success', Module::t('Language successfully updated.'));
            }
        } catch (Exception $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->render('update', ['form' => $form]);
    }
}
