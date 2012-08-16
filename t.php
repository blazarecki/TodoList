<?php

/*
 * This file is part of the todoList package.
 *
 * (c) Benjamin LAZARECKI <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

/**
 * todoList
 *
 * Allow you to manage your todolist.
 * You can add / remove tasks.  
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */

include __DIR__ . '/vendor/autoload.php';

// --- Init ---
$todoList = new TodoList\Base\TodoList();
$todoList->getFilesystem()->setPath(__DIR__ . '/todo.list');

try {
    $todoList->getFilesystem()->check();
} catch (\Exception $e) {
    fwrite(STDOUT, $e->getMessage());
    die();
}

$todoList->init();

// --- Display all tasks ---
if (count($argv) === 1) {
    fwrite(STDOUT, $todoList->display());
    exit(0);
}

$options = getopt('r:');

// --- Add a task ---
if (count($options) == 0) {
    $todoList
        ->addTask(array_slice($argv, 1))
        ->save();
    exit(0);
}

// --- Remove a task ---
$id = $options['r'];
if ($id != null) {
    try {
        $todoList->removeTask($id);
    } catch (\Exception $e) {
        fwrite(STDOUT, $e->getMessage());
        die();
    }

    $todoList->save();

    fwrite(STDOUT, sprintf('Task %s deleted.%s', $id, PHP_EOL));
    exit(0);
}
