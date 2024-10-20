<?php

/* 
Задача № 7
"Случайная картинка из папки"

В папке лежат файлы картинок.
При заходе пользоваателя на сайт покажите ему случайную картинку из этой папки.
Если он:
    1.обновит страницу,
    2.или зайдет через некоторое время,
    то картинка, показываемая ему - не должна поменяться...
*/

/* Вариант решения 1 */
/* 
1.Для начала создадим в папку task7, а в этой папке файлы картинок raz.jpg dva.jpeg tri.png chetyri.gif
*/

$livesCookieInSeconds = 3600; // Время жизни cookie

// Проверка, установлена ли cookie с именем 'srcImg'
if (empty($_COOKIE['srcImg'])) {
    // Получаем все изображения из папки
    $images = glob("*.{jpg,jpeg,png,gif}", GLOB_BRACE);
    
    // Проверяем, что папка с изображениями не пуста
    if ($images && count($images) > 0) {
        // Выбираем случайное изображение
        $srcImg = $images[rand(0, count($images) - 1)];
        
        // Устанавливаем cookie с выбранным изображением
        setcookie('srcImg', $srcImg, time() + $livesCookieInSeconds);
    } else {
        // Если картинок нет, выводим заглушку
        $srcImg = "no-image.png"; // замените на путь к заглушке
    }
} else {
    // Если cookie уже установлена, берем путь к изображению из cookie
    $srcImg = $_COOKIE['srcImg'];
}

// Выводим изображение
echo "<img src='{$srcImg}'>";

//при - $images = glob("task7/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
//ответ - <img src='task7/tri.png'> при чем через час будем получать рандомную картинку
//при $images = glob("*.{jpg,jpeg,png,gif}", GLOB_BRACE);
//ответ - <img src='no-image.png'> то есть рандомная заглушка