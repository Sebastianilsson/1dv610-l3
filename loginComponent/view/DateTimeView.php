<?php

class DateTimeView {


	public function showDateTimeString() {
		date_default_timezone_set("Europe/Stockholm");
		$timeString = $this->getWeekday() . ", the " . $this->getDayOfMonth() . " of " . $this->getMonth() . " " . $this->getYear() . ", The time is " . $this->getTime();
		return '<p>' . $timeString . '</p>';
	}

	public function getWeekday() {
		return date('l');
	}

	public function getDayOfMonth() {
		return date('jS');
	}

	public function getMonth() {
		return date('F');
	}

	public function getYear() {
		return date('Y');
	}

	public function getTime() {
		return date('H:i:s');
	}
}