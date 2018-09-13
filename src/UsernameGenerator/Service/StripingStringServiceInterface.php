<?php

namespace UsernameGenerator\Service;

interface StripingStringServiceInterface
{
    /**
     * @param array $array
     * @return array
     */
    public function strip(array $array) : array;
}
