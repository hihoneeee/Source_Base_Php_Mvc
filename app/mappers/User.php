<?php

class UserMapping {
    public static function mapToGetUserDTO(User $user) {
        return new GetUserDTO(
            $user->id,
            $user->username,
            $user->email,
            $user->firstName,
            $user->lastName,
        );
    }
}