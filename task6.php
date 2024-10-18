<?php

/* 
Задача 6
Названия файлов транслитом

Пусть есть папка с файлами, названия которых даны на русском языке.
Преобразуйте русский текст в названиях файлов в его транслит.
*/

//для корректной работы создал в основном корне папку task6
//а в этой папке 3 файла пример1.txt пример2.php пример3.js

//Вариант 1

//функция transliterate, которая принимает один аргумент - строку $text.
/* function transliterate($text) {
    //массив $transliteration, который представляет собой словарь замены. Он содержит пары "русская буква" => "английский эквивалент"
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
        
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
        'Д' => 'D', 'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K',
        'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
        'У' => 'U', 'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch', 'Ъ' => '',
        'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya'
    ];

    //strtr()  заменяет все русские буквы в $text на их английские эквиваленты из $transliteration
    return strtr($text, $transliteration);
}

//функция transliterateFilesInDirectory, которая принимает один аргумент - строку $directory, представляющую собой путь к директории
function transliterateFilesInDirectory($directory) {
    //opendir($directory)  пытается открыть директорию.
    //Если открытие успешное,  $handle  получает ресурс для доступа к директории.
    //Если директорию открыть не удается,  $handle  будет false
    if ($handle = opendir($directory)) {
        //цикл while, который будет выполняться, пока  readdir($handle)  возвращает не false.
        //readdir($handle)  читает следующий элемент из директории, которую мы открыли ранее.
        //$file  получает имя файла.
        //Цикл будет выполняться для каждого файла в директории.
        while (false !== ($file = readdir($handle))) {
            //Проверяется, что имя файла не является "." (текущая директория) или ".." (родительская директория).
            if ($file != "." && $file != "..") {
                //Вызывается функция transliterate  с именем файла $file  в качестве аргумента.
                //Результат, то есть транслитерированное имя файла, записывается в $newFileName.
                $newFileName = transliterate($file);
                
                //Проверяется,  было ли имя файла изменено после транслитерации. Если имя изменилось,  переименовывается файл.
                if ($file !== $newFileName) {
                    //Собирается полный путь к старому файлу,  объединяя путь к директории  $directory  с именем файла  $file.
                    $oldFilePath = $directory . '/' . $file;
                    //Собирается полный путь к новому файлу,  объединяя путь к директории  $directory  с новым именем файла  $newFileName.
                    $newFilePath = $directory . '/' . $newFileName;
                    //Вызывается функция rename() для переименования файла
                    //$oldFilePath  - путь к старому файлу. $newFilePath - путь к новому файлу.
                    if (rename($oldFilePath, $newFilePath)) {
                        //Если переименование успешное, функция rename()  вернет true, и код выведет сообщение о переименовании файла.
                        echo "Файл '$file' переименован в '$newFileName'.\n";
                    } else {
                        //Если переименование не удалось (например, файл с таким именем уже существует), выводится сообщение об ошибке.
                        echo "Не удалось переименовать файл '$file'.\n";
                    }
                }
            }
        }
        //Закрывается ресурс директории,  освобождая его.
        closedir($handle);
    } else {
        echo "Не удалось открыть папку '$directory'.\n";
    }
}

// Пример использования
$directory = 'task6'; // Укажите путь к папке с файлами
transliterateFilesInDirectory($directory); */

/* 
Итог варианта 1
Файл 'пример1.txt' переименован в 'primer1.txt'.
Файл 'пример2.php' переименован в 'primer2.php'.
Файл 'пример3.js' переименован в 'primer3.js'.
*/


/* 
ВАРИК 2
Получилось переименовать, а в первом варианте переименовать и создать новые
еще ремарка в данном варианте обязательно необходимо было подключить в php.ini расширение intl
*/


// Получаем список файлов и директорий
$paths = scandir('./task6/');
// Фильтруем только файлы (исключаем . и ..)
$filteredPaths = array_filter($paths, function($path) {
    return $path !== '.' && $path !== '..';
});
// Применяем транслитерацию
array_walk($filteredPaths, function (&$path) {
    $transliteratedPath = transliterator_transliterate('Russian-Latin/BGN', $path);
    // переименоваем файлы
    rename("./task6/$path", "./task6/$transliteratedPath");
    // Для вывода результата в консоль
    echo "Original: $path, Transliterated: $transliteratedPath\n";
});



$paths = scandir('./task6/');
$filteredPaths = array_filter($paths, function($path) {
    return $path !== '.' && $path !== '..';
});
array_walk($filteredPaths, function (&$path) {
    $transliteratedPath = transliterator_transliterate('Russian-Latin/BGN', $path);
    rename("./task6/$path", "./task6/$transliteratedPath");
    echo "Original: $path, Transliterated: $transliteratedPath\n";
});

?>