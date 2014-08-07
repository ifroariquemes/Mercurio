<?php

namespace controller\activity\type;

use model\activity\type\Type;

class TypeController {

    public static function select() {
        global $_MyCookie;
        $types = Type::select('t')->orderBy('t.name')->getQuery()->getResult();
        $_MyCookie->LoadView('activity/type', 'Select', $types);
    }

    public static function manage() {
        global $_MyCookie;
        $types = Type::select('t')->orderBy('t.name')->getQuery()->getResult();
        $_MyCookie->LoadView('activity/type', 'Manage', $types);
    }

    public static function add() {
        global $_MyCookie;
        $_MyCookie->LoadView('activity/type', 'Edit', new Type);
    }

    public static function edit() {
        global $_MyCookie;
        $type = Type::select('t')->where('t.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(3))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('activity/type', 'Edit', $type);
    }

    public static function save() {
        $type = (empty(filter_input(INPUT_POST, 'id'))) ? new Type : $type = Type::select('t')->where('t.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $type->setName(filter_input(INPUT_POST, 'Name'))->save();
    }

}
