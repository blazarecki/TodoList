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

use TodoList\Base\Task;

/**
 * TaskTest
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class TaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \TodoList\Base\Task A task.
     */
    private $task;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->task = new Task();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->task);
    }

    /**
     * @covers \TodoList\Base\Task::getId
     * @covers \TodoList\Base\Task::setId
     */
    public function testSetGetId()
    {
        $this->task->setId(1);
        $this->assertEquals(1, $this->task->getId());
    }

    /**
     * @covers \TodoList\Base\Task::setId
     */
    public function setIdFluentInterface()
    {
        $this->assertInstanceOf('TodoList\Base\Task', $this->task->setId(1));
    }

    /**
     * @covers \TodoList\Base\Task::getContent
     * @covers \TodoList\Base\Task::setContent
     */
    public function testSetGetContent()
    {
        $this->task->setContent('foo');
        $this->assertEquals('foo', $this->task->getContent());
    }

    /**
     * @covers \TodoList\Base\Task::setContent
     */
    public function setContentFluentInterface()
    {
        $this->assertInstanceOf('TodoList\Base\Task', $this->task->setContent('foo'));
    }

    /**
     * @covers \TodoList\Base\Task::getHelper
     * @covers \TodoList\Base\Task::setHelper
     */
    public function testSetGetHelper()
    {
        $helper = $this->getMockTaskHelper();

        $this->task->setHelper($helper);
        $this->assertEquals($helper, $this->task->getHelper());
    }

    /**
     * @covers \TodoList\Base\Task::setContent
     */
    public function setHelperFluentInterface()
    {
        $this->assertInstanceOf('TodoList\Base\Task', $this->task->setHelper($this->getMockTaskHelper()));
    }

    /**
     * @covers \TodoList\Base\Task::__construct
     */
    public function testConstruct()
    {
        $this->assertInstanceOf('TodoList\Helper\TaskHelper', $this->task->getHelper());
    }

    /**
     * @covers \TodoList\Base\Task::display
     */
    public function testDisplay()
    {
        $helper = $this->getMockTaskHelper();
        $helper
            ->expects($this->any())
            ->method('display')
            ->will($this->returnValue('foo'));

        $this->task->setHelper($helper);

        $this->assertEquals('foo', $this->task->display('bar'));
    }

    /**
     * @return \TodoList\Helper\TaskHelper mixed A mock TaskHelper.
     */
    private function getMockTaskHelper()
    {
        return $this->getMock('TodoList\Helper\TaskHelper');
    }
}
