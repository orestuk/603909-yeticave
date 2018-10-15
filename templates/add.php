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
<form class="form form--add-lot container <?=$class_name;?>" action="add.php" method="post"  enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <?php $class_name = isset($errors['lot-name']) ? "form__item--invalid" : "";
        $value = isset($lot['lot-name']) ? $lot['lot-name'] : ""; ?>
        <div class="form__item <?=$class_name?>"> <!-- form__item--invalid -->
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="lot-name" value="<?=$value;?>" placeholder="Введите наименование лота" >
            <span class="form__error">Введите наименование лота</span>
        </div>
        <?php $class_name = isset($errors['category']) ? "form__item--invalid" : "";
        $value = isset($lot['category']) ? $lot['category'] : ""; ?>
        <div class="form__item">
            <label for="category">Категория</label>
            <select id="category" value="<?=$value;?>" name="category">
                <?php foreach ($categories as $item):?>
                    <option><?=$item['name'];?></option>
                <?php endforeach;?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <?php $class_name = isset($errors['message']) ? "form__item--invalid" : "";
    $value = isset($lot['message']) ? $lot['message'] : ""; ?>
    <div class="form__item form__item--wide <?=$class_name?>">
        <label for="message">Описание</label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?=$value;?></textarea>
        <span class="form__error">Напишите описание лота</span>
    </div>
    <div class="form__item form__item--file"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" name="lot-image" type="file" id="photo2" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <div class="form__container-three">
        <?php $class_name = isset($errors['lot-rate']) ? "form__item--invalid" : "";
        $value = isset($lot['lot-rate']) ? $lot['lot-rate'] : ""; ?>
        <div class="form__item form__item--small <?=$class_name?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="lot-rate" value="<?=$value;?>" placeholder="0" >
            <span class="form__error">Введите начальную цену</span>
        </div>
        <?php $class_name = isset($errors['lot-step']) ? "form__item--invalid" : "";
        $value = isset($lot['lot-step']) ? $lot['lot-step'] : ""; ?>
        <div class="form__item form__item--small <?=$class_name?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="lot-step" value="<?=$value;?>" placeholder="0" >
            <span class="form__error">Введите шаг ставки</span>
        </div>
        <?php $class_name = isset($errors['lot-date']) ? "form__item--invalid" : "";
        $value = isset($lot['lot-date']) ? $lot['lot-date'] : ""; ?>
        <div class="form__item <?=$class_name?>">
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?=$value;?>">
            <span class="form__error">Введите дату завершения торгов</span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>
