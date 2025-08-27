<x-login-layout>
  @if($type == 'A')
    <div class="profile-edit-container">
      <div class="profile-icon-area">
        @if($user->icon_image)
          <img src="{{ asset('images/' . $user->icon_image) }}" alt="Icon" class="profile-icon-preview">
        @endif
      </div>

      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
        @csrf

        <div class="form-row">
          <label>user name</label>
          <input type="text" name="username" value="{{ old('username', $user->username) }}">
        </div>

        <div class="form-row">
          <label>mail address</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}">
        </div>

        <div class="form-row">
          <label>password</label>
          <input type="password" name="password">
        </div>

        <div class="form-row">
          <label>password confirm</label>
          <input type="password" name="password_confirmation">
        </div>

        <div class="form-row">
          <label>bio</label>
          <textarea name="bio">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div class="form-row">
          <label>icon image</label>
          <input type="file" name="icon_image">
        </div>

        <div class="form-row">
          <button type="submit" class="btn btn-danger">更新</button>
        </div>
      </form>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

  @elseif($type == 'B')
    <!-- プロフィール -->
    <div class="post-block typeB-profile">
      <div class="typeB-header">
        <img src="{{ asset('images/' . $user->icon_image) }}" class="user-icon">
        <div class="typeB-info">
          <div class="profile-row">
            <span class="profile-label">name</span>
            <span class="profile-text-big">{{ $user->username }}</span>
          </div>
          <div class="profile-row">
            <span class="profile-label">bio</span>
            <span class="profile-text-big">{{ $user->bio }}</span>
          </div>
        </div>

        <div class="typeB-follow-button">
          @if(Auth::id() !== $user->id)
            @if(in_array($user->id, $followings, true))
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
          @endif
        </div>
      </div>
    </div>

    <hr class="section-divider">

    <!-- 投稿一覧 -->
    @foreach($posts as $post)
      <div class="post-block">
        <div class="post-header">
          <div class="post-left">
            <img src="{{ asset('images/' . $post->user->icon_image) }}" class="user-icon">
            <div class="post-user-info">
              <div class="post-user-texts">
                <p class="username">{{ $post->user->username }}</p>
                <p class="post-content">{{ $post->post }}</p>
              </div>
            </div>
          </div>
          <div class="post-meta">
            <p class="post-time">{{ $post->created_at->format('Y-m-d H:i') }}</p>
          </div>
        </div>
      </div>

      @if(!$loop->last)
        <hr class="section-divider">
      @endif
    @endforeach
  @endif
</x-login-layout>
