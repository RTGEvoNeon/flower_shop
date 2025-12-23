<form method="POST" action="{{ route('register') }}">
    @csrf

    <div>
        <input type="text" name="name" placeholder="Name">
    </div>

    <div>
        <input type="email" name="email" placeholder="Email">
    </div>

    <div>
        <input type="password" name="password" placeholder="Password">
    </div>

    <button type="submit">Register</button>
</form>
