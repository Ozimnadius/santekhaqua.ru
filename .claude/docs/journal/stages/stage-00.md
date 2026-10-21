# Б24 #79227 — Доработка santekhaqua.ru — этап 0

## Этап 0 — инициализация проекта

| Шаг | Статус | Что сделано | Как проверено |
|---|---|---|---|
| 0.1 | ✅ | git: `.gitignore`, `core.autocrlf=input`, `core.quotepath=false`, исходники с прода | `secret-scan` — чисто, `git status` — чисто после коммита |
| 0.2 | ✅ | Правила проекта `.claude/CLAUDE.md` (режим bitrix, прод https://santekhaqua.ru, выкладка Claude по SSH, документы на сервере, рабочая папка `bitrix/templates/aspro_max`, удалённый репозиторий origin), журнал и план выкладки в `.claude/docs/`, `.claude/.htaccess`, исключения PhpStorm, скиллы Битрикса (46) | phpstorm-exclude --check — 0 (ftp); secret-scan --all — чисто (4258 файлов); git check-ignore — aspro_max в git, bitrix/.settings.php и .claude/skills игнорируются; ssh-deploy сухой прогон — «Нечего заливать» (проект = сервер); ssh-deploy --go --docs --all — залито и сверено 7 из 7; check-closed https://santekhaqua.ru — 8 из 8 закрыто (403), открытых нет; git ls-remote origin — репозиторий пуст |

Сверка 2026-10-21 (сверено с: таблица этапа): пунктов 2, сделано 2; расхождения: нет.
