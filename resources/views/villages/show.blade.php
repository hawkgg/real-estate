@extends('layouts.app')

@section('title')
    Посёлок {{ $village['name'] }}
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
                            <a class="btn btn-primary" href="{{ route('villages.edit', $village->id) }}">
                                <i class="fa-solid fa-pencil me-1"></i> Редактировать
                            </a>

                            <form action="{{ route('villages.destroy', $village) }}" method="post">
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
                @isset($village->photo)
                    <img class="w-100" src="{{ asset($village->photo->path) }}" alt="">
                @else
                    <h3>Фото отсутствует</h3>
                @endisset
            </div>
            <div class="col-xl-8 px-xl-3">
                <p class="mb-2"><b>Название</b>: {{ $village['name'] }}</p>
                <p class="my-2"><b>Адрес</b>: {{ $village['address'] }}</p>
                <p class="my-2"><b>Площадь поселка (гектар)</b>: {{ $village['square'] ?? '–' }}</p>
                <p class="my-2"><b>Горячая линия (телефон)</b>: {{ $village['phone'] ?? '–' }}</p>
                <p class="my-2"><b>YouTube видео</b>:
                    @isset($village['youtube_link'])
                        <a target="_blank" href="{{ $village['youtube_link'] }}">{{ $village['youtube_link'] }}</a>
                    @else
                        –
                    @endisset
                </p>

                @isset($village->presentation)
                    <p class="my-2">
                        <b>Файл презентации (pdf)</b>:
                        <a target="_blank"
                           class="text-decoration-none"
                           target="_blank"
                           href="{{ asset('storage/'.$village->presentation->path) }}">
                            {{ asset('storage/'.$village->presentation->path) }}
                        </a>
                    </p>
                @endisset
            </div>
        </div>
    </div>
@endsection
