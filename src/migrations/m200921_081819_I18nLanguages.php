<?php

use devnullius\i18n\components\I18N;
use devnullius\i18n\models\LanguageHelper;
use devnullius\i18n\models\LanguagesDictionary;
use yii\base\InvalidConfigException;
use yii\db\Migration;

/**
 * Class m200921_081819_I18nLanguages
 */
class m200921_081819_I18nLanguages extends Migration
{

    /**
     * {@inheritdoc}
     * @throws InvalidConfigException
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $i18n = Yii::$app->getI18n();
        assert($i18n instanceof I18N);
        if (!isset($i18n->sourceTable, $i18n->translationTable, $i18n->languageTable)) {
            throw new InvalidConfigException('You should configure i18n component');
        }

        $sourceTable = $i18n->getSourceTableName();
        $translationTable = $i18n->getTranslationTableName();
        $languageTable = $i18n->getLanguageTableName();

        $this->createTable($languageTable, [
            'language_id' => $this->string(5)->notNull(),

            'created_by' => $this->bigInteger()->notNull()->defaultValue(0),
            'updated_by' => $this->bigInteger()->notNull()->defaultValue(0),
            'created_at' => $this->bigInteger()->notNull(),
            'updated_at' => $this->bigInteger()->notNull(),
            'modifier' => $this->string()->notNull()->defaultValue('user'),
            'deleted' => $this->boolean()->defaultValue(false),

            'language' => $this->string(3)->notNull(),
            'country' => $this->string(3)->notNull(),
            'default' => $this->boolean()->defaultValue(false),
            'name' => $this->string(32)->notNull(),
            'name_short' => $this->string(32)->null(),
            'name_ascii' => $this->string(32)->notNull(),
            'name_ascii_short' => $this->string(32)->null(),
            'status' => $this->boolean()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk-language', $languageTable, 'language_id');

        $this->batchInsert($languageTable, [
            'language_id',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'modifier',
            'deleted',
            'language',
            'country',
            'default',
            'name',
            'name_ascii',
            'status',
        ], LanguageHelper::getLanguages());

        $this->createTable($sourceTable, [
            'id' => $this->bigPrimaryKey(),

            'created_by' => $this->bigInteger()->notNull()->defaultValue(0),
            'updated_by' => $this->bigInteger()->notNull()->defaultValue(0),
            'created_at' => $this->bigInteger()->notNull(),
            'updated_at' => $this->bigInteger()->notNull(),
            'modifier' => $this->string()->notNull()->defaultValue('user'),
            'deleted' => $this->boolean()->defaultValue(false),

            'category' => $this->string(32)->null(),
            'message' => $this->text()->null(),
        ], $tableOptions);

        $this->createTable($translationTable, [
            'id' => $this->bigInteger()->notNull(),

            'created_by' => $this->bigInteger()->notNull()->defaultValue(0),
            'updated_by' => $this->bigInteger()->notNull()->defaultValue(0),
            'created_at' => $this->bigInteger()->notNull(),
            'updated_at' => $this->bigInteger()->notNull(),
            'modifier' => $this->string()->notNull()->defaultValue('user'),
            'deleted' => $this->boolean()->defaultValue(false),

            'language' => $this->string(5)->notNull(),
            'translation' => $this->text()->null(),
        ], $tableOptions);

        $this->addPrimaryKey('pk-language_translate', $translationTable, ['id', 'language']);

        $this->createIndex('language_translate_idx_language', $translationTable, 'language');

        $this->addForeignKey(
            'fk-language_translate-language-language_id',
            $translationTable,
            ['language'],
            $languageTable,
            ['language_id'],
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-language_translate-translate_id-source_id',
            $translationTable,
            ['id'],
            $sourceTable,
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     * @throws InvalidConfigException
     */
    public function safeDown()
    {
        $i18n = Yii::$app->getI18n();
        assert($i18n instanceof I18N);
        if (!isset($i18n->sourceTable, $i18n->translationTable, $i18n->languageTable)) {
            throw new InvalidConfigException('You should configure i18n component');
        }

        $sourceTable = $i18n->getSourceTableName();
        $translationTable = $i18n->getTranslationTableName();
        $languageTable = $i18n->getLanguageTableName();

        $this->dropTable($translationTable);
        $this->dropTable($sourceTable);
        $this->dropTable($languageTable);
    }
}
