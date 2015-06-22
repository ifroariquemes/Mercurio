<?php

namespace controller\event\activity;

use model\event\activity\Type;
use model\event\activity\Translation;

class TypeController
{

    public static function select($id = null)
    {
        global $_MyCookie;
        $types = Type::select('t')->orderBy('t.name')->getQuery()->getResult();
        $_MyCookie->LoadView('event/activity/type', 'select', array('types' => $types, 'id' => $id));
    }

    public static function manage()
    {
        global $_MyCookie;
        $types = Type::select('t')->orderBy('t.name')->getQuery()->getResult();
        $_MyCookie->LoadView('event/activity/type', 'manage', $types);
    }

    public static function add()
    {
        global $_MyCookie;
        $_MyCookie->LoadView('event/activity/type', 'edit', new Type);
    }

    public static function edit()
    {
        global $_MyCookie;
        $type = Type::select('t')->where('t.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('event/activity/type', 'edit', $type);
    }

    public static function save()
    {
        $type = (empty(filter_input(INPUT_POST, 'id'))) ?
                new Type :
                Type::select('t')->where('t.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'id'))
                        ->getQuery()->getSingleResult();
        foreach ($type->getTranslations() as $t) {
            $t->delete();
        }
        $translations = filter_input(INPUT_POST, 'Translations'
                , FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        for ($i = 0, $max = count($translations['Name']); $i < $max; $i++) {
            $t = new Translation;
            $t->setName($translations['Name'][$i])
                    ->setLanguage($translations['Lang'][$i]);
            $t->setType($type);
            $type->addTranslation($t);
        }
        $type
                ->setName(filter_input(INPUT_POST, 'Name'))
                ->save();
    }

    public static function delete()
    {
        Type::select('t')->where('t.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult()->delete();
    }

    public static function deleteMsg()
    {
        _e('Are you sure to delete this type?', 'activity');
    }

    public static function deletedMsg()
    {
        _e('Type deleted successfully.', 'activity');
    }

    public static function createTranslationLine()
    {
        global $_MyCookie;
        $name = strtoupper(filter_input(INPUT_POST, 'Name'));
        $lang = strtolower(filter_input(INPUT_POST, 'Lang'));
        $t = new Translation;
        $t->setName($name)->setLanguage($lang);
        $_MyCookie->LoadView('event/activity/type', 'translation.line', $t);
    }
}