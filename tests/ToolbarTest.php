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
}
