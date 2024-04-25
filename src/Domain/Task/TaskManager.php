<?php

namespace Domain\Task;

use App\Request\TaskRequest;
use DateTime;
use DateTimeZone;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskManager
{

    public function validateRequest(Request $request, ValidatorInterface $validator): ?array
    {
        $taskRequest = new TaskRequest();
        $taskRequest->date = $request->request->get('date');
        $taskRequest->timezone = $request->request->get('timezone');

        $errors = $validator->validate($taskRequest);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
        }

        return $errorMessages ?? null;
    }

    /**
     * @throws Exception
     */
    public function prepareResult(Request $request): string
    {
        $timeZone = new DateTimeZone($request->request->get('timezone'));
        $dateTime = new DateTime($request->request->get('date'), $timeZone);

        $inputTimezone = $request->request->get('timezone');
        $offsetMinutes = $dateTime->getOffset() / 60;
        if($offsetMinutes > 0) $offsetMinutes = '+' . $offsetMinutes;
        $specificMonth = $dateTime->format('F');
        $specificMonthDays = $dateTime->format('t');

        $februaryDays = $dateTime->modify('last day of February ' . $dateTime->format('Y'))->format('d');

        return "The time zone $inputTimezone has $offsetMinutes minutes offset to UTC on the given day at noon.<br/>
                February in this year is $februaryDays days long.<br/>
                The specified month ($specificMonth) is $specificMonthDays days long.";
    }

}