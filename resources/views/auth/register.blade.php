<x-logout-layout>
    <section>
        <div class="atlas">
            <p class="welcome">新規ユーザー登録</p>

            {!! Form::open(['url' => 'register']) !!}

            <div class="form-group">
                {{ Form::label('username', 'user name') }}
                {{ Form::text('username',null,['class' => 'input']) }}
            </div>

            <div class="form-group">
                {{ Form::label('email', 'mail address') }}
                {{ Form::email('email',null,['class' => 'input']) }}
            </div>

            <div class="form-group">
                {{ Form::label('password', 'password') }}
                {{ Form::password('password',['class' => 'input']) }}
            </div>

            <div class="form-group">
                {{ Form::label('password_confirmation', 'password confirm') }}
                {{ Form::password('password_confirmation',['class' => 'input']) }}
            </div>

            {{ Form::submit('REGISTER', ['class' => 'btn btn-danger']) }}

            {!! Form::close() !!}

            <p class="login-link"><a href="{{ route('login') }}">ログイン画面に戻る</a></p>
        </div>
    </section>
</x-logout-layout>
