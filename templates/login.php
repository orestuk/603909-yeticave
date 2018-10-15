<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $item):?>
            <li class="nav__item">
                <a href="all-lots.html"><?=$item['name'];?></a>
            </li>
        <?php endforeach;?>
    </ul>
</nav>
<?php $class_name = isset($errors) ? "form--invalid" : ""; ?>
<form class="form container <?=$class_name;?>" action="login.php" method="post"  enctype="multipart/form-data">
<h2>Вход</h2>
    <?php $class_name = isset($errors['email']) ? "form__item--invalid" : "";
    $value = isset($user['email']) ? $user['email'] : ""; ?>
    <div class="form__item <?=$class_name;?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" value="<?=$value;?>" placeholder="Введите e-mail">
        <span class="form__error"><?=$errors['email'];?></span>
    </div>
    <?php $class_name = isset($errors['password']) ? "form__item--invalid" : "";
    $value = isset($user['password']) ? $user['password'] : ""; ?>
    <div class="form__item <?=$class_name;?>" >
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" value="<?=$value;?>" placeholder="Введите пароль">
        <span class="form__error"><?=$errors['password'];?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>

