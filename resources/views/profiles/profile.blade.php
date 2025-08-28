<x-login-layout>
  <div class="profile-edit-container">
    <div class="profile-icon-area">
      @if($user->icon_image)
        <img src="{{ asset('images/' . $user->icon_image) }}" alt="Icon" class="profile-icon-preview">
      @endif
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form" novalidate>
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

      <div class="form-row form-actions">
        <button type="submit" class="btn btn-danger">更新</button>
      </div>

       @if ($errors->any())
        <div class="form-errors" role="alert" aria-live="polite">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </form>
  </div>
</x-login-layout>
