<?php
declare(strict_types=1);

namespace devnullius\i18n\components;

use devnullius\i18n\models\Language;
use devnullius\i18n\Module;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\i18n\DbMessageSource;

class I18N extends \yii\i18n\I18N
{
    public string $languageTable = '{{%language}}';

    public string $sourceTable = '{{%language_source}}';

    public string $translationTable = '{{%language_translate}}';

    public string $sourceLanguage = 'en-US';

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
        $activeLanguages = Language::find()->andWhere(['status' => true])->all();
        $this->languages = ArrayHelper::getValue($activeLanguages, 'language_id');
        if (!$this->languages) {
            throw new InvalidConfigException('You should configure i18n component [language]');
        }

        if (!isset($this->translations['*'])) {
            $this->translations['*'] = [
                'class' => DbMessageSource::class,
                'db' => $this->db,
                'sourceMessageTable' => $this->getSourceTableName(),
                'messageTable' => $this->getTranslationTableName(),
                'on missingTranslation' => $this->getMissingTranslationHandlerPackage(),
                'sourceLanguage' => $this->getDevelopSourceLanguage(),
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
                'sourceLanguage' => $this->getDevelopSourceLanguage(),
                'cachingDuration' => $this->getCachingDurationValue(),
                'enableCaching' => $this->isCacheEnabled(),
            ];
        }
        parent::init();
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
}
