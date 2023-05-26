@extends('layouts.app')

@section('title')
    Дома
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Дома</h1>
            </div>
            @can('house.create')
                <div class="col text-end">
                    <a href="{{ route('houses.create') }}" class="btn btn-primary">Создать</a>
                </div>
            @endcan
        </div>
        <div class="row">
            <div class="w-auto">
                <form action="{{ route('houses.index') }}" class="row g-3">
                    <div class="col-12 col-lg-auto">
                        <input type="text" class="form-control" name="q" placeholder="Поиск по названию" value="{{ request()->get('q') }}">
                        @if (request()->get('sort_param'))
                            <input type="hidden" name="sort_param" value="{{ request()->get('sort_param') }}">
                        @endif
                        @if (request()->get('sort_direction'))
                            <input type="hidden" name="sort_direction" value="{{ request()->get('sort_direction') }}">
                        @endif
                    </div>

{{--                    <div class="d-flex col-6 col-lg-2 gap-2">--}}
{{--                        <label for="inputPrice" class="col-form-label">Цена:</label>--}}
{{--                        <input type="number" name="price" id="inputPrice" class="form-control" aria-describedby="priceHelpInline">--}}
{{--                    </div>--}}

                    <div class="d-flex col-6 col-lg-2 gap-2">
                        <label for="inputCurrency" class="col-form-label text-nowrap">Валюта:</label>
                        <select name="currency" id="inputCurrency" class="form-select @error('currency') is-invalid @enderror">
                            <option value="" @if(!request()->get('currency')) selected @endif>Любая</option>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}" {{ (int) request()->get('currency') === $currency->id ? "selected" : "" }}>
                                    {{ $currency->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex col-6 col-lg-2 gap-2">
                        <label for="inputFloors" class="col-form-label">Этажность:</label>
                        <input type="number" name="floors" id="inputFloors" value="{{ request()->get('floors') }}" class="form-control" aria-describedby="floorsHelpInline">
                    </div>

                    <div class="d-flex col-6 col-lg-2 gap-2">
                        <label for="inputBedrooms" class="col-form-label">Спальни:</label>
                        <input type="number" name="bedrooms" id="inputBedrooms" value="{{ request()->get('bedrooms') }}" class="form-control" aria-describedby="bedroomsHelpInline">
                    </div>

                    <div class="d-flex col-6 col-lg-2 gap-2">
                        <label for="inputSquare" class="col-form-label">Площадь:</label>
                        <input type="number" name="square" id="inputSqare" value="{{ request()->get('square') }}" class="form-control" aria-describedby="squareHelpInline">
                    </div>

                    <div class="d-flex col-6 col-lg-2 gap-2">
                        <label for="inputEstateType" class="col-form-label text-nowrap">Тип объекта:</label>
                        <select name="estate_type" id="inputEstateType" class="form-select @error('village') is-invalid @enderror">
                            <option value="" @if(!request()->get('estate_type')) selected @endif>Любой</option>
                            @foreach($estate_types as $estate_type)
                                <option value="{{ $estate_type->id }}" {{ (int) request()->get('estate_type') === $estate_type->id ? "selected" : "" }}>
                                    {{ $estate_type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex col-6 col-lg-3 gap-2">
                        <label for="inputVillage" class="col-form-label">Посёлок:</label>
                        <select name="village" id="inputVillage" class="form-select @error('village') is-invalid @enderror">
                            <option value="" @if(!request()->get('village')) selected @endif>Любой</option>
                            @foreach($villages as $village)
                                <option value="{{ $village->id }}" {{ (int) request()->get('village') === $village->id ? "selected" : "" }}>
                                    {{ $village->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-auto">
                        <input type="submit" class="btn btn-primary" value="Найти">
                    </div>
                </form>
            </div>
        </div>
        @if(session()->has('success'))
            <div class="mt-3 alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="row mt-3">
            <div class="col overflow-auto">
                @if (count($houses))
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="w-20">Фото</th>
                                <th>Название</th>
                                <th>
                                    @if (request()->get('currency'))
                                        <a href="{{ route('houses.index', [
                                        'sort_param' => 'price',
                                        'sort_direction' => request()->get('sort_direction') === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->get('q'),
                                        'currency' => request()->get('currency'),
                                        'floors' => request()->get('floors'),
                                        'bedrooms' => request()->get('bedrooms'),
                                        'square' => request()->get('square'),
                                        'estate_type' => request()->get('estate_type'),
                                        'village' => request()->get('village'),
                                        ]) }}"
                                           class="sortable @if(request()->get('sort_param') === 'price') {{ request()->get('sort_direction') }} @endif"
                                        >
                                            Цена
                                        </a>
                                    @else
                                        Цена
                                    @endif
                                </th>
                                <th>
                                    <a href="{{ route('houses.index', [
                                        'sort_param' => 'floors',
                                        'sort_direction' => request()->get('sort_direction') === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->get('q'),
                                        'currency' => request()->get('currency'),
                                        'floors' => request()->get('floors'),
                                        'bedrooms' => request()->get('bedrooms'),
                                        'square' => request()->get('square'),
                                        'estate_type' => request()->get('estate_type'),
                                        'village' => request()->get('village'),
                                        ]) }}"
                                       class="sortable @if(request()->get('sort_param') === 'floors') {{ request()->get('sort_direction') }} @endif"
                                    >
                                        Этажность
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('houses.index', [
                                        'sort_param' => 'bedrooms',
                                        'sort_direction' => request()->get('sort_direction') === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->get('q'),
                                        'currency' => request()->get('currency'),
                                        'floors' => request()->get('floors'),
                                        'bedrooms' => request()->get('bedrooms'),
                                        'square' => request()->get('square'),
                                        'estate_type' => request()->get('estate_type'),
                                        'village' => request()->get('village'),
                                        ]) }}"
                                       class="sortable @if(request()->get('sort_param') === 'bedrooms') {{ request()->get('sort_direction') }} @endif"
                                    >
                                        Спальни
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('houses.index', [
                                        'sort_param' => 'square',
                                        'sort_direction' => request()->get('sort_direction') === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->get('q'),
                                        'currency' => request()->get('currency'),
                                        'floors' => request()->get('floors'),
                                        'bedrooms' => request()->get('bedrooms'),
                                        'square' => request()->get('square'),
                                        'estate_type' => request()->get('estate_type'),
                                        'village' => request()->get('village'),
                                        ]) }}"
                                       class="sortable @if(request()->get('sort_param') === 'square') {{ request()->get('sort_direction') }} @endif"
                                    >
                                        Площадь
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('houses.index', [
                                        'sort_param' => 'estate_type',
                                        'sort_direction' => request()->get('sort_direction') === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->get('q'),
                                        'currency' => request()->get('currency'),
                                        'floors' => request()->get('floors'),
                                        'bedrooms' => request()->get('bedrooms'),
                                        'square' => request()->get('square'),
                                        'estate_type' => request()->get('estate_type'),
                                        'village' => request()->get('village'),
                                        ]) }}"
                                       class="sortable @if(request()->get('sort_param') === 'estate_type') {{ request()->get('sort_direction') }} @endif"
                                    >
                                        Тип объекта
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('houses.index', [
                                        'sort_param' => 'village',
                                        'sort_direction' => request()->get('sort_direction') === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->get('q'),
                                        'currency' => request()->get('currency'),
                                        'floors' => request()->get('floors'),
                                        'bedrooms' => request()->get('bedrooms'),
                                        'square' => request()->get('square'),
                                        'estate_type' => request()->get('estate_type'),
                                        'village' => request()->get('village'),
                                        ]) }}"
                                       class="sortable @if(request()->get('sort_param') === 'village') {{ request()->get('sort_direction') }} @endif"
                                    >
                                        Посёлок
                                    </a>
                                </th>
                                @if(Auth::user()->hasRole('admin'))
                                    <th>Управление</th>
                                @endif
                            </tr>
                        </thead>
                        @foreach($houses as $house)
                            <tr class="align-middle position-relative">
                                <td>
                                    <div class="house-image show-link-wrapper">
                                        <a class="show-link" href="{{ route('houses.show', $house->id) }}">
                                            @if(count($house->photos))
                                                <img height="100" src="{{ asset($house->photos->first()->path) }}" alt="">
                                            @endif
                                        </a>
                                    </div>
                                </td>
                                <td><div class="show-link-wrapper"><a class="show-link" href="{{ route('houses.show', $house->id) }}">{{ $house->name }}</a></div></td>
                                <td><div class="show-link-wrapper"><a class="show-link" href="{{ route('houses.show', $house->id) }}">{{ $house->default_price }} {{ $house->default_currency->name }}</a></div></td>
                                <td><div class="show-link-wrapper"><a class="show-link" href="{{ route('houses.show', $house->id) }}">{{ $house->floors }}</a></div></td>
                                <td><div class="show-link-wrapper"><a class="show-link" href="{{ route('houses.show', $house->id) }}">{{ $house->bedrooms }}</a></div></td>
                                <td><div class="show-link-wrapper"><a class="show-link" href="{{ route('houses.show', $house->id) }}">{{ $house->square }}</a></div></td>
                                <td><div class="show-link-wrapper"><a class="show-link" href="{{ route('houses.show', $house->id) }}">{{ $house->estate_type->name }}</a></div></td>
                                <td><div class="show-link-wrapper"><a class="show-link" href="{{ route('houses.show', $house->id) }}">{{ $house->village->name }}</a></div></td>
                                @if(Auth::user()->hasRole('admin'))
                                    <td>
                                        <div class="p-2 d-flex gap-2">
                                            <a class="btn btn-primary" href="{{ route('houses.edit', $house->id) }}"><i class="fa-solid fa-pencil"></i></a>
                                            <form action="{{ route('houses.destroy', $house->id) }}" method="post">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p class="fw-bold">Не найдено.</p>
                @endif
            </div>
            <div class="d-flex justify-content-center">
                {{ $houses->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
@endsection
