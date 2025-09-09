<?php

class UGControl{
    public function index() {
        view('undergrad/home');
    }
    public function appointment() {
        view('undergrad/appointments');
    }
    public function contact() {
        view('undergrad/contact');
    }
    public function crisis() {
        view('undergrad/crisis');
    }
     public function mood() {
        view('undergrad/mood');
    }
     public function resources() {
        view('undergrad/resources');
    }
     public function habits() {
        view('undergrad/habits');
    }
}