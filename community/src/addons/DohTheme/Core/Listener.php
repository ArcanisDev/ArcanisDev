<?php


namespace DohTheme\Core;

use XF\Mvc\Entity\Entity;


class Listener
{
    public static function nodeEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
    {
        $structure->columns['node_background'] = ['type' => Entity::STR, 'default' => '', 'nullable' => true];
    }

}