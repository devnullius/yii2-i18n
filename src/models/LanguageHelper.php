<?php
declare(strict_types=1);

namespace devnullius\i18n\models;

use devnullius\helper\helpers\CoreHelper;

final class LanguageHelper extends CoreHelper
{
    private static array $languages = [
        ['af-ZA', -1, -1, 1, 1, 'system', false, 'af', 'za', false, 'Afrikaans', 'Afrikaans', false],
        ['ar-AR', -1, -1, 1, 1, 'system', false, 'ar', 'ar', false, '‏العربية‏', 'Arabic', false],
        ['az-AZ', -1, -1, 1, 1, 'system', false, 'az', 'az', false, 'Azərbaycan dili', 'Azerbaijani', false],
        ['be-BY', -1, -1, 1, 1, 'system', false, 'be', 'by', false, 'Беларуская', 'Belarusian', false],
        ['bg-BG', -1, -1, 1, 1, 'system', false, 'bg', 'bg', false, 'Български', 'Bulgarian', false],
        ['bn-IN', -1, -1, 1, 1, 'system', false, 'bn', 'in', false, 'বাংলা', 'Bengali', false],
        ['bs-BA', -1, -1, 1, 1, 'system', false, 'bs', 'ba', false, 'Bosanski', 'Bosnian', false],
        ['ca-ES', -1, -1, 1, 1, 'system', false, 'ca', 'es', false, 'Català', 'Catalan', false],
        ['cs-CZ', -1, -1, 1, 1, 'system', false, 'cs', 'cz', false, 'Čeština', 'Czech', false],
        ['cy-GB', -1, -1, 1, 1, 'system', false, 'cy', 'gb', false, 'Cymraeg', 'Welsh', false],
        ['da-DK', -1, -1, 1, 1, 'system', false, 'da', 'dk', false, 'Dansk', 'Danish', false],
        ['de-DE', -1, -1, 1, 1, 'system', false, 'de', 'de', false, 'Deutsch', 'German', false],
        ['el-GR', -1, -1, 1, 1, 'system', false, 'el', 'gr', false, 'Ελληνικά', 'Greek', false],
        ['en-GB', -1, -1, 1, 1, 'system', false, 'en', 'gb', false, 'English (UK)', 'English (UK)', false],
        ['en-PI', -1, -1, 1, 1, 'system', false, 'en', 'pi', false, 'English (Pirate)', 'English (Pirate)', false],
        ['en-UD', -1, -1, 1, 1, 'system', false, 'en', 'ud', false, 'English (Upside Down)', 'English (Upside Down)', false],
        ['en-US', -1, -1, 1, 1, 'system', false, 'en', 'us', true, 'English (US)', 'English (US)', true],
        ['eo-EO', -1, -1, 1, 1, 'system', false, 'eo', 'eo', false, 'Esperanto', 'Esperanto', false],
        ['es-ES', -1, -1, 1, 1, 'system', false, 'es', 'es', false, 'Español (España)', 'Spanish (Spain)', false],
        ['es-LA', -1, -1, 1, 1, 'system', false, 'es', 'la', false, 'Español', 'Spanish', false],
        ['et-EE', -1, -1, 1, 1, 'system', false, 'et', 'ee', false, 'Eesti', 'Estonian', false],
        ['eu-ES', -1, -1, 1, 1, 'system', false, 'eu', 'es', false, 'Euskara', 'Basque', false],
        ['fa-IR', -1, -1, 1, 1, 'system', false, 'fa', 'ir', false, '‏فارسی‏', 'Persian', false],
        ['fb-LT', -1, -1, 1, 1, 'system', false, 'fb', 'lt', false, 'Leet Speak', 'Leet Speak', false],
        ['fi-FI', -1, -1, 1, 1, 'system', false, 'fi', 'fi', false, 'Suomi', 'Finnish', false],
        ['fo-FO', -1, -1, 1, 1, 'system', false, 'fo', 'fo', false, 'Føroyskt', 'Faroese', false],
        ['fr-CA', -1, -1, 1, 1, 'system', false, 'fr', 'ca', false, 'Français (Canada)', 'French (Canada)', false],
        ['fr-FR', -1, -1, 1, 1, 'system', false, 'fr', 'fr', false, 'Français (France)', 'French (France)', false],
        ['fy-NL', -1, -1, 1, 1, 'system', false, 'fy', 'nl', false, 'Frysk', 'Frisian', false],
        ['ga-IE', -1, -1, 1, 1, 'system', false, 'ga', 'ie', false, 'Gaeilge', 'Irish', false],
        ['gl-ES', -1, -1, 1, 1, 'system', false, 'gl', 'es', false, 'Galego', 'Galician', false],
        ['he-IL', -1, -1, 1, 1, 'system', false, 'he', 'il', false, '‏עברית‏', 'Hebrew', false],
        ['hi-IN', -1, -1, 1, 1, 'system', false, 'hi', 'in', false, 'हिन्दी', 'Hindi', false],
        ['hr-HR', -1, -1, 1, 1, 'system', false, 'hr', 'hr', false, 'Hrvatski', 'Croatian', false],
        ['hu-HU', -1, -1, 1, 1, 'system', false, 'hu', 'hu', false, 'Magyar', 'Hungarian', false],
        ['hy-AM', -1, -1, 1, 1, 'system', false, 'hy', 'am', false, 'Հայերեն', 'Armenian', false],
        ['id-ID', -1, -1, 1, 1, 'system', false, 'id', 'id', false, 'Bahasa Indonesia', 'Indonesian', false],
        ['is-IS', -1, -1, 1, 1, 'system', false, 'is', 'is', false, 'Íslenska', 'Icelandic', false],
        ['it-IT', -1, -1, 1, 1, 'system', false, 'it', 'it', false, 'Italiano', 'Italian', false],
        ['ja-JP', -1, -1, 1, 1, 'system', false, 'ja', 'jp', false, '日本語', 'Japanese', false],
        ['ka-GE', -1, -1, 1, 1, 'system', false, 'ka', 'ge', false, 'ქართული', 'Georgian', false],
        ['km-KH', -1, -1, 1, 1, 'system', false, 'km', 'kh', false, 'ភាសាខ្មែរ', 'Khmer', false],
        ['ko-KR', -1, -1, 1, 1, 'system', false, 'ko', 'kr', false, '한국어', 'Korean', false],
        ['ku-TR', -1, -1, 1, 1, 'system', false, 'ku', 'tr', false, 'Kurdî', 'Kurdish', false],
        ['la-VA', -1, -1, 1, 1, 'system', false, 'la', 'va', false, 'lingua latina', 'Latin', false],
        ['lt-LT', -1, -1, 1, 1, 'system', false, 'lt', 'lt', false, 'Lietuvių', 'Lithuanian', false],
        ['lv-LV', -1, -1, 1, 1, 'system', false, 'lv', 'lv', false, 'Latviešu', 'Latvian', false],
        ['mk-MK', -1, -1, 1, 1, 'system', false, 'mk', 'mk', false, 'Македонски', 'Macedonian', false],
        ['ml-IN', -1, -1, 1, 1, 'system', false, 'ml', 'in', false, 'മലയാളം', 'Malayalam', false],
        ['ms-MY', -1, -1, 1, 1, 'system', false, 'ms', 'my', false, 'Bahasa Melayu', 'Malay', false],
        ['nb-NO', -1, -1, 1, 1, 'system', false, 'nb', 'no', false, 'Norsk (bokmål)', 'Norwegian (bokmal)', false],
        ['ne-NP', -1, -1, 1, 1, 'system', false, 'ne', 'np', false, 'नेपाली', 'Nepali', false],
        ['nl-NL', -1, -1, 1, 1, 'system', false, 'nl', 'nl', false, 'Nederlands', 'Dutch', false],
        ['nn-NO', -1, -1, 1, 1, 'system', false, 'nn', 'no', false, 'Norsk (nynorsk)', 'Norwegian (nynorsk)', false],
        ['pa-IN', -1, -1, 1, 1, 'system', false, 'pa', 'in', false, 'ਪੰਜਾਬੀ', 'Punjabi', false],
        ['pl-PL', -1, -1, 1, 1, 'system', false, 'pl', 'pl', false, 'Polski', 'Polish', false],
        ['ps-AF', -1, -1, 1, 1, 'system', false, 'ps', 'af', false, '‏پښتو‏', 'Pashto', false],
        ['pt-BR', -1, -1, 1, 1, 'system', false, 'pt', 'br', false, 'Português (Brasil)', 'Portuguese (Brazil)', false],
        ['pt-PT', -1, -1, 1, 1, 'system', false, 'pt', 'pt', false, 'Português (Portugal)', 'Portuguese (Portugal)', false],
        ['ro-RO', -1, -1, 1, 1, 'system', false, 'ro', 'ro', false, 'Română', 'Romanian', false],
        ['ru-RU', -1, -1, 1, 1, 'system', false, 'ru', 'ru', false, 'Русский', 'Russian', false],
        ['sk-SK', -1, -1, 1, 1, 'system', false, 'sk', 'sk', false, 'Slovenčina', 'Slovak', false],
        ['sl-SI', -1, -1, 1, 1, 'system', false, 'sl', 'si', false, 'Slovenščina', 'Slovenian', false],
        ['sq-AL', -1, -1, 1, 1, 'system', false, 'sq', 'al', false, 'Shqip', 'Albanian', false],
        ['sr-RS', -1, -1, 1, 1, 'system', false, 'sr', 'rs', false, 'Српски', 'Serbian', false],
        ['sv-SE', -1, -1, 1, 1, 'system', false, 'sv', 'se', false, 'Svenska', 'Swedish', false],
        ['sw-KE', -1, -1, 1, 1, 'system', false, 'sw', 'ke', false, 'Kiswahili', 'Swahili', false],
        ['ta-IN', -1, -1, 1, 1, 'system', false, 'ta', 'in', false, 'தமிழ்', 'Tamil', false],
        ['te-IN', -1, -1, 1, 1, 'system', false, 'te', 'in', false, 'తెలుగు', 'Telugu', false],
        ['th-TH', -1, -1, 1, 1, 'system', false, 'th', 'th', false, 'ภาษาไทย', 'Thai', false],
        ['tl-PH', -1, -1, 1, 1, 'system', false, 'tl', 'ph', false, 'Filipino', 'Filipino', false],
        ['tr-TR', -1, -1, 1, 1, 'system', false, 'tr', 'tr', false, 'Türkçe', 'Turkish', false],
        ['uk-UA', -1, -1, 1, 1, 'system', false, 'uk', 'ua', false, 'Українська', 'Ukrainian', false],
        ['vi-VN', -1, -1, 1, 1, 'system', false, 'vi', 'vn', false, 'Tiếng Việt', 'Vietnamese', false],
        ['xx-XX', -1, -1, 1, 1, 'system', false, 'xx', 'xx', false, 'Fejlesztő', 'Developer', false],
        ['zh-CN', -1, -1, 1, 1, 'system', false, 'zh', 'cn', false, '中文(简体)', 'Simplified Chinese (China)', false],
        ['zh-HK', -1, -1, 1, 1, 'system', false, 'zh', 'hk', false, '中文(香港)', 'Traditional Chinese (Hong Kong)', false],
        ['zh-TW', -1, -1, 1, 1, 'system', false, 'zh', 'tw', false, '中文(台灣)', 'Traditional Chinese (Taiwan)', false],
    ];

    /**
     * @return array
     */
    public static function getLanguages(): array
    {
        return self::$languages;
    }
}
