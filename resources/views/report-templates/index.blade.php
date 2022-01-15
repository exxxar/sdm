@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <report-templates-page
                            :user="{{ Auth::user() }}"
                            :report_templates="{{json_encode($report_templates)}}"
                        ></report-templates-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
