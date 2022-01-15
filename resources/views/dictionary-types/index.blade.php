@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <dictionary-types-page
                            :user="{{ Auth::user() }}"
                            :dictionary_types="{{ $dictionary_types }}"
                            :dictionaries="{{ $dictionaries }}"
                        ></dictionary-types-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
