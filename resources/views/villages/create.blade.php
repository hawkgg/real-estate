@extends('layouts.app')

@section('title')
    Добавление посёлка
@endsection

@section('content')
    <div class="container">
        <a class="text-decoration-none d-flex align-items-center gap-1" href="{{ url()->previous() }}">
            <i class="fa-solid fa-chevron-left"></i> Назад
        </a>
        <div class="row mt-4">
            <div class="col">
                <h1>Добавление посёлка</h1>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-7">
                <form method="post" action="{{ route('villages.store') }}" class="row g-3" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('POST') }}
                    <div class="form-group">
                        <label for="village-name">Название:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="village-name" required name="name" value="{{ old('name') }}" placeholder="Вятское">
                    </div>
                    @error('name')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-address">Адрес:</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="village-address" required name="address" value="{{ old('address') }}" placeholder="Ярославская обл.">
                    </div>
                    @error('address')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-square" class="form-label">Площадь поселка (гектар): <span id="squareval">{{ old('square', 50) }}</span></label>
                        <input type="range" class="form-range @error('square') is-invalid @enderror" id="village-square" name="square" value="{{ old('square') }}" onInput="$('#squareval').html($(this).val())">
                    </div>
                    @error('square')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-phone">Горячая линия (телефон):</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" pattern="[0-9]+" id="village-phone" name="phone" value="{{ old('phone') }}" placeholder="79999999999">
                    </div>
                    @error('phone')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-youtube">YouTube видео:</label>
                        <input type="tel" class="form-control @error('youtube_link') is-invalid @enderror" id="village-youtube" name="youtube_link" value="{{ old('youtube_link') }}" placeholder="Ссылка на видео">
                    </div>
                    @error('youtube_link')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-photo">Фотография:</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="village-photo" name="photo" value="{{ old('photo') }}" accept=".jpg,.jpeg,.png">
                    </div>
                    @error('photo')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-presentation">Файл презентации (pdf):</label>
                        <input type="file" class="form-control @error('presentation') is-invalid @enderror" id="village-presentation" name="presentation" accept=".pdf" value="{{ old('presentation') }}">
                    </div>
                    @error('presentation')
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
