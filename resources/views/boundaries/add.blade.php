@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <boundaries-add-page
                            :user="{{ Auth::user() }}"
                            :boundary_groups="{{ $boundary_groups }}"
                            :regions="{{ $regions }}"
                            :devices="{{ $devices }}"
                            :violations="{{ $violations }}"
                        ></boundaries-add-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
