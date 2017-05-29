<?php

use Marquine\Iconic\Repository;
use PHPUnit\Framework\TestCase;
use VirtualFileSystem\FileSystem;

class RepositoryTest extends TestCase
{
    /** @test */
    function read_the_svg_file_and_cache_it_by_name_for_future_calls_then_return_its_contents()
    {
        $repository = new Repository;

        $svg  = '<svg fill="#000000" height="24" width="24"></svg>';

        $filesystem = new FileSystem();
        mkdir($filesystem->path('icons'));

        file_put_contents($filesystem->path('icons/icon.svg'), $svg);
        $this->assertEquals(
            $svg, $repository->get('icon', $filesystem->path('icons'))
        );

        unlink($filesystem->path('icons/icon.svg'));
        $this->assertEquals(
            $svg, $repository->get('icon', $filesystem->path('icons'))
        );
    }
}
