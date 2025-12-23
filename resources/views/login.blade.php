<form method="POST" action="{{ route('authorize') }}">
    @csrf

    <div>
        <input type="email" name="email" placeholder="Email">
    </div>

    <div>
        <input type="password" name="password" placeholder="Password">
    </div>

    <button type="submit">Login</button>
</form>
