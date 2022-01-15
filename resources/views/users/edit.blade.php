@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <users-edit-page
                            :user="{{ Auth::user() }}"
                            :selected_user="{{ $selected_user }}"
                            :device_groups="{{ $device_groups }}"
                            :edit="{{$edit}}"
                        ></users-edit-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
