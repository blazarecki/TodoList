<?php

/*
 * This file is part of the todoList package.
 *
 * (c) Benjamin LAZARECKI <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace TodoList\Tests\Base;

use TodoList\Base\Task,
    TodoList\Base\TodoList,
    TodoList\Storage\Filesystem;

/**
 * Test TodoList.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class TodoListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \TodoList\Base\TodoList The todoList.
     */
    private $todoList;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->todoList = new TodoList();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->todoList);
    }

    /**
     * @covers \TodoList\Base\TodoList::setFilesystem
     *
     * @expectedException PHPUnit_Framework_Error
     */
    public function testSetFilesystemThrowException()
    {
        $this->todoList->setFilesystem('foo');
        $this->todoList->setFilesystem(1);
        $this->todoList->setFilesystem(true);
    }

    /**
     * @covers \TodoList\Base\TodoList::setFilesystem
     */
    public function testSetFilesystemFluentInterface()
    {
        $this->assertInstanceOf('TodoList\Base\TodoList', $this->todoList->setFilesystem(new Filesystem()));
    }

    /**
     * @covers \TodoList\Base\TodoList::getFilesystem
     * @covers \TodoList\Base\TodoList::setFilesystem
     */
    public function testSetGetFilesytem()
    {
        $this->todoList->setFilesystem(new Filesystem());

        $this->assertInstanceOf('TodoList\Storage\Filesystem', $this->todoList->getFilesystem());
    }

    /**
     * @covers \TodoList\Base\TodoList::setTasks
     *
     * @expectedException PHPUnit_Framework_Error
     */
    public function testSetTasks()
    {
        $this->todoList->setTasks('foo');
        $this->todoList->setTasks(1);
        $this->todoList->setTasks(true);
    }

    /**
     * @covers \TodoList\Base\TodoList::setTasks
     */
    public function testSetTasksFluentInterface()
    {
        $this->assertInstanceOf('TodoList\Base\TodoList', $this->todoList->setTasks(array()));
    }

    /**
     * @covers \TodoList\Base\TodoList::getTasks
     * @covers \TodoList\Base\TodoList::setTasks
     */
    public function testSetGetTasks()
    {
        $this->todoList->setTasks(array());
        $this->assertEquals(array(), $this->todoList->getTasks());

        $mockTask = $this->getMock('TodoList\Base\Task');
        $this->todoList->setTasks(array($mockTask));
        $this->assertEquals(1, count($this->todoList->getTasks()));
    }

    /**
     * @covers \TodoList\Base\TodoList::addTask
     */
    public function testAddTaskFluentInterface()
    {
        $this->assertInstanceOf('TodoList\Base\TodoList', $this->todoList->addTask('foo'));
    }

    /**
     * @covers \TodoList\Base\TodoList::addTask
     * @covers \TodoList\Base\TodoList::getTasks
     */
    public function testAddTask()
    {
        $this->assertEquals(0, count($this->todoList->getTasks()));
        $this->todoList->addTask('foo');
        $this->assertEquals(1, count($this->todoList->getTasks()));
    }

    /**
     * @covers \TodoList\Base\Task::getContent
     *
     * @covers \TodoList\Base\TodoList::addTask
     * @covers \TodoList\Base\TodoList::getTask
     * @covers \TodoList\Base\TodoList::getTasks
     */
    public function testAddTaskWithArray()
    {
        $this->assertEquals(0, count($this->todoList->getTasks()));
        $this->todoList->addTask(array('foo', 'bar'));
        $this->assertEquals(1, count($this->todoList->getTasks()));
        $this->assertEquals('foo bar', $this->todoList->getTask(1)->getContent());
    }

    /**
     * @covers \TodoList\Base\TodoList::addTask
     * @covers \TodoList\Base\TodoList::getTask
     */
    public function testAddGetTask()
    {
        $this->assertNull($this->todoList->getTask(1));

        $this->todoList->addTask('foo');
        $this->assertInstanceOf('TodoList\Base\Task', $this->todoList->getTask(1));
    }

    /**
     * @covers \TodoList\Base\TodoList::addTask
     * @covers \TodoList\Base\TodoList::removeTask
     */
    public function testRemoveTaskFluentInterface()
    {
        $this->todoList->addTask('foo');
        $this->assertInstanceOf('TodoList\Base\TodoList', $this->todoList->removeTask(1));
    }

    /**
     * @covers \TodoList\Base\TodoList::removeTask
     *
     * @expectedException InvalidArgumentException
     */
    public function testRemoveTaskThrowsException()
    {
        $this->todoList->removeTask(1);
    }

    /**
     * @covers \TodoList\Base\Task::getContent
     *
     * @covers \TodoList\Base\TodoList::addTask
     * @covers \TodoList\Base\TodoList::getTask
     * @covers \TodoList\Base\TodoList::getTasks
     * @covers \TodoList\Base\TodoList::removeTask
     */
    public function testRemoveTask()
    {
        $this->todoList
            ->addTask('foo')
            ->addTask('bar');

        $this->assertEquals(2, count($this->todoList->getTasks()));
        $this->assertEquals(1, count($this->todoList->removeTask(1)));
        $this->assertEquals('bar', $this->todoList->getTask(1)->getContent());
    }

    /**
     * @covers \TodoList\Base\TodoList::init
     * @covers \TodoList\Base\TodoList::setFilesystem
     */
    public function testInitFluentInterface()
    {
        $stubFilesystem = $this->getMockFilesystem();
        $stubFilesystem->expects($this->any())
             ->method('read')
             ->will($this->returnValue(array()));

        $this->todoList->setFilesystem($stubFilesystem);
        $this->assertInstanceOf('TodoList\Base\TodoList', $this->todoList->init());
    }

    /**
     * @covers \TodoList\Base\TodoList::init
     * @covers \TodoList\Base\TodoList::setFilesystem
     * @covers \TodoList\Base\TodoList::getTasks
     */
    public function testInit()
    {
        $stubFilesystem = $this->getMockFilesystem();
        $stubFilesystem->expects($this->any())
             ->method('read')
             ->will($this->returnValue(array()));

        $this->todoList->setFilesystem($stubFilesystem);
        $this->todoList->init();
        $this->assertEquals(0, count($this->todoList->getTasks()));

        $tasks = array(new Task(), new Task());
        $stubFilesystem = $this->getMockFilesystem();
        $stubFilesystem->expects($this->any())
             ->method('read')
             ->will($this->returnValue($tasks));

        $this->todoList->setFilesystem($stubFilesystem);
        $this->todoList->init();
        $this->assertEquals(2, count($this->todoList->getTasks()));
    }

    /**
     * @covers \TodoList\Base\TodoList::setFilesystem
     * @covers \TodoList\Base\TodoList::save
     */
    public function testSaveFluentInterface()
    {
        $stubFilesystem = $this->getMockFilesystem();
        $this->todoList->setFilesystem($stubFilesystem);
        $this->assertInstanceOf('TodoList\Base\TodoList', $this->todoList->save());
    }

    /**
     * @covers \TodoList\Base\TodoList::setHelper
     */
    public function testSetHelperFluentInterface()
    {
        $this->assertInstanceOf('TodoList\Base\TodoList', $this->todoList->setHelper($this->getMockTodoListHelper()));
    }

    /**
     * @covers \TodoList\Base\TodoList::getHelper
     * @covers \TodoList\Base\TodoList::setHelper
     */
    public function testGetSetHelper()
    {
        $helper = $this->getMockTodoListHelper();

        $this->todoList->setHelper($helper);
        $this->assertEquals($helper, $this->todoList->getHelper());
    }

    /**
     * @covers \TodoList\Base\TodoList::display
     */
    public function testDisplayWithGlue()
    {
        $helper = $this->getMockTodoListHelper();
        $helper
            ->expects($this->any())
            ->method('display')
            ->will($this->returnValue('foo'));

        $this->todoList->setHelper($helper);

        $this->assertEquals('foo', $this->todoList->display('bar'));
    }

    /**
     * @covers \TodoList\Base\TodoList::display
     */
    public function testDisplayWithoutGlue()
    {
        $helper = $this->getMockTodoListHelper();
        $helper
            ->expects($this->any())
            ->method('display')
            ->will($this->returnValue('foo'));

        $this->todoList->setHelper($helper);

        $this->assertEquals('foo', $this->todoList->display());
    }

    /**
     * @covers \TodoList\Base\TodoList::__construct
     */
    public function testConstruct()
    {
        $this->assertInstanceOf('\TodoList\Helper\TodoListHelper', $this->todoList->getHelper());
        $this->assertInstanceOf('\TodoList\Storage\Filesystem', $this->todoList->getFilesystem());
        $this->assertEmpty($this->todoList->getTasks());
    }

    /**
     * @return mixed A mock filesystem.
     */
    private function getMockFilesystem()
    {
        return $this->getMock('TodoList\Storage\Filesystem');
    }

    /**
     * @return mixed A mock todoListHelper..
     */
    private function getMockTodoListHelper()
    {
        return $this->getMock('TodoList\Helper\TodoListHelper');
    }
}
