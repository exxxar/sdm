@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <map-page
                            :user="{{ Auth::user() }}"
                            :devices="{{ $devices }}"
                            :device_types="{{ $device_types }}"
                            :malfunctions="{{ $malfunctions }}"
                            :regions="{{ $regions }}"
                        ></map-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
