@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 75vh">
           <div class="col-12 d-flex justify-content-center">
               <h1 class="text-center ">Вам временно ограничен доступ к аккаунту с {{
    \Carbon\Carbon::parse($user->blocked_from)->format("d.m.Y H:i")
  }} до {{ \Carbon\Carbon::parse($user->blocked_to)->format("d.m.Y H:i")}}.

               </h1>



           </div>
            <form action="/logout" method="post" class="col-12 d-flex justify-content-center">
                @csrf
                <button class="btn btn-outline-info">Выход</button>
            </form>

        </div>
    </div>
@endsection
