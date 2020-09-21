<?php
declare(strict_types=1);

namespace devnullius\i18n\models\search;

use devnullius\helper\helpers\FlagHelper;
use devnullius\i18n\models\Language;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use function is_numeric;
use const SORT_ASC;

class LanguageSearch extends Model
{
    public $language_id;
    public $language;
    public $country;
    public $name;
    public $name_ascii;
    public $name_short;
    public $name_ascii_short;
    public $default;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['language_id', 'safe'],
            ['language', 'safe'],
            ['country', 'safe'],
            ['name', 'safe'],
            ['name_short', 'safe'],
            ['name_ascii', 'safe'],
            ['name_ascii_short', 'safe'],
            ['default', 'safe'],
            ['status', 'boolean'],
        ];
    }

    /**
     * @param array|null $params
     *
     * @return ActiveDataProvider
     * @throws InvalidConfigException
     */
    public function search(?array $params): ActiveDataProvider
    {
        $query = Language::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['language_id' => SORT_ASC],
                'enableMultiSort' => true,

            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->getStatusFilterValue() === FlagHelper::IS_ENABLED) {
            $query->isEnabled(null, 'status');
        }
        if ($this->getStatusFilterValue() === FlagHelper::IS_DISABLED) {
            $query->isDisabled(null, 'status');
        }

        if ($this->getDefaultFilterValue() === FlagHelper::IS_DEFAULT) {
            $query->isDefault(null, 'default');
        }
        if ($this->getDefaultFilterValue() === FlagHelper::IS_NOT_DEFAULT) {
            $query->isNotDefault(null, 'default');
        }

        $query
            ->andFilterWhere(['like', Language::tableName() . '.language_id', $this->language_id])
            ->andFilterWhere(['like', Language::tableName() . '.language', $this->language])
            ->andFilterWhere(['like', Language::tableName() . '.country', $this->country])
            ->andFilterWhere(['like', Language::tableName() . '.name', $this->name])
            ->andFilterWhere(['like', Language::tableName() . '.name_short', $this->name_short])
            ->andFilterWhere(['like', Language::tableName() . '.name_ascii', $this->name_ascii])
            ->andFilterWhere(['like', Language::tableName() . '.name_ascii_short', $this->name_ascii_short]);

        return $dataProvider;
    }

    private function getStatusFilterValue(): ?bool
    {
        $status = null;
        if (is_numeric($this->status)) {
            $status = (bool)$this->status;
        }

        return $status;
    }

    private function getDefaultFilterValue(): ?bool
    {
        $default = null;
        if (is_numeric($this->default)) {
            $default = (bool)$this->default;
        }

        return $default;
    }
}
