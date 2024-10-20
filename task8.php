<?php

/* 
Задача 8
"Нарастающее разбиение строки"

Дана строка с любыми символами. Для примера пусть будет такая:
'1234567890'

Нужно разбить строку в массив таким образом:
['1', '23', '456', '7890']

И так далее, пока символы в строке не закончатся.
*/

/* 
// Тут представлен супер короткий код....
$str = '1234567890';
$countStr = strlen($str);
$result = [];
for ($i = 0, $c = 1; $i < $countStr; $i += $c, $c++) {
 $result[] = substr($str, $i, $c);
}
print_r($result); */


$str = '1234567890';
$countStr = strlen($str);
$result = [];
// инициализируем $c, которая отвечает за длину отрезаемой подстроки на каждой итерации
$c = 1;
$i = 0;

while ($i < $countStr) {
    // ф-ция substr() извлекает подстроки из строки $str, начинаяс индекса $i и длиной $c 
    $result[] = substr($str, $i, $c);
    $i += $c; // сдвигаем $i на $c символов
    $c++;     // увеличиваем $c для следующего отрезка
}

print_r($result);

/* 
Вывод
Array
(
    [0] => 1
    [1] => 23
    [2] => 456
    [3] => 7890  
)
*/