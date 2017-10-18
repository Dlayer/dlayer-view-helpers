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
     * @var array Classes for the component sections
     */
    private $classes;

    /**
     * @var array Tool groups
     */
    private $tool_groups;

    /**
     * @var array Bootstrap styles
     */
    protected $supported_text_styles = [
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'light',
        'dark'
    ];

    /**
     * @var array Bootstrap styles
     */
    protected $supported_background_styles = [
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'light',
        'dark',
        'white'
    ];

    /**
     * @var integer Active button id
     */
    private $active;

    /**
     * @var string Id for navbar, needs to be unique if there are multiple navbars in the same view
     */
    private $id;

    /**
     * @var array Have custom options been set?
     */
    private $options_set;

    /**
     * @var string Base uri for all links
     */
    private $base_uri;

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
     * Override the __toString() method to allow echo/print of the view helper directly, saves a
     * call to render()
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->render();
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
        $this->tool_groups['main'] = $groups;

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
        $this->tool_groups['left'] = $group;

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
        $this->tool_groups['right'] = $group;

        return $this;
    }

    /**
     * Collapse the navbar below lg
     *
     * @return Toolbar
     */
    public function collapseBelowLg()
    {
        $this->options_set['expand'] = true;
        $this->classes['main']['expand'] = 'navbar-expand-lg';

        return $this;
    }

    /**
     * Collapse the navbar below md
     *
     * @return Toolbar
     */
    public function collapseBelowMd()
    {
        $this->options_set['expand'] = true;
        $this->classes['main']['expand'] = 'navbar-expand-md';

        return $this;
    }

    /**
     * Collapse the navbar below sm
     *
     * @return Toolbar
     */
    public function collapseBelowSm()
    {
        $this->options_set['expand'] = true;
        $this->classes['main']['expand'] = 'navbar-expand-sm';

        return $this;
    }

    /**
     * Collapse the navbar below xl
     *
     * @return Toolbar
     */
    public function collapseBelowXl()
    {
        $this->options_set['expand'] = true;
        $this->classes['main']['expand'] = 'navbar-expand-xl';

        return $this;
    }

    /**
     * Attach the dark navbar style for when you are using a light background colour
     *
     * @return Toolbar
     */
    public function dark() : Toolbar
    {
        $this->options_set['style'] = true;
        $this->classes['main']['style'] = 'navbar-dark';

        return $this;
    }

    /**
     * Fixed bottom layout
     *
     * @return Toolbar
     */
    public function fixedBottom() : Toolbar
    {
        $this->classes['main'][] = 'fixed-bottom';

        return $this;
    }

    /**
     * Fixed top layout
     *
     * @return Toolbar
     */
    public function fixedTop() : Toolbar
    {
        $this->classes['main'][] = 'fixed-top';

        return $this;
    }

    /**
     * Attach the light navbar style for when you are using a dark background colour
     *
     * @return Toolbar
     */
    public function light() : Toolbar
    {
        $this->options_set['style'] = true;
        $this->classes['main']['style'] = 'navbar-light';

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
     * Set the background color for the component, need to be one of the following, primary, secondary, success, danger,
     * warning, info, light, dark or white, if an incorrect style is passed in we don't apply the class.
     *
     * @param string $color
     *
     * @return Toolbar
     */
    public function setBgStyle(string $color) : Toolbar
    {
        $this->assignBackgroundStyle($color);

        return $this;
    }

    /**
     * Set the base uri for any links
     *
     * @param string $uri
     *
     * @return Toolbar
     */
    public function setBaseUri(string $uri) : Toolbar
    {
        $this->base_uri = $uri;

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
        $this->classes['left'] = $classes;

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
        $this->classes['right'] = $classes;

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
        $this->classes['groups'] = $classes;

        return $this;
    }

    /**
     * Set the text color for the component, need to be one of the following, primary, secondary, success, danger,
     * warning, info, light or dark, if an incorrect style is passed in we don't apply the class.
     *
     * @param string $color
     *
     * @return Toolbar
     */
    public function setTextStyle(string $color) : Toolbar
    {
        $this->assignTextStyle($color);

        return $this;
    }

    /**
     * Sticky top layout
     *
     * @return Toolbar
     */
    public function stickyTop() : Toolbar
    {
        $this->classes['main'][] = 'sticky-top';

        return $this;
    }

    /**
     * Validate and assign the background colour, needs to be one of the following, primary, secondary, success, danger,
     * warning, info, light, dark or white, if an incorrect style is passed in we don't apply the class.
     *
     * @param string $color
     */
    protected function assignTextStyle(string $color)
    {
        if (in_array($color, $this->supported_text_styles) === true) {
            $this->classes['main'] = $color;
        }
    }

    /**
     * Validate and assign the text colour, needs to be one of the following, primary, secondary, success, danger,
     * warning, info, light or dark, if an incorrect style is passed in we don't apply the class.
     *
     * @param string $color
     */
    protected function assignBackgroundStyle(string $color)
    {
        if (in_array($color, $this->supported_text_styles) === true) {
            $this->options_set['background'] = true;
            $this->classes['main'] = $color;
        }
    }

    /**
     * Generate the classes string for the toolbar based on the set properties, default values are used if
     * options haven't been set
     *
     * @return string
     */
    private function classes()
    {
        $classes = [ 'navbar' ];

        if ($this->options_set['expand'] === false) {
            $classes[]= 'navbar-expand-lg';
        }

        if ($this->options_set['style'] === false) {
            $classes[] = 'navbar-dark';
        }

        if ($this->options_set['background'] === false) {
            $classes[] = 'bg-dark';
        }

        return implode(' ', array_merge($classes, $this->classes['main']));
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

        $glyph = '';
        if (array_key_exists('fa-glyphs', $button) === true) {
            $glyph = '<i class="fa ' . implode(' ', $button['fa-glyphs']) .
                '" aria-hidden="true"></i> ';
        }

        return '<a class="' . $classes . '" href="' . (($this->base_uri !== null) ? $this->base_uri : null) .
            $button['id'] . '">' . $glyph . $button['name'] . '</a>';
    }

    /**
     * Worker method for the view helper, generates the HTML, the method is private so that we
     * can echo/print the view helper directly
     *
     * @return string
     */
    private function render() : string
    {
        $html = '<nav class="' . $this->classes() . '">';
        $html .= '<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#' .
            $this->id . '" aria-controls="' . $this->id .
            '" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
        $html .= '<div class="collapse navbar-collapse" id="' . $this->id . '">';

        if (count($this->tool_groups['left']) > 0) {
            $html .= '<div class="' . implode(' ', $this->classes['left']) . '">';
            foreach ($this->tool_groups['left'] as $button) {
                $html .= $this->button($button);
            }
            $html .= '</div>';
        }

        foreach ($this->tool_groups['main'] as $group) {
            if (count($group) > 0) {
                $html .= '<div class="' . implode(' ', $this->classes['groups']) . '">';
                foreach ($group as $button) {
                    $html .= $this->button($button);
                }
                $html .= '</div>';
            }
        }

        if (count($this->tool_groups['right']) > 0) {
            $html .= '<div class="' . implode(' ', $this->classes['right']) . '">';
            foreach ($this->tool_groups['right'] as $button) {
                $html .= $this->button($button);
            }
            $html .= '</div>';
        }

        $html .= '</div></nav>';

        return $html;
    }

    /**
     * Reset all properties in case the view helper is called multiple times within a script
     *
     * @return void
     */
    private function reset() : void
    {
        $this->options_set = [
            'expand' => false,
            'style' => false,
            'background' => false,
            'text' => false
        ];

        $this->classes = [
            'main' => [ ],
            'groups' => [ 'btn-group' ],
            'left' => [ 'btn-group' ],
            'right' => [ 'btn-group' ]
        ];

        $this->tool_groups = [
            'main' => [],
            'left' => [],
            'right' => []
        ];

        $this->active = null;
        $this->id = null;
        $this->base_uri = null;
    }
}
