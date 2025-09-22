<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Laravel Conference 2025',
                'description' => 'A conference for Laravel enthusiasts.',
                'location' => 'New York, USA',
                'start_date' => now()->addMonths(1),
                'end_date' => now()->addMonths(1)->addDays(2),
                'image_url' => 'https://images.tokopedia.net/img/cache/700/aphluv/1997/1/1/b7d429ac2d4c42e8aeb0d16b88d4ac67~.jpeg',
                'tickets' => [
                    ['name' => 'Regular', 'price' => 100000, 'quantity' => 500],
                    ['name' => 'VIP', 'price' => 300000, 'quantity' => 100],
                ],
            ],
            [
                'title' => 'Vue.js Summit',
                'description' => 'The biggest Vue.js event of the year.',
                'location' => 'Amsterdam, Netherlands',
                'start_date' => now()->addMonths(2),
                'end_date' => now()->addMonths(2)->addDays(1),
                'image_url' => 'https://images.tokopedia.net/img/cache/700/aphluv/1997/1/1/b7d429ac2d4c42e8aeb0d16b88d4ac67~.jpeg',
                'tickets' => [
                    ['name' => 'Early Bird', 'price' => 150000, 'quantity' => 1000],
                    ['name' => 'Standard', 'price' => 250000, 'quantity' => 500],
                ],
            ],
            [
                'title' => 'React Rally',
                'description' => 'A community conference about React and topics of interest to React developers.',
                'location' => 'Salt Lake City, USA',
                'start_date' => now()->addMonths(3),
                'end_date' => now()->addMonths(3)->addDays(1),
                'image_url' => 'https://images.tokopedia.net/img/cache/700/aphluv/1997/1/1/b7d429ac2d4c42e8aeb0d16b88d4ac67~.jpeg',
                'tickets' => [
                    ['name' => 'General Admission', 'price' => 200000, 'quantity' => 800],
                    ['name' => 'Workshop', 'price' => 400000, 'quantity' => 200],
                ],
            ],
        ];

        foreach ($events as $eventData) {
            $event = Event::create([
                'title' => $eventData['title'],
                'description' => $eventData['description'],
                'location' => $eventData['location'],
                'start_date' => $eventData['start_date'],
                'end_date' => $eventData['end_date'],
            ]);

            // Add image from URL
            if (isset($eventData['image_url'])) {
                $event->addMediaFromUrl($eventData['image_url'])->toMediaCollection('posters');
            }

            foreach ($eventData['tickets'] as $ticketData) {
                $event->tickets()->create($ticketData);
            }
        }
    }
}
