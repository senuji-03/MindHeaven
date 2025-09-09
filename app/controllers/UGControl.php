<?php

class UGControl{
    public function index() {
        view('undergrad/home');
    }
    public function appointment() {
        view('undergrad/appointments');
    }
}