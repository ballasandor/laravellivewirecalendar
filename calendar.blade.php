<div class="max-w-4xl mx-auto">
    <div class="flex gap-4 mb-4">
        <div class="flex gap-3 items-center justify-between w-[280px] bg-white p-2  rounded-md shadow border">
            <button wire:click="yearDecrement" class="border border-gray-300 rounded-md px-3 py-1">-</button>
            <div>{{ $this->year }}</div>
            <button wire:click="yearIncrement" class="border border-gray-300 rounded-md px-3 py-1">+</button>
        </div>

        <div class="flex gap-3 items-center justify-between w-[280px] bg-white p-2  rounded-md shadow border">
            <button wire:click="monthDecrement" class="border border-gray-300 rounded-md px-3 py-1">-</button>
            <div>{{ $this->getActualMonth() }}</div>
            <button wire:click="monthIncrement" class="border border-gray-300 rounded-md px-3 py-1">+</button>
        </div>

        <div class="flex gap-3 items-center justify-between bg-white p-2  rounded-md shadow border">
            <button wire:click="setCurrentDate" class="border border-gray-300 rounded-md px-3 py-1">Today</button>
        </div>
    </div>
    <div class="bg-white p-3 rounded-lg shadow-2xl">
        <div class="grid grid-cols-7 gap-1">
            @foreach($this->getWeekDays() as $day)
                <div class="text-center border rounded">
                    {{ $day }}
                </div>
            @endforeach

            @foreach($this->getCalendarDays() as $day)
                <div class="border rounded hover:bg-gray-50 h-24 relative @if(!$day['currentMonth']) bg-gray-100 @endif">
                    @if($day['text'])
                        <div class="absolute @if($day['currentDay']) bg-red-500 text-white font-bold @endif right-1 top-1 rounded-full bg-indigo-50 w-6 h-6 text-[12px] flex items-center justify-center"><span>{{ $day['text'] }}</span></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="text-right">{{ $title }}</div>
</div>
