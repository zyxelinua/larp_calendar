<?php

namespace App\Twig;

class StringUtilsExtension extends \Twig_Extension
{
    /** {@inheritDoc} */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('cut', [$this, 'cut']),
            new \Twig_SimpleFilter('link', [$this, 'link']),
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

    public static function link($string)
    {
        $string = str_replace("\r\n", ' ', $string);
        $string = str_replace("\n", ' ', $string);
        $words = explode(' ', $string);
        foreach ($words as $word) {
            if ((strpos($word, 'https://') !== false) || (strpos($word, 'http://') !== false)) {
                $result[] = '<a href="' . $word . '">' . $word . "</a>";
            } else {
                $result[] = $word;
            }
        }
        return implode(' ', $result);
    }
}
