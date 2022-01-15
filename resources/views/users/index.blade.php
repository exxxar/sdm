@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <users-page
                            :user="{{ Auth::user() }}"
                            :device_groups="{{ $device_groups }}"
                            :users="{{ $users }}"

                        ></users-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
