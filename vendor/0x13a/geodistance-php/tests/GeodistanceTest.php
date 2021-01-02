<?php

namespace GeodistanceTest;

use \Geodistance\Location;

class GeodistanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testLocationLatitudeShouldReturnRadians()
    {
        $new_york = new Location(180.0, 0.0);

        $this->assertSame(pi(), $new_york->latitude());
    }

    /**
     * @test
     */
    public function testLocationLongitudeShouldReturnRadians()
    {
        $new_york = new Location(0.0, 180.0);

        $this->assertSame(pi(), $new_york->longitude());
    }

    /**
     * @test
     */
    public function testSameLocationShouldReturnZeroDistance()
    {
        $new_york = new Location(10.2, 12.1);

        $this->assertSame(0.0, \geodistance\meters($new_york, $new_york));
    }
}
