<?php

namespace Tests;

use UsernameGenerator\Service\StripingStringService;
use UsernameGenerator\UsernameGenerator;
use PHPUnit_Framework_TestCase;

class UserNameGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getSpecificationTests()
    {
        return [
            [["Efren", "Reyes", "bata", 1954]],
            [["Strickland", "earl.strickland@gmail.com"]],
            [["Francisco", "Bustamante"]],
            [["Ronnie O’Sullivan"]],
            [["a"]],
        ];
    }

    /**
     * @return array
     */
    public function getSetNoItems()
    {
        return [[2], [3], [4], [5], [1], [0], [-1]];
    }

    /**
     * @dataProvider getSetNoItems
     * @param int $i
     */
    public function testReturnNOSetItems(int $i)
    {
        $userNameGenerator =  new UsernameGenerator();
        $permutation = $userNameGenerator->generate(["one"], $i);
        $this->assertEquals($i > 0 ? $i : 0, count($permutation), "Number of items returned don't match set number of items");
        $permutation = $userNameGenerator->generate(["one", "two"], $i);
        $this->assertEquals($i > 0 ? $i : 0, count($permutation), "Number of items returned don't match set number of items");
        $permutation = $userNameGenerator->generate(["one", "two", "three"], $i);
        $this->assertEquals($i > 0 ? $i : 0, count($permutation), "Number of items returned don't match set number of items");
    }

    /**
     * @dataProvider getSpecificationTests
     * @param array $array
     */
    public function testReturnNotSetNoItems(array $array)
    {
        $userNameGenerator =  new UsernameGenerator();
        $userNames = $userNameGenerator->generate($array);
        $this->assertEquals(5, count($userNames), "Number of items returned don't match default value 5");
    }

    /**
     * @dataProvider getSpecificationTests
     * @param array $array
     */
    public function testReturnProperValues(array $array)
    {
        $userNameGenerator =  new UsernameGenerator();
        $stripingService =  new StripingStringService();
        $strippedArray = $stripingService->strip($array);
        $userNames = $userNameGenerator->generate($array, 5);
        foreach ($userNames as $value) {
            $this->assertLessThanOrEqual(25, strlen($value), "Returned username is to long");
            $this->assertGreaterThanOrEqual(3, strlen($value), "Returned username is to short");
            $this->assertRegExp(
                '/^([a-z0-9]+_{0,1}[a-z0-9]+)/',
                $value,
                "Returned username doesn't match regex"
            );
            if (!preg_match('/^[0-9]+$/', $value)) {
                $isStringContainsItemFromArray=false;
                foreach ($strippedArray as $item) {
                    if (strpos($value, $item)>-1) {
                        $isStringContainsItemFromArray=true;
                    }
                }
                $this->assertTrue($isStringContainsItemFromArray, "Returned username don't contain provided values");
            }
        }
    }
}
