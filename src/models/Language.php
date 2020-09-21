<?php
declare(strict_types=1);

namespace devnullius\i18n\models;

use devnullius\i18n\components\I18N;
use devnullius\i18n\Module;
use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use function assert;

final class Language extends ActiveRecord
{
    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get(Yii::$app->getI18n()->db);
    }

    /**
     * @return string
     * @throws InvalidConfigException
     */
    public static function tableName(): string
    {
        $i18n = Yii::$app->getI18n();
        assert($i18n instanceof I18N);
        if (!isset($i18n->translationTable)) {
            throw new InvalidConfigException('You should configure i18n component');
        }

        return $i18n->getTranslationTableName();
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['language_id',], 'string', 'max' => 5],
            [['language', 'country'], 'string', 'max' => 3],
            [['name', 'name_ascii'], 'string', 'max' => 32],
            [['default', 'status'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return ArrayHelper::merge(
            [
                'language_id' => Module::t('ID'),
                'language' => Module::t('Language'),
                'country' => Module::t('Country'),
                'default' => Module::t('Default'),
                'name' => Module::t('Name'),
                'name_ascii' => Module::t('ASCII Name'),
                'status' => Module::t('Status'),
            ],
            LanguageHelper::attributeLabels(
                static function (string $message, array $params = [], ?string $language = null) {
                    return Module::t($message, $params, $language);
                }
            )
        );
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'defaultValue' => -1,
            ],
        ];
    }
}
