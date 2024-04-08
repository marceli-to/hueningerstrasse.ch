<form wire:submit="save" class="mt-16 lg:mt-24">
  @if (session()->has('status'))
    <div x-data="{ open: true }" x-show="open">
      <div class="bg-green-600 rounded-sm text-white font-sans-bold font-bold font-normal py-15 pl-15 pr-30 fixed top-10 left-10 inline-block w-auto z-[101]">
        <div class="relative">
          <a href="javascript:;" x-on:click="open = false">
            Vielen Dank, wir haben Ihre Anfrage erhalten.
            <x-icons.cross class="!w-15 !h-15 absolute -top-5 -right-20" />
          </a>
        </div>
      </div>
    </div>
  @endif

  <div class="mt-25 mb-10">
    <h2>ICH INTERESSIERE MICH FÜR (BITTE AUSWÄHLEN):</h2>
  </div>
  <x-layout.grid class="sm:gap-y-15 lg:gap-x-25 lg:gap-y-20">
    <x-honeypot />
    <x-layout.span class="relative !col-span-12 !mb-20 md:!mb-10">
      @error('interest')
        <x-form.error 
          message="mind. 1 Option auswählen"
          class="relative right-auto left-0 h-24 mb-5 top-2"
          />
      @enderror
      <div class="flex flex-col md:flex-row md:gap-x-40">
        <div class="md:mb-0">
          <div class="mb-5">
            <x-form.checkbox name="interest" value="1.5-Zimmerwohnung" isWire="true" class="-mt-4" id="interest-1.5zi" />
            <x-form.checkbox-label for="interest-1.5zi">1-Zimmerwohnung</x-form.checkbox-label>
          </div>
          <div class="mb-5">
            <x-form.checkbox name="interest" value="2.5-Zimmerwohnung" isWire="true" class="-mt-4" id="interest-2.5zi" />
            <x-form.checkbox-label for="interest-2.5zi">2.5-Zimmerwohnung</x-form.checkbox-label>
          </div>
        </div>
        <div class="md:mb-0">
          <div class="mb-5">
            <x-form.checkbox name="interest" value="3.5-Zimmerwohnung" isWire="true" class="-mt-4" id="interest-3.5zi" />
            <x-form.checkbox-label for="interest-3.5zi">3.5-Zimmerwohnung</x-form.checkbox-label>
          </div>
          <div class="mb-5">
            <x-form.checkbox name="interest" value="4.5-Zimmerwohnung" isWire="true" class="-mt-4" id="interest-4.5zi" />
            <x-form.checkbox-label for="interest-4.5zi">4.5-Zimmerwohnung</x-form.checkbox-label>
          </div>
        </div>
        <div>
          <div class="mb-5">
            <x-form.checkbox name="interest" value="5.5-Zimmerwohnung" isWire="true" class="-mt-4" id="interest-5.5zi" />
            <x-form.checkbox-label for="interest-5.5zi">5.5-Zimmerwohnung</x-form.checkbox-label>
          </div>
          <div>
            <x-form.checkbox name="interest" value="Gewerbefläche" isWire="true" class="-mt-4" id="interest-business" />
            <x-form.checkbox-label for="interest-business">Gewerbefläche</x-form.checkbox-label>
          </div>
        </div>
      </div>
    </x-layout.span>
    <x-layout.span class="relative">
      <x-form.input name="firstname" placeholder="Vorname*" isWire="true" />
      @error('firstname')
        <x-form.error message="{{ $message }}" />
      @enderror 
    </x-layout.span>
    <x-layout.span class="relative">
      <x-form.input name="name" placeholder="Name*" isWire="true" />
      @error('name')
        <x-form.error message="{{ $message }}" />
      @enderror 
    </x-layout.span>
    <x-layout.span class="relative">
      <x-form.input name="street" placeholder="Strasse/Nr.*" isWire="true" />
      @error('street')
        <x-form.error message="{{ $message }}" />
      @enderror 
    </x-layout.span>
    <x-layout.span class="relative">
      <x-form.input name="location" placeholder="PLZ/Ort*" isWire="true" />
      @error('location')
        <x-form.error message="{{ $message }}" />
      @enderror 
    </x-layout.span>
    <x-layout.span class="relative">
      <x-form.input name="email" type="email" placeholder="E-Mail*" isWire="true" />
      @error('email')
        <x-form.error message="{{ $message }}" />
      @enderror 
    </x-layout.span>
    <x-layout.span class="relative">
      <x-form.input name="phone" placeholder="Telefon" isWire="true" />
      @error('phone')
        <x-form.error message="{{ $message }}" />
      @enderror 
    </x-layout.span>
    <x-layout.span class="relative sm:!col-span-12">
      @error('privacy')
        <x-form.error 
          message="Datenschutzerklärung muss akzeptiert werden"
          class="relative right-auto left-0 mb-6"
          />
      @enderror
      <div class="flex items-start">
        <x-form.checkbox name="privacy" id="privacy" isWire="true" class="mt-2 lg:mt-6" />
        <x-form.checkbox-label for="privacy" class="ml-6 lg:!ml-10">
          Ich habe die <a href="{{ route('page.privacy') }}" title="Datenschutzerklärung" target="_blank" class="hover:underline underline-offset-2 decoration-1">Datenschutzerklärung</a> gelesen und akzeptiere diese
        </x-form.checkbox-label>
      </div>
    </x-layout.span>
    <x-layout.span class="sm:col-span-12 mt-5">
      <x-form.button>
        <div wire:loading>
          <x-form.spinner class="mr-12 text-olive" />
        </div>
        Absenden
      </x-form.button>
    </x-layout.span>
  </x-layout.grid>
</form>
