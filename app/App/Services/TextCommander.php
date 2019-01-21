<?php

namespace App\App\Services;

use Opis\Pattern\RegexBuilder;
use Psr\Container\ContainerInterface;

class TextCommander {
    protected $builder;
    protected $routes = [];

    public function __construct()
    {
        $this->builder = new RegexBuilder([RegexBuilder::REGEX_MODIFIER=>'i']);
    }

    public function register(string $route, callable $action): self
    {
        // Generate a regex for the route
        $regex = $this->builder->getRegex($route);

        // Save the regex and the action
        $this->routes[$regex] = $action;

        return $this;
    }

    public function execute(string $path)
    {
        // We reverse the routes order, so the last registered
        // is the first called
        $ordered_routes = array_reverse($this->routes, true);
        
        // Loop through all routes until one is matched
        foreach ($ordered_routes as $regex => $action) {
            if ($this->builder->matches($regex, $path)) {
                // Get the values of placeholders
                $values = $this->builder->getValues($regex, $path);

                // Invoke the action
                $data = $action($path, $values);
                
                // If the action returned false, 
                // we continue to search for another route
                if ($data === false) {
                    continue;
                }
                
                return $data;
            }
        }

        // Nothing matched
        return false;
    }
}