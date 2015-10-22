<?php
class dummyPhpUnitTest extends PHPUnit_Framework_TestCase {

    public function testDummyTest() {
        $a = 'foo';
        $b = 'foo';
        // Assert
        $this->assertEquals($a, $b);
    }

}