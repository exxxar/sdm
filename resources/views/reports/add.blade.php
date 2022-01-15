@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <reports-add-page
                            :user="{{ Auth::user() }}"
                            :objects="{{json_encode($objects)}}"
                            :users="{{$users}}"
                            :roles="{{$roles}}"
                            :report_templates="{{$report_templates}}"
                        ></reports-add-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
