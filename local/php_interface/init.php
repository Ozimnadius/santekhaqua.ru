<?php
// Свои обработчики сайта santekhaqua.ru. Ядро и модули Аспро не правим.

// Аспро «Максимум» 2.7.1: поля для Max нет — добавляем «Max» в раздел «Социальные сети» настроек решения,
// сразу после Telegram. Значение (ссылка на профиль Max) хранится как обычная настройка сайта SOCIAL_MAX,
// выводит его шаблон bitrix/templates/aspro_max/components/aspro/social.info.max/.default.
AddEventHandler('aspro.max', 'OnAsproParameters', function (&$arParametrsList) {
    if (!isset($arParametrsList['SOCIAL']['OPTIONS']) || isset($arParametrsList['SOCIAL']['OPTIONS']['SOCIAL_MAX'])) {
        return;
    }

    $max = [
        'SOCIAL_MAX' => [
            'TITLE' => 'Max',
            'TYPE' => 'text',
            'DEFAULT' => '',
            'THEME' => 'N',
        ],
    ];
    $options = $arParametrsList['SOCIAL']['OPTIONS'];
    $pos = array_search('SOCIAL_TELEGRAM', array_keys($options), true);

    $arParametrsList['SOCIAL']['OPTIONS'] = $pos === false
        ? $options + $max
        : array_slice($options, 0, $pos + 1, true) + $max + array_slice($options, $pos + 1, null, true);
});
