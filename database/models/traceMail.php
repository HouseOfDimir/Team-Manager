<?php

namespace Models;

use Illuminate\Database\Eloquent\{Model, Collection};

    class traceMail extends Model
    {
        const CREATED_AT = null;
        const UPDATED_AT = null;

        protected $table         = 'traceMail';
        protected $primaryKey    = 'id';

        public static function insertTraceMail(string $receiver, string $subject, string $message):void
        {
            $insert            = new self();
            $insert->dateEnvoi = Date('Ymd');
            $insert->receiver  = $receiver;
            $insert->subject   = $subject;
            $insert->message   = $message;
        }
    }
// FILES COULD BE FACTURES ENERGIE, TELEPHONE, INTERNET, RIB, IBAN, CONTRAT (CEE CDD CDI)
?>
