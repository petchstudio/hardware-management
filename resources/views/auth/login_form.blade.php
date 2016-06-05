      <form action="{{ url('login') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
          <input type="text" name="username" class="form-control" placeholder="อีเมลหรือรหัสประจำตัว" value="{{ old('username') }}">
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="รหัสผ่าน">
        </div>
        <div class="m-checkbox">
          <input name="remember" id="remember" type="checkbox">
          <label for="remember">คงอยู่ในระบบ</label>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-block btn-success">เข้าสู่ระบบ</button>
        </div>
        <div class="text-center">
          <a href="{{ url('resetpassword') }}" class="btn btn-link">ลืมรหัสผ่าน</a>
        </div>
      </form>
