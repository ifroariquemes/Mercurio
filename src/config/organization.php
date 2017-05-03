<?php

use lib\util\module;

return module\Module::createInstance()
                ->setName('Organizações')
                ->setDescription('')
                ->addAuthor(module\Author::createInstance()
                        ->setName('Natanael Simões')
                        ->setEmail('natanael.simoes@ifro.edu.br'))
                ->setVersion('1.0')
                ->setCreationDate('2017-04-20')
                ->setLastReleaseDate('2017-04-20')
                ->setTile(module\Tile::createInstance()
                        ->setColor('blue')
                        ->setIcon('fa-gear'))
                ->setHome(module\Home::createInstance()
                        ->setControl('OrganizationController')
                        ->setAction('manage'))
                ->addController(module\Controller::createInstance()
                        ->setName('OrganizationController'));
