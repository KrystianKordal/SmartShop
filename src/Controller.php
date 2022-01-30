<?php

namespace SmartShop;

use SmartShop\Controller\ProductListingController;

/**
 * Processing queries and displaying content
 */
abstract class Controller
{
    /** @var array Variables passed to template */
    protected $tpl_vars = [];

    /** @var string Template name */
    protected $template;

    /** @var array List of hooks */
    public static $hooks = [];

    public function init()
    {
        $output = $this->postProcess();
        $output .= $this->display();

        return $output;
    }

    /**
     * Displays content
     */
    public function display()
    {
        return getTemplate($this->template, $this->tpl_vars);
    }

    /**
     * Processing POST requests
     */
    public function postProcess()
    {
        
    }

    /**
     * Adds variables to tpl vars
     * 
     * @param array $vars Array with vars to assign
     */
    protected function assignTplVars($vars) 
    {
        $this->tpl_vars = array_merge($this->tpl_vars, $vars);
    }
}