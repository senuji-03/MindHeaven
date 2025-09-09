<?php

class CallResponderControl{
    public function index() {
        view('CallResponder/CallPage');
    }
    public function success() {
        view('CallResponder/CallSuccess');
    }
}