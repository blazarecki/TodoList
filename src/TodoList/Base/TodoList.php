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

use TodoList\Base\Task,
    TodoList\Helper\TodoListHelper,
    TodoList\Storage\Filesystem;

/**
 * Represent a toto list.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class TodoList
{
    /**
     * @var array An array of task.
     */
    private $tasks;

    /**
     * @var \TodoList\Storage\Filesystem The filesystem.
     */
    private $filesystem;

    /**
     * @var \TodoList\Helper\TodoListHelper The helper for todolist.
     */
    private $helper;

    /**
     * Constructor.
     *
     * Init the helper.
     */
    public function __construct()
    {
        $this->tasks = array();
        $this->filesystem = new Filesystem();
        $this->helper = new TodoListHelper();
    }

    /**
     * Get all tasks.
     *
     * @return array
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Get filesystem.
     *
     * @return \TodoList\Storage\Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * Get a task by id.
     *
     * @param integer $id The id.
     *
     * @return null|\TodoList\Base\Task
     */
    public function getTask($id)
    {
        $tasks = $this->getTasks();
        if ($id - 1 < count($tasks)) {
            return $tasks[$id - 1];
        }

        return null;
    }

    /**
     * Get the helper.
     *
     * @return \TodoList\Helper\TodoListHelper
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * Add a task.
     *
     * @param string|array $content The content.
     *
     * @return \TodoList\Base\TodoList
     */
    public function addTask($content)
    {
        if (is_array($content)) {
            $content = implode(' ', $content);
        }

        $task = new Task();
        $task
            ->setId(count($this->tasks) + 1)
            ->setContent($content);

        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Set the tasks.
     *
     * @param array $tasks The tasks.
     *
     * @return \TodoList\Base\TodoList
     */
    public function setTasks(array $tasks)
    {
        $id = 1;
        foreach ($tasks as $task) {
            $task->setId($id);
            $id++;
        }

        $this->tasks = $tasks;

        return $this;
    }

    /**
     * Set filesystem.
     *
     * @param \TodoList\Storage\Filesystem $filesystem The filesystem.
     *
     * @return \TodoList\Base\TodoList
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Remove a task.
     *
     * @param integer $id The id.
     *
     * @return \TodoList\Base\TodoList
     *
     * @throws \InvalidArgumentException
     */
    public function removeTask($id)
    {
        if ($id > count($this->getTasks())) {
            throw new \InvalidArgumentException(sprintf('Task with id %s does not exist !%s', $id, PHP_EOL));
        }

        $tasks = array();
        foreach ($this->getTasks() as $task) {
            if ($task->getId() != $id) {
                $tasks[] = $task;
            }
        }

        $this->setTasks($tasks);

        return $this;
    }

    /**
     * Set the helper.
     *
     * @param \TodoList\Helper\TaskHelper $helper The helper.
     *
     * @return \TodoList\Base\TodoList
     */
    public function setHelper(TodoListHelper $helper)
    {
        $this->helper = $helper;

        return $this;
    }

    /**
     * Initialize the todoList.
     *
     * @return \TodoList\Base\TodoList
     */
    public function init()
    {
        $tasks = $this->filesystem->read();
        $this->setTasks($tasks);

        return $this;
    }

    /**
     * Save the current todoList.
     *
     * @return \TodoList\Base\TodoList
     */
    public function save()
    {
        $this->filesystem->save($this);

        return $this;
    }

    /**
     * Display the task.
     *
     * @param null|string $glue The glue.
     *
     * @return string
     */
    public function display($glue = null)
    {
        if ($glue != null) {
            return $this->getHelper()->display($this, $glue);
        }

        return $this->getHelper()->display($this);
    }
}
