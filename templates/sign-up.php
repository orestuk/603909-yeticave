    <?php
        $config = require_once 'config/config.php';
    ?>

    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $item):?>
                <li class="nav__item">
                    <a href="all-lots.html"><?=$item['name'];?></a>
                </li>
            <?php endforeach;?>
        </ul>
    </nav>

    <form class="form container" action="sign-up.php" method="post"  enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
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
        <?php $class_name = isset($errors['name']) ? "form__item--invalid" : "";
        $value = isset($user['name']) ? $user['name'] : ""; ?>
        <div class="form__item <?=$class_name;?>" >
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" value="<?=$value;?>" placeholder="Введите имя">
            <span class="form__error"><?=$errors['name'];?></span>
        </div>
        <?php $class_name = isset($errors['message']) ? "form__item--invalid" : "";
        $value = isset($user['message']) ? $user['message'] : ""; ?>
        <div class="form__item <?=$class_name;?>" >
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?=$value;?></textarea>
            <span class="form__error"><?=$errors['message'];?></span>
        </div>
        <?php $class_name = isset($errors['avatar']) ? "form__item--invalid" : "";
        $value = isset($user['avatar']) ? $avatar['avatar'] : ""; ?>
        <div class="form__item form__item--file form__item--last <?=$class_name;?>">
            <label>Аватар</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="<?=$config['avatar_image_directory'].$user['avatar'];?> width="113" height="113" alt="Ваш аватар">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="avatar" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"><?=$errors['avatar'];?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
