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

/**
 * Телефоны для шапки (Б24 79227): регион, если регионализация включена и регион определён, иначе HEADER_PHONES Аспро.
 * Используют page_blocks/header/header_1.php и header_mobile_1.php.
 *
 * @return array<int, array{PHONE: string, HREF: string}>
 */
function santekhaquaHeaderPhones(): array
{
    global $arRegion;
    if (!class_exists('CMax')) {
        return [];
    }

    $phones = [];
    if (\CMax::GetFrontParametrValue('USE_REGIONALITY', SITE_ID, true) === 'Y' && !empty($arRegion['PHONES'])) {
        foreach ($arRegion['PHONES'] as $phone) {
            $phones[] = ['PHONE' => (string)$phone['PHONE'], 'HREF' => (string)$phone['HREF']];
        }
    } else {
        $params = \CMax::GetBackParametrsValues(SITE_ID);
        for ($i = 0, $cnt = (int)$params['HEADER_PHONES']; $i < $cnt; ++$i) {
            $phones[] = [
                'PHONE' => (string)$params['HEADER_PHONES_array_PHONE_VALUE_' . $i],
                'HREF' => (string)$params['HEADER_PHONES_array_PHONE_HREF_' . $i],
            ];
        }
    }

    foreach ($phones as &$phone) {
        if ($phone['HREF'] === '') {
            $phone['HREF'] = 'javascript:;';
        }
    }
    unset($phone);

    return array_values(array_filter($phones, fn($phone) => trim($phone['PHONE']) !== ''));
}

/**
 * Мессенджеры для шапки из настроек Аспро «Социальные сети»: Telegram, Max (своё поле SOCIAL_MAX), WhatsApp.
 * Пустое поле — мессенджера нет.
 *
 * @return array<string, array{HREF: string, TITLE: string}> ключи telegram, max, whats — в этом порядке
 */
function santekhaquaHeaderMessengers(): array
{
    if (!class_exists('CMax')) {
        return [];
    }

    $get = fn(string $code): string => trim((string)\CMax::GetFrontParametrValue($code));
    $messengers = [];
    if ($telegram = $get('SOCIAL_TELEGRAM')) {
        $messengers['telegram'] = ['HREF' => $telegram, 'TITLE' => 'Telegram'];
    }
    if ($max = $get('SOCIAL_MAX')) {
        $messengers['max'] = ['HREF' => $max, 'TITLE' => 'Max'];
    }
    $whatsCustom = $get('SOCIAL_WHATS_CUSTOM');
    $whats = $get('SOCIAL_WHATS');
    if ($whatsCustom !== '' || $whats !== '') {
        $messengers['whats'] = ['HREF' => $whatsCustom ?: 'https://wa.me/' . $whats, 'TITLE' => 'WhatsApp'];
    }

    return $messengers;
}
