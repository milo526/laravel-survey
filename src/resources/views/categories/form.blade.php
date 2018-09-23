<div class="sv-flex">
    <div class="sv-w-full xl:sv-w-192 sv-max-w-full sv-m-auto">
        <form class="sv-card" action="{{ isset($category) ? route('survey::categories.update', $category) : route('survey::categories.store') }}" method="POST">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif
            <div class="sv-card-header">
                <div class="sv-card-title">{{ isset($category) ? "Editing category: {$category->title}" : 'Creating a new category.' }}</div>
            </div>
            <div class="sv-form-input-group {{ $errors->has('title') ? "sv-form-error" : '' }}">
                <label class="sv-form-label" for="title">
                    Title
                </label>
                <input class="sv-form-input" id="title" name="title" type="text" value="{{ old('title') ?: (isset($category) ? $category->title : '') }}"}}>
                @if($errors->has('title'))
                    <p class="sv-form-error-text">{{ $errors->first('title') }}</p>
                @endif
            </div>

            <div>
                <button class="sv-btn sv-btn-primary" type="submit">
                    {{ isset($category) ? 'Update' : 'Create' }}
                </button>

                <a class="sv-btn sv-btn-secondary" href="{{ isset($category) ? route('survey::categories.show', $category) : route('survey::categories.index') }}">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>