<?php

use lib\util\module;

return module\Module::createInstance()
                ->setName('Activity')
                ->setDescription('')
                ->addAuthor(module\Author::createInstance()
                        ->setName('Natanael Simões')
                        ->setEmail('natanael.simoes@ifro.edu.br'))
                ->setVersion('1.0')
                ->setCreationDate('2014-08-05')
                ->setLastReleaseDate('2014-08-05')
                ->setTile(module\Tile::createInstance()
                        ->setColor('yellow')
                        ->setIcon('fa-paperclip'))
                ->setHome(module\Home::createInstance()
                        ->setControl('ActivityController')
                        ->setAction('Manage'))
                ->addController(module\Controller::createInstance()
                        ->setName('ActivityController'))
                ->addController(module\Controller::createInstance()
                        ->setName('TypeController')
                        ->setSubmodule('type'))
                ->addAccess('NONE');
