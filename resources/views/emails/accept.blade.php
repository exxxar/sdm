@component('mail::message')
# Для вас создали пользователя в SDM

Ваши логин и пароль для входа в систему:<br>
Login: {{ $data['login'] }}<br>
Password: {{ $data['password'] }}
@endcomponent