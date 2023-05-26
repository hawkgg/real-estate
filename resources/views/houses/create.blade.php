@extends('layouts.app')

@section('title')
    Добавление дома
@endsection

@section('content')
    <div class="container">
        <a class="text-decoration-none d-flex align-items-center gap-1" href="{{ url()->previous() }}">
            <i class="fa-solid fa-chevron-left"></i> Назад
        </a>
        <div class="row mt-4">
            <div class="col">
                <h1>Добавление дома</h1>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-7">
                <form method="post" action="{{ route('houses.store') }}" class="row g-3" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('POST') }}
                    <div class="form-group">
                        <label for="house-name">Название:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="house-name" required name="name" value="{{ old('name') }}" placeholder="Колотушкина">
                    </div>
                    @error('name')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group d-flex gap-3 col-md-7">
                        <div class="col-7">
                            <div class="form-group">
                                <label for="house-address">Цена:</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="house-address" min="0" required name="price" value="{{ old('price') }}">
                            </div>
                            @error('price')
                                <span class="d-block invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label for="house-currency">Валюта:</label>
                                <select name="currency" id="house-currency" class="form-select @error('currency') is-invalid @enderror">
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}" {{ old('currency') === $currency->id ? "selected" : "" }}>
                                            {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('currency')
                            <span class="d-block invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="house-name">Этажность:</label>
                        <input type="number" class="form-control @error('floors') is-invalid @enderror" id="house-floors" min="0" required name="floors" value="{{ old('floors') }}" placeholder="10">
                    </div>
                    @error('floors')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="house-name">Спальни:</label>
                        <input type="number" class="form-control @error('bedrooms') is-invalid @enderror" id="house-bedrooms" min="0" required name="bedrooms" value="{{ old('bedrooms') }}" placeholder="3">
                    </div>
                    @error('bedrooms')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="house-square" class="form-label">Площадь: <span id="squareval">{{ old('square', 50) }}</span></label>
                        <input type="range" class="form-range @error('square') is-invalid @enderror" id="house-square" name="square" value="{{ old('square') }}" onInput="$('#squareval').html($(this).val())">
                    </div>
                    @error('square')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="house-currency">Тип объекта:</label>
                        <select name="estate_type" id="house-estate-type" class="form-select @error('estate_type') is-invalid @enderror">
                            @foreach($estate_types as $estate_type)
                                <option value="{{ $estate_type->id }}" {{ old('estate_type') === $estate_type->id ? "selected" : "" }}>
                                    {{ $estate_type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('estate_type')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="house-village">Посёлок:</label>
                        <select name="village" id="house-village" class="form-select @error('village') is-invalid @enderror">
                            @foreach($villages as $village)
                                <option value="{{ $village->id }}" {{ old('village') === $village->id ? "selected" : "" }}>
                                    {{ $village->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('village')
                    <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="house-photo">Фотографии:</label>
                        <input type="file" class="form-control @error('photos') is-invalid @enderror" id="house-photo" name="photos[]" multiple accept=".jpg,.jpeg,.png">
                    </div>
                    @error('photos')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
