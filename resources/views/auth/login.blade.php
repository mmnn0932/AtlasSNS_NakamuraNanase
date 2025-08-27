<x-logout-layout>
  <div class="atlas">
    <p class="welcome">AtlasSNSへようこそ</p>

    {!! Form::open(['url' => 'login']) !!}
    @csrf
      <div class="form-group">
        {{ Form::label('email', 'mail address') }}
        {{ Form::text('email', null, ['class' => 'input']) }}
      </div>

      <div class="form-group">
        {{ Form::label('password', 'password') }}
        {{ Form::password('password', ['class' => 'input']) }}
      </div>

      {{ Form::submit('LOGIN', ['class' => 'btn btn-danger']) }}
    {!! Form::close() !!}

    <p class="register-link">
      <a href="{{ route('register') }}">新規ユーザーの方はこちら</a>
    </p>
  </div>
</x-logout-layout>
