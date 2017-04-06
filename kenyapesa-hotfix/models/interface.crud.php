<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/14/17
 * Time: 10:55 PM
 */

interface PesaCrud {

    public function create();
    public function update($id);
    public static function delete($id);
    public static function getById($id);
    public static function all();
}