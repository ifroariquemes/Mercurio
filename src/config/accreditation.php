<?php

use lib\util\module;

return module\Module::createInstance()
                ->setName('Accreditation')
                ->setDescription('')
                ->addAuthor(module\Author::createInstance()
                        ->setName('Natanael Simões')
                        ->setEmail('natanael.simoes@ifro.edu.br'))
                ->setVersion('1.0')
                ->setCreationDate('2014-08-26')
                ->setLastReleaseDate('2014-08-26')
                ->setTile(module\Tile::createInstance()
                        ->setColor('blue')
                        ->setIcon('fa-star'))
                ->setHome(module\Home::createInstance()
                        ->setControl('AccreditationController')
                        ->setAction('Manage'))
                ->addController(module\Controller::createInstance()
                        ->setName('AccreditationController'))
                ->addAccess('ADMINISTRATOR')
                ->addAccess('STAFF');
