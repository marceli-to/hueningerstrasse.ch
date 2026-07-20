<?php

namespace App\Console\Commands;

use App\Models\Registration;
use App\Notifications\WeeklyRegistrationsExport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class ExportWeeklyRegistrations extends Command
{
    protected $signature = 'registrations:export-weekly {--all : Include all registrations, not only those not yet exported}';

    protected $description = 'Email the list of new registrations to the client and mark them as exported.';

    public function handle(): int
    {
        $recipient = config('services.registrations.export_email');

        if (blank($recipient)) {
            $this->error('No export recipient configured (REGISTRATIONS_EXPORT_EMAIL).');

            return self::FAILURE;
        }

        // Mehrere Empfänger per Komma getrennt erlaubt.
        $recipients = array_values(array_filter(array_map('trim', explode(',', $recipient))));

        $query = Registration::query()->orderBy('created_at');

        if (! $this->option('all')) {
            $query->whereNull('exported_at');
        }

        $registrations = $query->get();

        $periodStart = now()->subWeek();
        $periodEnd = now();

        Notification::route('mail', $recipients)
            ->notify(new WeeklyRegistrationsExport($registrations, $periodStart, $periodEnd));

        if ($registrations->isNotEmpty()) {
            Registration::whereIn('id', $registrations->pluck('id'))->update(['exported_at' => now()]);
        }

        $this->info("Sent {$registrations->count()} registration(s) to ".implode(', ', $recipients).'.');

        return self::SUCCESS;
    }
}
