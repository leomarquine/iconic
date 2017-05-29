<?php

use Marquine\Iconic\Icon;
use PHPUnit\Framework\TestCase;

class IconTest extends TestCase
{
    protected $icon;

    public function setUp()
    {
        parent::setUp();

        $this->init();
    }

    public function init($config = null, $svg = null)
    {
        $config = $config ?: ['path' => '/path/to/icons'];
        $svg = $svg ?: '<svg fill="#000000" height="24" width="24"></svg>';

        $repository = Mockery::mock('Marquine\Iconic\Repository');
        $repository->shouldReceive('get')->with('name', '/path/to/icons')->once()->andReturn($svg);

        $this->icon = new Icon($repository, $config);

        icon($this->icon);
    }

    /** @test */
    function it_renders_the_svg()
    {
        $this->assertEquals('<svg fill="#000000" height="24" width="24"></svg>', $this->icon->make('name')->render());
    }

    /** @test */
    function it_provides_an_icon_helper_function()
    {
        icon($this->icon); // Set the helper function Icon instance.

        $this->assertInstanceOf(Icon::class, icon('name'));
    }

    /** @test */
    function it_casts_the_icon_instance_to_string()
    {
        $this->assertEquals('<svg fill="#000000" height="24" width="24"></svg>', icon('name'));
    }

    /** @test */
    function it_changes_the_height_of_the_svg()
    {
        $this->assertEquals('<svg fill="#000000" height="16" width="24"></svg>', icon('name')->height(16));
    }

    /** @test */
    function it_changes_the_width_of_the_svg()
    {
        $this->assertEquals('<svg fill="#000000" height="24" width="16"></svg>', icon('name')->width(16));
    }

    /** @test */
    function it_changes_the_height_and_width_of_the_svg()
    {
        $this->assertEquals('<svg fill="#000000" height="16" width="16"></svg>', icon('name')->size(16));
    }

    /** @test */
    function it_changes_the_color_of_the_svg()
    {
        $this->assertEquals('<svg fill="#416e61" height="24" width="24"></svg>', icon('name')->color('#416e61'));
    }


    /** @test */
    function it_applies_default_values()
    {
        $this->init([
            'path' => '/path/to/icons',
            'defaults' => [
                'color' => '#4c656f',
                'height' => '16',
                'width' => '16',
            ]
        ]);

        $this->assertEquals('<svg fill="#4c656f" height="16" width="16"></svg>', icon('name'));
    }
}
