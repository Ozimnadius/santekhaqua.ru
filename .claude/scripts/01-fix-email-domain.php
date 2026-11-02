<?php
// Замена домена-опечатки santehaqua.ru на santekhaqua.ru в адресах писем и адресе сайта (шаг 2.1).
// $dryRun = true — только показать; запись — при строгом false.
$dryRun = true;

$changes = [
    ['main', 'email_from', 'info@santehaqua.ru', 'info@santekhaqua.ru'],
    ['sale', 'order_email', 'info@santehaqua.ru', 'info@santekhaqua.ru'],
    ['main', 'server_name', 'santehaqua.ru', 'santekhaqua.ru'],
];

foreach ($changes as [$module, $name, $old, $new]) {
    $cur = \Bitrix\Main\Config\Option::get($module, $name, '');
    echo $module, ' ', $name, ': "', $cur, '"';
    if ($cur !== $old) {
        echo ' — не совпадает с ожидаемым "', $old, '", пропуск', "\n";
        continue;
    }
    if ($dryRun === false) {
        \Bitrix\Main\Config\Option::set($module, $name, $new);
        echo ' → "', \Bitrix\Main\Config\Option::get($module, $name, ''), '"', "\n";
    } else {
        echo ' → будет "', $new, '"', "\n";
    }
}
echo $dryRun === false ? "Записано\n" : "Пробный запуск, ничего не записано\n";
