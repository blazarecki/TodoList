<?php

/*
 * This file is part of the todoList package.
 *
 * (c) Benjamin LAZARECKI <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace TodoList\Helper;

use TodoList\Helper\HelperInterface;

/**
 * TodoListHelper.
 *
 * Helper for TodoList.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class TodoListHelper implements HelperInterface
{
    /**
     * @const string the default glue.
     */
    const GLUE = ' - ';

    /**
     * {@inheritdoc}
     */
    public function display($todoList, $glue = self::GLUE)
    {
        $toDisplay = '';
        foreach ($todoList->getTasks() as $task) {
            $toDisplay .= $task->display($glue);
        }

        return $toDisplay;
    }
}
