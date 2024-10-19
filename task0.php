<?php

/* 
Задача нульова

Есть персонаж;
Он откладывает по 2 тысячи рублей ежедневно;
В начале каждого месяца он открывает новый влад в банке и кладет туда все накопленные за месяц деньги;
Банк на сегодняшний день дает ставку 1,5 % в месяц;
Проценты по вкладу начисляются с переодичностью в месяц с даты открытия вклада; 
Но каждые последующие два месяца ставка на новые вклады падает на 0,04 %;
Срок жизни вклада 60+1 день;
Вклад с накопленными процентами каждые два месяца снимается со счета и кладется заново;
Необходимо выводить информацию о общей сумме, которую человек имеет на определенную дату (это значение переменное):
1. Дома в копилке (соответственно эта сумма не может превышать 31*2000 = 62000 рублей);
2. Сумму которую ему могут отдать сегодняшним (определенная нами дата) днем в банке;
*/

class InvestmentManager {
    private $dailySavings = 2000; // Ежедневная сумма, которую откладывает персонаж
    private $initialRate = 0.01; // Начальная ставка (1,5% в месяц)
    private $rateDrop = 0.000003; // Снижение ставки каждые два месяца
    private $investmentDuration = 61; // Дни жизни вклада (60+1)
    private $bankDeposits = []; // Массив для хранения вкладов
    private $startDate; // Дата начала процесса

    public function __construct($startDate) {
        $this->startDate = new DateTime($startDate);
    }

    // Получаем количество дней в предыдущем месяце
    private function getDaysInPreviousMonth($currentDate) {
        $previousMonth = clone $currentDate;
        $previousMonth->modify('first day of last month'); // Переходим на первый день предыдущего месяца
        return $previousMonth->format('t'); // Возвращаем количество дней в предыдущем месяце
    }

    // Рассчитываем, сколько денег накопилось в копилке на текущую дату
    public function calculatePiggyBank($currentDate) {
        $currentDate = new DateTime($currentDate);
        $daysInCurrentMonth = $currentDate->format('j'); // День в текущем месяце

        // Используем количество дней в предыдущем месяце
        $daysInPreviousMonth = $this->getDaysInPreviousMonth($currentDate);

        // Считаем, сколько накопилось денег в текущем месяце
        $savedInPiggyBank = $this->dailySavings * $daysInCurrentMonth;
        return min($savedInPiggyBank, $this->dailySavings * $daysInPreviousMonth);
    }

    // Открываем новый вклад каждый месяц с учетом текущей ставки
    public function openNewDeposit($currentDate) {
        $currentDate = new DateTime($currentDate);
        $daysSinceStart = $this->startDate->diff($currentDate)->days;

        // Определяем, сколько раз ставка снижалась
        $monthsSinceStart = floor($daysSinceStart / 30); // Примерное количество месяцев
        $rateDropCount = floor($monthsSinceStart / 2); // Каждые 2 месяца падает ставка
        $currentRate = $this->initialRate - ($rateDropCount * $this->rateDrop);

        // Используем количество дней в предыдущем месяце
        $daysInPreviousMonth = $this->getDaysInPreviousMonth($currentDate);
        $totalSaved = $this->dailySavings * $daysInPreviousMonth; // Полная сумма за предыдущий месяц

        // Добавляем вклад в массив вкладов
        $this->bankDeposits[] = [
            'dateOpened' => clone $currentDate,
            'amount' => $totalSaved,
            'rate' => $currentRate
        ];
    }

    /* ТУТ вставка, для того чтобы не писать о каждом вкладе отдельно, если мы
    в курсе о ом что вклад происходит каждый месяц, если нет - удалить =================== */

    // Открываем вклады на несколько месяцев вперед
    public function openDepositsForMonths($startDate, $endDate) {
        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);

        while ($startDate <= $endDate) {
            $this->openNewDeposit($startDate->format('Y-m-d'));
            // Переходим к следующему месяцу
            $startDate->modify('first day of next month');
        }
    }
    /* ============================================= */

    // Рассчитываем проценты по каждому вкладу на текущую дату
    public function calculateBankDeposits($currentDate) {
        $currentDate = new DateTime($currentDate);
        $totalAmount = 0;

        foreach ($this->bankDeposits as $deposit) {
            $depositDate = $deposit['dateOpened'];
            $monthsActive = floor($depositDate->diff($currentDate)->days / 30);

            // Рассчитываем начисленные проценты
            $amountWithInterest = $deposit['amount'];

            // Начисляем проценты за каждый полный месяц действия вклада
            for ($i = 0; $i < $monthsActive; $i++) {
                $amountWithInterest += $amountWithInterest * $deposit['rate'];
            }

            // Добавляем сумму вклада с начисленными процентами к общему итогу
            $totalAmount += $amountWithInterest;
        }

        return $totalAmount;
    }

    // Получаем полную информацию на определенную дату
    public function getTotalAmountOnDate($currentDate) {
        $piggyBank = $this->calculatePiggyBank($currentDate);
        $bankDeposits = $this->calculateBankDeposits($currentDate);

        return [
            'piggyBank' => $piggyBank,
            'bankDeposits' => $bankDeposits,
            'total' => $piggyBank + $bankDeposits
        ];
    }
}

// Пример использования
$investmentManager = new InvestmentManager('2024-07-01');

// Пример открытия вкладов, в том случае если пишем каждый вклад отдельно
/* $investmentManager->openNewDeposit('2024-08-01');
$investmentManager->openNewDeposit('2024-09-01');
$investmentManager->openNewDeposit('2024-10-01');
$investmentManager->openNewDeposit('2024-11-01'); */

$investmentManager->openDepositsForMonths('2024-08-01', '2025-12-01');


// Получаем сумму на определенную дату
$result = $investmentManager->getTotalAmountOnDate('2025-12-19');

echo "Сумма в копилке: " . $result['piggyBank'] . " руб.\n";
echo "Сумма в банке: " . $result['bankDeposits'] . " руб.\n";
echo "Общая сумма: " . $result['total'] . " руб.\n";
?>

