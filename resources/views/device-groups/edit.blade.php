@extends('layouts.app')

@section('content')
    <div class="row w-100 m-auto justify-content-center">
        <main style="width: 100%">
            <div class="row w-100 m-auto justify-content-center">
                <div class="col-12">
                    <transition name="fade">
                        <device-groups-edit-page
                            :user="{{ Auth::user() }}"
                            :group="{{ $deviceGroup }}"
                            :connecteddevices="{{ $deviceGroup->devices }}"
                            :devices="{{ $devices }}"
                        ></device-groups-edit-page>
                    </transition>
                </div>
            </div>
        </main>
    </div>
@endsection
