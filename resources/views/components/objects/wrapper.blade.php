@props([
  'objects' => collect(),
  'title' => '',
  'variant' => 'living',
])

{{-- Zwei Layouts:
     Mobil normaler Blockfluss – die Isometrie steht oben und bleibt angeheftet,
     die Tabelle scrollt darunter durch. Kein Grid, weil jedes Grid-Item eine
     eigene Zeile bekäme und sticky dann keinen Weg hätte; im Blockfluss ist der
     Wrapper der Bezugsrahmen und damit so hoch wie Grafik + Tabelle zusammen.

     Ab lg zweispaltig: die Tabellenspalte nimmt genau ihre Inhaltsbreite (auto),
     damit alle sieben Spalten samt Vormerken-Button ohne Querscrollen
     hineinpassen, die Isometrie bekommt den kompletten Rest. minmax(0,…)
     verhindert, dass die Grafik ihre Spalte aufbläht. --}}
<div class="mt-32 md:mt-40 lg:grid lg:grid-cols-[auto_minmax(0,1fr)] lg:gap-x-40 xl:gap-x-56 lg:items-start">

  {{-- Angeheftete Grafik. Mobil deckt sie die durchlaufende Tabelle ab, braucht
       also den Sektionshintergrund und muss darüber liegen.
       Mobil sitzt top auf 97 – der Höhe des Headers unterhalb von md. Bei md ist
       er 105 hoch, der Kasten schiebt sich dort also 8px darunter; das deckt der
       Header ab. Wichtig ist die Richtung: top darf nie GRÖSSER als der Header
       sein, sonst bleibt zwischen beiden ein Schlitz offen, durch den die
       Tabelle durchscrollt. Das pt-8 hebt die Grafik wieder auf die
       Header-Unterkante, damit sie nicht angeschnitten wird.
       Ab lg ist top = Header (125) plus Luft für die beim Hover angehobenen
       Etagen: iso.js hebt sie um --iso-lift (1000 User-Units), die oberste Etage
       sitzt bei y=230 und ragt damit 770 UU über die viewBox – je nach
       Spaltenbreite 52-107px, die sonst unter der Navigation verschwänden.
       Ab lg schiebt der mt-Versatz die Grafik auf die Oberkante der Tabelle,
       also unter den Titelblock (h3 33 + mb-10 + p 30 + mb-20). --}}
  <div @class([
    'sticky top-97 pt-8 z-20 bg-sky pb-16 mb-24',
    'lg:order-2 lg:top-250 lg:pt-0 lg:z-auto lg:bg-transparent lg:pb-0 lg:mb-0 lg:self-start',
    'lg:mt-93' => $title !== '',
  ])>
    {{-- Mobil darf die angeheftete Grafik höchstens 45vh hoch werden, sonst
         bliebe zu wenig Schirm für die Tabelle darunter. Begrenzt wird über die
         Breite, damit das Seitenverhältnis erhalten bleibt und die viewBox nicht
         seitlich leer läuft: 4150/3400 = 1.2206, also 45vh * 1.2206 = 54.9vh.
         min() behält zugleich die 36rem-Obergrenze auf hohen Schirmen. --}}
    <x-objects.iso class="max-w-[min(36rem,54.9vh)] lg:max-w-xl mx-auto lg:mx-0" />
  </div>

  <div class="lg:order-1">
    <x-objects.table :objects="$objects" :title="$title" :variant="$variant" />
  </div>
</div>
