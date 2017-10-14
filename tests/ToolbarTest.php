<?php

require __DIR__ . '../../vendor/autoload.php';

use Dlayer\ViewHelper\Toolbar;

final class ToolbarTest extends \PHPUnit\Framework\Testcase
{
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
     * Set single group with one button
     */
    public function testSingleGroupOneButton()
    {
        $view_helper = new Toolbar();
        $view_helper->__invoke('toolbar')
            ->addTools(
                [
                    'group_1' => [
                        'tool_1' => [
                            'id' => 'tool_1',
                            'name' => 'Tool 1'
                        ]
                    ]
                ]
            );
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
            ->addTools(
                [
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
                ]
            );
        $this->assertEquals(
            '<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#toolbar" aria-controls="toolbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="toolbar"><div class="btn-group"><a class="btn" href="tool_1">Tool 1</a></div><div class="btn-group"><a class="btn" href="tool_2">Tool 2</a></div></div></nav>',
            $view_helper->__toString()
        );
    }
}
