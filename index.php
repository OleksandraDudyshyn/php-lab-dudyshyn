<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/app/Tasks/Task1Composition.php';
require_once __DIR__.'/app/Tasks/Task2Hierarchy.php';

use App\Core\Database;
use App\Core\EntityFactory;
use App\Models\Medicine;
use App\Services\ConsoleLogger;
use App\Services\EntityService;
use App\Services\FileLogger;
use App\Tasks\Exam;
use App\Tasks\FinalExam;
use App\Tasks\Group;
use App\Tasks\Student;
use App\Tasks\Test;
use App\Tasks\Triangle;

echo '<h1>Лабораторна робота №4 — ООП в PHP та патерни проєктування (Варіант 16)</h1>';

// 1. Патерн Singleton (Database)
echo '<h3>1. Патерн Singleton (Database):</h3>';
$db1 = Database::getInstance();
$db2 = Database::getInstance();
$isSame = $db1 === $db2 ? 'Так (один екземпляр у пам’яті)' : 'Ні';
echo "<p>Перевірка \$db1 === \$db2: <strong>{$isSame}</strong></p>";

// 2. Патерн Factory + Абстрактні класи + Трейт/Інтерфейс JSON-експорту
echo '<h3>2. Патерн Factory, спадкування та JSON-експорт (Trait + Interface):</h3>';
$medicine = EntityFactory::createEntity('medicine', [
    'id' => 'MED-101',
    'createdAt' => '2026-11-21',
    'name' => 'Амоксиклав 625 мг',
    'activeSubstance' => 'Амоксицилін + Клавуланова кислота',
    'price' => 345.50,
    'stockQuantity' => 42,
]);

$user = EntityFactory::createEntity('user', [
    'id' => 'USR-01',
    'createdAt' => '2026-11-21',
    'name' => 'Дудишин Олександра',
    'email' => 'dudyshyn@pharmacy.ua',
    'role' => 'Фармацевт',
]);

echo "<p>{$medicine->getDetails()}</p>";
echo "<p>{$user->getDetails()}</p>";

if ($medicine instanceof Medicine) {
    echo '<p><strong>Експорт моделі Medicine у JSON:</strong></p>';
    echo '<pre>'.$medicine->exportToJson().'</pre>';
}

// 3. Патерн Dependency Injection (LoggerInterface + EntityService)
echo '<h3>3. Патерн Dependency Injection (EntityService + LoggerInterface):</h3>';
$consoleLogger = new ConsoleLogger;
$entityService = new EntityService($consoleLogger);
$entityService->processEntity($medicine);
$entityService->calculateOrderTotal(345.50, 2);

$fileLogger = new FileLogger;
$fileService = new EntityService($fileLogger);
$fileService->applyDiscount(691.00, 10.0);

// 4. Індивідуальне завдання (Варіант 16)
echo '<h3>4. Індивідуальне завдання — Композиція класів Student та Group (Табл. 4.2 №2):</h3>';
$group = new Group(41, 'КН-41');
$group->addStudent(new Student(1, 'Олександра', 'Дудишин', '2005-04-12'));
$group->addStudent(new Student(2, 'Андрій', 'Коваленко', '2005-08-23'));
$group->addStudent(new Student(3, 'Марія', 'Мельник', '2005-02-10'));
$group->removeStudent(2);
$found = $group->searchStudent('Дудишин');

echo "<p>Група {$group->name} (після видалення студента #2): ";
foreach ($group->getStudents() as $student) {
    echo '<br>• '.$student->getFullInfo();
}
echo '</p>';
echo '<p>Результат пошуку за запитом «Дудишин»: <strong>'.$found[0]->getFullInfo().'</strong></p>';

echo '<h3>5. Індивідуальне завдання — Ієрархія класів Випробувань (Табл. 4.3 №5):</h3>';
$test = new Test('Модульний тест з PHP');
$exam = new Exam('Семестровий іспит з Веб-програмування');
$finalExam = new FinalExam('Кваліфікаційний випускний іспит');

echo "<ul>
    <li>{$test->getTitle()} (Test): прохідний бал = <strong>{$test->getPassingScore()}</strong></li>
    <li>{$exam->getTitle()} (Exam): прохідний бал = <strong>{$exam->getPassingScore()}</strong></li>
    <li>{$finalExam->getTitle()} (FinalExam): прохідний бал = <strong>{$finalExam->getPassingScore()}</strong></li>
</ul>";

echo '<h3>6. Індивідуальне завдання — Клас Triangle з readonly-сторонами (Табл. 4.4 №2):</h3>';
$triangle = new Triangle(3.0, 4.0, 5.0);
echo "<p>Трикутник зі сторонами a = {$triangle->a}, b = {$triangle->b}, c = {$triangle->c}:<br>";
echo "Периметр: <strong>{$triangle->getPerimeter()}</strong>, Площа (за формулою Герона): <strong>{$triangle->getArea()}</strong></p>";
