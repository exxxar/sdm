@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <boundaries-page
                            :user="{{ Auth::user() }}"
                            :boundaries_groups="{{ $boundaries_groups }}"
                        ></boundaries-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
