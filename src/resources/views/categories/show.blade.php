@extends('survey::layouts.app')

@section('content')
    <div class="sv-flex">
        <div class="sm:sv-w-full md:sv-w-1/2 sv-m-4">
            <div class="sv-card">
                <div class="sv-card-header">
                    <p class="sv-card-title">{{$category->title}}</p>
                    <a href="{{ route('survey::categories.edit', $category) }}" class="sv-btn sv-btn-primary">Edit</a>
                </div>
            </div>
        </div>
        <div class="sm:sv-w-full md:sv-w-1/2 sv-m-4">
            <div class="sv-card">
                <div class="sv-text-black sv-font-bold sv-text-xl sv-mb-2">Questions</div>
                <ul>
                    @forelse($category->questions as $question)
                        <li class="sv-text-grey-darker sv-text-base">{{ $question->title }}</li>
                    @empty
                        <p class="sv-text-grey-darker sv-text-base sv-text-center">
                            This category does not yet have any questions, <a href="{{ route('survey::categories.questions.create', $category) }}">get started by adding a question</a>.
                        </p>
                    @endempty
                </ul>
            </div>
        </div>
    </div>
@endsection