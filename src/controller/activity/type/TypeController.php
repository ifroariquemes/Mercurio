<?php

namespace controller\activity\type;

use model\activity\type\Type;

class TypeController {

    public static function select($id = null) {
        global $_MyCookie;
        $types = Type::select('t')->orderBy('t.name')->getQuery()->getResult();
        $_MyCookie->LoadView('activity/type', 'Select', array('types' => $types, 'id' => $id));
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
        $type = Type::select('t')->where('t.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('activity/type', 'Edit', $type);
    }

    public static function save() {
        $type = (empty(filter_input(INPUT_POST, 'id'))) ? new Type : $type = Type::select('t')->where('t.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $type->setName(filter_input(INPUT_POST, 'Name'))->save();
    }

    public static function delete() {
        Type::select('t')->where('t.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult()->delete();
    }

    public static function deleteMsg() {
        _e('Are you sure to delete this type?', 'activity');
    }

    public static function deletedMsg() {
        _e('Type deleted successfully.', 'activity');
    }

}
