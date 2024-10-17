<?php

/* Задача 3
Подсчет цифр в массиве

Дан массив с числами. Подсчитайте количество цифр 3 в данном массиве. Например, в следующем массиве их пять:

[10, 13, 35, 3, 433] 
*/

//создадим функцию countThrees, которая примет в себя массив
function countThrees($array) {
    //инициализация переменной, которая будет хранить общее количество цифр '3'
    $count = 0;

    //перебор каждого элемента массива и сохранение этого элемента в переменную $num
    foreach ($array as $num) {
        //с помощью strval преобразуем число в строку (теперь можем искать символы в строковом представлении)
        $strNum = strval($num);
        //с помощью substr_count подсчитаем количество цифр '3' в строке и прибавим их к count
        $count += substr_count($strNum, '3');
    }

    return $count;
}

// Пример использования
//Создадим массив с числами, содержащими тройки
$array = [3, 13, 35, 3, 433];
//выводим количество цифр три с помощью функции countThrees
echo "Количество цифр '3': " . countThrees($array);