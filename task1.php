<?php
/* 
*Задача 1
*Проверка на степень
*
*Проверьте, что целое число является степенью другого целого числа. Например, 4 - вторая степень двойки, 9
*вторая степень тройки, 16 - одновременно степень и двойки и четверки. Результатом верните все варианты  *разложения числа на основание степени и ее показатель.
*/

function isDegreeOfNumber(int $number): array
{
    $result = [];
    
    for ($start = 2; $start <= (int)sqrt($number); $start++) {
        //$start <= (int)sqrt($number) основание `$start` будет увеличиваться, пока оно меньше
        //или равно квадратному корню из исходного числа `$number`.
        $exponent = 1;
        $degree = $start;

        while ($degree <= $number) {
            if ($degree == $number) {
                $result[] = ["start" => $start, "exponent" => $exponent];
            }
            $exponent++;
            $degree *= $start;
        }
    }

    return $result;
}

print_r(isDegreeOfNumber(16));

/* 
Array
(
    [0] => Array
        (
            [start] => 2
            [exponent] => 4
        )

    [1] => Array
        (
            [start] => 4
            [exponent] => 2
        )

)
*/