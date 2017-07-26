<?php

if (!function_exists('twigJsHelper')) {
    function twigJsHelper($s)
    {
        return new \yii\web\JsExpression($s);
    }
    function twigPhpFunctionHelper($args, $code)
    {
        return create_function($args, $code);
    }

    /**
     * @param \yii\web\View $view
     * @param string $viewFile
     * @param array $names
     * @return callable
     */
    function renderCallback($view, $viewFile, $names)
    {
        return function () use ($view, $viewFile, $names) {
            return $view->render($viewFile, array_combine($names, func_get_args()));
        };
    }

    function fixErrors($s) {
        if (preg_match_all('#<li>.*?</li>#m', $s, $m)) {
            return preg_replace('#<li>.*</li>#sm', implode("\n", array_unique($m[0])), $s);
        }

        return $s;
    }

    function shortText($s, $length = 150) {
        $text = strip_tags($s);

        if (mb_strlen($text) > $length) {
            preg_match('/^(.*?)(\.\s[A-ZА-Я0-9]|\.?\s*$)/u', mb_substr($text, $length), $m);

            return mb_substr($text, 0, $length) . (array_key_exists(1, $m) ? $m[1] : '') . '.';
        } else {
            return $text;
        }
    }

    function filterArray($v) {
        return array_filter((array)$v);
    }
}

return [
    'class' => '\components\View',
    'defaultExtension' => 'twig',
    'renderers' => [
        'twig' => [
            'class' => 'yii\twig\ViewRenderer',
            'cachePath' => '@runtime/Twig/cache',
            'options' => ['auto_reload' => true],
            'globals' => [
                'html' => '\frontend\components\HtmlHelper',
                'url' => '\yii\helpers\Url'
            ],
            'functions' => [
                'js' => 'twigJsHelper',
                'phpFunc' => 'twigPhpFunctionHelper',
                'renderCallback' => 'renderCallback',
                'pr' => 'var_dump',
                'fixErrors' => 'fixErrors'
            ],
            'filters' => [

            ],
        ]
    ]
];
