<?php
declare(strict_types=1);

namespace devnullius\i18n;

use devnullius\i18n\models\SourceMessage;
use Yii;
use yii\i18n\MissingTranslationEvent;

class Module extends \yii\base\Module
{
    public int $pageSize = 50;

    public static function t(string $message, array $params = [], ?string $language = null): string
    {
        return Yii::t('i18n', $message, $params, $language);
    }

    /**
     * @param MissingTranslationEvent $event
     */
    public static function missingTranslation(MissingTranslationEvent $event): void
    {
        $driver = Yii::$app->getDb()->getDriverName();
        $caseInsensitivePrefix = $driver === 'mysql' ? 'binary' : '';
        $sourceMessage = SourceMessage::find()
            ->where('category = :category and message = ' . $caseInsensitivePrefix . ' :message', [
                ':category' => $event->category,
                ':message' => $event->message,
            ])
            ->with('messages')
            ->one();

        if (!$sourceMessage) {
            $sourceMessage = new SourceMessage;
            $sourceMessage->setAttributes([
                'category' => $event->category,
                'message' => $event->message,
            ], false);
            $sourceMessage->save(false);
        }
        $sourceMessage->initMessages();
        $sourceMessage->saveMessages();
        $event->translatedMessage = $event->message;
        //        $event->translatedMessage = "@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @";
    }
}
