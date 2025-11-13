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

    // "New event" ခလုတ် ဖြုတ်ရန် (အရင်အတိုင်း)
    public function headerActions(): array
    {
        return [];
    }

    // Drag & Drop (ဆွဲချ) ဖွင့်ရန် (အရင်အတိုင်း)
    public static function canManageEvents(): bool
    {
        return true;
    }

    // === (၁) (အမှားပြင်ဆင်ပြီး) Function တည်ဆောက်ပုံ အမှန် ===
    public function onEventDrop(
        array $event,
        array $oldEvent,
        array $relatedEvents,
        array $delta,
        ?array $oldResource = null, // <-- (က) Parameter အသစ် (၁)
        ?array $newResource = null  // <-- (ခ) Parameter အသစ် (၂)
    ): bool { // <-- (ဂ) Return type ကို 'bool' ပြောင်းပါ
        
        $record = Event::find($event['id']);
        
        if ($record) {
            $record->update([
                'start_date' => Carbon::parse($event['start']),
                'end_date' => isset($event['end']) ? Carbon::parse($event['end']) : null,
            ]);
        }

        return true; // <-- (ဃ) 'true' ကို return ပြန်ပါ
    }
    // ====================================================

    // Data ဆွဲထုတ်တဲ့ Logic (အရင်အတိုင်း)
    public function fetchEvents(array $fetchInfo): array
    {
        $isRunningInConsole = app()->runningInConsole();
        $start = $fetchInfo['start'];
        $end = $fetchInfo['end'];

        return Event::query()
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                ->orWhereBetween('end_date', [$start, $end])
                ->orWhere(function ($q) use ($start, $end) {
                    $q->where('start_date', '<', $start)
                      ->where('end_date', '>', $end);
                });
            })
            ->get()
            ->map(function (Event $event) use ($isRunningInConsole) {
                
                $data = [
                    'id'    => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_date,
                    'end'   => $event->end_date,
                ];

                // Color Coding (အရင်အတိုင်း)
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
                
                // "Edit" page ကို သွားမယ့် 'url' (အရင်အတိုင်း)
                if (! $isRunningInConsole) {
                    $data['url'] = EventResource::getUrl('edit', ['record' => $event]);
                }

                return $data;
            })
            ->all();
    }
}