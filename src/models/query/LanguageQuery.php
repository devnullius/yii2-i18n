<?php
declare(strict_types=1);

namespace devnullius\i18n\models\query;

use devnullius\helper\helpers\StandardQueryTrait;
use yii\db\ActiveQuery;

final class LanguageQuery extends ActiveQuery
{
    use StandardQueryTrait;
}
