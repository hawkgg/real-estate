@extends('layouts.app')

@section('title')
    Дом {{ $house['name'] }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-between flex-nowrap">
                <a class="text-decoration-none d-flex align-items-center gap-1" href="{{ url()->previous() }}">
                    <i class="fa-solid fa-chevron-left"></i> Назад
                </a>
                @if(Auth::user()->hasRole('admin'))
                    <td>
                        <div class="p-2 d-flex gap-2">
                            <a class="btn btn-primary" href="{{ route('houses.edit', $house->id) }}">
                                <i class="fa-solid fa-pencil me-1"></i> Редактировать
                            </a>

                            <form action="{{ route('houses.destroy', $house) }}" method="post">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger" type="submit">
                                    <i class="fa-solid fa-trash"></i> Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                @endif
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-xl-4">
                @if(count($house->photos))
                    <div class="slick-single-item">
                        @foreach($house->photos as $photo)
                            <div>
                                <img class="w-100" src="{{ asset($photo->path) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                @else
                    <h3>Фото отсутствует</h3>
                @endisset
            </div>
            <div class="col-xl-8 px-xl-3">
                <p class="mb-2"><b>Название</b>: {{ $house->name }}</p>
                <p class="my-2"><b>Цена</b>: {{ $house->default_price }} {{ $house->default_currency->name }}</p>
                <p class="my-2"><b>Этажность</b>: {{ $house->floors ?? '–' }}</p>
                <p class="my-2"><b>Спальни</b>: {{ $house->bedrooms ?? '–' }}</p>
                <p class="my-2"><b>Площадь</b>: {{ $house->square ?? '–' }}</p>
                <p class="my-2"><b>Тип объекта</b>: {{ strtolower($house['estate_type']['name']) }}</p>
                <p class="my-2"><b>Посёлок</b>: {{ $house->village->name }}</p>
            </div>
        </div>
    </div>
@endsection

@section('bottom_scripts')
    @parent
    <script type="module">
        $(document).ready(function(){
            $('.slick-single-item').slick({
                slidesToShow: 1,
                dots: true,
            });
        });
    </script>
@endsection
