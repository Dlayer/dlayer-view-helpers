<?php

require __DIR__ . '../../vendor/autoload.php';

use Dlayer\ViewHelper\Toolbar;

final class ToolbarTest extends \PHPUnit\Framework\Testcase
{
    private $single_tool_group = [
        'group_1' => [
            'tool_1' => [
                'id' => 'tool_1',
                'name' => 'Tool 1'
            ]
        ]
    ];

    private $two_groups_single_tool = [
        'group_1' => [
            'tool_1' => [
                'id' => 'tool_1',
                'name' => 'Tool 1'
            ]
        ],
        'group_2' => [
            'tool_2' => [
                'id' => 'tool_2',
                'name' => 'Tool 2'
            ]
        ]
    ];

    /**
     * Test the most minimal call of the view helper
     */
    public function testDefault()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar');
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Set a different element id
     */
    public function testAlternateElementId()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar_2');
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar_2" aria-controls="toolbar_2" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar_2"></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Set the fixed bottom option
     */
    public function testFixedBottom()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->fixedBottom();
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Set the fixed top option
     */
    public function testFixedTop()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->fixedTop();
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Set the sticky top option
     */
    public function testStickyTop()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->stickyTop();
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Set single group with one button
     */
    public function testSingleGroupOneButton()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->addTools($this->single_tool_group);
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"><div class="btn-group"><a class="btn" href="tool_1">Tool 1</a></div></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Set single group with three buttons
     */
    public function testSingleGroupThreeButtons()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->addTools(
                [
                    'group_1' => [
                        'tool_1' => [
                            'id' => 'tool_1',
                            'name' => 'Tool 1'
                        ],
                        'tool_2' => [
                            'id' => 'tool_2',
                            'name' => 'Tool 2'
                        ],
                        'tool_3' => [
                            'id' => 'tool_3',
                            'name' => 'Tool 3'
                        ]
                    ]
                ]
            );
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"><div class="btn-group"><a class="btn" href="tool_1">Tool 1</a><a class="btn" href="tool_2">Tool 2</a><a class="btn" href="tool_3">Tool 3</a></div></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Set multipleGroupsSingleButton
     */
    public function testMultipleGroupsOneButton()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->addTools($this->two_groups_single_tool);
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"><div class="btn-group"><a class="btn" href="tool_1">Tool 1</a></div><div class="btn-group"><a class="btn" href="tool_2">Tool 2</a></div></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Test set active button
     */
    public function testSetActive()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->addTools($this->two_groups_single_tool)
            ->setActiveTool('tool_1');
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"><div class="btn-group"><a class="btn active" href="tool_1">Tool 1</a></div><div class="btn-group"><a class="btn" href="tool_2">Tool 2</a></div></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Set a base uri
     */
    public function testBaseUri()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->addTools($this->single_tool_group)
            ->setBaseUri('http://base.uri/');
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"><div class="btn-group"><a class="btn" href="http://base.uri/tool_1">Tool 1</a></div></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Test the collapse below options
     */
    public function testCollapseBelowLg()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->collapseBelowLg();
        $this->assertEquals(
            '<nav class="navbar navbar-dark bg-dark navbar-expand-lg"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Test the collapse below options
     */
    public function testCollapseBelowMd()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->collapseBelowMd();
        $this->assertEquals(
            '<nav class="navbar navbar-dark bg-dark navbar-expand-md"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Test the collapse below options
     */
    public function testCollapseBelowSm()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->collapseBelowSm();
        $this->assertEquals(
            '<nav class="navbar navbar-dark bg-dark navbar-expand-sm"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Test the collapse below options
     */
    public function testCollapseBelowXl()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->collapseBelowXl();
        $this->assertEquals(
            '<nav class="navbar navbar-dark bg-dark navbar-expand-xl"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Test dark scheme
     */
    public function testSchemeDark()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->dark();
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg bg-dark navbar-dark"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"></div></nav>',
            $view_helper->__toString()
        );
    }

    /**
     * Test light scheme
     */
    public function testSchemeLight()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->light();
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg bg-dark navbar-light"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"></div></nav>',
            $view_helper->__toString()
        );
    }
}
