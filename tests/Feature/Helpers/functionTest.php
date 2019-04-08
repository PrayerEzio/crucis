<?php

namespace Tests\Feature\Helpers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class functionTest extends TestCase
{
    public function testBubbleSort()
    {
        $arr = range(1, 10);
        shuffle($arr);
        $resort_array = bubbleSort($arr);
        $this->assertTrue([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] == $resort_array);
    }

    public function testQuickSort()
    {
        $arr = range(1, 10);
        shuffle($arr);
        $resort_array = quickSort($arr);
        $this->assertTrue([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] == $resort_array);
    }

    public function testSelectionSort()
    {
        $arr = range(1, 10);
        shuffle($arr);
        $resort_array = selectionSort($arr);
        $this->assertTrue([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] == $resort_array);
    }

    public function testShellSort()
    {
        $arr = range(1, 10);
        shuffle($arr);
        $resort_array = shellSort($arr);
        $this->assertTrue([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] == $resort_array);
    }

    public function testMergeSort()
    {
        $arr = range(1, 10);
        shuffle($arr);
        $resort_array = mergeSort($arr);
        $this->assertTrue([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] == $resort_array);
    }
}
