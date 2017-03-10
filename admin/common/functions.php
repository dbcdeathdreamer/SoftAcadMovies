<?php
/**
 * @param $data
 * @return array
 */
function isValidAddAdministrator($data)
{
    $errors = [
        'username' => [],
        'password' => [],
        'email'    => [],
    ];

    //TODO Add validation for all fields

    return $errors;
}

/**
 * @param $errors
 * @return bool
 */
function checkForErrors($errors)
{
    $flag = true;
    foreach ($errors as $error) {
        if (!empty($error)) {
            $flag = false;
        }
    }

    return $flag;
}


function insertAdministrator($data, $conn)
{
    $username   = mysqli_real_escape_string($conn, $data['username']);
    $password   = mysqli_real_escape_string($conn, $data['password']);
    $email      = mysqli_real_escape_string($conn, $data['email']);

    $query = "
        INSERT INTO users
        SET 
        `username` = '{$username}',
        `password` = '{$password}',
        `email`    = '{$email}'
    ";

    mysqli_query($conn, $query);

    echo '<pre>';
    var_dump(mysqli_error($conn));
    echo '</pre>';

}

function getUsers($conn)
{
    $query = "SELECT * FROM users";

    $result = mysqli_query($conn, $query);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }


    echo '<pre>';
    var_dump(mysqli_error($conn));
    echo '</pre>';

    return $users;
}