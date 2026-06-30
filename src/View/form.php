<!DOCTYPE html>
<html>
    <head>
        <title>Symfony</title>
        <meta charset="UTF-8">
        <script src="js/parsing_form.js" defer></script>
        <script src="js/getAvatar.js" defer></script>
        <link rel="stylesheet" href="css/form.css">
    </head>
    <body>
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
            <input type="file" name="avatar" class="user-form__avatar"> 

            <input type="hidden" name="avatar_path">

            <input type="submit" accept="image/png, image/jpeg, image/gif" value="Отправить" class="user-form__button">
        </form>
    </body>
</html>