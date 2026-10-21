# Журнал работ — Б24 #79227 — Доработка santekhaqua.ru

> Ведёт `/kit:step-done` (скрипт `kit-journal.js`) после каждого проверенного шага. После сжатия контекста и в новой сессии читать первым. Правила проекта — `.claude/CLAUDE.md`.

## Сейчас

- **Этап:** 1 — Доработка santekhaqua.ru (Б24 79227) (начат 2026-10-21); последний шаг 1.6 — Переадресация почты: ящику info@santekhaqua.ru в ISPmanager задано «Слать копии писем на e-mail» = mr.bilyan@inbox.ru (письма уходят на inbox.ru и остаются в info@ на сервере)
- **Следующий шаг:** 1.7 — итоговая проверка по задаче и отчёт в Б24 79227
- **Блокеры и открытые вопросы:** Подтвердить у заказчика, что тестовое письмо «Проверка пересылки santekhaqua.ru» (21.10.2026) пришло на mr.bilyan@inbox.ru (проверить и «Спам»)

## Этапы

Части журнала: решения — `journal/decisions.md`, баги — `journal/bugs.md`, справочник и материалы заказчика — `journal/reference.md`, закрытые этапы — `journal/stages/`.

| Этап | Название | Файл |
|---|---|---|
| 0 | инициализация проекта | `journal/stages/stage-00.md` |
| 1 | Доработка santekhaqua.ru (Б24 79227) | ниже |

## Документы

| Файл | О чём | Статус |
|---|---|---|

## Прод: не забыть

- Включить обратно автокеширование Битрикса — пользователь выключил его 21.10.2026 на время проверки

## Этап 1 — Доработка santekhaqua.ru (Б24 79227)

| Шаг | Статус | Что сделано | Как проверено |
|---|---|---|---|
| 1.1 | ✅ | Изучена задача и устройство сайта: откуда шапка, подвал и контакты берут телефоны, почту, адрес и соцсети; выбран подход к правкам | Чтение на сервере (remote-php.js): настройки Аспро s1 — HEADER_TYPE=1, FOOTER_TYPE=1, USE_REGIONALITY=N, HEADER_PHONES=3 (495, 985, 916), SOCIAL_TELEGRAM=t.me/GarnikApresyn, SOCIAL_WHATS пусто; код CMax::showEmail/showAddress; 29 типов шапки — ни один не выводит сразу адрес, почту и соцсети; https://santekhaqua.ru/ — tel:+79197758852 больше нет, почта info@santehaqua.ru, адрес Калужское ш. |
| 1.2 | ✅ | Контакты во включаемых областях: три телефона (страница контактов), новый адрес (контакты и подвал), info@santekhaqua.ru вместо info@santehaqua.ru (контакты и подвал), карта контактов — метка «Сантехаква» на 55.611880, 37.487991, масштаб 16; скрытый разделитель «, » между номерами для микроразметки Organization | php -l contacts-site-map.php — ок, MAP_DATA unserialize — ок; md5 на сервере до заливки = первый коммит (кроме своей строки карты); ssh-deploy --go — залито и сверено 8 из 8 (7 контактов + исходный front_review/template.php после отката); curl / и /contacts/ — tel только 495, 985, 916, mailto:info@santekhaqua.ru, адрес «Славянский Мир», Калужского ш. нет, координаты 55.61188; микроразметка Organization в подвале — telephone «+7 (495) 970-72-26, +7 (985) 970-72-26, +7 (916) 086-34-84», email и streetAddress новые; браузер /contacts/ — 1366, 800 и 375 px: адрес, 3 телефона столбиком, почта, карта с меткой у МКАД/Коммунарки; подвал — новые почта и адрес |
| 1.3 | ✅ | Мессенджеры для +7 916 086-34-84: Telegram https://t.me/+79160863484, WhatsApp 79160863484 (настройки Аспро), Max — своё поле SOCIAL_MAX в «Социальных сетях» настроек Аспро (local/php_interface/init.php, событие OnAsproParameters) и своя копия шаблона aspro:social.info.max/.default с пунктом Max и значками (белый, серый, цветной — силуэт из логотипа max.ru) | php -l init.php и файлов шаблона — ок; вставка поля на тестовом массиве — SOCIAL_MAX после SOCIAL_TELEGRAM, без дублей; ssh-deploy --go — залито и сверено 9 из 9; скрипт настроек (remote-php.js) — SOCIAL_TELEGRAM GarnikApresyn → t.me/+79160863484, SOCIAL_WHATS пусто → 79160863484, SOCIAL_MAX → ссылка max.ru, кеш aspro:social.info.max сброшен; на сервере \CMax::$arParametrsList — SOCIAL_MAX после SOCIAL_TELEGRAM, GetFrontParametrsValues отдаёт ссылку; curl / и /contacts/ — ссылки t.me, wa.me, max.ru (3 и 4 раза), li.max есть, max-color.svg — 200 image/svg+xml; браузер /contacts/ — плитки Telegram, Max, WhatsApp; стили li.max: подвал — max-white.svg 43px, страница и мобильное меню — max-color.svg |
| 1.4 | ✅ | Админка Аспро: у поля «Max» в «Социальных сетях» вместо значка VK по умолчанию — серый силуэт Max (local/php_interface/init.php, обработчик OnBeforeProlog — стиль только на страницах /bitrix/admin/aspro.max_*) | php -l init.php — ок; ssh-deploy --go — залито и сверено 1 из 1; https://santekhaqua.ru/ — 200; /bitrix/admin/aspro.max_options.php — в head есть правило div[data-optioncode="SOCIAL_MAX"] … max-gray.svg; /bitrix/admin/index.php — правила нет |
| 1.5 | ✅ | Шапка header_1: над ней строка с адресом (полный, include/top_page/site-address.php), почтой (include/footer/site-email.php) и значками Telegram, Max, WhatsApp (настройки Аспро); телефон со списком трёх номеров и «Заказать звонок» — как было; мобильная шапка без изменений | php -l header_1.php — ок; пробная вставка на живой странице (только в браузере Claude) — 1440: строка 40px над шапкой, адрес и почта слева, значки справа, ниже шапка как была; главная — тёмный текст #333 поверх светлого баннера; 1024 — адрес обрезается многоточием, строка одна; ssh-deploy --go — залито и сверено 2 из 2 (заменил прошлый вариант «почта и адрес рядом с телефоном»); curl / и /contacts/ — header-topbar есть, старого блока нет, 3 значка, 200; собранный CSS шаблона содержит правила .header-topbar__inner; браузер /contacts/ — строка над шапкой на живом сайте |
| 1.6 | ✅ | Переадресация почты: ящику info@santekhaqua.ru в ISPmanager задано «Слать копии писем на e-mail» = mr.bilyan@inbox.ru (письма уходят на inbox.ru и остаются в info@ на сервере) | ISPmanager (https://hosting.web-komp.ru:1500, вход — пользователь, user1867) — форма ящика сохранена, в списке у info@ значок «Слать копии писем на e-mail: mr.bilyan@inbox.ru»; тестовое письмо sendmail с сервера на info@ — sendmail=0, письмо в ~/email/santekhaqua.ru/info/.maildir/new; DNS — SPF ip4:217.174.105.80 ip4:217.174.108.22, DKIM есть, DMARC p=none; приход копии на mr.bilyan@inbox.ru с нашей стороны не виден — подтверждает владелец ящика |
| 1.7 | ⏳ | итоговая проверка по задаче и отчёт в Б24 79227 | |
