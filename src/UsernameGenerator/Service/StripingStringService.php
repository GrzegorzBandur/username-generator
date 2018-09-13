<?php

namespace UsernameGenerator\Service;

class StripingStringService implements StripingStringServiceInterface
{
    /**
     * @param array $array
     * @return array
     */
    public function strip(array $array): array
    {
        foreach ($array as $key => &$value) {
            $this->stripEmailDomainPart($value);
            $matches = preg_split("/[\s.]+/", $value);
            if (count($matches) > 1) {
                unset($array[$key]);
                $array=array_merge($array, $this->strip($matches));
                continue;
            }
            $this->toLower($value);
            $this->stripForCharacters($value);
        }
        return $array;
    }

    /**
     * @param string $value
     */
    private function stripEmailDomainPart(string &$value)
    {
        if ($posAt = strpos($value, '@')) {
            $value = substr($value, 0, $posAt);
        }
    }

    /**
     * @param string $value
     */
    private function toLower(string &$value)
    {
        $value = strtolower($value);
    }

    /**
     * @param string $value
     */
    private function stripForCharacters(string &$value)
    {
        $value = preg_replace("/[^a-z0-9]+/", "", $value);
    }
}
