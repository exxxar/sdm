@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <dictionary-types-add-page
                            :user="{{ Auth::user() }}"
                        ></dictionary-types-add-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
