<?php

include __DIR__.'/Model.php';

class User extends Model
{
    public function all()
    {
        $sql = 'SELECT * FROM `users`';

        return $this->query($sql)->select();
    }
}
