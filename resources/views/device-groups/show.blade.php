@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <device-groups-show-page
                            :user="{{ Auth::user() }}"
                            :device_group="{{ $deviceGroup }}"
                            :device_groups="{{ $device_groups }}"
                            :device_types="{{ $device_types }}"
                        ></device-groups-show-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
