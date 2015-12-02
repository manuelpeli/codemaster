demo
====

A Symfony project created on November 28, 2015, 7:56 pm.

5-12-2015:
This demo is an example of symfony with doctrine application:

* Twig templates with forms.

* OneToMany and ManyToOne doctrine relations.

* Create, read, update queries.

Bootstrap instructions:

1. Download vendors with "php composer.phar install".

2. Specify your database parameters in parameters.yml (with a not existent database name).

3. Create database from command line using "php app/console doctrine:database:create" (or php bin/console or app/console or bin/console, depending on your symfony installation).

4. Launch database schema update using "php app/console doctrine:schema:update --force".