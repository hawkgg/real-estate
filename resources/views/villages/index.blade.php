@extends('layouts.app')

@section('title')
    Посёлки
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Посёлки</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-10">
                <form action="{{ route('villages.index') }}" class="row row-cols-lg-auto g-2">
                    <div class="col w-25">
                        <input type="text" class="form-control" name="q" placeholder="Поиск по названию" value="{{ request()->get('q') }}">
                        @if (request()->get('sort_param'))
                            <input type="hidden" name="sort_param" value="{{ request()->get('sort_param') }}">
                        @endif
                        @if (request()->get('sort_direction'))
                            <input type="hidden" name="sort_direction" value="{{ request()->get('sort_direction') }}">
                        @endif
                    </div>
                    <div class="col">
                        <input type="submit" class="btn btn-primary" value="Найти">
                    </div>
                </form>
            </div>
            @can('village.create')
                <div class="col text-end">
                    <a href="{{ route('villages.create') }}" class="btn btn-primary">Создать</a>
                </div>
            @endcan
        </div>
        @if(session()->has('success'))
            <div class="mt-3 alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="mt-3 alert alert-danger">
                <p class="fw-bold mb-1">Удаление не выполнено:</p>
                <p class="mb-0">{{ session()->get('error') }}</p>
            </div>
        @endif
        <div class="row mt-3">
            <div class="col overflow-auto mb-3">
                @if (count($villages))
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="w-20">Фото</th>
                                <th>Название</th>
                                <th>Адрес</th>
                                <th>
                                    <a href="{{ route('villages.index', [
                                        'sort_param' => 'square',
                                        'sort_direction' => request()->get('sort_direction') === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->get('q')
                                        ]) }}"
                                       class="sortable @if(request()->get('sort_param') === 'square') {{ request()->get('sort_direction') }} @endif"
                                       >
                                        Площадь посёлка (гектар)
                                    </a>
                                </th>
                                @if(Auth::user()->hasRole('admin'))
                                    <th>Управление</th>
                                @endif
                            </tr>
                        </thead>
                        @foreach($villages as $village)
                            <tr class="align-middle position-relative">
                                <td>
                                    <div class="village-image show-link-wrapper">
                                        <a class="show-link" href="{{ route('villages.show', $village->id) }}">
                                            @isset($village->photo)
                                                <img height="100" src="{{ asset($village->photo->path) }}" alt="">
                                            @endisset
                                        </a>
                                    </div>
                                </td>
                                <td><div class="show-link-wrapper"><a class="show-link" href="{{ route('villages.show', $village->id) }}">{{ $village->name }}</a></div></td>
                                <td><div class="show-link-wrapper"><a class="show-link" href="{{ route('villages.show', $village->id) }}">{{ $village->address }}</a></div></td>
                                <td><div class="show-link-wrapper"><a class="show-link" href="{{ route('villages.show', $village->id) }}">{{ $village->square }}</a></div></td>
                                @if(Auth::user()->hasRole('admin'))
                                    <td>
                                        <div class="p-2 d-flex gap-2">
                                            <a class="btn btn-primary" href="{{ route('villages.edit', $village->id) }}"><i class="fa-solid fa-pencil"></i></a>
                                            <form action="{{ route('villages.destroy', $village->id) }}" method="post">
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
                {{ $villages->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
@endsection
