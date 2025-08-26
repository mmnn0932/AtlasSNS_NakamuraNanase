<x-login-layout>

  <div class="search-form-heading">
  <form method="GET" action="{{ route('users.result') }}" class="search-form">
    <input type="text" name="keyword" placeholder="ユーザー名"
           value="{{ request('keyword', '') }}" class="search-input">
    <button type="submit" class="search-button">
      <img src="{{ asset('images/search.png') }}" alt="検索">
    </button>
  </form>

  @if(request('keyword'))
    <span class="search-keyword">検索ワード：{{ request('keyword') }}</span>
  @endif
</div>

    <hr class="icon-divider">
    <ul style="padding: 0; list-style: none;">
      @foreach($users as $user)
        <li class="user-list-item">
          <div class="user-info">
            <img src="{{ asset('images/' . $user->icon_image) }}" alt="ユーザーアイコン" class="user-icon">
            <span>{{ $user->username }}</span>
          </div>

          <div class="follow-button">
            @if(in_array($user->id, $followings))
              <form method="POST" action="{{ route('follow.destroy', ['id' => $user->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">フォロー解除</button>
              </form>
            @else
              <form method="POST" action="{{ route('follow.store', ['id' => $user->id]) }}">
                @csrf
                <button type="submit" class="btn btn-primary">フォローする</button>
              </form>
            @endif
          </div>
        </li>
      @endforeach
    </ul>

  </x-login-layout>
