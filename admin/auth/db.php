<?php 
    $login = function() use ($conn){
        $email = filter_input(INPUT_POST,'email');
        $password = filter_input(INPUT_POST,'password');
        if(is_null($password) or is_null($email) ){
            return false;
        }
        $sql = 'SELECT * from users where email = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result  = $stmt->get_result();
        $user = $result->fetch_assoc();
        if(!$user){
            return false;
        }

        if(password_verify($password, $user['password'])){
            unset($user['password']);
            $_SESSION['auth']= $user;
            return true;
            
        }
        return false;

    };