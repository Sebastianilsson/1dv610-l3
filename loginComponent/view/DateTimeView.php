<?php

class DateTimeView
{


	public function showDateTimeString(): string
	{
		date_default_timezone_set("Europe/Stockholm");
		$timeString = $this->getWeekday() . ", the " . $this->getDayOfMonth() . " of " . $this->getMonth() . " " . $this->getYear() . ", The time is " . $this->getTime();
		return '<p>' . $timeString . '</p>';
	}

	public function getWeekday(): string
	{
		return date('l');
	}

	public function getDayOfMonth(): string
	{
		return date('jS');
	}

	public function getMonth(): string
	{
		return date('F');
	}

	public function getYear(): string
	{
		return date('Y');
	}

	public function getTime(): string
	{
		return date('H:i:s');
	}
}
