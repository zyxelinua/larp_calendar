<?php

namespace App\Twig;

class StringUtilsExtension extends \Twig_Extension
{
    /** {@inheritDoc} */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('cut', [$this, 'cut']),
        ];
    }

    /**
     * @param string $string
     * @param int $length
     * @return string
     */
    public static function cut($string, $length = 600)
    {
        return (mb_strlen($string) > $length)
            ? mb_substr($string, 0, $length - 4) . " ..."
            : $string
        ;
    }
}
