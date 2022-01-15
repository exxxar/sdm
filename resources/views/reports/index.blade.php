@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <reports-page
                            :user="{{ Auth::user() }}"
                            :reports="{{json_encode($reports)}}"
                            :users="{{$users}}"
                        ></reports-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
