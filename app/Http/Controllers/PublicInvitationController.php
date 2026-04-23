<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicInvitationController extends Controller
{
    public function show(string $tenant, string $eventToken, ?string $guestToken = null): View
    {
        $tenantModel = Tenant::findOrFail($tenant);

        tenancy()->initialize($tenantModel);

        // Public invitation pages still render tenant model casts in Blade,
        // so the tenant connection must stay active until the response is sent.
        app()->terminating(function (): void {
            if (tenancy()->initialized) {
                tenancy()->end();
            }
        });

        $event = Event::with('guests')->where('invitation_token', $eventToken)->firstOrFail();
        $guest = $guestToken
            ? $event->guests()->where('invitation_token', $guestToken)->first()
            : null;

        return view('landing.invitation.show', [
            'tenant' => $tenantModel,
            'event' => $event,
            'guest' => $guest,
        ]);
    }

    public function submitRsvp(Request $request, string $tenant, string $eventToken, ?string $guestToken = null): RedirectResponse
    {
        $tenantModel = Tenant::findOrFail($tenant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'attendance' => 'required|in:confirmed,declined',
            'plus_one' => 'nullable|integer|min:0|max:10',
            'notes' => 'nullable|string',
        ]);

        try {
            tenancy()->initialize($tenantModel);

            $event = Event::where('invitation_token', $eventToken)->firstOrFail();
            $guest = $guestToken
                ? $event->guests()->where('invitation_token', $guestToken)->first()
                : null;

            if (! $guest) {
                $guest = $event->guests()->create([
                    'name' => $validated['name'],
                    'email' => $validated['email'] ?? null,
                    'phone' => $validated['phone'] ?? null,
                    'category' => 'RSVP',
                    'plus_one' => $validated['plus_one'] ?? 0,
                    'notes' => $validated['notes'] ?? null,
                ]);
            }

            $guest->update([
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'confirmed' => $validated['attendance'] === 'confirmed',
                'rsvp_status' => $validated['attendance'],
                'responded_at' => now(),
                'plus_one' => $validated['plus_one'] ?? 0,
                'notes' => $validated['notes'] ?? null,
            ]);
        } finally {
            if (tenancy()->initialized) {
                tenancy()->end();
            }
        }

        return redirect()
            ->route('invitation.show', [
                'tenant' => $tenant,
                'eventToken' => $eventToken,
                'guestToken' => $guest->invitation_token,
            ])
            ->with('success', 'Ваш ответ получен. Спасибо!');
    }
}
