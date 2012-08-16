<?php

/*
 * This file is part of the todoList package.
 *
 * (c) Benjamin LAZARECKI <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace TodoList\Base;

use TodoList\Helper\TaskHelper;

/**
 * Represent a task.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class Task
{
    /**
     * @var integer The id of the task.
     */
    private $id;

    /**
     * @var string The content of the task.
     */
    private $content;

    /**
     * @var \TodoList\Helper\TaskHelper The helper to display this task.
     */
    private $helper;

    /**
     * Constructor.
     *
     * Init the helper.
     */
    public function __construct()
    {
        $this->helper = new TaskHelper();
    }

    /**
     * Get task'id.
     *
     * @return \TodoList\Base\Task
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get content'id.
     *
     * @return \TodoList\Base\Task
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the helper.
     *
     * @return \TodoList\Helper\TaskHelper
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * Set task'id.
     *
     * @param integer $id The id.
     *
     * @return \TodoList\Base\Task
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set task'content.
     *
     * @param string $content The content.
     *
     * @return \TodoList\Base\Task
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the helper.
     *
     * @param \TodoList\Helper\TaskHelper $helper The helper.
     *
     * @return \TodoList\Base\Task
     */
    public function setHelper(TaskHelper $helper)
    {
        $this->helper = $helper;

        return $this;
    }

    /**
     * Display the task.
     *
     * @param string $glue The glue.
     *
     * @return string
     */
    public function display($glue)
    {
        return $this->getHelper()->display($this, $glue);
    }
}
