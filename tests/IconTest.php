<?php

use Marquine\Iconic\Icon;
use PHPUnit\Framework\TestCase;

class IconTest extends TestCase
{
    protected $icon;

    public function setUp()
    {
        parent::setUp();

        $repository = Mockery::mock('Marquine\Iconic\Repository');
        $repository->shouldReceive('get')->with('name', '/path/to/icons')->once()->andReturn('<svg fill="#000000" height="24" width="24"></svg>');

        Icon::config(['path' => '/path/to/icons']);
        Icon::repository($repository);
    }

    /** @test */
    function it_renders_the_svg()
    {
        $icon = new Icon;

        $this->assertEquals('<svg fill="#000000" height="24" width="24"></svg>', $icon->make('name')->render());
    }

    /** @test */
    function it_provides_an_icon_helper_function()
    {
        $this->assertInstanceOf(Icon::class, icon('name'));
    }

    /** @test */
    function it_casts_the_icon_instance_to_string()
    {
        $this->assertEquals('<svg fill="#000000" height="24" width="24"></svg>', icon('name'));
    }

    /** @test */
    function it_sets_an_attribute_value()
    {
        $this->assertEquals('<svg fill="#000000" height="24" role="button" width="24"></svg>', icon('name')->attribute('role', 'button'));
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
    function it_adds_a_class_of_the_svg()
    {
        $this->assertEquals('<svg class="icon" fill="#000000" height="24" width="24"></svg>', icon('name')->class('icon'));
    }

    /** @test */
    function it_appends_a_class_of_the_svg()
    {
        $repository = Mockery::mock('Marquine\Iconic\Repository');
        $repository->shouldReceive('get')->with('name', '/path/to/icons')->once()->andReturn('<svg class="icon" fill="#000000" height="24" width="24"></svg>');

        Icon::repository($repository);

        $this->assertEquals('<svg class="icon success" fill="#000000" height="24" width="24"></svg>', icon('name')->class('success'));
    }

    /** @test */
    function it_overrides_a_class_of_the_svg()
    {
        $repository = Mockery::mock('Marquine\Iconic\Repository');
        $repository->shouldReceive('get')->with('name', '/path/to/icons')->once()->andReturn('<svg class="warning" fill="#000000" height="24" width="24"></svg>');

        Icon::repository($repository);

        $this->assertEquals('<svg class="success" fill="#000000" height="24" width="24"></svg>', icon('name')->class('success', true));
    }

    /** @test */
    function it_sets_the_id_of_the_svg()
    {
        $this->assertEquals('<svg fill="#000000" height="24" id="id" width="24"></svg>', icon('name')->id('id'));
    }

    /** @test */
    function it_applies_default_values()
    {
        Icon::config([
            'path' => '/path/to/icons',
            'defaults' => [
                'color' => '#4c656f',
                'height' => '16',
                'width' => '16',
                'class' => 'icon',
            ]
        ]);

        $this->assertEquals('<svg class="icon" fill="#4c656f" height="16" width="16"></svg>', icon('name'));
    }

    /** @test */
    function it_sets_the_state_of_the_icon()
    {
        Icon::state('success', function ($icon) {
            $icon->color('#4d6968')->class('icon')->size(23);
        });

        $this->assertEquals('<svg class="icon" fill="#4d6968" height="23" width="23"></svg>', icon('name')->success());
    }

    /** @test */
    function it_conditionally_sets_the_state_of_the_icon()
    {
        Icon::state('success', function ($icon) {
            $icon->class('success');
        });

        Icon::state('warning', function ($icon) {
            $icon->class('warning');
        });

        $condition = true;

        $this->assertEquals('<svg class="success" fill="#000000" height="24" width="24"></svg>', icon('name')->success($condition)->warning(! $condition));
        $this->assertEquals('<svg class="warning" fill="#000000" height="24" width="24"></svg>', icon('name')->success(! $condition)->warning($condition));
    }

    /** @test */
    function it_sets_the_style_of_the_icon()
    {
        $this->assertEquals('<svg fill="#000000" height="24" style="z-index: 10;" width="24"></svg>', icon('name')->style('z-index', 10));
    }

    /** @test */
    function it_sets_the_multiple_styles_of_the_icon()
    {
        $style = [
            'margin' => '10px',
            'z-index' => '10',
        ];

        $this->assertEquals('<svg fill="#000000" height="24" style="margin: 10px; z-index: 10;" width="24"></svg>', icon('name')->style($style));
    }
}
