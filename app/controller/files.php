<?php

namespace Controller;

class Files extends Base {

	public function thumb($f3, $params) {
		$file = new \Model\Issue\File();
		$file->load($params["id"]);

		if(!$file->id) {
			$f3->error(404);
			return;
		}

		// Output thumbnail of image file
		if(substr($file->content_type, 0, 5) == "image") {
			$img = new \Image($file->disk_filename, null, $f3->get("ROOT") . "/");
			$img->resize($params["size"], $params["size"]);

			// Ensure proper content-type for JPEG images
			if($params["format"] == "jpg") {
				$params["format"] = "jpeg";
			}

			$img->render($params["format"]);
			return;
		}
	}

	public function avatar($f3, $params) {
		$user = new \Model\User();
		$user->load($params["id"]);

		// Use Gravatar if user does not have an avatar
		// Note: this should rarely be used, as the URL for Gravatars should be used directly in most cases
		if(!$user->avatar_filename) {
			header("Content-type: image/png");
			readfile(gravatar($user->email, $params["size"]));
			return;
		}

		$img = new \Image($user->avatar_filename, null, $f3->get("ROOT") . "/uploads/avatars/");
		$img->resize($params["size"], $params["size"]);

		// Ensure proper content-type for JPEG images
		if($params["format"] == "jpg") {
			$params["format"] = "jpeg";
		}

		$img->render($params["format"]);
		return;
	}

	public function file($f3, $params) {
		$file = new \Model\Issue\File();
		$file->load($params["id"]);

		if(!$file->id) {
			$f3->error(404);
			return;
		}

		header("Content-Type: " . $file->content_type);
		header("Content-Length: " . filesize($file->disk_filename));
		readfile($file->disk_filename);
	}

}
