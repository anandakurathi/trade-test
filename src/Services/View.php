<?php


namespace Src\Services;


use Exception;

class View
{
    /**
     * Render a view file
     * @param string $view The view file
     * @param array $args Associative array of data to display in the view (optional)
     */
    public static function render(string $view, array $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . '/Views/'.$view.'.php';

        if (is_readable($file)) {
            /** @noinspection PhpIncludeInspection */
            require $file;
        } else {
            self::render('404');
        }
    }

    /**
     * Include layout elements
     * @param $file
     * @return mixed
     */
    public static function includeLayoutElement($file)
    {
        $base = PATH.'Views/';
        if (is_readable($path = $base . ltrim($file, DS) . EXTENSION)) {
            /** @noinspection PhpIncludeInspection */
            return require $path;
        }
    }
}