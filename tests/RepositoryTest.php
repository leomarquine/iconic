<?php

use Marquine\Iconic\Repository;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    /** @test */
    function read_the_svg_file_and_cache_it_by_name_for_future_calls_then_return_its_contents()
    {
        $repository = new Repository;

        $svg  = '<svg fill="#000000" height="24" width="24"></svg>';

        $this->assertEquals($svg, $repository->get('icon', __DIR__));
        $this->assertEquals($svg, $repository->get('icon', ''));
    }
}
