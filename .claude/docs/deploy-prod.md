# Выкладка на прод — santekhaqua.ru

## Общие правила

- Заливает Claude по SSH: `/kit:step-done` после просмотра пользователем — скриптом `ssh-deploy.js` (всё, что изменилось с последней заливки по таблице ниже, и удаления), затем проверка на сервере и коммит; строка в таблицу ниже — на каждом шаге.
- Не выкладываются: `.idea`, `.git`, `.claude`, `.gitignore`.
- Из `.claude/` на сервер уезжают только документы — `.claude/docs` (без снимков `visual`), `CLAUDE.md` и `.htaccess` (первым): их заливает `/kit:step-done` перед коммитом шага (`ssh-deploy.js --docs`, «Документы на сервере: да»); остальное в ней не уезжает; снаружи папку закрывает `.htaccess` (`Require all denied`); проверка снаружи — `check-closed` (2026-10-21: документы `.claude` — 403, открытых нет). nginx может отдавать статику (pdf, docx, картинки, txt…) мимо `.htaccess` — поэтому главное — не выкладывать (при «Документы на сервере: да» — не класть в `.claude/docs` то, что нельзя показать).
- До записи в проект — `php -l` (PHP 8.2).
- Удалённые в git файлы удаляет `ssh-deploy.js`; прочее (старые копии) — раздел «Удалить с сервера».

## Залито на прод

| Шаг | Дата | Файлы | Коммит | Проверка |
|---|---|---|---|---|
| 1.2 | 2026-10-21 | залито 8: bitrix/templates/aspro_max/components/bitrix/news.list/front_review/template.php (откат к исходному), include/contacts-site-address.php, include/contacts-site-email.php, include/contacts-site-map.php, include/contacts-site-phone-one.php, include/contacts-site-phone.php, include/footer/site-email.php, include/top_page/site-address.php (ssh-deploy.js, md5 сверен) | | curl главной и /contacts/, микроразметка Organization, браузер 1366/800/375 px |
| 1.3 | 2026-10-21 | залито 9: bitrix/templates/aspro_max/components/aspro/social.info.max/.default/images/max-color.svg, …/images/max-gray.svg, …/images/max-white.svg, …/lang/en/template.php, …/lang/ru/template.php, …/result_modifier.php, …/style.css, …/template.php, local/php_interface/init.php (ssh-deploy.js, md5 сверен) | | curl главной и /contacts/ (ссылки t.me, wa.me, max.ru), браузер /contacts/, поле SOCIAL_MAX в \CMax::$arParametrsList на сервере |
| 1.4 | 2026-10-21 | залито 1: local/php_interface/init.php (ssh-deploy.js, md5 сверен) | | стиль SOCIAL_MAX в head страницы /bitrix/admin/aspro.max_options.php, на /bitrix/admin/index.php его нет; сайт 200 |
| 1.5 | 2026-10-21 | залито 2: bitrix/templates/aspro_max/css/custom.css, bitrix/templates/aspro_max/page_blocks/header/header_1.php (ssh-deploy.js, md5 сверен; заменили прошлую заливку того же шага) | | curl главной и /contacts/, собранный CSS шаблона, браузер /contacts/ на 1440 |
| 1.9 | 2026-10-21 | залито 3: include/licenses_detail.php, include/offer_detail.php, robots.txt (ssh-deploy.js, md5 сверен) | | curl оферты, политики и robots.txt — старых домена и адреса нет, Host новый |
| 1.10 | 2026-10-21 | залито 2: catalog/index_help_text.php, help/delivery/index.php (ssh-deploy.js, md5 сверен); службы доставки — скриптом remote-php.js | | /help/delivery/, подсказка в карточке, калькулятор доставки в карточке (Москва) |
| 1.12 | 2026-10-21 | залито 4: bitrix/templates/aspro_max/css/custom.css, bitrix/templates/aspro_max/page_blocks/header/header_1.php, local/php_interface/init.php, include/top_page/header-address.php (ssh-deploy.js, md5 сверен) | | curl главной, /contacts/, карточки; браузер главная 1440/1280/1024, /contacts/ тёмная 1440, форма «Заказать звонок» |
| 1.13 | 2026-10-21 | залито 2: bitrix/templates/aspro_max/css/custom.css, bitrix/templates/aspro_max/page_blocks/header/header_1.php (ssh-deploy.js, md5 сверен; повторная заливка custom.css после проверки) | | главная 1440/1024 (значки, кнопка, наведение), /contacts/ тёмная тема |
| 1.14 | 2026-10-21 | залито 2: bitrix/templates/aspro_max/css/custom.css, bitrix/templates/aspro_max/page_blocks/header_mobile_1.php (ssh-deploy.js, md5 сверен; повторная заливка custom.css после проверки) | | главная и /contacts/ 375 светлая и тёмная, 768; бургер-меню (избранное, сравнение) |
| 1.15 | 2026-10-21 | залито 1: bitrix/templates/aspro_max/css/custom.css (ssh-deploy.js, md5 сверен) | | главная 1160/992/1440 — края строки шапки совпадают с полосой меню |

## Удалить с сервера

Удалять через Remote Host в PhpStorm или через `/kit:server` (SSH, иначе файл-канал `kit-exec.php`; шаблон `delete-list.php`: с согласия пользователя, строгий список, сначала сухой прогон).

| Путь | Почему | Удалён |
|---|---|---|

## Чек-лист переключения

1. (заполняется по ходу работы)
