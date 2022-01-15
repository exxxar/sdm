@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <devices-edit-page
                            :user="{{ Auth::user() }}"
                            :device_groups="{{ $device_groups }}"
                            :boundaries="{{ $boundaries }}"
                            :device_types="{{ $device_types }}"
                            :regions="{{ $regions }}"
                            :device="{{ $device }}"
                            :passages_month="{{$passagesMonth}}"
                            :violations_month="{{$violationsMonth}}"
                            :edit="{{ $edit }}"
                            :certificate="{{$device->certificate}}"
                        ></devices-edit-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
