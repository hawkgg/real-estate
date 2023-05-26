@extends('layouts.app')

@section('title')
    Редактирование посёлка {{ $village['name'] }}
@endsection

@section('content')
    <div class="container">
        <a class="text-decoration-none d-flex align-items-center gap-1" href="{{ url()->previous() }}">
            <i class="fa-solid fa-chevron-left"></i> Назад
        </a>
        <div class="row mt-4">
            <div class="col">
                <h1>Редактирование посёлка</h1>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-7">
                <form method="post" action="{{ route('villages.update', ['id' => $village->id]) }}" class="row g-3" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="form-group">
                        <label for="village-name">Название:</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="village-name" name="name" value="{{ $village->name }}" placeholder="Вятское">
                    </div>
                    @error('name')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-address">Адрес:</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="village-address" name="address" value="{{ $village->address }}" placeholder="Ярославская обл.">
                    </div>
                    @error('address')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-square" class="form-label">Площадь поселка (гектар): <span id="squareval">{{ $village->square ?? '50' }}</span></label>
                        <input type="range" class="form-range" id="village-square" name="square" value="{{ $village->square }}" onInput="$('#squareval').html($(this).val())">
                    </div>
                    @error('square')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-phone">Горячая линия (телефон):</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" pattern="[0-9]+" id="village-phone" name="phone" value="{{ $village->phone }}" placeholder="79999999999">
                    </div>
                    @error('phone')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-youtube">YouTube видео:</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="village-youtube" name="youtube_link" value="{{ $village->youtube_link }}" placeholder="Ссылка на видео">
                    </div>
                    @error('youtube_link')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-photo">Фотография:</label>
                        <input type="file" class="form-control @error('phone') is-invalid @enderror" id="village-photo" name="photo" accept=".jpg,.jpeg,.png">
                    </div>
                    @error('photo')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <label for="village-presentation">Файл презентации (pdf):</label>
                        <input type="file" class="form-control @error('phone') is-invalid @enderror" id="village-presentation" name="presentation" accept=".pdf">
                    </div>
                    @error('presentation')
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
