<x-logout-layout>
  <div class="atlas-panel">
    <div class="atlas-lead-group">
      <p class="atlas-lead">{{ $username }}さん</p>
      <p class="atlas-lead">ようこそ！AtlasSNSへ</p>
    </div>

    <p>ユーザー登録が完了いたしました。</p>
    <p>早速ログインをしてみましょう！</p>

    <div class="atlas-actions">
      <a href="{{ route('login') }}" class="btn btn-danger">ログイン画面へ</a>
    </div>
  </div>
</x-logout-layout>
