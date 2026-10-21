<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
// Max: в Аспро 2.7.1 своего поля нет — SOCIAL_MAX добавлено в раздел «Социальные сети» настроек Аспро (local/php_interface/init.php)
$arResult['SOCIAL_MAX'] = trim((string)\Bitrix\Main\Config\Option::get('aspro.max', 'SOCIAL_MAX', '', SITE_ID));
