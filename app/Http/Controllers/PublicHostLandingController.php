<?php

namespace App\Http\Controllers;

use App\Models\BudgetItem;
use App\Models\Event;
use App\Models\Guest;
use App\Models\Tenant;
use App\Models\Vendor;
use Throwable;
use Illuminate\View\View;

class PublicHostLandingController extends Controller
{
    public function show(Tenant $tenant): View
    {
        $stats = [
            'events' => 0,
            'guests' => 0,
            'vendors' => 0,
            'budget' => 0,
        ];
        $featuredEvents = collect();

        try {
            tenancy()->initialize($tenant);

            $stats = [
                'events' => Event::count(),
                'guests' => Guest::count(),
                'vendors' => Vendor::count(),
                'budget' => BudgetItem::sum('actual_amount'),
            ];

            $featuredEvents = Event::latest()
                ->limit(3)
                ->get()
                ->map(fn (Event $event) => [
                    'title' => $event->title,
                    'event_date' => optional($event->event_date)->format('d.m.Y'),
                    'venue_name' => $event->venue_name,
                ]);
        } catch (Throwable) {
            // A public page should remain visible even if the tenant database
            // has not been created yet. The CTA and selected design still work.
        } finally {
            if (tenancy()->initialized) {
                tenancy()->end();
            }
        }

        return view('landing.hosts.templates.' . $tenant->landingTemplate(), [
            'tenant' => $tenant,
            'stats' => $stats,
            'featuredEvents' => $featuredEvents,
        ]);
    }
}
