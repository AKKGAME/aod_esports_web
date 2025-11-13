<?php
// app/Filament/Widgets/EventCalendarWidget.php
namespace App\Filament\Widgets;

use App\Models\Event; 
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget; 
use App\Filament\Resources\EventResource; 
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EventCalendarWidget extends FullCalendarWidget 
{
    protected static ?int $sort = 1; 
    public Model | string | null $model = Event::class;

    // "New event" ခလုတ် ဖြုတ်ရန်
    public function headerActions(): array
    {
        return [];
    }

    // Drag & Drop ဖွင့်ရန်
    public static function canManageEvents(): bool
    {
        return true;
    }

    // Drag & Drop Logic (Error ရှင်းပြီးသား)
    public function onEventDrop(
        array $event,
        array $oldEvent,
        array $relatedEvents,
        array $delta,
        ?array $oldResource = null,
        ?array $newResource = null
    ): bool { 
        
        $record = Event::find($event['id']);
        
        if ($record) {
            $record->update([
                'start_date' => Carbon::parse($event['start']),
                'end_date' => isset($event['end']) ? Carbon::parse($event['end']) : null,
            ]);
        }

        return true;
    }

    // Data ဆွဲထုတ်တဲ့ Logic (Bug Fix ပြီးသား)
    public function fetchEvents(array $fetchInfo): array
    {
        $isRunningInConsole = app()->runningInConsole();
        $start = $fetchInfo['start'];
        $end = $fetchInfo['end'];

        return Event::query()
            ->where(function ($query) use ($start, $end) {
                $query->where('start_date', '<=', $end)
                      ->where('end_date', '>=', $start);
            })
            ->get()
            ->map(function (Event $event) use ($isRunningInConsole) {
                
                $data = [
                    'id'    => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_date,
                    'end'   => $event->end_date,
                ];

                // Color Coding
                $now = now();
                if ($event->start_date > $now) {
                    $data['backgroundColor'] = '#059669'; // Green
                    $data['borderColor'] = '#047857';
                } elseif (($event->end_date && $event->end_date < $now) || ($event->end_date === null && $event->start_date < $now->subDay())) {
                    $data['backgroundColor'] = '#4B5563'; // Gray
                    $data['borderColor'] = '#374151';
                } else {
                    $data['backgroundColor'] = '#DC2626'; // Red
                    $data['borderColor'] = '#B91C1C';
                }
                
                if (! $isRunningInConsole) {
                    $data['url'] = EventResource::getUrl('edit', ['record' => $event]);
                }

                return $data;
            })
            ->all();
    }
    
    // === (၂) windowResize JS block ကို လုံးဝ ဖြုတ်လိုက်ပါပြီ ===
    public function config(): array
    {
        return [
            // "Today" ခလုတ်ကို ဘယ်ဘက်ထောင့်မှာ ထည့်ပါ
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,listWeek', // View options
            ],
            
            // Default view (Desktop)
            'initialView' => 'dayGridMonth',

            // windowResize option ကို ဒီမှာ ဖယ်ရှားလိုက်ပါပြီ
        ];
    }
}