## Тестовое задание на вакансию Full-stack разработчик

Разработать админ-панель (далее админка) с использованием фреймворка Laravel. Админка должна быть написана без использования готовых решений наподобие Laravel Nova или October CMS. Дизайн самый простой на ваше усмотрение. Для верстки рекомендуется использовать Bootstrap, jQuery и Vue.js. Плюсом будет соблюдение принципов SOLID, DRY и KISS. Время на выполнение 5 рабочих дней.

### В админке должны быть следующие функции:
- Редактируемые списки поселков и домов;
- В каждом списке должна быть возможность добавить, удалить объект;
- У каждого элемента списка должны быть режимы просмотра и редактирования. В режиме просмотра все элементы редактирования скрыты и допускается другой дизайн;
- Для сущности поселка должны быть разработаны функции сохранения следующих данных: Название, Адрес, Площадь посёлка (гектар), Горячая линия (телефон), YouTube видео, Фотография, Файл презентации (pdf);
- Для сущности дома должны быть разработаны функции сохранения следующих данных: Название, Цена в RUB, Цена в USD, Валюта по-умолчанию,  Этажность, Спальни, Площадь, Тип объекта (Дом, Коттедж, Таунхаус, Квартира), Галерея изображений, поселок (выбор среди существующих в списке поселков);
- В зависимости от выбранной валюты по-умолчанию, раз в сутки должно запускаться cron задание для автоматического обновления курса валют и цен;
- У списка домов должны быть функции фильтрации и сортировки (по возрастанию и по убыванию) по следующим полям: цена (в зависимости от выбранной валюты в фильтре), Этажность, Спальни, Площадь, Тип объекта, Поселок;
- В каждом списке должна быть реализована возможность поиска по названию;
- Загружаемые файлы не должны храниться в общей папке, а делиться на подпапки в зависимости от типа сущности и id объекта;
- Должны быть 2 пользователя admin и manager. Пользователь admin может все редактировать, а у manager должны быть скрыты элементы редактирования и режим редактирования. Если посетитель сайта не авторизован, то должна отображаться форма авторизации;

### Демо: https://realestate.eurodir.ru


### Запуск проекта
1) Имплементировать серверную конфигурацию от `.env.example`
2) Развернуть базу и тестовые объекты: `php artisan migrate --seed`
3) Обновление курсов валют и списка цен выполняется по крону: `0 0 * * * path/to/php path/to/artisan schedule:run`
