<?php
declare(strict_types=1);

namespace devnullius\i18n\models;

use devnullius\helper\helpers\FlagHelper;
use devnullius\i18n\components\I18N;
use devnullius\i18n\models\query\LanguageQuery;
use devnullius\i18n\Module;
use DomainException;
use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use function assert;
use function count;

/**
 * Class Language
 *
 * @package devnullius\i18n\models
 * @property string $language_id               [varchar(5)]
 * @property int    $created_by                [bigint]  Modifier id of create, if 0 created from db, if -1 not registered user.
 * @property int    $updated_by                [bigint]  Modifier id of update, if 0 created from db, if -1 not registered user.
 * @property int    $created_at                [bigint]  Unix time-stamp of create date.
 * @property int    $updated_at                [bigint]  Unix time-stamp of update date.
 * @property string $modifier                  [varchar(255)]  Operation performer entity name.
 * @property bool   $deleted                   [boolean]  If true row softly deleted, only marker.
 *
 * @property string $language                  [varchar(3)]
 * @property string $country                   [varchar(3)]
 * @property string $name                      [varchar(32)]
 * @property string $name_short                [varchar(32)]
 * @property string $name_ascii                [varchar(32)]
 * @property string $name_ascii_short          [varchar(32)]
 * @property int    $default                   [boolean]
 * @property int    $status                    [boolean]
 */
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

        return $i18n->getLanguageTableName();
    }

    /**
     * @return LanguageQuery
     */
    public static function find(): LanguageQuery
    {
        return new LanguageQuery(static::class);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['language_id', 'language', 'country', 'name', 'name_ascii'], 'required'],
            [['language_id',], 'string', 'max' => 5],
            [['language', 'country'], 'string', 'max' => 3],
            [['name', 'name_ascii'], 'string', 'max' => 32],
            [['name_short', 'name_ascii_short'], 'string', 'max' => 32],
            [['default', 'status'], 'boolean'],
            [
                ['default', 'status'],
                'filter',
                'filter' => function ($value) {
                    return (boolean)$value;
                },
            ],
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
            LanguageHelper::attributeLabels()
        );
    }

    /**
     * @param Language $language
     *
     * @throws Exception
     */
    public static function persist(self $language): void
    {
        if ($language->default === FlagHelper::IS_DEFAULT) {
            $otherDefaultLanguage = static::find()->isDefault(null, 'default')->all();
            try {
                if (count($otherDefaultLanguage) > 1) {
                    throw new DomainException('Consistency error there is greater than one language marked as default.');
                }
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
            }

            foreach ($otherDefaultLanguage as $entity) {
                $entity->default = FlagHelper::IS_NOT_DEFAULT;
                $entity->save();
            }
            $language->status = true;
        }
        if (!$language->save()) {
            throw new Exception('Save operation failed.');
        }
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
