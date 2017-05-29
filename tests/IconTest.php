<?php

use Marquine\Iconic\Icon;
use PHPUnit\Framework\TestCase;

class IconTest extends TestCase
{
    protected $icon;

    protected $svg = '<svg fill="#000000" height="24" width="24"></svg>';

    public function setUp()
    {
        parent::setUp();

        $repository = Mockery::mock('Marquine\Iconic\Repository');
        $repository->shouldReceive('get')->with('icon', '/path/to/icons')->once()->andReturn($this->svg);

        $config = [
            'path' => '/path/to/icons',
        ];

        $icon = new Icon($repository, $config);

        $this->icon = $icon->make('icon');
    }

    /** @test */
    function it_renders_the_svg()
    {
        $this->assertEquals($this->svg, $this->icon->render());
    }

    /** @test */
    function it_casts_the_icon_instance_to_string()
    {
        $this->assertEquals($this->svg, $this->icon);
    }

    /** @test */
    function it_changes_the_height_of_the_svg()
    {
        $svg = '<svg fill="#000000" height="16" width="24"></svg>';

        $this->assertEquals($svg, $this->icon->height(16));
    }

    /** @test */
    function it_changes_the_width_of_the_svg()
    {
        $svg = '<svg fill="#000000" height="24" width="16"></svg>';

        $this->assertEquals($svg, $this->icon->width(16));
    }

    /** @test */
    function it_changes_the_height_and_width_of_the_svg()
    {
        $svg = '<svg fill="#000000" height="16" width="16"></svg>';

        $this->assertEquals($svg, $this->icon->size(16));
    }

    /** @test */
    function it_changes_the_color_of_the_svg()
    {
        $svg = '<svg fill="#416e61" height="24" width="24"></svg>';

        $this->assertEquals($svg, $this->icon->color('#416e61'));
    }

    /** @test */
    function render_icon_using_helper_function()
    {
        // Set the helper function Icon instance.
        icon($this->icon);

        $this->assertEquals($this->svg, icon('icon'));
    }
}
