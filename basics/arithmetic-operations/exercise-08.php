<?php declare(strict_types=1);

// Foo Corporation needs a program to calculate how much to pay their hourly
// employees. The US Department of Labor requires that employees get paid time
// and a half for any hours over 40 that they work in a single week. For
// example, if an employee works 45 hours, they get 5 hours of overtime, at
// 1.5 times their base pay. The State of Massachusetts requires that hourly
// employees be paid at least $8.00 an hour. Foo Corp requires that an employee
// not work more than 60 hours in a week.
//
// Summary
//
//    An employee gets paid (hours worked) × (base pay), for each hour up to 40 hours.
//    For every hour over 40, they get overtime = (base pay) × 1.5.
//    The base pay must not be less than the minimum wage ($8.00 an hour). If it is, print an error.
//    If the number of hours is greater than 60, print an error message.
//
// Write a method that takes the base pay and hours worked as parameters, and
// prints the total pay or an error. Write a main method that calls this method
// for each of these employees:
//
// Employee     Base Pay    Hours Worked
// Employee 1   $7.50       35
// Employee 2   $8.20       47
// Employee 3   $10.00      73
class Employee
{
    const MINIMUM_WAGE = 8.00;
    const MAX_WORKING_HOURS = 60;
    const BASE_WORKING_HOURS = 40;
    const OVERTIME_MULTIPLIER = 1.5;

    public string $employeeId = 'Employee 0';
    public float $basePay = 0.0;
    public int $hours = 0;

    public function __construct(string $employeeId, float $basePay, int $hours)
    {
        $this->employeeId = $employeeId;
        $this->basePay = $basePay;
        $this->hours = $hours;
    }

    public function getTotalPay(): TotalPayResult
    {
        // Check if employee has at least minimum wage
        if ($this->basePay < self::MINIMUM_WAGE) {
            return new TotalPayResult(
                false,
                0.0,
                $message = 'The base pay must not be less than a minimum wage!'
            );
        }

        // Check if work hours exceed the limit
        if ($this->hours > self::MAX_WORKING_HOURS) {
            return new TotalPayResult(
                false,
                0.0,
                $message = 'Must not work more than ' . self::MAX_WORKING_HOURS . ' hours!'
            );
        }

        // Calculate pay if working only base hours
        if ($this->hours <= self::BASE_WORKING_HOURS) {
            return new TotalPayResult(
                true,
                $totalPay = $this->hours * $this->basePay
            );
        }

        // Calculate pay if working overtime
        if ($this->hours > self::BASE_WORKING_HOURS) {
            return new TotalPayResult(
                true,
                $totalPay = $this->calculateTotalPay()
            );
        }

        // Should not get here
        return new TotalPayResult(
            false,
            0.0,
            $message = 'Invalid data!'
        );
    }

    private function calculateTotalPay(): float
    {
        $overtime = $this->hours - self::BASE_WORKING_HOURS;

        return self::BASE_WORKING_HOURS * $this->basePay
            + $overtime * $this->basePay * self::OVERTIME_MULTIPLIER;
    }
}

class TotalPayResult
{
    public bool $success;
    public float $totalPay;
    public string $message;

    public function __construct(bool $success, float $totalPay = 0.0, string $message = '')
    {
        $this->success = $success;
        $this->totalPay = $totalPay;
        $this->message = $message;
    }
}

// Data
$employees = [
    new Employee('Employee 1', 7.50, 35),
    new Employee('Employee 2', 8.20, 47),
    new Employee('Employee 3', 10.00, 73)
];

// Output
$fmt = numfmt_create('en_US', NumberFormatter::CURRENCY);

echo "Employee Id    Base Pay    Hours    Total Pay\n";

foreach ($employees as $employee) {
    $totalPayResult = $employee->getTotalPay();

    if ($totalPayResult->success) {
        $totalPay = $fmt->formatCurrency($totalPayResult->totalPay, 'USD');
    } else {
        $totalPay = 'Error: ' . $totalPayResult->message;
    }

    printf(
        "%-14s %-11s %-8d %-12s\n",
        $employee->employeeId,
        $fmt->formatCurrency($employee->basePay, 'USD'),
        $employee->hours,
        $totalPay
    );
}
