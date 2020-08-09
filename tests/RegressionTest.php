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

use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class RegressionTest extends TestCase
{
    public function testCSVImportWorksCorrectly()
    {
        $reg = new \mnshankar\LinearRegression\Regression();
        //dependent variable is vas1.. column number 1
        //independent columns are indep1, indep2, indep3 and indep4.. column numbers 9,10,11 and 12
        $reg->loadCSV('tests/testfile.csv', [1], [9, 10, 11, 12]);
        static::assertSame($this->getXForTesting(), $reg->getX());
        static::assertSame($this->getYForTesting(), $reg->getY());
    }

    public function testSimpleRegression()
    {
        $reg = new \mnshankar\LinearRegression\Regression();
        $reg->setX([[1, 1], [1, 2], [1, 3], [1, 4]]);
        $reg->setY([[2.5], [4], [5.5], [7]]);
        $reg->compute();
        static::assertSame([1.0, 1.5], $reg->getCoefficients());
    }

    public function testInvalidSetXException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $reg = new \mnshankar\LinearRegression\Regression();
        $reg->setX([]);
    }

    public function testInvalidSetYException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $reg = new \mnshankar\LinearRegression\Regression();
        $reg->setY([]);
    }

    public function testRegressionComputation()
    {
        $reg = new \mnshankar\LinearRegression\Regression();
        $reg->setX($this->getXForTesting());
        $reg->setY($this->getYForTesting());
        $reg->compute();
        static::assertEqualsWithDelta(0.3956, $reg->getRSquare(), .01);
        static::assertEqualsWithDelta(1.800187032, $reg->getF(), .01);
        static::assertSame(331.75, $reg->getSSTOScalar());
        static::assertSame(200.5, $reg->getSSEScalar());
        static::assertSame(131.25, $reg->getSSRScalar());
        static::assertEqualsWithDelta(0.628990651, $reg->getMultipleR(), .01);
        static::assertSame(16, $reg->getObservations());
        $stdErrors = $reg->getStdErrors();
        $pValues = $reg->getPValues();
        $tStat = $reg->getTStats();
        $coefficients = $reg->getCoefficients();
        //The values to test against is obtained from excel for this data.
        //refer to attached excel workbook Regression_Verification.xlsx
        $coefficientsToTest = [10, -1, 0.75, -2.5, 5];
        $stdErrorsToTest = [6.492346893, 2.134670509, 2.134670509, 2.134670509, 2.134670509];
        $tStatToTest = [1.54027506, -0.468456371, 0.351342278, -1.171140928, 2.342281855];
        $pValuesToTest = [0.151751456, 0.648604269, 0.731968834, 0.26628656, 0.039014953];
        static::assertEqualsWithDelta($coefficientsToTest, $coefficients, .01);
        static::assertEqualsWithDelta($stdErrorsToTest, $stdErrors, .01);
        static::assertEqualsWithDelta($tStatToTest, $tStat, .01);
        static::assertEqualsWithDelta($pValuesToTest, $pValues, .01);
    }

    /**
     * @return array
     */
    private function getXForTesting()
    {
        return [
            [1, 2, 1, 2, 2],
            [1, 2, 2, 2, 2],
            [1, 2, 1, 2, 1],
            [1, 2, 2, 2, 1],
            [1, 2, 1, 1, 2],
            [1, 2, 2, 1, 2],
            [1, 2, 1, 1, 1],
            [1, 2, 2, 1, 1],
            [1, 1, 1, 2, 2],
            [1, 1, 2, 2, 2],
            [1, 1, 1, 2, 1],
            [1, 1, 2, 2, 1],
            [1, 1, 1, 1, 2],
            [1, 1, 2, 1, 2],
            [1, 1, 1, 1, 1],
            [1, 1, 2, 1, 1],
        ];
    }

    /**
     * @return array
     */
    private function getYForTesting()
    {
        return [
            [12],
            [12],
            [13],
            [7],
            [21],
            [22],
            [9],
            [7],
            [9],
            [16],
            [11],
            [17],
            [16],
            [19],
            [13],
            [10],
        ];
    }
}
