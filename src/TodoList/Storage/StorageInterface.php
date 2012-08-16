<?php

/*
 * This file is part of the todoList package.
 *
 * (c) Benjamin LAZARECKI <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace TodoList\Storage;

use TodoList\Base\TodoList;

/**
 * StorageInterface.
 *
 * A TodoList must be find and save somewhere.
 * This interface provide some methods to checks if storage is properly configure,
 * and allow to get and save a TodoList.
 *
 * All Storage Class must implement this interface.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
interface StorageInterface
{
    /**
     * Return a TodoList.
     *
     * @return \TodoList\Base\TodoList
     */
    public function read();

    /**
     * Save the TodoList.
     *
     * @param \TodoList\Base\TodoList $todoList The todoList to save.
     */
    public function save(TodoList $todoList);

    /**
     * Check if storage is configure.
     *
     * @return true
     *
     * @throws \Exception
     */
    public function check();
}
