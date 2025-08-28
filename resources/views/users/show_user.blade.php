<x-login-layout>
  <div class="post-block show-user-profile">
    <div class="show-user-header">
      <img src="{{ asset('images/' . $user->icon_image) }}" class="user-icon">
      <div class="show-user-info">
        <div class="profile-row">
          <span class="profile-label">name</span>
          <span class="profile-text-big">{{ $user->username }}</span>
        </div>
        <div class="profile-row">
          <span class="profile-label">bio</span>
          <span class="profile-text-big">{{ $user->bio }}</span>
        </div>
      </div>

      <div class="show-user-follow-button">
  @if(Auth::id() !== $user->id)
    @if($isFollowing)
      <form method="POST" action="{{ route('follow.destroy', ['id' => $user->id]) }}">
        @csrf @method('DELETE')
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
</x-login-layout>
