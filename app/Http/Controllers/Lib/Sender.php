<?php

namespace App\Lib;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Lib\Mail\Mailer;
use Models\Employee;

class Sender extends Controller
{
    // ------------- [ Send email ] --------------------
    public function sendEmailToUser(){

        Mail::to(Employee::getMailEmployeeById($fkEmployee))->send(new Mailer);

        return "<p> Your E-mail has been sent successfully. </p>";

    }
}
