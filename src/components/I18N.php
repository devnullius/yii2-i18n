<?php
declare(strict_types=1);

namespace devnullius\i18n\components;

use devnullius\i18n\models\Language;
use devnullius\i18n\Module;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\i18n\DbMessageSource;
use function is_string;

class I18N extends \yii\i18n\I18N
{
    private static array $languageList = [];

    public string $languageTable = '{{%i18n_language}}';

    public string $sourceTable = '{{%i18n_language_source}}';

    public string $translationTable = '{{%i18n_language_translate}}';

    public string $sourceLanguage = 'en-US';

    public bool $showOnlyCurrentLanguage = false;

    public int $cachingDuration = 86400;

    public bool $enableCaching = false;

    public array $languages = [];

    public array $missingTranslationHandler = [Module::class, 'missingTranslation'];

    public string $db = 'db';

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        $sourceLanguage = $this->getDevelopSourceLanguage();
        Yii::$app->sourceLanguage = $sourceLanguage;
        if (!isset($this->translations['*'])) {
            $this->translations['*'] = [
                'class' => DbMessageSource::class,
                'db' => $this->db,
                'sourceMessageTable' => $this->getSourceTableName(),
                'messageTable' => $this->getTranslationTableName(),
                'on missingTranslation' => $this->getMissingTranslationHandlerPackage(),
                'sourceLanguage' => $sourceLanguage,
                'cachingDuration' => $this->getCachingDurationValue(),
                'enableCaching' => $this->isCacheEnabled(),
            ];
        }
        if (!isset($this->translations['app']) && !isset($this->translations['app*'])) {
            $this->translations['app'] = [
                'class' => DbMessageSource::class,
                'db' => $this->db,
                'sourceMessageTable' => $this->getSourceTableName(),
                'messageTable' => $this->getTranslationTableName(),
                'on missingTranslation' => $this->getMissingTranslationHandlerPackage(),
                'sourceLanguage' => $sourceLanguage,
                'cachingDuration' => $this->getCachingDurationValue(),
                'enableCaching' => $this->isCacheEnabled(),
            ];
        }
        parent::init();
    }

    final public static function initLanguageList(): array
    {
        if (static::$languageList === []) {
            $activeLanguages = Language::find()->andWhere(['status' => true])->all();
            static::$languageList = ArrayHelper::getColumn($activeLanguages, 'language_id');
        }

        return static::$languageList;
    }

    final public function getMissingTranslationHandlerPackage(): array
    {
        return $this->missingTranslationHandler;
    }

    final public function getSourceTableName(): string
    {
        return $this->sourceTable;
    }

    final public function getTranslationTableName(): string
    {
        return $this->translationTable;
    }

    final public function getLanguageTableName(): string
    {
        return $this->languageTable;
    }

    final public function getDevelopSourceLanguage(): string
    {
        try {
            /**
             * @var $defaultLanguage string
             */
            $languageTableName = $this->getLanguageTableName();
            $defaultLanguage = (new Query())
                ->select(['language_id'])
                ->from($languageTableName)
                ->where(['deleted' => false, 'default' => true])
                ->limit(1)
                ->cache()
                ->scalar();
            if (!is_string($defaultLanguage)) {
                throw new Exception('Reading default source language failed, fallback to ' . $this->sourceLanguage . '.');
            }
            $this->sourceLanguage = $defaultLanguage;
        } catch (Exception $e) {
            Yii::$app->errorHandler->logException($e);
        }

        return $this->sourceLanguage;
    }

    final public function getCachingDurationValue(): int
    {
        return $this->cachingDuration;
    }

    final public function isCacheEnabled(): bool
    {
        return $this->enableCaching === true;
    }

    final public function doShowOnlyCurrentLanguage(): bool
    {
        return $this->showOnlyCurrentLanguage === true;
    }
}
