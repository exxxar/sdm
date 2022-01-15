@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <reports-automatic-page
                            :user="{{ Auth::user() }}"
                            :automatic_reports="{{json_encode($automatic_reports)}}"
                            :users="{{json_encode($users)}}"
                        ></reports-automatic-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
