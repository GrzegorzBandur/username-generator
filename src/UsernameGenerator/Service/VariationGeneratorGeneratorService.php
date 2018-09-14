<?php

namespace UsernameGenerator\Service;

class VariationGeneratorGeneratorService implements VariationGeneratorServiceInterface
{
    /** var array */
    private $glueArray;

    public function __construct(array $glueArray = ["", "_"])
    {
        $this->glueArray = $glueArray;
    }

    /**
     * @param array $array
     * @param int $amount
     * @param int $minLength
     * @param int $maxLength
     * @return array
     */
    public function generate(array $array, int $amount = 5, int $minLength = 3, int $maxLength = 25): array
    {
        if ($amount < 1 ) {
            return array();
        }
        $elements = $this->doGenerate($array, $amount, $minLength, $maxLength);
        if (count($elements) < $amount) {
            while (count($elements) < $amount) {
                $elements[] = (string) mt_rand(10000000, 999999999);
            }
        }
        return $elements;
    }

    /**
     * @param array $array
     * @param int $amount
     * @param int $minLength
     * @param int $maxLength
     * @return array
     */
    private function doGenerate(array $array, int $amount = 5, int $minLength = 3, int $maxLength = 25): array
    {
        $result = array();
        foreach ($array as $key => $word) {
            $this->addWordToResultIfConditionsMet(
                $word,
                $result,
                $minLength,
                $maxLength,
                $amount
            );
            foreach ($this->doGenerate(
                array_diff_key($array, array($key => $word)),
                $amount,
                $minLength,
                $maxLength
            ) as $generatedWord) {
                if (count($result) >= $amount) {
                    return array_values($result);
                }
                foreach ($this->glueArray as $glue) {
                    $this->addWordToResultIfConditionsMet(
                        $word . $glue . $generatedWord,
                        $result,
                        $minLength,
                        $maxLength,
                        $amount
                    );
                }
            }
        }
        return array_values($result);
    }

    /**
     * @param string $word
     * @param array $result
     * @param int $minLength
     * @param int $maxLength
     * @param int $maxAmount
     */
    private function addWordToResultIfConditionsMet(
        string $word,
        array &$result,
        int $minLength,
        int $maxLength,
        int $maxAmount
    ) {
        if (strlen($word) >= $minLength
            && strlen($word) <=$maxLength
            && count($result) < $maxAmount) {
            $result[$word] = $word;
        }
    }
}
