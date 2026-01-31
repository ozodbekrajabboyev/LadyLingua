@extends('layouts.app')

@section('title', config('app.name', 'LadyLingo') . ' - Tarjimonlar va Kitobxonlar Platformasi')

@section('content')
    <x-hero-section />

    <section class="w-full max-w-[1200px] px-6 lg:px-40 py-12">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-bold text-[#121117] dark:text-white">So'nggi tarjimalar</h3>
            <a class="text-primary text-sm font-semibold hover:underline" href="#">Barchasini ko'rish</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <x-translation-card
                title="Tibbiy tadqiqot maqolasi"
                description="Immunologiya protokollari va so'nggi klinik sinovlar natijalari bo'yicha chuqur tahlil."
                language-from="EN"
                language-to="UZ"
                rating="4.9"
                translator-name="Alex Johnson"
                translator-image="https://lh3.googleusercontent.com/aida-public/AB6AXuC9bjI5ADhoNg3pH0jiOdejkrsjEmhL3pc8aCobsNUrAro-IpxGGo6GzYHhwF5Yv4hYHuuv2SY7AIlh8G2zWyzeG7RIp23-NHPLfJSNfND-hnSSEM-UYgHqa0hwa6RNNtkBvw8t0g6LtZu99gexkRnbzdu26v7hIsEmSZWAcP5yXleHATYrjqfYmTkpNB1nYSlR819hti8XEFfzHWrthDzIgt_oaLIzhnwPUyn1_zQbFIbgvL6tog_zLaG28g3OO9qw1IlGf7dN-zA"
                time-ago="2 soat oldin"
            />

            <x-translation-card
                title="E-commerce Ilova"
                description="Parijda joylashgan lyuks moda brendi uchun to'liq interfeys mahalliylashtirish."
                language-from="FR"
                language-to="UZ"
                rating="5.0"
                translator-name="Sarah Chen"
                translator-image="https://lh3.googleusercontent.com/aida-public/AB6AXuC8nf31r4FRPw0TxG1H-kybc9zij5xOvPbkTe7_JpXxnkjpTpOZdwx0kU_DPaQQOZg05aI73Urv_4TrWt5E8-Q0KfgqmETkau5Nnmt57topwJNu0FWnF-nmXMBRpsV34wfcNdj6KCAtlvEu5VZZ6Z4VyHmuUfBUSZ_uymnFZ4N6sJ24BzoDk8PO6RC-_l3PmQqXf7yLobvHbe-1nzUgDJvJxkMqaMzfxOrvlbTyWS72L-QVXMwUvDg92MUNKj9o80sSGXYkQOkvp3g"
                time-ago="5 soat oldin"
            />

            <x-translation-card
                title="Yillik moliyaviy hisobot"
                description="Rasmiy balans varaqlari, audit natijalari va investorlar uchun ma'lumotlar."
                language-from="RU"
                language-to="UZ"
                rating="4.8"
                translator-name="Marcus Weber"
                translator-image="https://lh3.googleusercontent.com/aida-public/AB6AXuC7NA-A9Ozm74RROTzGtrfODF8hHEIabAyFU8aIo7fhpZkwQm7K6WCedAF-78XXSPgW7z0M-i2i5wWIn7OP5d1hddxovJFlvmf_6zY2kHcTk-scTlIOm6Aq4nyaJVnh6gstzdeihzioDSKO6fnAt7QHcfLbSkO3o4Dm0cGE287OSaa_mfXYCb25pgNsrR5WvkpqDiF6VufTVhN8H3NG1KLexI3FvMIdyFbewiWtKXWPyajVzWmbyBsg8ZpeO2KoD74dM0nNHBSMkgo"
                time-ago="Kecha"
            />
        </div>
    </section>
@endsection
