@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <dictionary-types-edit-page
                            :user="{{ Auth::user() }}"
                            :dictionary_type="{{ $dictionary_type }}"
                        ></dictionary-types-edit-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
