<?php

namespace App\Livewire;

use Livewire\Component;

/**
 * @author Balla Sándor
 * @link https://www.webelite.hu
 * @date 2024 February
 *
 */

class Calendar extends Component
{
    public string $title = 'Laravel livewire Calendar 2024';

    public int $year = 0;
    public int $month = 0;
    public int $monthDays = 0;

    private array $calendarDays = [];

    private array $weekDays = [
        'Hétfő',
        'Kedd',
        'Szerda',
        'Csütörtök',
        'Péntek',
        'Szombat',
        'Vasárnap',
    ];

    private array $months = [
        'Január',
        'Február',
        'Március',
        'Április',
        'Május',
        'Június',
        'Július',
        'Augusztus',
        'Szeptember',
        'Október',
        'November',
        'December'
    ];


    public function __construct()
    {
        $this->setCurrentDate();
    }

    public function getCalendarDays(){
        return $this->calendarDays;
    }

    public function getWeekDays(){
        return $this->weekDays;
    }

    public function refreshCalendarDays(): array{

        // Clear Calendar Days
        $this->calendarDays = [];

        $date = $this->year .'-'. $this->month . '-1';

        // Get Days number
        $this->monthDays = $this->getMonthNumberOfDays($this->month,$this->year);

        // Set days for previous month
        $firstDayNumberOfWeek = $this->getDayOfWeekNumber($date);
        for($i = $firstDayNumberOfWeek -1; $i >= 1; $i--){
            $prev = $this->getDay(strtotime('-' . $i . ' day', strtotime($date)));
            $this->calendarDays[] = [
                'text' => $prev,
                'currentMonth' => false,
                'currentDay' => false,
            ];
        }

        // Set days for current month
        for($i = 1; $i <= $this->monthDays; $i++){
            $this->calendarDays[] = [
                'text' => $this->getDay(strtotime($this->year.'-'.$this->month.'-'.$i)),
                'currentMonth' => true,
                'currentDay' => date('Ymd',strtotime($this->year.'-'.$this->month.'-'.$i)) == date('Ymd'),
            ];
        }

        // Set days for next month
        $lastDayNumberOfWeek = $this->getDayOfWeekNumber($this->year .'-'. $this->month . '-' . $this->monthDays);


        for($i = 0; $i < 7 - $lastDayNumberOfWeek; $i++){
            $next = $this->getDay(strtotime('+' . $i . ' day', strtotime($date)));
            $this->calendarDays[] = [
                'text' => $next,
                'currentMonth' => false,
                'currentDay' => false,
            ];
        }

        return $this->calendarDays;
    }

    private function getDay($date): string{
        return date('d',$date);
    }

    public function getActualMonth(): string{
        return $this->months[$this->month - 1];
    }

    public function setCurrentDate(){
        $this->year = date('Y');
        $this->month = date('m');
        $this->monthDays = $this->getMonthNumberOfDays($this->month,$this->year);
        $this->refreshCalendarDays();
    }

    public function yearIncrement(){
        $this->year++;
        $this->refreshCalendarDays();
    }

    public function yearDecrement(){
        $this->year--;
        $this->refreshCalendarDays();
    }
    public function monthIncrement(){
        if ($this->month == 12){
            $this->month = 1;
            $this->year++;
        }else{
            $this->month++;
        }
        $this->refreshCalendarDays();
    }

    public function monthDecrement(){
        if ($this->month == 1){
            $this->month = 12;
            $this->year--;
        }else{
            $this->month--;
        }
        $this->refreshCalendarDays();
    }

    private function getMonthNumberOfDays($month, $year): int{
        return cal_days_in_month(CAL_GREGORIAN,$month,$year);
    }

    private function getYear(string $date): int{
        return date('Y',strtotime($date));
    }

    private function getMonth(string $date): int{
        return date('m',strtotime($date));
    }

    private function getDayOfWeekNumber(string $date): int{
        return date('N', strtotime($date));
    }

    public function render()
    {
        return view('livewire.calendar');
    }
    
}
