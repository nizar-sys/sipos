@php
use Carbon\Carbon;
@endphp
@extends('layouts.app')
@section('title', 'SIPOS | Data pengguna')

@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mt-4">
        <li class="breadcrumb-item"><a
                href="{{ route('home', ['role' => Auth::user()->role == '1' ? 'admin' : 'user']) }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a
                href="{{ route('user.list', ['role' => Auth::user()->role == '1' ? 'admin' : 'user']) }}">Data
                Pengguna</a></li>
    </ol>
@endsection


@section('action_btn')
    @if (Auth::user()->role == '1')
        <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#modalCreateUserWithExcel">New data</a>
        <button type="button" disabled id="delete-data-selected" class="btn btn-neutral btn-sm">Delete</button>

        <form id="formdelete-select-data" action="{{ route('user.select.destroy') }}" method="post" class="d-none">
            @csrf
            <input type="hidden" name="selectedData" id="selectedData" multiple>
        </form>
    @endif
@endsection

@section('content')
    @include('_partials.modals.modalCreateUserWithExcel')
    @include('_partials.modals.detailImage')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">Username</th>
                                <th scope="col" class="sort" data-sort="budget">Email</th>
                                <th scope="col" class="sort" data-sort="status">Status</th>
                                <th scope="col" class="sort" data-sort="create at">Created at</th>
                                <th scope="col">Avatar</th>
                                @if (Auth::user()->role == '1')

                                    <th scope="col" id="select-all-data" ondblclick="selectAllData('selectData')">Filter All
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="list" id="user-list">
                            @foreach ($data['users'] as $user)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{ $user->username }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        <span class="badge badge-dot mr-4">
                                            <i class="bg-{{ $user->role == '1' ? 'success' : 'warning' }}"></i>
                                            <span
                                                class="status">{{ $user->role == '1' ? 'Admin' : 'User' }}</span>
                                        </span>
                                    </td>
                                    <td>
                                        {{ Carbon::parse($user->created_at)->diffForHumans() }}
                                    </td>
                                    <td>
                                        <div class="avatar-group">
                                            <span style="cursor: pointer" class="avatar rounded-circle" data-toggle="tooltip"
                                                data-original-title="{{ Str::title($user->username) }}">
                                                <img onclick="detailImage(this)" alt="{{$user->username}}"
                                                    src="{{ asset('/storage/avatarUsers/' . $user->avatar) }}">
                                            </span>
                                        </div>
                                    </td>
                                    @if (Auth::user()->role == '1')
                                        <td class="text-center">
                                            <input type="checkbox" name="selectData" id="selectData"
                                                onclick="getCheckedCheckboxesFor('selectData')"
                                                value="{{ $user->id }}">
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        <ul class="pagination justify-content-end mb-0">
                            {{ $data['users']->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('c_js')
@include('_partials.funcJs.filterDatatable')
    <script>
        @if ($errors->any())
            $('#modalCreateUserWithExcel').modal('show')
        @endif
    </script>
@endsection
