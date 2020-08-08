<?php
/**
 * Contains class MatrixTest.
 *
 * PHP version 7.4
 *
 * LICENSE:
 * Copyright (c) 2015 Shankar Manamalkav <nshankar@ufl.edu>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    shankar<nshankar@ufl.edu>
 * @author    Michael Cummings<mgcummings@yahoo.com>
 * @copyright 2015 Shankar Manamalkav
 */

namespace Tests;

use mnshankar\LinearRegression\Matrix;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class MatrixTest extends TestCase
{
    public function testAdd()
    {
        $arr1 = [
            [1, 2, 3, 4],
            [4, 5, 6, 7],
        ];
        $arr2 = [
            [1, 2, 3, 4],
            [4, 5, 6, 7],
        ];

        $mat1 = new Matrix($arr1);
        $mat2 = new Matrix($arr2);
        $ret = $mat1->add($mat2);
        $testRet = [[2, 4, 6, 8], [8, 10, 12, 14]];
        static::assertSame($ret->getInnerArray(), $testRet);
    }

    public function testAddException()
    {
        $this->expectException(\DomainException::class);
        $arr1 = [
            [1, 2, 3, 4],
            [4, 5, 6, 7],
        ];
        $arr2 = [
            [1, 2, 3],
        ];
        $mat1 = new Matrix($arr1);
        $mat2 = new Matrix($arr2);
        $mat1->add($mat2);
    }

    public function testCanCreate2dMatrix()
    {
        $arr = [
            [1, 2],
            [3, 4],
        ];
        $m = new Matrix($arr);
        static::assertInstanceOf('mnshankar\LinearRegression\Matrix', $m);
    }

    public function testDeterminant()
    {
        $arr1 = [
            [1, 2],
            [3, 4],
        ];
        $mat1 = new Matrix($arr1);
        $det = $mat1->determinant();
        static::assertSame(-2, $det);
    }

    public function testDeterminantException()
    {
        $this->expectException(\RangeException::class);
        $arr1 = [
            [1, 2],
            [3, 4],
            [5, 6],
        ];
        $mat1 = new Matrix($arr1);
        $mat1->determinant();
    }

    public function testInvalidMatrixException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $arr = [
            [2, 3],
            [1],
        ];
        new Matrix($arr);
    }

    public function testInverse()
    {
        $arr1 = [
            [4, 3],
            [3, 2],
        ];
        $mat1 = new Matrix($arr1);
        $t = $mat1->inverse()
            ->getInnerArray();
        $exp = [
            [-2, 3],
            [3, -4],
        ];
        static::assertSame($exp, $t);
    }

    public function testInverseException()
    {
        $this->expectException(\RangeException::class);
        $arr1 = [
            [4, 3],
            [3, 2],
            [4, 5],
        ];
        $mat1 = new Matrix($arr1);
        $mat1->inverse();
    }

    /**
     * test console display function to ensure 100% code coverage.
     */
    public function testMatrixDisplay()
    {
        $arr = [
            [1, 2],
            [3, 4],
        ];
        $m = new Matrix($arr);
        $stringDisplay = $m->displayMatrix();
        static::assertSame("Order of the matrix is (2 rows X 2 columns)\n1, 2\n3, 4\n", $stringDisplay);
    }

    public function testMultiply()
    {
        $arr1 = [
            [2, 0, -1, 1],
            [1, 2, 0, 1],
        ];
        $arr2 = [
            [1, 5, -7],
            [1, 1, 0],
            [0, -1, 1],
            [2, 0, 0],
        ];
        $mat1 = new Matrix($arr1);
        $mat2 = new Matrix($arr2);
        $ret = $mat1->multiply($mat2);
        $testRet = [[4, 11, -15], [5, 7, -7]];
        static::assertSame($ret->getInnerArray(), $testRet);
    }

    public function testMultiplyException()
    {
        $this->expectException(\DomainException::class);
        $arr1 = [
            [2, 0, -1, 1],
            [1, 2, 0, 1],
        ];
        $arr2 = [
            [1, 5, -7],
            [1, 1, 0],
            [0, -1, 1],
        ];
        $mat1 = new Matrix($arr1);
        $mat2 = new Matrix($arr2);
        $mat1->multiply($mat2);
        //the above should throw an exception!
    }

    public function testNotSquare()
    {
        $arr = [[1, 2], [3, 4], [5, 6]];
        $m = new Matrix($arr);
        static::assertFalse($m->isSquareMatrix());
    }

    public function testSubtract()
    {
        $arr1 = [
            [1, 2, 3, 4],
            [4, 5, 6, 7],
        ];
        $arr2 = [
            [1, 2, 3, 4],
            [4, 5, 6, 7],
        ];
        $mat1 = new Matrix($arr1);
        $mat2 = new Matrix($arr2);
        $ret = $mat1->subtract($mat2);
        $testRet = [[0, 0, 0, 0], [0, 0, 0, 0]];
        static::assertSame($ret->getInnerArray(), $testRet);
    }

    public function testSubtractException()
    {
        $this->expectException(\DomainException::class);
        $arr1 = [
            [1, 2, 3, 4],
            [4, 5, 6, 7],
        ];
        $arr2 = [
            [1, 2, 3],
        ];
        $mat1 = new Matrix($arr1);
        $mat2 = new Matrix($arr2);
        $mat1->subtract($mat2);
    }

    public function testTranspose()
    {
        $arr1 = [
            [1, 2],
            [3, 4],
        ];
        $mat1 = new Matrix($arr1);
        $t = $mat1->transpose();
        $testArr = [[1, 3], [2, 4]];
        static::assertSame($t->getInnerArray(), $testArr);
    }
}
