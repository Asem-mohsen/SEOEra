<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('report:daily')->dailyAt('00:00');
