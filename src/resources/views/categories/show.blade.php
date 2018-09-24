@extends('survey::layouts.app')

@section('content')
    <div class="sv-flex sv-flex-wrap md:sv-p-4">
        <div class="sv-w-full md:sv-w-1/2">
            <div class="sv-card">
                <div class="sv-card-header">
                    <p class="sv-card-title">{{$category->title}}</p>
                    <a href="{{ route('survey::categories.edit', $category) }}" class="sv-btn sv-btn-primary">Edit</a>
                </div>
            </div>
        </div>
        <div class="sv-w-full md:sv-w-1/2">
            <div class="sv-card">
                <div class="sv-card-header">
                    <p class="sv-card-title">Questions</p>
                    <a href="{{ route('survey::categories.questions.create', $category) }}" class="sv-btn sv-btn-primary">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
                @forelse($category->questions as $question)
                    <div class="sv-question-show">
                        <div class="sv-question-title">
                            {{ $question->title }}
                        </div>
                        <div class="sv-question-view">
                            <a class="sv-btn sv-btn-secondary" href="{{ route('survey::categories.questions.show', [$category, $question]) }}">
                                <i class="fa fa-eye sv-text-grey-dark" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="sv-question-edit">
                            <a class="sv-btn sv-btn-primary" href="{{ route('survey::categories.questions.edit', [$category, $question]) }}">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="sv-question-delete">
                            <form method="POST" action="{{ route('survey::categories.questions.destroy', [$category, $question]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="sv-btn sv-btn-danger">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="sv-text-grey-darker sv-text-base sv-text-center">
                        This category does not yet have any questions, <a href="{{ route('survey::categories.questions.create', $category) }}">get started by adding a question</a>.
                    </p>
                @endempty
            </div>
        </div>
    </div>
@endsection