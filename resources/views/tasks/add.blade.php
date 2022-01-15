@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <appeals-add-page
                            :user="{{ Auth::user() }}"
                            :users="{{ $users }}"
                            :boundaries="{{ $boundaries }}"
                            :devices="{{ $devices }}"
                            :malfunctions="{{ $malfunctions }}"
                        ></appeals-add-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
