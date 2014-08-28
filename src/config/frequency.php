<?php

use lib\util\module;

return module\Module::createInstance()
                ->setName('Frequency')
                ->setDescription('')
                ->addAuthor(module\Author::createInstance()
                        ->setName('Natanael Simões')
                        ->setEmail('natanael.simoes@ifro.edu.br'))
                ->setVersion('1.0')
                ->setCreationDate('2014-08-26')
                ->setLastReleaseDate('2014-08-26')
                ->setTile(module\Tile::createInstance()
                        ->setColor('wisteria')
                        ->setIcon('fa-clock-o'))
                ->setHome(module\Home::createInstance()
                        ->setControl('FrequencyController')
                        ->setAction('Manage'))
                ->addController(module\Controller::createInstance()
                        ->setName('FrequencyController'))
                ->addAccess('ADMINISTRATOR')
                ->addAccess('STAFF');
