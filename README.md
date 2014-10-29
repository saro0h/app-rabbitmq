Playground with RabbitMQ
========================

You need to install RabbitMQ: http://www.rabbitmq.com/download.html.

To install the project:

- Install composer: https://getcomposer.org/download/
- run the command: ``composer.phar install``


### What does this appllication ?

Basically, this application sends email, through a queue, and a consumer takes the message to actually send it with SwiftMailer.
Based on the article of Clément Delmas: http://afsy.fr/avent/2013/21-rabbitmq-et-Symfony2-traitements-asynchrones (in french)

Feel free to play with it! 
