# Б24 #79227 — Доработка santekhaqua.ru — справочник и материалы заказчика

## Материалы заказчика

- Задача Б24 #79227 (постановщик — Михаил Шахов, срок — 23.10.2026 18:00):
  - телефоны в шапку и подвал: +7 495 970-72-26, +7 985 970-72-26, +7 916 086-34-84;
  - значки мессенджеров (Max, Telegram, WhatsApp) в шапку и подвал — для номера +7 916 086-34-84; Max по телефону не находится, нужна ссылка — Михаил Шахов запрашивает (21.10.2026);
  - новый адрес в контактах и в шапке: ряд В, 22/3, ТОГК Славянский Мир, район Коммунарка, Новомосковский административный округ, Москва; координаты 55.611880, 37.487991;
  - почта info@santekhaqua.ru с переадресацией на mr.bilyan@inbox.ru;
  - info@santekhaqua.ru — в шапке, подвале и контактах.
- ссылка на Max — https://max.ru/u/f9LHodD0cOKBifIRgVlztpbKgwMc9yD6vjjbbj3XIoQDrxrBGc79FmU-7yc (Михаил Шахов, чат задачи, 21.10.2026 12:21); там же — старый телефон убрать: «Да»
- шапка — вариант 3 «компактная · светлая тема» из Figma (скриншот в чате задачи 21.10.2026 16:26; Михаил Шахов: «этот вариант делаем, он оплатил»)
- доставку проставить в корзине и вообще везде на сайте — по Москве 750 руб., до 10 км от МКАД 1 100 руб., до 30 км от МКАД 1 800 руб., до 70 км от МКАД 3 500 руб. (чат задачи, 21.10.2026 16:27)
- оферту и политику обновить — «да» (21.10.2026 16:30)

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
- Отчёт заказчику: 2026-10-21 (период с 2026-10-21)
- Дизайн шапки: Figma https://www.figma.com/design/zVZrOHrtoS8c0UrxI9dy0a (команда «Михаил Серегин's team», черновики) — компоненты (логотип, значки, мессенджеры, меню), варианты 1–3 тёмные (x=0), светлые (x=1600), адаптив светлых (x=3200)
- Светлая тема сайта: фон #FFFFFF, телефон #222, текст #555, «Заказать звонок» и меню #365EDC; тёмная — фон #1B1B1B; шрифт Montserrat; контейнер — поля 30 px, на широких экранах контент 1348 px по центру; мобильная шапка ниже 992 px, высота 64 px
- Страницы юридических текстов: /include/offer_detail.php (оферта), /include/licenses_detail.php (политика конфиденциальности)
- Службы доставки (sale): [1] «Доставка по Москве (в пределах МКАД)» 750, [5] «до 10 км от МКАД» 1100, [6] «до 30 км» 1800, [7] «до 70 км» 3500 — Configurable, ограничения BySite s1 + ByLocation 0000028023 (Россия); [2] Самовывоз 0; [3] СПСР выключена; [4] Без доставки (служебная); оплата — только «Наличные курьеру» [1], без привязки к доставке
- Откат доставки: выключить [5] [6] [7], вернуть [1] имя «Доставка курьером» и цену 500
- Тексты о доставке: /help/delivery/ (help/delivery/index.php), подсказка в карточке — catalog/index_help_text.php (включаемая область раздела с суффиксом help_text, кешируется вместе с catalog.element); калькулятор в карточке — aspro:catalog.delivery.max (include/comp_catalog_delivery.php)
- Переменные темы Аспро (светлая / тёмная): --white_text_black #333 / white, --basic_text_black #555 / #ccc, --stroke_black #ececec / #3a3a3a, --black_bg_black #fff / #1b1b1b, --theme-base-color #365edc; тёмная включается по prefers-color-scheme
- Мобильная шапка Аспро (header_mobile_1.php): бургер, логотип, значки телефона (ShowHeaderMobilePhones), поиска, кабинета, корзины с сравнением/избранным (ShowBasketWithCompareLink)
- Шапка header_1 (вариант 3): .hdr-brand (логотип + слоган), .hdr-contacts (.hdr-phones, .hdr-sub), .hdr-actions (.header-messengers, .hdr-callback), затем .right-icons Аспро; стили — css/custom.css, точки 1299 и 1199
- Короткий адрес шапки — include/top_page/header-address.php (правится в админке); полный — include/top_page/site-address.php (подвал) и include/contacts-site-address.php (контакты)
- В Figma вариант 3 на 1024 (узел 6:755) — телефоны в ряд, как на сайте
- Цвет «Заказать звонок» в шапке меняется с переходом 0.3 с — при проверке скриптом цвет читать с паузой, иначе попадает промежуточное значение
- Отчёт заказчику: 2026-10-21 (период с 2026-10-21, после отчёта шага 1.7)
