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

use TodoList\Base\Task,
    TodoList\Base\TodoList,
    TodoList\Storage\StorageInterface;

/**
 * Allow to store TodoList in filesystem.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class Filesystem implements StorageInterface
{
    /**
     * @var string The path to the file.
     */
    private $path;

    /**
     * Get the path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the path.
     *
     * @param string $path The path.
     *
     * @return \TodoList\Storage\Filesystem
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function read()
    {
        if (($file = fopen($this->getPath(), 'r')) !== false) {
            $tasks = array();

            while (($data = fgetcsv($file, 0, ',')) !== false) {
                $task = new Task();
                $task
                    ->setId($data[0])
                    ->setContent($data[1]);

                $tasks[] = $task;
            }

            return $tasks;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save(TodoList $todoList)
    {
        $file = fopen($this->getPath(), 'w+');
        $content = $todoList->display(',');

        fwrite($file, $content);
    }

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        $path = $this->path;

        if (!file_exists($path)) {
            if (!touch($path)) {
                throw new \Exception(sprintf('Error: Unable to create %s file !%s', $path, PHP_EOL));
            }
        }

        if (!is_writable($path)) {
            throw new \Exception(sprintf('Error: File %s is not writable !%s', $path, PHP_EOL));
        }
    }
}
