<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use database\Models\Employee;
use database\Models\paramAdmin;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Carbon;

class EmailController extends Controller
{
    const MAIL_N1             = 'MN1';
    const PAGE_N1             = 'mailN1';
    const TITLE_SEND_PLANNING = 'Votre emploi du temps';
    const TITLE_SEND_TO_N1    = 'Informations employé - Edition d\'un contrat';
    // ------------- [ Send email ] --------------------
    public function sendEmailToN1($fkEmployee){
        $request = new Request();
        $request->setMethod('POST');
        $request->request->add(['fkEmployee' => $fkEmployee]);
        $this->validate($request, ['fkEmployee' => 'required|string|exists:\database\Models\Employee,salt']);

        $employeeInfo = Employee::getEmployeeById($fkEmployee);
        $collection   = collect(['title' => self::TITLE_SEND_TO_N1, 'view' => self::PAGE_N1]);
        $employeeInfo = $collection->merge($employeeInfo);

        Mail::to(env('MAIL_USERNAME'))->send(new Mailer($this->employeeDecryptor($employeeInfo)));
        return redirect()->route('employee.index')->with('success', 'Email envoyé avec succès !');
    }

    public function sendCalendarToEmployee(){
        //besoin id employee, mail, nom, et qu'il,soit actif
        // ensuite foreach mail::to($mail)->send(new Mailer($employeeInfo))
        // renvoi vers la page du calendar solo, new js avec chargement calendar
    }

    public function employeeDecryptor($employee){
        $employee['birthDate']   = Carbon::createFromFormat('Ymd', $employee['birthDate'])->format('d/m/Y');
        $employee['firstName']    = Crypt::decrypt($employee['firstName']);
        $employee['name']         = Crypt::decrypt($employee['name']);
        $employee['greenNumber']  = Crypt::decrypt($employee['greenNumber']);
        $employee['mail']         = Crypt::decrypt($employee['mail']);
        $employee['phone']        = Crypt::decrypt($employee['phone']);
        $employee['adress']       = Crypt::decrypt($employee['adress']);
        $employee['zipCode']      = Crypt::decrypt($employee['zipCode']);
        $employee['city']         = Crypt::decrypt($employee['city']);
        return $employee;
    }
}

// ENVOI DE PLANNING : PAGE AVEC DEUX CALENDRIERS CHOISIR 2 DATES ET ENVOYER
// RECUPERER LA LISTE DES EMPLOYES ACTIFS (COMPARER AVEC LES CONTRATS ?)
// RECUPERER LE CALENDAR DE LA SEMAINE CIBLE POUR CHAQUE EMPLOYE ET ENVOYER + KEEP TRACES
