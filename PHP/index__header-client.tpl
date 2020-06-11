    <header class="header header_access-client">
        <h1 class="header__title">Отдел технической поддержки</h1>
        <form class="form-login acc-info" method="POST" action="./PHP/auth-check.php">
            <label class="form-login__label" for="user_login">Логин :</label>
            <input required type="text" name="user_login" id="user_login">
            <label class="form-login__label" for="user_login">Пароль :</label>
            <input required type="password" name="user_password" id="user_password">
            <input class="btn btn_type-login" type="submit" value="Войти">
        </form>
    </header>