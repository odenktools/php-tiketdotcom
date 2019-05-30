<?php

if (!class_exists('PHPUnit_Framework_TestCase') && class_exists('\PHPUnit\Framework\TestCase'))
    class_alias('\PHPUnit\Framework\TestCase', 'PHPUnit_Framework_TestCase');

class tiketTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    public static function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function testSha256()
    {
        $hash = in_array('sha256', hash_algos());
        $this->assertTrue($hash);
    }
}
