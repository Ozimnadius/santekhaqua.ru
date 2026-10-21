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

// Админка Аспро: значок у поля «Max». Стили модуля (bitrix/css/aspro.max/style.css) ставят всем полям «Социальных сетей»
// значок VK по умолчанию и меняют его по data-optioncode — для SOCIAL_MAX правила нет. Подключаем своё только на страницах Аспро.
AddEventHandler('main', 'OnBeforeProlog', function () {
    if (!defined('ADMIN_SECTION') || ADMIN_SECTION !== true) {
        return;
    }
    $page = (string)\Bitrix\Main\Context::getCurrent()->getRequest()->getRequestedPage();
    if (strpos($page, '/bitrix/admin/aspro.max_') !== 0) {
        return;
    }

    $icon = '/bitrix/templates/aspro_max/components/aspro/social.info.max/.default/images/max-gray.svg';
    \Bitrix\Main\Page\Asset::getInstance()->addString(
        '<style>.groups_block.SOCIAL .block_wrapper .item div[data-optioncode="SOCIAL_MAX"] .value_wrapper:after'
        . '{background:url("' . $icon . '") 50% 50%/36px 36px no-repeat;}</style>'
    );
});
