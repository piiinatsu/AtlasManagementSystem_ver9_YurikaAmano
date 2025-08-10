<x-guest-layout>
  <div class="d-flex flex-column align-items-center justify-content-center min-vh-100" style="background:#EEF2F7;">

    <!-- ロゴ＋フォームをまとめて中央寄せ -->
    <div class="d-flex flex-column align-items-center">

      <!-- ロゴ -->
      <div class="login-logo d-flex justify-content-center mb-5">
        <img src="{{ asset('image/atlas-black.png') }}" alt="Atlas Logo" class="img-fluid" style="max-width:200px; height:auto;">
      </div>

      <!-- フォーム -->
      <form action="{{ route('loginPost') }}" method="POST">
        <div class="bg-white rounded shadow p-4" style="width:420px;">
          <div class="w-75 m-auto pt-5">
            <label class="d-block m-0" style="font-size:13px;">メールアドレス</label>
            <div class="border-bottom border-primary w-100">
              <input type="text" class="w-100 border-0" name="mail_address">
            </div>
          </div>
          <div class="w-75 m-auto pt-5">
            <label class="d-block m-0" style="font-size:13px;">パスワード</label>
            <div class="border-bottom border-primary w-100">
              <input type="password" class="w-100 border-0" name="password">
            </div>
          </div>
          <div class="text-right m-3">
            <input type="submit" class="btn btn-primary" value="ログイン">
          </div>
          <div class="text-center">
            <a href="{{ route('registerView') }}">新規登録はこちら</a>
          </div>
        </div>
        {{ csrf_field() }}
      </form>

    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
</x-guest-layout>
