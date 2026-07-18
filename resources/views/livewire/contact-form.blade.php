<div>
  @if ($submitted)
    <div class="flex flex-col gap-16" role="status" aria-live="polite" data-reveal>
      <x-headings.h2 class="!mb-0">Wir haben Ihre Anfrage erhalten</x-headings.h2>
      <p class="max-w-2xl">
        Vielen Dank für Ihr Interesse an der Hüningerstrasse 40. Wir setzen uns zeitnah mit Ihnen in
        Verbindung und informieren Sie über das weitere Vorgehen.
      </p>
    </div>
  @else
    <x-headings.h2>Kontaktformular</x-headings.h2>

    <form wire:submit="submit" class="flex flex-col gap-24 md:gap-28">

      <fieldset>
        <x-headings.h3 class="mb-14">Ich interessiere mich für (Bitte auswählen)</x-headings.h3>
        <div class="grid w-fit grid-cols-1 gap-x-72 gap-y-10 sm:grid-flow-col sm:auto-cols-max sm:grid-rows-2 text-lg md:text-xl">
          @foreach ($sizes as $value => $label)
            <x-form.checkbox
              id="size-{{ \Illuminate\Support\Str::slug($value) }}"
              value="{{ $value }}"
              wire:model="apartment_sizes"
              nowrap
              :error="$errors->has('apartment_sizes')">
              {{ $label }}
            </x-form.checkbox>
          @endforeach
        </div>
        @error('apartment_sizes')
          <p class="mt-8 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </fieldset>

      <div class="grid grid-cols-1 gap-20 md:gap-24 sm:grid-cols-2">
        <x-form.input name="first_name" label="Vorname*" wire:model="first_name" autocomplete="given-name" />
        <x-form.input name="last_name" label="Name*" wire:model="last_name" autocomplete="family-name" />
      </div>

      <div class="grid grid-cols-1 gap-20 md:gap-24 sm:grid-cols-2">
        <x-form.input name="street" label="Strasse/Nr.*" wire:model="street" autocomplete="street-address" />
        <x-form.input name="zip_city" label="PLZ/Ort*" wire:model="zip_city" autocomplete="postal-code" />
      </div>

      <div class="grid grid-cols-1 gap-20 md:gap-24 sm:grid-cols-2">
        <x-form.input name="email" label="E-Mail*" type="email" wire:model="email" autocomplete="email" />
        <x-form.input name="phone" label="Telefon*" type="tel" wire:model="phone" autocomplete="tel" />
      </div>

      <x-form.textarea name="message" label="Nachricht*" wire:model="message" rows="7" />

      <x-form.checkbox id="privacy" name="privacy" wire:model="privacy" multiline :error="$errors->has('privacy')">
        Ich habe die
        <a href="{{ route('page.privacy') }}" class="text-bordeaux hover:underline decoration-1 underline-offset-2">Datenschutzerklärung</a>
        gelesen und akzeptiere diese.
      </x-form.checkbox>

      @error('turnstileToken')
        <p class="text-sm text-red-600">{{ $message }}</p>
      @enderror

      <div>
        <button
          type="submit"
          class="inline-flex items-center gap-10 bg-bordeaux hover:bg-ink text-white transition-colors font-bold uppercase tracking-wide text-[20.7px] md:text-[23px] leading-none pt-10 pb-11 px-13 rounded-[2px] group cursor-pointer disabled:opacity-60"
          wire:loading.attr="disabled"
          wire:target="submit">
          <span wire:loading.remove wire:target="submit">Absenden</span>
          <span wire:loading wire:target="submit">Wird gesendet…</span>
        </button>
      </div>
    </form>

    {{-- Cloudflare Turnstile (Invisible) — only renders when keys are configured --}}
    @if (filled(config('services.turnstile.site_key')))
      <div wire:ignore x-data
        x-on:turnstile:reset.window="window.turnstile && $refs.widget.dataset.widgetId && window.turnstile.reset($refs.widget.dataset.widgetId)">
        <div x-ref="widget" x-init="
          const render = () => {
            $refs.widget.dataset.widgetId = window.turnstile.render($refs.widget, {
              sitekey: '{{ config('services.turnstile.site_key') }}',
              callback: (token) => $wire.set('turnstileToken', token),
              'expired-callback': () => $wire.set('turnstileToken', ''),
            });
          };
          window.turnstile ? render() : document.addEventListener('turnstile:loaded', render, { once: true });
        "></div>
      </div>
      @push('scripts')
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onTurnstileLoad" async defer></script>
        <script>window.onTurnstileLoad = () => document.dispatchEvent(new Event('turnstile:loaded'));</script>
      @endpush
    @endif
  @endif
</div>
