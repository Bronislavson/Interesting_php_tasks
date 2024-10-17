<?php

/* Задача 2
*   Проверка на похожесть слов
*    Checking for similarity of words
*   
*   Некоторые слова выглядят одинаково, если заменить русскую букву на английскую и наоборот. Например,
*   русская и английская буквы "o", а также "H" и другие, совпадают. Это может создать проблемы на сайте,
*   к примеру, можно зарегистрировать два "одинаковых" ника с буквами из разных языков и писать от чужого имени.
*   
*   Напишите функцию, которая сравнивает строки, учитывая язык - строки, написанные буквами разных языков,
*   но выглядящие одинаково, следует признать равными. Для простоты берем только русский и английский языки.
*/

function normalizeString($string) {
    // Массив соответствий русских и английских букв
    $transliteration = [
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g',
        'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k',
        'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
        'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ъ' => '',
        'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        
        'A' => 'а', 'B' => 'б', 'C' => 'ц', 'E' => 'е',
        'H' => 'н', 'K' => 'к', 'M' => 'м', 'O' => 'о',
        'P' => 'р', 'T' => 'т', 'Y' => 'у'
    ];

    // Заменяем буквы
    $normalizedString = strtr($string, $transliteration);
    
    // Приводим к нижнему регистру для корректного сравнения
    return mb_strtolower($normalizedString);
}

function areSimilar($string_1, $string_2) {
    return normalizeString($string_1) === normalizeString($string_2);
}

// Примеры использования
$string_1 = "привет";
$string_2 = "privet";

if (areSimilar($string1, $string2)) {
    echo "Строки похожи.";
} else {
    echo "Строки не похожи.";
}

// Проверка
var_dump(areSimilar("привет", "privet")); // true
var_dump(areSimilar("шашка", "shashka")); // true
var_dump(areSimilar("удивительный", "udivitelnyy")); // true
var_dump(areSimilar("хряк", "hryak")); // false

