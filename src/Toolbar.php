<?php
declare(strict_types=1);

namespace Dlayer\ViewHelper;

use Zend\View\Helper\AbstractHelper;

/**
 * Generate the toolbar for the Dlayer managers and designers
 *
 * @package Dlayer\ViewHelper
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Copyright (c) 2017 G3D Development Limited
 * @license https://github.com/Dlayer/dlayer-view-helpers/blob/master/LICENSE
 */
class Toolbar extends AbstractHelper
{
    /**
     * @var array Classes to apply to the left button group
     */
    private $classes_left_tool_group;

    /**
     * @var array Classes to apply to the right button group
     */
    private $classes_right_tool_group;

    /**
     * @var array Left button group
     */
    private $tool_groups_left;

    /**
     * @ var array Right button group
     */
    private $tool_groups_right;

    /**
     * @var array Button groups by section
     */
    private $tool_groups;

    /**
     * @var array Classes to apply to each button group in the main part of the toolbar
     */
    private $classes_tool_groups;

    /**
     * @var integer Active button id
     */
    private $active;

    /**
     * @var string Id for navbar, needs to be unique if there are multiple navbars in the same view
     */
    private $id;

    /**
     * @var boolean Fixed bottom layout
     */
    private $fixed_bottom = false;

    /**
     * Entry point for the view helper
     *
     * @param string $id Id for navbar
     *
     * @return Toolbar
     */
    public function __invoke($id = 'dlayer_toolbar') : Toolbar
    {
        $this->reset();

        $this->id = $id;

        return $this;
    }

    /**
     * Pass in the id of the active button
     *
     * @param integer $id Id/Name of the active button
     *
     * @return Toolbar
     */
    public function setActiveTool($id)
    {
        $this->active = $id;

        return $this;
    }

    /**
     * Pass in the button groups array
     *
     * @param array $groups The button groups to display
     *
     * @return Toolbar
     */
    public function addTools(array $groups) : Toolbar
    {
        $this->tool_groups = $groups;

        return $this;
    }

    /**
     * Custom classes to attach to the button groups in the main part of the toolbar
     *
     * @param array $classes
     *
     * @return Toolbar
     */
    public function setClassForToolGroups(array $classes) : Toolbar
    {
        $this->classes_tool_groups = $classes;

        return $this;
    }

    /**
     * Custom classes to attach to the left button group
     *
     * @param array $classes
     *
     * @return Toolbar
     */
    public function setClassesForLeftToolGroup(array $classes) : Toolbar
    {
        $this->classes_left_tool_group = $classes;

        return $this;
    }

    /**
     * Custom classes to attach to the right button group
     *
     * @param array $classes
     *
     * @return Toolbar
     */
    public function setClassesForRightToolGroup(array $classes) : Toolbar
    {
        $this->classes_right_tool_group = $classes;

        return $this;
    }

    /**
     * Set the button group to optionally display at the left edge of the toolbar, for Dlayer
     * this is typically the cancel button. Unlike the buttonGroup method this method assumes one
     * group, not multiple groups
     *
     * @param array $group The button group
     *
     * @return Toolbar
     */
    public function addToolsToLeft(array $group) : Toolbar
    {
        $this->tool_groups_left = $group;

        return $this;
    }

    /**
     * Set the button group to optionally display at the right edge of the toolbar, for Dlayer
     * this is typically the expand control
     *
     * @param array $group The button group
     *
     * @return Toolbar
     */
    public function addToolsToRight(array $group) : Toolbar
    {
        $this->tool_groups_right = $group;

        return $this;
    }

    /**
     * Fixed bottom layout
     *
     * @return Toolbar
     */
    public function fixedBottom() : Toolbar
    {
        $this->fixed_bottom = true;

        return $this;
    }

    /**
     * Generate the HTML for the button
     *
     * @param array $button Button array
     *
     * @return string
     */
    private function button(array $button) : string
    {
        $classes = 'btn';
        if (array_key_exists('btn-classes', $button) === true) {
            $classes .= ' ' . implode(' ', $button['btn-classes']);
        }

        if ($this->active !== null && $button['id'] === $this->active) {
            $classes .= ' active';
        }

        $glypth = '';
        if (array_key_exists('fa-glyphs', $button) === true) {
            $glypth = '<i class="fa ' . implode(' ', $button['fa-glyphs']) .
                '" aria-hidden="true"></i> ';
        }

        return '<a class="' . $classes . '" href="' . $button['id'] . '">' . $glypth .
            $button['name'] . '</a>';
    }

    /**
     * Reset all properties in case the view helper is called multiple times within a script
     *
     * @return void
     */
    private function reset() : void
    {
        $this->tool_groups = [];
        $this->classes_tool_groups = [];
        $this->tool_groups_left = [];
        $this->tool_groups_right = [];
        $this->classes_left_tool_group = [];
        $this->classes_right_tool_group = [];
        $this->active = null;
        $this->id = null;
        $this->fixed_bottom = false;
    }

    /**
     * Worker method for the view helper, generates the HTML, the method is private so that we
     * can echo/print the view helper directly
     *
     * @return string
     */
    private function render() : string
    {
        $classes = '';

        if ($this->fixed_bottom === true) {
            $classes .= ' fixed-bottom';
        }

        $html = '<nav class="navbar navbar-expand-lg navbar-dark bg-dark' . $classes . '">';
        $html .= '<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#' .
            $this->id . '" aria-controls="' . $this->id .
            '" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
        $html .= '<div class="collapse navbar-collapse" id="' . $this->id . '">';

        if (count($this->tool_groups_left) > 0) {
            $html .= '<div class="btn-group btn-group-sm">';
            foreach ($this->tool_groups_left as $button) {
                $html .= $this->button($button);
            }
            $html .= '</div>';
        }

        foreach ($this->tool_groups as $section) {
            foreach ($section as $group) {
                if (count($group) > 0) {
                    $html .= '<div class="btn-group ' . implode(' ', $this->classes_tool_groups) . '">';
                    foreach ($group as $button) {
                        $html .= $this->button($button);
                    }
                    $html .= '</div>';
                }
            }
        }

        if (count($this->tool_groups_right) > 0) {
            $html .= '<div class="btn-group btn-group-sm ml-auto">';
            foreach ($this->tool_groups_right as $button) {
                $html .= $this->button($button);
            }
            $html .= '</div>';
        }

        $html .= '</div></nav>';

        return $html;
    }

    /**
     * Override the __toString() method to allow echo/print of the view helper directly, saves a
     * call to render()
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->render();
    }
}
