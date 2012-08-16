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
 * TaskHelper.
 *
 * Helper for Task.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class TaskHelper implements HelperInterface
{
    /**
     * {@inheritdoc}
     */
    public function display($task, $glue = null)
    {
        return sprintf('%s%s%s%s',
            $task->getId(),
            $glue,
            $task->getContent(),
            PHP_EOL
        );
    }
}
