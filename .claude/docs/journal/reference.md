# Б24 #79227 — Доработка santekhaqua.ru — справочник и материалы заказчика

## Материалы заказчика

- Задача Б24 #79227 (постановщик — Михаил Шахов, срок — 23.10.2026 18:00):
  - телефоны в шапку и подвал: +7 495 970-72-26, +7 985 970-72-26, +7 916 086-34-84;
  - значки мессенджеров (Max, Telegram, WhatsApp) в шапку и подвал — для номера +7 916 086-34-84; Max по телефону не находится, нужна ссылка — Михаил Шахов запрашивает (21.10.2026);
  - новый адрес в контактах и в шапке: ряд В, 22/3, ТОГК Славянский Мир, район Коммунарка, Новомосковский административный округ, Москва; координаты 55.611880, 37.487991;
  - почта info@santekhaqua.ru с переадресацией на mr.bilyan@inbox.ru;
  - info@santekhaqua.ru — в шапке, подвале и контактах.

## Справочник

- Прод: https://santekhaqua.ru, nginx/1.20.2, **PHP 8.2.28**. Синтаксис: `C:\OSPanel\modules\PHP-8.2\php.exe -l`.
- Дев: дева нет.
- Корень сайта на сервере — `/var/www/user1867/data/www/santekhaqua.ru` (ISPmanager, хост 4.web-comp.ru, IP 217.174.108.22), PHP CLI — `/opt/php82/bin/php`. Ядро 25.100.500, Аспро «Максимум» 2.7.1, шаблон `aspro_max`; `local/` и `bitrix/php_interface/init.php` нет.
- Почта: MX — `mail.santekhaqua.ru`; ящик `info` уже создан на хостинге (`~/email/santekhaqua.ru/info`, 19.10.2026).
- Включаемые области контактов: `include/contacts-site-phone.php`, `contacts-site-address.php`, `contacts-site-email.php`, `contacts-site-map.php`; шапка и подвал — `include/header_include`, `include/footer`.
