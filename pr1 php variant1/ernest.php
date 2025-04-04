<?php

$name = "Ернест";
$age = 17;
$is_student = true;

echo "Мене звати $name, мені $age років, і я " . ($is_student ? "студент" : "не студент") . ".<br>";

// 2. Масив чисел від 1 до 5 та сума всіх елементів
$numbers = [1, 2, 3, 4, 5];
$sum = array_sum($numbers);

echo "Сума чисел від 1 до 5: $sum<br>";


$contact = [
    "name" => "Ернест",
    "email" => "ernik9095@icloud.com",
    "phone" => "+380996011390"
];

echo "<ul>";
foreach ($contact as $key => $value) {
    echo "<li><strong>$key:</strong> $value</li>";
}
echo "</ul>";


if ($age > 18) {
    echo "Вам більше 18 років.<br>";
} else {
    echo "Вам 18 років або менше.<br>";
}


$grade = 85;

if ($grade >= 90) {
    echo "Оцінка: Відмінно";
} elseif ($grade >= 70) {
    echo "Оцінка: Добре";
} elseif ($grade >= 50) {
    echo "Оцінка: Задовільно";
} else {
    echo "Оцінка: Незадовільно";
}
?>