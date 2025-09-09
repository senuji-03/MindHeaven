<?php

class COControl {
    public function dashboard() {
        view('/counselor/Cdashboard');
    }
    public function appointmentmgt() {
        view('/counselor/appointmentmgt');
    }
    public function calender() {
        view('/counselor/calender');
    }
    public function sessionHistory() {
        view('/counselor/sessionHistory');
    }
}