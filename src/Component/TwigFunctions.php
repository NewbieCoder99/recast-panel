<?php

namespace App\Component;

use Twig_Extension;

/**
 * Class TwigFunctions
 * @author Soner Sayakci <shyim@posteo.de>
 */
class TwigFunctions extends Twig_Extension
{
    public function getFunctions() : array
    {
        return [
            new \Twig_SimpleFunction('md5', [$this, 'md5'], [
                'is_safe' => ['html'],
            ])
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('encode', [$this, 'encode'], [
                'is_safe' => ['html'],
            ])
        ];
    }


    /**
     * @param string $string
     * @author Soner Sayakci <shyim@posteo.de>
     * @return string
     */
    public function md5($string): string
    {
        return md5($string);
    }

    /**
     * @param $string
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function encode($string): string
    {
        return json_encode($string, JSON_PRETTY_PRINT);
    }
}