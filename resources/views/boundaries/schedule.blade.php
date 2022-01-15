@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <boundaries-schedule-page
                            :user="{{ Auth::user() }}"
                            :boundary_groups="{{ $boundary_groups }}"
                            :devices="{{ $devices }}"
                            :boundaries="{{$boundaries}}"
                        ></boundaries-schedule-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
