<?php

namespace Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\{Model, Collection};
use Illuminate\Support\Carbon;

class planning extends Model
    {
        const CREATED_AT = null;
        const UPDATED_AT = null;

        protected $table         = 'planning';
        protected $primaryKey    = 'id';

        public static function getAllFileType():Collection
        {
            return self::whereNull('dateFin')->get();
        }

        public static function insertBulkPlanning(array $array):void
        {
            self::insert($array);
        }

        public static function getEvents(Request $request){
            self::leftJoin('task', 'task.id', '=', 'planning.fkTask')
                ->where('eventStart', '>=', $request->start)
                ->where('eventEnd',   '<=', $request->end)
                ->whereNull('planning.endDate')
                ->get(['planning.id', 'libelle AS title', 'eventStart', 'eventEnd', 'fktask AS resourceId']);
        }

        public static function insertEvent(Request $request){
            $event             = new planning();
            $event->fkTask     = $request->fkTask;
            $event->fkEmployee = $request->fkEmployee;
            $event->eventStart = Carbon::createFromFormat('Y-m-d H-i', $request->start)->format('Y-m-d H:i');
            $event->eventEnd   = Carbon::createFromFormat('Y-m-d H-i', $request->end)->format('Y-m-d H:i');
            $event->eventDate  = $request->eventDate;
            $event->startDate  = Date('Ymd');
            $event->save();
            return $event;
        }

        public static function updateEvent(Request $request){
            $event = self::where('id', $request->fkEvent);
            $event->update(['fkEmployee' => $request->fkEmployee, 'eventStart' => $request->start, 'eventEnd' => $request->end, 'eventDate' => $request->eventDate]);
            return $event;
        }

        public static function deleteEvent(Request $request){
            $event = self::where('id', $request->fkEvent);
            $event->update(['endDate' => Date('Ymd')]);
            return $event;
        }

        public static function getAllEventsByDate($start, $end){
            return self::leftJoin('task', 'task.id', '=', 'planning.fkTask')
            ->leftJoin('letterColor', 'letterColor.id', '=', 'task.fkLetterColor')
            ->whereBetween('planning.eventDate', [$start, $end])
            ->whereNull('planning.endDate')
            ->select('planning.id AS id', 'libelle AS title', 'eventStart AS start', 'eventEnd AS end', 'fkEmployee AS resourceId', 'color AS backgroundColor', 'letterColor AS color')
            ->get();
        }

        public static function getAllEventsByDateAndFkEmployee($fkEmployee, $start, $end){
            return self::leftJoin('task', 'task.id', '=', 'planning.fkTask')
            ->leftJoin('letterColor', 'letterColor.id', '=', 'task.fkLetterColor')
            ->whereBetween('planning.eventDate', [$start, $end])
            ->where('fkEmployee', $fkEmployee)
            ->whereNull('planning.endDate')
            ->select('planning.id AS id', 'libelle AS title', 'eventStart AS start', 'eventEnd AS end','fkEmployee AS resourceId', 'color AS backgroundColor', 'letterColor AS color')
            ->get();
        }

        public static function getSumDayEmployee($fkEmployee, $eventDate){
            return self::where('fkEmployee', $fkEmployee)
                        ->where('eventDate', $eventDate)
                        ->whereNull('endDate')
                        ->select('eventStart', 'eventEnd')
                        ->get();
        }

        public static function getSumDayEmployeeWeek($fkEmployee, $startDate, $endDate){
            return self::where('fkEmployee', $fkEmployee)
                        ->whereBetween('eventDate', [$startDate, $endDate])
                        ->whereNull('endDate')
                        ->select('eventStart', 'eventEnd')
                        ->get();
        }
    }
// FILES COULD BE FACTURES ENERGIE, TELEPHONE, INTERNET, RIB, IBAN, CONTRAT (CEE CDD CDI)
?>
