<div class="sv-flex">
    <div class="sv-w-full xl:sv-w-192 sv-max-w-full sv-m-auto">
        <form class="sv-card" action="{{ isset($question) ? route('survey::categories.questions.update', [$category, $question]) : route('survey::categories.questions.store', $category) }}" method="POST">
            @csrf
            @if(isset($question))
                @method('PUT')
            @endif

            <div class="sv-card-header">
                <div class="sv-card-title">{{ isset($question) ? "Editing question: {$question->title}" : 'Creating a new question.' }}</div>
            </div>
            <div class="sv-form-input-group {{ $errors->has('title') ? "sv-form-error" : '' }}">
                <label class="sv-form-label" for="title">
                    Title
                </label>
                <input class="sv-form-input" id="title" name="title" type="text" value="{{ old('title') ?: (isset($question) ? $question->title : '') }}"}}>
                @if($errors->has('title'))
                    <p class="sv-form-error-text">{{ $errors->first('title') }}</p>
                @endif
            </div>

            <div class="sv-form-input-group {{ $errors->has('type') ? "sv-form-error" : '' }}">
                <label class="sv-form-label" for="type">
                    Type
                </label>
                <select class="sv-form-input" id="type" name="type">
                    @foreach(\MCesar\Survey\Facade\Question::types() as $type)
                        <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : (isset($question) && $question->type == $type ? 'selected' : '') }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <p class="sv-form-error-text">{{ $errors->first('type') }}</p>
                @endif
            </div>

            <div class="sv-form-input-group {{ $errors->has('values') ? "sv-form-error" : '' }}">
                <label class="sv-form-label" for="values">
                    Values
                </label>

                <input class="sv-form-input" id="values" name="values" type="text" value="{{ old('values') ?: (isset($question) ? implode(', ', $question->values) : '') }}"}}>
                @if($errors->has('values'))
                    <p class="sv-form-error-text">{{ $errors->first('values') }}</p>
                @endif
            </div>

            <div class="sv-form-input-group {{ $errors->has('required') ? "sv-form-error" : '' }}">
                <label class="sv-form-label" for="required">
                    Required
                </label>
                <input id="required" name="required" type="checkbox" value="1" {{ old('required') ? "checked" : (isset($question) && $question->required ? 'checked' : '') }}>
                @if($errors->has('required'))
                    <p class="sv-form-error-text">{{ $errors->first('required') }}</p>
                @endif
            </div>

            <div>
                <button class="sv-btn sv-btn-primary" type="submit">
                    {{ isset($category) ? 'Update' : 'Create' }}
                </button>

                <a class="sv-btn sv-btn-secondary" href="{{ isset($question) ? route('survey::categories.questions.show', [$category, $question]) : route('survey::categories.show', $category) }}">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>