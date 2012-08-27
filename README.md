# TodoList [![Build Status](https://secure.travis-ci.org/benjaminlazarecki/TodoList.png)](http://travis-ci.org/benjaminlazarecki/TodoList)

> Don't manage your todolist, just do it !

A minimalist todolist in terminal

## Install

    git clone git@github.com:benjaminlazarecki/TodoList.git

And add this to your bashrc or bash_profile

    alias t='php /path/to/TodoList/t.php'

## Usage

### List tasks

    t

Will display

    1 - first task
    2 - second task
    3 - ...

### Add task

    t buy milk

### Remove task

    t -r (task number)

For example

    t -r 1

will display

    Task 1 deleted.

