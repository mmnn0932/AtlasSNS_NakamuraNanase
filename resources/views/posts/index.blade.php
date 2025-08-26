<x-login-layout>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(function () {
  // モーダル
  $(document).on('click', '.js-modal-open', function (e) {
    e.preventDefault();
    const postContent = $(this).data('post') || '';
    const updateUrl   = $(this).data('url')  || '';

    $('#editForm').attr('action', updateUrl); // 送信先URLをセット
    $('#modalPost').val(postContent);

    $('.js-modal').addClass('is-active');
    $('body').css('overflow', 'hidden');
    setTimeout(() => $('#modalPost').trigger('focus'), 0);
  });

  // 送信ガード：action 未設定や /index なら送らない
  $(document).on('submit', '#editForm', function (e) {
    const action = this.action || '';
    const path   = action ? new URL(action, location.origin).pathname : '';
    if (!action || path === '/index') {
      e.preventDefault();
      alert('編集URLが未設定です。投稿の編集ボタンから開いてください。');
    }
  });

  // 閉じる（× / 背景）
  $(document).on('click', '.js-modal-close, .js-modal__bg', function () {
    closeModal();
  });

  // ESC で閉じる
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
  });

  function closeModal(){
    $('.js-modal').removeClass('is-active');
    $('body').css('overflow', '');
  }
});
</script>


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
      <div class="post-meta">
        <p class="post-time">{{ $post->created_at->timezone('Asia/Tokyo')->format('Y-m-d H:i') }}</p>
      </div>
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
<div class="js-modal modal">
  <div class="modal__bg js-modal__bg"></div>
  <div class="modal__content">
    <form id="editForm" method="POST">
      @csrf
      @method('POST')
      <textarea id="modalPost" name="post" rows="5" style="width:100%; padding:10px;"></textarea>
      <div style="margin-top: 10px; text-align: center;">
        <button type="submit" class="edit-btn" style="background: none; border: none; padding: 0;">
          <img src="{{ asset('images/edit.png') }}" class="default" alt="編集" style="width: 32px;">
          <img src="{{ asset('images/edit_h.png') }}" class="hover" alt="編集" style="width: 32px; display: none;">
        </button>
      </div>
    </form>
  </div>
</div>
</x-login-layout>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.js-modal-open').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const postContent = this.getAttribute('data-post');
        const updateUrl = this.getAttribute('data-url');
        document.getElementById('editForm').action = updateUrl;
        document.getElementById('modalPost').value = postContent;
        document.querySelector('.js-modal').classList.add('is-active');
      });
    });

    document.querySelectorAll('.js-modal-close, .js-modal__bg').forEach(elem => {
      elem.addEventListener('click', () => {
        document.querySelector('.js-modal').classList.remove('is-active');
      });
    });
  });
</script>
