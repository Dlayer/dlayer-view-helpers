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
        $view_helper->__invoke();
        $this->assertEquals(true, true);
    }
}
