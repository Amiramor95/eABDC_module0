<?php


namespace App\Constants;


final class TaskStatusConstants
{
    const ACTIVE_STATUS = 'ACTIVE';
    const INACTIVE_STATUS = 'INACTIVE';
    const TASK_GENERAL = 'GENERAL';

    const ACTIVE_INACTIVE_STATUS = [ self::ACTIVE_STATUS, self::INACTIVE_STATUS];
}
