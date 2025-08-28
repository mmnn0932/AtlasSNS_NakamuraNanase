<x-login-layout>
  <div class="icon-list-wrapper">
    <h2 class="follow-list-title">Follower List</h2>
    <div class="icon-list">
      @foreach($followers as $follower)
        <a href="{{ route('users.show', ['id' => $follower->id]) }}">
          <img src="{{ asset('images/' . $follower->icon_image) }}"
               alt="ユーザーアイコン"
               class="user-icon">
        </a>
      @endforeach
    </div>
  </div>

  <hr class="icon-divider">

  @foreach($posts as $post)
    <div class="post-block">
      <div class="post-header">
        <div class="post-left">
          <a href="{{ route('users.show', ['id' => $post->user->id]) }}">
            <img src="{{ asset('images/' . $post->user->icon_image) }}" class="user-icon">
          </a>
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
    @if (!$loop->last)
      <hr class="section-divider">
    @endif
  @endforeach
</x-login-layout>
