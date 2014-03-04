<?php

/*
 * Copyright (c) 2013, Flaming Code
 * 
 */

namespace FlamingBaseTest\Entity;

use PHPUnit_Framework_TestCase;

use DateTime;

/**
 * AbstractEntityTest
 *
 * @author Flemming Andersen <flemming@flamingcode.com>
 * @copyright (c) 2013, Flaming Code
 * @link https://github.com/FlamingCode/FlamingBase for the canonical source repository
 * @license http://opensource.org/licenses/MIT MIT
 */
class AbstractEntityTest extends PHPUnit_Framework_TestCase
{
	public function testCanPopulateFromArray()
	{
		$thatTime = new DateTime('2013-04-04 20:05:12');

		$instance = new ConcreteEntity;
		$data = array(
			'id' => 1,
			'name' => 'John Doe',
			'skills' => array('Climbing', 'Running', 'Jumping'),
			'timestamp' => $thatTime
		);
		$instance->setOptions($data);

		$this->assertSame($data['id'], $instance->getId());
		$this->assertSame($data['name'], $instance->getName());
		$this->assertEquals($data['skills'], $instance->getSkills());
		$this->assertSame($data['timestamp'], $instance->getTimestamp());
	}

	public function testMagicSetters()
	{
		$thatTime = new DateTime('2013-04-04 20:05:12');

		$instance = new ConcreteEntity;
		$data = array(
			'id' => 1,
			'name' => 'John Doe',
			'skills' => array('Climbing', 'Running', 'Jumping'),
			'timestamp' => $thatTime
		);
		$instance->id = $data['id'];
		$instance->name = $data['name'];
		$instance->skills = $data['skills'];
		$instance->timestamp = $data['timestamp'];

		$this->assertSame($data['id'], $instance->getId());
		$this->assertSame($data['name'], $instance->getName());
		$this->assertEquals($data['skills'], $instance->getSkills());
		$this->assertSame($data['timestamp'], $instance->getTimestamp());
	}

	public function testMagicGetters()
	{
		$thatTime = new DateTime('2013-04-04 20:05:12');

		$instance = new ConcreteEntity;
		$data = array(
			'id' => 1,
			'name' => 'John Doe',
			'skills' => array('Climbing', 'Running', 'Jumping'),
			'timestamp' => $thatTime
		);
		$instance->setOptions($data);

		$this->assertSame($data['id'], $instance->id);
		$this->assertSame($data['name'], $instance->name);
		$this->assertEquals($data['skills'], $instance->skills);
		$this->assertSame($data['timestamp'], $instance->timestamp);
	}
	
	public function testThrowsExceptionFromUnknownProperty()
	{
		$instance = new ConcreteEntity;
		
		$this->setExpectedException(
			'FlamingBase\Entity\Exception\UnknownPropertyException',
			'Trying to set unknown property: someUnknownProperty'
		);
		
		$instance->someUnknownProperty = 'Test';
	}
}