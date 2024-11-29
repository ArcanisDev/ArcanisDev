<?php


namespace DohTheme\Core\XF\Admin\Controller;

use XF\Mvc\FormAction;

class Forum extends XFCP_Forum
{

    protected function nodeSaveProcess(\XF\Entity\Node $node)
    {
        $background = $this->filter([
            'node' =>[
                'node_background' => 'str', 
            ]
        ]);
        $formAction = parent::nodeSaveProcess($node);
        $formAction->setup(function() use ($node, $background)
        {
            $node->node_background = $background['node']['node_background']; 
        });
        return $formAction;
    }
}