@php
        if(!isset($selected)){
            $selected = [];
        } elseif(!is_array($selected)){
            $selected = explode(".", $selected);
        }
        $selectedColor = "sv-text-orange-dark";
@endphp
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Survey Admin</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="/vendor/survey/css/app.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body>
    <div id="wrapper" class="sv-flex sv-w-full sv-flex-col md:sv-flex-row sv-font-light sv-h-screen sv-bg-grey-lightest">
        <div id="sidebar" class="sv-bg-orange-darker sv-w-screen md:sv-w-64">
            <header class="sv-flex sv-justify-between sv-items-center sv-border-b sv-border-orange-darkest sv-pt-8 sv-pb-8 sv-pl-6 sv-pr-6">
                <div id="logo">
                    <a href="#" class="sv-no-underline sv-text-white md:sv-text-2xl sv-text-4xl sv-font-bold">
                        Survey Admin
                    </a>
                </div>
                <div id="collapse" class="sv-text-white sv-border sv-border-white sv-p-2 sv-h-8 sv-rounded sm:sv-block md:sv-hidden sv-cursor-pointer">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>
            </header>
            <ul id="menu" class="sv-hidden sv-list-reset sv-hidden md:sv-block">
                <li class="sv-block">
                    <a href="#" class="sv-no-underline {{ in_array('dashboard', $selected) ? $selectedColor : 'sv-text-white' }} sv-block sv-h-full sv-w-full sv-border-b sv-border-orange-darkest sv-px-8 sv-py-4 hover:sv-text-orange">
                        <i class="fa fa-tachometer sv-mr-2" aria-hidden="true"></i>
                        Dashboard
                    </a>
                </li>
                <li class="sv-block sv-border-b sv-border-orange-darkest">
                    <div id="categories-menu" class="sv-no-underline {{ in_array('categories', $selected) ? $selectedColor : 'sv-text-white' }} sv-block sv-h-full sv-w-full sv-px-8 sv-py-4 hover:sv-text-orange sv-cursor-pointer">
                        <i class="fa fa-book sv-mr-2" aria-hidden="true"></i>
                        Categories
                        <i class="fa fa-angle-down sv-float-right" aria-hidden="true"></i>
                    </div>
                    <ul id="categories-menu-list" class="sv-hidden sv-list-reset">
                        @foreach(\MCesar\Survey\Facade\Category::all() as $category)
                            <li class="sv-block">
                                <a href="{{ route('survey::categories.show', $category )}}" class="sv-no-underline {{ in_array($category->title, $selected) ? $selectedColor : 'sv-text-white' }} sv-block sv-h-full sv-w-full sv-ml-4 hover:sv-text-orange sv-px-8 sv-py-2">
                                    <i class="fa fa-minus sv-mr-2" aria-hidden="true"></i>
                                    {{$category->title}}
                                </a>
                            </li>
                        @endforeach

                        <li class="sv-block">
                            <a href="{{ route('survey::categories.create') }}" class="sv-no-underline {{ in_array('create_new_category', $selected) ? $selectedColor : 'sv-text-white' }} sv-block sv-h-full sv-w-full sv-ml-4 hover:sv-text-orange sv-px-8 sv-py-2">
                                <i class="fa fa-plus sv-mr-2" aria-hidden="true"></i>
                                New
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div id="content" class="sv-flex-1">
            @if(Session::has('notification'))
                <div class="sv-banner sv-banner-{{ Session::get('notification')['type'] }}" role="alert">
                    {{ Session::get('notification')['message'] }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <!-- Scrips -->
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/vendor/survey/js/app.js"></script>
</body>
</html>
