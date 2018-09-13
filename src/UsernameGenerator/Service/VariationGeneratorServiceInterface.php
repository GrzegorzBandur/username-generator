<?php

namespace UsernameGenerator\Service;

interface VariationGeneratorServiceInterface
{
    /**
     * @param array $array
     * @param int $amount
     * @return array
     */
    public function generate(array $array, int $amount = 5) : array;
}
