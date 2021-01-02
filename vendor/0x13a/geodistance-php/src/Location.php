<?php

namespace Geodistance;

class Location
{
    // We'll need another constant here,
    // when we'll start using GPS on Mars
    const EARTH_RADIUS = 6371000;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @throw \InvalidArgumentException
     */
    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function latitude(): float
    {
        return deg2rad($this->latitude);
    }

    /**
     * @return float
     */
    public function longitude(): float
    {
        return deg2rad($this->longitude);
    }
}

function meters(Location $x, Location $y, int $precision = 0)
{
    $deltaLatitude = $y->latitude() - $x->latitude();
    $deltaLongitude = $y->longitude() - $x->longitude();

    $angle = asin(
        sqrt(
            pow(sin($deltaLatitude * 0.5), 2)
            + cos($x->latitude()) * cos($y->latitude())
            * pow(sin($deltaLongitude * 0.5), 2)
        )
    ) * 2;

    return round(Location::EARTH_RADIUS * $angle, $precision);
}

function kilometers(Location $x, Location $y, int $precision = 0)
{
    return round(meters($x, $y) * 0.001, $precision);
}

function miles(Location $x, Location $y, int $precision = 0)
{
    return round(meters($x, $y) * 0.000621371, $precision);
}

function centimeters(Location $x, Location $y, int $precision = 0)
{
    return round(meters($x, $y) * 100, $precision);
}

function yards(Location $x, Location $y, int $precision = 0)
{
    return round(meters($x, $y) * 1.09361, $precision);
}

function feet(Location $x, Location $y, int $precision = 0)
{
    return round(meters($x, $y) * 3.28083, $precision);
}
