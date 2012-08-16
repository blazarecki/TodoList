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

/**
 * HelperInterface.
 *
 * Some object like Task or TodoList must be able to be display.
 *
 * All Helpers must implement this interface.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
interface HelperInterface
{
    /**
     * Display an object.
     *
     * @param mixed $arg The object to display.
     *
     * @return string
     */
    public function display($arg);
}
