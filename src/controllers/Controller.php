<?php
namespace tinder\controllers;

interface Controller
{
    public function add();
    public static function delete($id);
    public function update();
    public function save();
}
