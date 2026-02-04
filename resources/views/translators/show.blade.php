@extends('layouts.app')

@section('title', 'Tarjimon - ' . $translatorData['name'])

@section('content')
    <main class="flex-grow flex flex-col items-center py-6 px-4 md:px-8 max-w-[1280px] mx-auto w-full gap-6">
        {{-- Translator Profile Header --}}
        @include('translators.partials.profile-header', ['translator' => $translatorData])

        {{-- Statistics Section --}}
        @include('translators.partials.profile-stats', ['translator' => $translatorData])

        {{-- Completed Works Section --}}
        @include('translators.partials.completed-works', ['translations' => $completedTranslations])

        {{-- Skills and Languages Section --}}
        @include('translators.partials.skills-languages', ['translator' => $translatorData])
    </main>
@endsection
