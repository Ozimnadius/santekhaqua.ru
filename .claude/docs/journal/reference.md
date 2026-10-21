# Б24 #79227 — Доработка santekhaqua.ru — справочник и материалы заказчика

## Материалы заказчика

- Задача Б24 #79227 (постановщик — Михаил Шахов, срок — 23.10.2026 18:00):
  - телефоны в шапку и подвал: +7 495 970-72-26, +7 985 970-72-26, +7 916 086-34-84;
  - значки мессенджеров (Max, Telegram, WhatsApp) в шапку и подвал — для номера +7 916 086-34-84; Max по телефону не находится, нужна ссылка — Михаил Шахов запрашивает (21.10.2026);
  - новый адрес в контактах и в шапке: ряд В, 22/3, ТОГК Славянский Мир, район Коммунарка, Новомосковский административный округ, Москва; координаты 55.611880, 37.487991;
  - почта info@santekhaqua.ru с переадресацией на mr.bilyan@inbox.ru;
  - info@santekhaqua.ru — в шапке, подвале и контактах.
- ссылка на Max — https://max.ru/u/f9LHodD0cOKBifIRgVlztpbKgwMc9yD6vjjbbj3XIoQDrxrBGc79FmU-7yc (Михаил Шахов, чат задачи, 21.10.2026 12:21); там же — старый телефон убрать: «Да»

## Справочник

- Прод: https://santekhaqua.ru, nginx/1.20.2, **PHP 8.2.28**. Синтаксис: `C:\OSPanel\modules\PHP-8.2\php.exe -l`.
- Дев: дева нет.
- Корень сайта на сервере — `/var/www/user1867/data/www/santekhaqua.ru` (ISPmanager, хост 4.web-comp.ru, IP 217.174.108.22), PHP CLI — `/opt/php82/bin/php`. Ядро 25.100.500, Аспро «Максимум» 2.7.1, шаблон `aspro_max`; `local/` и `bitrix/php_interface/init.php` нет.
- Почта: MX — `mail.santekhaqua.ru`; ящик `info` уже создан на хостинге (`~/email/santekhaqua.ru/info`, 19.10.2026).
- Включаемые области контактов: `include/contacts-site-phone.php`, `contacts-site-address.php`, `contacts-site-email.php`, `contacts-site-map.php`; шапка и подвал — `include/header_include`, `include/footer`.
- Настройки Аспро s1 (на 2026-10-21): HEADER_TYPE=1, FOOTER_TYPE=1, HEADER_MOBILE=1, PAGE_CONTACTS=1, USE_REGIONALITY=N; телефоны шапки и подвала — HEADER_PHONES (CMax::ShowHeaderPhones; в шапке 1 видим первый, остальные — по наведению)
- Почта и адрес в подвале: CMax::showEmail → include/footer/site-email.php, CMax::showAddress → include/top_page/site-address.php; страница контактов — include/contacts-site-*.php (там ещё +7 919 775-88-52 и info@santehaqua.ru), карта — include/contacts-site-map.php (метка 55.744, 37.603)
- Соцсети подвала: include/footer/social.info.php → компонент aspro:social.info.max (поля SOCIAL_* настроек Аспро)
- Настройки Аспро в БД — не в b_option по имени (там только служебные строки модуля); читать через \CMax::GetFrontParametrsValues('s1')
- Микроразметку Organization в подвале выводит модуль: CAsproMax::shemaOrganization (bitrix/modules/aspro.max/lib/functions/CAsproMax.php) — strip_tags из include/contacts-site-phone-one.php, contacts-site-address.php, contacts-site-email.php
- Страница контактов (PAGE_CONTACTS=1, contacts/page_contacts_1.php): телефоны — include/contacts-site-phone-one.php (без регионов), адрес — contacts-site-address.php, почта — contacts-site-email.php
- 2026-10-21: кеш компонента bitrix:news.list на проде сброшен (clearComponentCache); пользователь сбросил весь кеш Битрикса
- Сайт работает через php-cgi (ISPmanager, ~/php-bin-isp-php82/santekhaqua.ru/php), opcache.revalidate_freq = 0
- Соцсети Аспро: настройки сайта s1 в b_option_site (aspro.max, SOCIAL_*); WhatsApp — номер без «+», ссылку https://wa.me/… строит шаблон; Telegram — полная ссылка
- Компонент aspro:social.info.max (шаблон .default) выводится в подвале (include/footer/social.info.php), на странице контактов, в мобильном меню (header_mobile_menu_1) и мега-меню; своя копия шаблона — bitrix/templates/aspro_max/components/aspro/social.info.max/.default
- local/php_interface/init.php — первый свой init.php на сайте (до этого init.php не было ни в local, ни в bitrix/php_interface)
- Значки полей «Социальных сетей» в админке Аспро — bitrix/css/aspro.max/style.css: всем полям по умолчанию значок VK (social.svg 0 0), свой — по div[data-optioncode="…"]; для своих полей стиль добавляет local/php_interface/init.php
- Шапка header_1: строка .header-topbar — первый блок .header-wrapper (до .logo_and_menu-row, который display:flex); стили — bitrix/templates/aspro_max/css/custom.css (Аспро собирает его в /bitrix/cache/css/s1/aspro_max/template_*.css)
- Главная с большим баннером (body BIG_BANNER_INDEX, .long_banner .header_wrap:not(.light-menu-color)) — шапка поверх светлого баннера, Аспро красит тексты в #333; для своих блоков нужен тот же селектор
- Референс шапки от пользователя (santeh-kd2.ru): телефоны строкой сверху, логотип, слоган, график работы, почта и адрес столбиком, значки мессенджеров, «Заказать звонок» — на потом, после оплаты клиентом
- Панель ISPmanager сервера — https://hosting.web-komp.ru:1500/ispmgr (сертификат *.web-komp.ru; через 4.web-comp.ru:1500 браузер не пускает — имя не совпадает); сервер один: IP 217.174.105.80, 217.174.108.22 (сайт), 217.174.108.23
- Почта info@santekhaqua.ru: maildir ~/email/santekhaqua.ru/info/.maildir, Exim 4.97 + Dovecot; пересылку копий делает Exim по настройке панели (в .dovecot.sieve правил нет)
- В поле «Примечание» ящика info@ в ISPmanager открытым текстом записана строка, похожая на пароль — лучше убрать (решает пользователь)
- Отчёт заказчику: 2026-10-21 (период с 2026-10-21)
