<x-app-layout>
    <x-slot name="header">
        <h2 class="font-senbold text-xl text-gray-800 leading-tight">
            {{ __('Formular') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (Auth::user()->form_sent == '1')
                        Danke für die Teilnahme!
                    @else
                        {{-- <form method="POST" action="{{ route('form') }}"> --}}
                        <div class="mb-8">
                            <p>Liebe Mitarbeiter:innen, <br />
                                <br />
                                Sie möchten Ihre:n Arbeitgeber:in dabei unterstützen, die
                                digitale Transformation Ihres Betriebes voranzutreiben. Zudiesem Zweck soll nun zunächst
                                mit Hilfe eins Digital Checks der aktuelle Stand ermittelt werden. Bitte füllen Sie den
                                Bogen spontan und einfach nach bestem Wissen aus. Dabei handelt es sich in der Regel um
                                Ihresubjektive Wahrnehmung und Einschätzung. Sollte eine einfache Antwort durch
                                ankreuzen nicht möglich
                                sein, nutzen Sie bitte gern die Möglichkeit, in den folgenden Freitextfeldern unter
                                "Sonstiges" Ihre Antworten auszuführen. Wir stellen Ihnen Fragen zur Einschätzung des
                                aktuellen Stands der Digitalisierung im Unternehmen, zu Abläufen täglicher
                                Arbeitsprozesse, sowie zu den Bereichen Technisierung, Arbeitsorganisation,
                                Digitalisierung der
                                Produtkpalette die digitale Kundenanbindung, den Umgang mit Lieferanten und den Aufbau
                                digitaler Kompetenzen. <br />
                                <br />
                                Noch ein letzter Hinweis zum Datenschutz: Ihre Eingaben werden vom
                                System komplett anonymisiert, d. h. niemand kann die von Ihnen getätigten Angaben Ihrem
                                Nutzer eindeutig zuordnen. Es werden lediglich Daten zum Bearbeitungsstand Nutzerbasiert
                                erhoben und weitergegeben.<br />
                                <br />
                                Wir bedanken uns für Ihre Unterstützung! <br />
                                Mit besten Grüßen <br />
                                Das digitale Projektteam der mittelstandpioniere.
                            </p>
                        </div>
                        <form id="self_ass_form">
                            @csrf

                            @include('forms.fieldsets.digital-transformation')
                            @include('forms.fieldsets.digital-products')
                            @include('forms.fieldsets.digital-processes')
                            @include('forms.fieldsets.digital-employees')
                            @include('forms.fieldsets.digital-customer-loyalty')
                            @include('forms.fieldsets.digital-supplier-loyalty')
                            @include('forms.fieldsets.digitalized-machines')
                            @include('forms.fieldsets.digital-data')

                            <div class="relative mt-4">
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-primary bg-opacity-25">
                                    <div data-js-progress
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary">
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button disabled
                                    class="ml-4 inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-senbold text-xs text-white uppercase tracking-widest focus:outline-none hover:bg-opacity-75 disabled:opacity-25 transition ease-in-out duration-150"
                                    data-js-prev>Zurück</button>
                                <button disabled
                                    class="ml-4 inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-senbold text-xs text-white uppercase tracking-widest focus:outline-none hover:bg-opacity-75 disabled:opacity-25 transition ease-in-out duration-150"
                                    data-js-next>Weiter</button>
                                <button data-js-confirm-button
                                    class="ml-4 inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-senbold text-xs text-white uppercase tracking-widest focus:outline-none hover:bg-opacity-75 disabled:opacity-25 transition ease-in-out duration-150">
                                    Weiter
                                </button>

                            </div>
                            @include('forms.confirm-modal')
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
