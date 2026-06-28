<?php

echo 'first_name = ' . htmlspecialchars($user->getFirstName()) . '<br>';
echo 'last_name = ' . htmlspecialchars($user->getLastName()) . '<br>';
echo 'middle_name = ' . htmlspecialchars($user->getMiddleName()) . '<br>';
echo 'gender = ' . htmlspecialchars($user->getGender()) . '<br>';
echo 'birth_date = ' . htmlspecialchars($user->getBirthDate()) . '<br>';
echo 'email = ' . htmlspecialchars($user->getEmail()) . '<br>';
echo 'phone = ' . htmlspecialchars($user->getPhone()) . '<br>';
echo 'avatar_path = ' . htmlspecialchars($user->getAvatarPath()) . '<br>';