@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <report-templates-edit-page
                            :user="{{ Auth::user() }}"
                            :objects="{{json_encode($objects)}}"
                            :users="{{$users}}"
                            :report_template="{{$report_template}}"
                            :roles="{{$roles}}"
                        ></report-templates-edit-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
