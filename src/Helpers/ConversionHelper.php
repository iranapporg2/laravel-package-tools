<?php

	namespace iranapp\Tools\Helpers;

	class ConversionHelper {

		/**
		 * @param int $time timestamp and int format
		 * @param bool $hour only get hour
		 * @param bool $minute only get minute
		 * @param bool $second only get second
		 * @return float|string
		 */
		function secondToTime($time,$hour = true,$minute = true,$second = true): float|string {

			if ($hour && !$minute && !$second) return floor($time / 3600);
			if ($minute && !$hour && !$second) return floor($time / 60);
			if (!$minute && !$hour && $second) return floor($time % 60);

			$days = floor($time / (60 * 60 * 24));
			$time -= $days * (60 * 60 * 24);

			$hours = floor($time / (60 * 60));
			$time -= $hours * (60 * 60);

			$minutes = floor($time / 60);
			$time -= $minutes * 60;

			$seconds = floor($time);
			$time -= $seconds;

			$final = '';
			if ($days > 0)
				$final .= "{$days} روز";

			if ($hours > 0)
				$final .= " {$hours} ساعت";

			if ($minutes > 0)
				$final .= " {$minutes} دقیقه";

			if ($seconds > 0)
				$final .= " {$seconds} ثانیه";

			return $final;

		}

		/**
		 * convert time to readable data (ex 10 days ago)
		 * @param int|date $datetime
		 * @return false|int|mixed|string
		 */
		function ago($datetime) {

			if (preg_match('/^\d+$/', $datetime)) {
				$last_date = $datetime;
			} else
				$last_date = strtotime($datetime);

			$now = time();
			$time = $last_date;
			// catch error
			if (!$time) {
				return $last_date;
			}
			// build period and length arrays
			$periods = array('ثانیه', 'دقیقه', 'ساعت', 'روز', 'هفته', 'ماه', 'سال', 'قرن');
			$lengths = array(60, 60, 24, 7, 4.35, 12, 10);
			// get difference
			$difference = $now - $time;
			// set descriptor
			if ($difference < 0) {
				$difference = abs($difference); // absolute value
				$negative = true;
			}
			// do math
			for ($j = 0; $difference >= $lengths[$j] and $j < count($lengths) - 1; $j++) {
				$difference /= $lengths[$j];
			}
			// round difference
			$difference = intval(round($difference));

			if ($difference == 0) return 'لحظاتی پیش';

			// return
			return number_format($difference) . ' ' . $periods[$j] . ' ' . (isset($negative) ? '' : 'پیش');

		}

		function numToWord($strnum) {

			if ($strnum == '0') return 'صفر';
			$strnum = trim($strnum);
			$size_e = strlen($strnum);

			for ($i = 0; $i < $size_e; $i++) {
				if (!($strnum [$i] >= "0" && $strnum [$i] <= "9")) {
					die ("content of string must be number. " . 'فقط عدد وارد کنید' . $strnum);

				}
			}

			for ($i = 0; $i < $size_e && $strnum [$i] == "0"; $i++)
				;

			$str = substr($strnum, $i);
			$size = strlen($str);

			$arr = array();
			$res = "";
			$mod = $size % 3;
			if ($mod) {
				$arr [] = substr($str, 0, $mod);
			}

			for ($j = $mod; $j < $size; $j += 3) {
				$arr [] = substr($str, $j, 3);
			}

			$arr1 = array("", "یک", "دو", "سه", "چهار", "پنج", "شش", "هفت", "هشت", "نه");
			$arr2 = array(1 => "یازده", "دوازده", "سیزده", "چهارده", "پانزده", "شانزده", "هفده", "هجده", "نوزده");
			$arr3 = array(1 => "ده", "بیست", "سی", "چهل", "پنجاه", "شصت", "هفتاد", "هشتاد", "نود");
			$arr4 = array(1 => "صد", "دویست", "سیصد", "چهارصد", "پانصد", "ششصد", "هفتصد", "هشتصد", "نهصد");
			$arr5 = array(1 => "هزار", "میلیون", "میلیارد", "تیلیارد");
			$explode = 'و';
			$size_arr = count($arr);

			if ($size_arr > count($arr5) + 1) {
				die ("عدد بسیار بزرگ است . " . 'this number is greate');

			}

			for ($i = 0; $i < $size_arr; $i++) {

				$flag_2 = 0;
				$flag_1 = 0;

				if ($i) {
					$res .= ' ' . $explode . ' ';
				}

				$p = $arr [$i];
				$ss = strlen($p);

				for ($k = 0; $k < $ss; $k++) {
					if ($p [$k] != "0") {
						break;
					}
				}

				$p = substr($p, $k);
				$size_p = strlen($p);

				if ($size_p == 3) {
					$res .= $arr4 [( int )$p [0]];
					$p = substr($p, 1);
					$size_p = strlen($p);

					if ($p [0] == "0") {
						$p = substr($p, 1);
						$size_p = strlen($p);
						if ($p [0] == "0") {
							continue;
						} else {
							$flag_1 = 1;
						}

					} else {
						$flag_2 = 1;
					}

				}

				if ($size_p == 2) {

					if ($flag_2) {
						$res .= ' ' . $explode . ' ';
					}

					if ($p >= "0" && $p <= "9") {
						$res .= $arr1 [( int )$p];
					} elseif ($p >= "11" && $p <= "19") {
						$res .= $arr2 [( int )$p [1]];
					} elseif ($p [0] >= "1" && $p [0] <= "9" && $p [1] == "0") {
						$res .= $arr3 [( int )$p [0]];
					} else {
						$res .= $arr3 [( int )$p [0]];
						$res .= ' ' . $explode . ' ';
						$res .= $arr1 [( int )$p [1]];
					}

				}

				if ($size_p == 1) {

					if ($flag_1) {
						$res .= ' ' . $explode . ' ';
					}

					$res .= $arr1 [( int )$p];

				}

				if ($i + 1 < $size_arr) {
					$res .= ' ' . $arr5 [$size_arr - $i - 1];
				}

			}

			return rtrim($res, ' و');

		}

		function byteToWord($number, $precision = 3, $divisors = null) {

			// Setup default $divisors if not provided
			if (!isset($divisors)) {
				$divisors = array(
					pow(1000, 0) => '', // 1000^0 == 1
					pow(1000, 1) => 'K', // Thousand
					pow(1000, 2) => 'M', // Million
					pow(1000, 3) => 'B', // Billion
					pow(1000, 4) => 'T', // Trillion
					pow(1000, 5) => 'Qa', // Quadrillion
					pow(1000, 6) => 'Qi', // Quintillion
				);
			}

			// Loop through each $divisor and find the
			// lowest amount that matches
			foreach ($divisors as $divisor => $shorthand) {
				if (abs($number) < ($divisor * 1000)) {
					// We found a match!
					break;
				}
			}

			// We found our match, or there were no matches.
			// Either way, use the last defined value for $divisor.
			return number_format($number / $divisor, $precision) . $shorthand;

		}

		function precent($total, $number) {
			return $total > 0 ? number_format(($number * 100) / $total, 0) : 0;
		}

		function sanitize($str,$remove_spaces = true,$remove_comma = false) {

			$str = str_replace('ك','ک',$str);
			$str = str_replace('ي','ی',$str);
			if ($remove_comma) $str = str_replace(',','',$str);

			$en_num = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
			$fa_num = array('٠', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
			$fa_num1 = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');

			$t = str_replace($fa_num1, $en_num, $str);
			$t = str_replace($fa_num, $en_num, $t);
			$t = str_replace('۰','0',$t);

			if ($remove_spaces)
				$t = preg_replace('/\s+/', ' ', $t);

			return $t;

		}

		/**
		 * convert gregorian date to persian date
		 * @param $gregorial_date
		 * @param $format
		 * @return string
		 */
		function persian($gregorian_date,$format = 'Y/m/d') {
			return verta($this->sanitize($gregorian_date))->format($format);
		}

		/**
		 * convert persian date to gregorian date
		 * @param $gregorial_date
		 * @param $format
		 * @return string
		 */
		function gregorian($persian_date,$format = 'Y-m-d') {
			return \Verta::parse($this->sanitize($persian_date))->datetime()->format($format);
		}

		function number($number) {
			return number_format($this->sanitize($number),0);
		}

		public function slug($text)
		{
			// trim
			$text = trim($text);

			// replace non letter or digits by -
			$text = preg_replace('~[^\pL\d]+~u', '-', $text);

			// trim -
			$text = trim($text, '-');

			// remove duplicate -
			$text = preg_replace('~-+~', '-', $text);

			// lowercase
			$text = strtolower($text);

			if (empty($text)) {
				return null;
			}

			return $text;
		}

	}