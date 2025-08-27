<x-login-layout>

  <!-- 投稿フォーム -->
 <form action="{{ route('posts.store') }}" method="POST" class="post-form">
  @csrf
  <div class="post-form-inner">
    <img src="{{ asset('images/' . auth()->user()->icon_image) }}" alt="ユーザーアイコン" class="user-icon">
    <textarea name="post" placeholder="投稿内容を入力してください。"></textarea>
    <input type="image" src="{{ asset('images/post.png') }}" alt="投稿" class="post-submit">
  </div>
</form>
<hr class="section-divider form-divider">

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
        <p class="post-time">{{ $post->created_at->timezone('Asia/Tokyo')->format('Y-m-d H:i') }}</p>
    </div>

    @if(Auth::id() === $post->user_id)
    <div class="post-actions">
      <a href="#" class="js-modal-open edit-btn"
         data-post="{{ $post->post }}"
         data-id="{{ $post->id }}"
         data-url="{{ route('posts.update', ['id' => $post->id]) }}">
        <img src="{{ asset('images/edit.png') }}" class="default" alt="編集" />
        <img src="{{ asset('images/edit_h.png') }}" class="hover" alt="編集" />
      </a>
      <a href="{{ route('posts.delete', ['id' => $post->id]) }}"
         onclick="return confirm('この投稿を削除します。よろしいでしょうか？')"
         class="delete-link">
        <img src="{{ asset('images/trash.png') }}" class="icon default-image" alt="削除">
        <img src="{{ asset('images/trash-h.png') }}" class="icon hover-image" alt="削除2">
      </a>
    </div>
    @endif
  @if (!$loop->last)
    <hr class="section-divider">
  @endif
  </div>
@endforeach
  <!-- 編集モーダル -->
<div class="js-modal modal" aria-hidden="true">
  <div class="modal__bg js-modal__bg"></div>
  <div class="modal__content" role="dialog" aria-modal="true">
    <form id="editForm" method="POST">
      @csrf
      <textarea id="modalPost" name="post" rows="5"></textarea>

      <div class="modal-actions">
        <button type="submit" class="modal-submit-btn edit-btn">
  <img src="{{ asset('images/edit.png') }}" class="default" alt="編集">
  <img src="{{ asset('images/edit_h.png') }}" class="hover" alt="編集(hover)">
</button>
      </div>
    </form>
  </div>
</div>
</x-login-layout>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal     = document.querySelector('.js-modal');
  const modalBg   = document.querySelector('.js-modal__bg');
  const editForm  = document.getElementById('editForm');
  const modalPost = document.getElementById('modalPost');

  // 開く
  document.querySelectorAll('.js-modal-open').forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const postContent = link.dataset.post || '';
      const updateUrl   = link.dataset.url  || '';

      if (editForm) editForm.action = updateUrl;
      if (modalPost) modalPost.value = postContent;

      modal.classList.add('is-active');
      document.body.style.overflow = 'hidden';
      setTimeout(() => modalPost && modalPost.focus(), 0);
    });
  });

  // 送信ガード（action未設定や/indexならブロック）
  if (editForm) {
    editForm.addEventListener('submit', (e) => {
      const action = editForm.getAttribute('action') || '';
      const path   = action ? new URL(action, location.origin).pathname : '';
      if (!action || path === '/index') {
        e.preventDefault();
        alert('編集URLが未設定です。投稿の編集ボタンから開いてください。');
      }
    });
  }

  function closeModal(){
    modal.classList.remove('is-active');
    document.body.style.overflow = '';
  }

  // 閉じる（背景/×/ESC）
  if (modalBg) modalBg.addEventListener('click', closeModal);
  document.querySelectorAll('.js-modal-close').forEach(el => el.addEventListener('click', closeModal));
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
  });
});
</script>
