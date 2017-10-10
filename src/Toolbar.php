<?php
declare(strict_types=1);

namespace Dlayer\ViewHelper;

use Zend\View\Helper\AbstractHelper;

/**
 * Generate the toolbar for the managers/designers
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
    private $button_group_classes_left;

    /**
     * @var array Classes to apply to the right button group
     */
    private $button_group_classes_right;

    /**
     * @var array Left button group
     */
    private $button_group_left;

    /**
     * @ var array Right button group
     */
    private $button_group_right;

    /**
     * @var array Button groups by section
     */
    private $button_groups;

    /**
     * @var array Classes to apply to each button group in the main part of the toolbar
     */
    private $button_groups_classes;

    /**
     * @var integer Active button id
     */
    private $active;

    /**
     * Entry point for the view helper
     *
     * @return Toolbar
     */
    public function __invoke() : Toolbar
    {
        $this->reset();

        return $this;
    }

    /**
     * Pass in the id of the active button
     *
     * @param integer $id Id/Name of the active button
     *
     * @return Toolbar
     */
    public function active($id)
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
    public function buttonGroups(array $groups) : Toolbar
    {
        $this->button_groups = $groups;

        return $this;
    }

    /**
     * Custom classes to attach to the button groups in the main part of the toolbar
     *
     * @param array $classes
     *
     * @return Toolbar
     */
    public function buttonGroupsClasses(array $classes) : Toolbar
    {
        $this->button_groups_classes = $classes;

        return $this;
    }

    /**
     * Custom classes to attach to the left button group
     *
     * @param array $classes
     *
     * @return Toolbar
     */
    public function buttonGroupClassesLeft(array $classes) : Toolbar
    {
        $this->button_group_classes_left = $classes;

        return $this;
    }

    /**
     * Custom classes to attach to the right button group
     *
     * @param array $classes
     *
     * @return Toolbar
     */
    public function buttonGroupClassesRight(array $classes) : Toolbar
    {
        $this->button_group_classes_right = $classes;

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
    public function buttonGroupLeft(array $group) : Toolbar
    {
        $this->button_group_left = $group;

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
    public function buttonGroupRight(array $group) : Toolbar
    {
        $this->button_group_right = $group;

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
        $this->button_groups = [];
        $this->button_groups_classes = [];
        $this->button_group_left = [];
        $this->button_group_right = [];
        $this->button_group_classes_left = [];
        $this->button_group_classes_right = [];
        $this->active = null;
    }

    /**
     * Worker method for the view helper, generates the HTML, the method is private so that we
     * can echo/print the view helper directly
     *
     * @return string
     */
    private function render() : string
    {
        $html = '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom mt5">';
        $html .= '
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarBottom" aria-controls="navbarBottom" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>';
        $html .= '
            <div class="collapse navbar-collapse" id="navbarBottom">';

        if (count($this->button_group_left) > 0) {
            $html .= '<div class="btn-group btn-group-sm">';
            foreach ($this->button_group_left as $button) {
                $html .= $this->button($button);
            }
            $html .= '</div>';
        }

        foreach ($this->button_groups as $section) {
            foreach ($section as $group) {
                if (count($group) > 0) {
                    $html .= '<div class="btn-group ' . implode(' ', $this->button_groups_classes) . '">';
                    foreach ($group as $button) {
                        $html .= $this->button($button);
                    }
                    $html .= '</div>';
                }
            }
        }

        if (count($this->button_group_right) > 0) {
            $html .= '<div class="btn-group btn-group-sm ml-auto">';
            foreach ($this->button_group_right as $button) {
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
