<!DOCTYPE html>
<html>
    <head>
        <title>Symfony</title>
        <meta charset="UTF-8">    
        <link rel="stylesheet" href="css/profile.css">
        <script src="js/buttonChange.js" defer></script>
        <script src="js/formChange.js" defer></script>
        <script src="js/getAvatar.js" defer></script>
        <script src="js/buttonDelete.js" defer></script>
    </head>
    <body>
        <div class="user-info">
            <img src="uploads/<?php echo htmlspecialchars($user->getAvatarPath()) ?>" alt="avatar">
            <span><?php echo htmlspecialchars($user->getFirstName()) ?></span>
            <span><?php echo htmlspecialchars($user->getLastName()) ?></span>
            <span><?php echo htmlspecialchars($user->getMiddleName()) ?></span>
            <span><?php echo htmlspecialchars($user->getGender()) ?></span>
            <span><?php echo htmlspecialchars($user->getBirthDate()) ?></span>
            <span><?php echo htmlspecialchars($user->getEmail()) ?></span>
            <span><?php echo htmlspecialchars($user->getPhone()) ?></span>
            <button class="button-change">Изменить профиль</button>
            <button class="button-delete">Удалить профиль</button>
        </div>
        <form action="index.php" method="POST" class="user-form">
            <p>Имя</p>
            <input type="text" name="first_name" class="user-form__first-name">
            <p>Фамилия</p>
            <input type="text" name="last_name" class="user-form__last_name">
            <p>Отчество</p>
            <input type="text" name="middle_name" class="user-form__middle_name">
            <p>Пол</p>
            <input type="text" name="gender" class="user-form__gender">
            <p>Дата рождения</p>
            <input type="text" name="birth_date" class="user-form__birth_date">
            <p>Почта</p>
            <input type="email" inputmode="email" name="email" class="user-form__email">
            <p>Номер телефона</p>
            <input type="tel" inputmode="tel" name="phone" class="user-form__phone">
            <p>Фото</p>
            <input type="file" name="avatar" accept="image/png, image/jpeg, image/gif" class="user-form__avatar"> 
            <input type="hidden" name="avatar_path">
            <input type="submit" value="Отправить" class="user-form__button">
        </form>
    </body>
</html>

<!-- echo 'first_name = ' . htmlspecialchars($user->getFirstName()) . '<br>';
echo 'last_name = ' . htmlspecialchars($user->getLastName()) . '<br>';
echo 'middle_name = ' . htmlspecialchars($user->getMiddleName()) . '<br>';
echo 'gender = ' . htmlspecialchars($user->getGender()) . '<br>';
echo 'birth_date = ' . htmlspecialchars($user->getBirthDate()) . '<br>';
echo 'email = ' . htmlspecialchars($user->getEmail()) . '<br>';
echo 'phone = ' . htmlspecialchars($user->getPhone()) . '<br>';
echo 'avatar_path = ' .  . '<br>'; -->