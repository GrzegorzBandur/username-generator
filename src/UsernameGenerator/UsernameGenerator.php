<?php

namespace UsernameGenerator;

use UsernameGenerator\Service\VariationGeneratorGeneratorService;
use UsernameGenerator\Service\VariationGeneratorServiceInterface;
use UsernameGenerator\Service\StripingStringService;
use UsernameGenerator\Service\StripingStringServiceInterface;

class UsernameGenerator
{
    /** @var StripingStringServiceInterface */
    private $stripingStringService;
    /** @var VariationGeneratorServiceInterface */
    private $variationsGeneratorService;

    /**
     * UsernameGenerator constructor.
     * @param StripingStringServiceInterface|null $stripingStringService
     * @param VariationGeneratorServiceInterface|null $variationGeneratorService
     */
    public function __construct(
        StripingStringServiceInterface $stripingStringService = null,
        VariationGeneratorServiceInterface $variationGeneratorService = null
    ) {
        $this->stripingStringService = $stripingStringService ?? new StripingStringService();
        $this->variationsGeneratorService = $variationGeneratorService ?? new VariationGeneratorGeneratorService();
    }
    /**
     * @param $array
     * @param int $amount
     * @return array
     */
    public function generate(array $array, int $amount = 5): array
    {
        $array = $this->stripingStringService->strip($array);
        return $this->variationsGeneratorService->generate($array, $amount);
    }
}
