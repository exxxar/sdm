@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <history-page
                            :user="{{ Auth::user() }}"
                            :users="{{ $users }}"
                            :objects="{{ json_encode($objects) }}"
                            :actions="{{ json_encode($actions) }}"
                        ></history-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
