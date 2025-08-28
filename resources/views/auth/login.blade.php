<x-logout-layout>
  <div class="atlas">
    <p class="welcome">AtlasSNSへようこそ</p>

    {!! Form::open(['url' => route('login'), 'method' => 'post', 'novalidate' => true]) !!}
      @csrf

      <div class="form-group">
        {{ Form::label('email', 'mail address') }}

        {{ Form::text('email', null, ['class' => 'input']) }}
        @error('email')
          <div class="invalid-comment" style="color:#d32f2f; margin-top:8px;">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        {{ Form::label('password', 'password') }}
        {{ Form::password('password', ['class' => 'input']) }}
        @error('password')
          <div class="invalid-comment" style="color:#d32f2f; margin-top:8px;">{{ $message }}</div>
        @enderror
      </div>

      {{ Form::submit('LOGIN', ['class' => 'btn btn-danger']) }}
    {!! Form::close() !!}

    <p class="register-link">
      <a href="{{ route('register') }}">新規ユーザーの方はこちら</a>
    </p>
  </div>
</x-logout-layout>
