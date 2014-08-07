<?php

use lib\util\module;

return module\Module::createInstance()
                ->setName('Events')
                ->setDescription('')
                ->addAuthor(module\Author::createInstance()
                        ->setName('Natanael Simões')
                        ->setEmail('natanael.simoes@ifro.edu.br'))
                ->setVersion('1.0')
                ->setCreationDate('2014-07-27')
                ->setLastReleaseDate('2014-07-27')
                ->setTile(module\Tile::createInstance()
                        ->setColor('yellow')
                        ->setIcon('fa-paperclip'))
                ->setHome(module\Home::createInstance()
                        ->setControl('EventController')
                        ->setAction('Manage'))
                ->addController(module\Controller::createInstance()
                        ->setName('EventController'));
