<?php

namespace jedlikowski\WP_Router;

/**
 * Class Router
 * Uses WP Rewrite API to handle requests to specified URIs.
 * These URIs don't need to exist in WP (don't need to be a post or a page previously created)
 */
class Router
{
    private $routes = [];
    private $queryVar = "router_route";
    private $wildcardRoute = "([a-zA-Z0-9\/-]+)";

    /**
     * Router constructor.
     * @param array $routes Array of routes for user to mock in the WP environment
     * @throws \Exception
     */
    public function __construct(array $routes = [])
    {
        if (is_admin()) { // Custom routes are for the front-end only
            return;
        }
        if (isset($GLOBALS["WP_Router"])) {
            throw new \Exception("Only one WP_Router instance is allowed.");
        }

        foreach ($routes as $route => $routeHandler) {
            // Clean routes urls

            // Remove / at the beginning of the url, add it at the end
            $route = ltrim(trailingslashit(esc_url($route, null, '')), "/");
            if (empty($route) || $route === "/") {
                unset($routes[$route]);
                continue;
            }

            if (!is_string($routeHandler)) {
                unset($routes[$route]);
                continue;
            }

            $routeIsCallable = false;
            if (strpos($routeHandler, "@") === false) {
                $routeIsCallable = is_callable($routeHandler);
            } else {
                $routeCallback = explode("@", $routeHandler);
                if (class_exists($routeCallback[0]) && !empty($routeCallback[1])) {
                    $routeIsCallable = is_callable($routeCallback[0], $routeCallback[1]);
                }
            }

            if (!$routeIsCallable) {
                unset($routes[$route]);
                continue;
            }
            $this->routes[$route] = $routeHandler;
        }

        if (!empty($this->routes)) {
            $GLOBALS["WP_Router"] = $this;
            add_action("init", [$this, "setRewriteRules"]);
            add_filter("query_vars", [$this, "setQueryVars"]);
            add_action('template_redirect', [$this, "renderRoute"]);
        }
    }

    /**
     * setRewriteRules - adds necessary rewrite rules for requests to match our custom routes
     */
    public function setRewriteRules()
    {
        $baseRule = "(%route%/?(\?([\w-]+(=[\w-]*)?(&[\w-]+(=[\w-]*)?)*)?)?)$";
        $baseRewrite = "index.php?" . $this->queryVar . "=\$matches[1]";
        $rewriteRules = [];
        $rulesShouldBeFlashed = false;
        global $wp_rewrite;
        $currentRules = $wp_rewrite->wp_rewrite_rules();
        foreach ($this->routes as $route => $routeHandler) {
            $routeForRule = str_replace("*", $this->wildcardRoute, $route);
            $rule = str_replace("%route%", rtrim($routeForRule, "/"), $baseRule);
            $rewrite = str_replace("%route%", $route, $baseRewrite);
            $rewriteRules[$rule] = $rewrite;
        }
        foreach ($rewriteRules as $rule => $rewrite) {
            if (!isset($currentRules[$rule]) || $currentRules[$rule] !== $rewrite) {
                $rulesShouldBeFlashed = true;
            }
            add_rewrite_rule(
                $rule,
                $rewrite,
                'top'
            );
        }
        if ($rulesShouldBeFlashed) {
            flush_rewrite_rules();
        }
    }

    public function setQueryVars($vars)
    {
        $vars[] = $this->queryVar;
        return $vars;
    }

    /**
     * renderRoute - renders the contents of the matched route.
     * It checks if the callback specified as route render callback is callable
     * and then calls it with the route as parameter
     */
    public function renderRoute()
    {
        global $post;
        $post = null;

        $requestedRoute = get_query_var($this->queryVar);
        if (!$requestedRoute || empty($requestedRoute)) {
            return;
        }

        $requestedRoute = trailingslashit($requestedRoute);
        $routeHandler = $this->getRouteHandler($requestedRoute);

        // Route hasn't been found, send 404 header and render 404 template
        if (!$routeHandler) {
            static::set404();
        }

        if (strpos($routeHandler, "@") === false && is_callable($routeHandler)) {
            return $this->callRouteHandler($routeHandler, $requestedRoute);
        }
        $routeCallback = explode("@", $routeHandler);
        $class = $routeCallback[0];
        $method = empty($routeCallback[1]) ? null : $routeCallback[1];

        if (!class_exists($class) || empty($method)) {
            return;
        }

        $reflectionClass = new \ReflectionClass($class);
        if (!$reflectionClass->hasMethod($method)) {
            return;
        }

        $methodChecker = new \ReflectionMethod($class, $method);
        if ($methodChecker->isStatic()) {
            return $this->callRouteHandler([$class, $method], $requestedRoute);
        } else {
            $instance = new $class;
            return $this->callRouteHandler([$instance, $method], $requestedRoute);
        }
    }

    private function callRouteHandler($routeHandler, $route)
    {
        $route = '/' . trim($route, '/');
        do_action("WP_Router_before_render_route", $route);
        call_user_func($routeHandler, $route);
        exit;
    }

    /**
     * @param $requestedRoute
     * @return bool|mixed
     */
    public function getRouteHandler($requestedRoute)
    {
        foreach ($this->routes as $route => $routeHandler) {
            if ($requestedRoute === $route) {
                return $routeHandler;
            }
            if (strpos($route, "*") !== false) {

                $regexMatches = [];
                $route = str_replace("*", $this->wildcardRoute, $route);
                preg_match("~" . $route . "~", $requestedRoute, $regexMatches);
                if (!empty($regexMatches)) {
                    return $routeHandler;
                }
            }
        }
        return false;
    }

    /**
     * @param bool $show404Page Whether to render wp template for 404 page or show default browser 404 page
     */
    public static function set404($show404Page = true)
    {
        global $wp_query;
        $wp_query->set_404();
        $wp_query->posts = [];
        status_header(404);
        if ($show404Page) {
            get_template_part(404);
        }
        exit;
    }
}
