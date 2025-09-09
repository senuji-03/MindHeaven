<?php

class DonorControl{
    public function DonationForm() {
        view('Donor/DonationForm');
    }
    public function DonationSuccess() {
        view('Donor/DonationSuccess');
    }
}