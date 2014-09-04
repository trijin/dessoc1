DespeRados Sociometry v1
=========

Особенности:

  - Заранее заданные вопросы.
  - Индивидуальный вопрос




Опрос состоит из 4х этапов:


  - Этап 1: Регистрация и добавление персонального вопроса
  - Этап 2: Технический - рассылка уникальных ссылок.
  - Этап 3: Опрос
  - Этап 4: Технический - рассылка результатов.

Version
----

1.0

Tech
-----------

Используется composer :

```json
{
    "require": {
        "slim/slim": "2.*",
		"trijin/notorm": "dev-master",
		"twig/twig": "1.*",
		"slim/views": "0.1.*",
		"monolog/monolog": "~1.6",
		"phpmailer/phpmailer": "dev-master"
    }
}
```

* [Slim Framework] - Framework
* [Twig] - Framework
* [NotORM] - [Docs] - My extends of cool DB lib
* [Bootplus] - Based on Bootstrap
* [jQuery] - duh 

Installation
--------------
Для инсталяции необходимо поправить конфиг, пароли, аккаунты и т.п.
А так же выставить права записи на папки `img` и `cache`.
В папку выше уровнем необходимо установить библиотеки используя composer.

License
----

Используйте. Изменяйте. Не продавайте.


**Free Software, Hell Yeah!**

[Slim Framework]:slimframework.com
[Twig]:http://twig.sensiolabs.org/
[notorm]:https://github.com/trijin/notorm/
[Docs]:http://www.notorm.com
[Bootplus]:http://aozora.github.io/bootplus/index.html
[jQuery]:http://jquery.com
