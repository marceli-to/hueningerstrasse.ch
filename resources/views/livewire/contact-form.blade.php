<div>
    <x-headings.h2 class="mb-29! md:mb-43!">Kontaktformular</x-headings.h2>

    <form wire:submit="submit" class="flex flex-col gap-24 md:gap-28">

      <fieldset>
        <x-headings.h3 class="mb-14">Ich interessiere mich für (Bitte auswählen)</x-headings.h3>
        <div class="grid w-fit grid-cols-1 gap-x-72 gap-y-10 sm:grid-flow-col sm:auto-cols-max sm:grid-rows-2 text-lg md:text-xl">
          @foreach ($sizes as $value => $label)
            <x-form.checkbox
              id="size-{{ \Illuminate\Support\Str::slug($value) }}"
              value="{{ $value }}"
              wire:model.live="apartment_sizes"
              nowrap
              :error="$errors->has('apartment_sizes')">
              {{ $label }}
            </x-form.checkbox>
          @endforeach
        </div>
        @error('apartment_sizes')
          <p class="mt-8 text-sm text-error">{{ $message }}</p>
        @enderror
      </fieldset>

      <div class="grid grid-cols-1 gap-20 md:gap-24 sm:grid-cols-2">
        <x-form.input name="first_name" label="Vorname*" wire:model.blur="first_name" autocomplete="given-name" />
        <x-form.input name="last_name" label="Name*" wire:model.blur="last_name" autocomplete="family-name" />
      </div>

      <div class="grid grid-cols-1 gap-20 md:gap-24 sm:grid-cols-2">
        <x-form.input name="street" label="Strasse/Nr.*" wire:model.blur="street" autocomplete="street-address" />
        <x-form.input name="zip_city" label="PLZ/Ort*" wire:model.blur="zip_city" autocomplete="postal-code" />
      </div>

      <div class="grid grid-cols-1 gap-20 md:gap-24 sm:grid-cols-2">
        <x-form.input name="email" label="E-Mail*" type="email" wire:model.blur="email" autocomplete="email" />
        <x-form.input name="phone" label="Telefon*" type="tel" wire:model.blur="phone" autocomplete="tel" />
      </div>

      <x-form.textarea name="message" label="Nachricht*" wire:model.blur="message" rows="7" />

      <div>
        <x-form.checkbox id="privacy" name="privacy" wire:model.live="privacy" multiline :error="$errors->has('privacy')">
          Ich habe die
          <a href="{{ route('page.privacy') }}" class="text-bordeaux hover:underline decoration-1 underline-offset-2">Datenschutzerklärung</a>
          gelesen und akzeptiere diese.*
        </x-form.checkbox>
        @error('privacy')
          <p class="mt-8 text-sm text-error">{{ $message }}</p>
        @enderror
      </div>

      @error('turnstileToken')
        <p class="text-sm text-error">{{ $message }}</p>
      @enderror

      <div>
        <x-buttons.primary tag="button" type="submit" title="Absenden"
          class="disabled:opacity-60"
          wire:loading.attr="disabled" wire:target="submit">
          <span wire:loading.remove wire:target="submit">Absenden</span>
          <span wire:loading wire:target="submit">Wird gesendet…</span>
        </x-buttons.primary>
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
</div>
