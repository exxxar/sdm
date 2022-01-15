@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <summary-page
                            :user="{{ Auth::user() }}"
                            :devices="{{ $devices }}"
                            :device_types="{{ $device_types }}"
                            :device_groups="{{ $device_groups }}"
                            :boundaries="{{ $boundaries }}"
                        ></summary-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
