<?php

namespace plugin\name;

/**
 * Class Loader
 *
 * Manages hooks and actions for the Plugin Name plugin.
 *
 * @package plugin\name
 */
class Loader {

    /**
     * Array to store registered actions.
     *
     * @var array
     */
    protected $actions;

    /**
     * Array to store registered filters.
     *
     * @var array
     */
    protected $filters;

    /**
     * Constructor initializes the actions and filters arrays.
     */
    public function __construct() {
        $this->actions = array();
        $this->filters = array();
    }

    /**
     * Register an action to WordPress.
     *
     * @param string   $hook         The name of the WordPress action to which the $component is hooked.
     * @param object   $component    A reference to the instance of the object on which the action is defined.
     * @param string   $callback     The name of the function definition on the $component.
     * @param int      $priority     The priority at which the function should be executed.
     * @param int      $accepted_args The number of arguments the function accepts.
     */
    public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
    }

    /**
     * Register a filter to WordPress.
     *
     * @param string   $hook         The name of the WordPress filter to which the $component is hooked.
     * @param object   $component    A reference to the instance of the object on which the filter is defined.
     * @param string   $callback     The name of the function definition on the $component.
     * @param int      $priority     The priority at which the function should be executed.
     * @param int      $accepted_args The number of arguments the function accepts.
     */
    public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
    }

    /**
     * Add a hook to the respective array.
     *
     * @param array    $hooks        The array of hooks (actions or filters) to which the hook is added.
     * @param string   $hook         The name of the WordPress hook.
     * @param object   $component    A reference to the instance of the object on which the hook is defined.
     * @param string   $callback     The name of the function definition on the $component.
     * @param int      $priority     The priority at which the function should be executed.
     * @param int      $accepted_args The number of arguments the function accepts.
     *
     * @return array Updated array of hooks.
     */
    private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {
        $hooks[] = array(
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        );

        return $hooks;
    }

    /**
     * Run the registered actions and filters.
     */
    public function run() {
        // Register filters
        foreach ( $this->filters as $hook ) {
            add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }

        // Register actions
        foreach ( $this->actions as $hook ) {
            add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }
    }

}
