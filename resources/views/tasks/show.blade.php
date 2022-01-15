@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">


                            <appeals-show-page
                                :user="{{ Auth::user() }}"
                                :users="{{ $users }}"
                                :boundary="{{ isset($boundary)?$boundary:new \App\Boundary() }}"
                                :devices="{{ $devices }}"
                                :malfunctions="{{ $malfunctions }}"
                                :device="{{ isset($device)?$device:new \App\Device() }}"
                                :malfunction="{{ $malfunction }}"
                                :responsible="{{ $responsible }}"
                                :appeal="{{ $task }}"
                            ></appeals-show-page>






                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
