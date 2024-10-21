protected function schedule(Schedule $schedule)
{
    $schedule->command('backup:run')->daily();
}
