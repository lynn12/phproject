<?php

namespace Helper;

class Matrix extends \Matrix {

	/**
	 * Merge n sorted arrays into a single array with the same sort order
	 *
	 * @param  array $arrays  Array of sorted arrays to merge
	 * @return array
	 */
	public function mergeSorted(array $arrays) {
		$lengths = array();
		foreach ($arrays as $k=>$v) {
			$lengths[$k] = count($v);
		}
		$max = max($lengths);
		$result = array();
		for ($i = 0; $i < $max; $i++) {
			foreach ($lengths as $k=>$l) {
				if ($l > $i) {
					$result[] = $arrays[$k][$i];
				}
			}
		}
		return $result;
	}

	/**
	 * Run array_merge on an array of arrays
	 *
	 * @param  array  $arrays
	 * @return array
	 */
	public function merge(array $arrays) {
		return call_user_func_array("array_merge", $arrays);
	}

}
