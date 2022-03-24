<?php

namespace App\Exceptions;

use Exception;

class RoomConnectionException extends Exception
{

    public $redirectTo;
    public function redirectTo($url)
    {
        $this->redirectTo = $url;

        return $this;
    }
 public function render($request)
    {
        return redirect()->back()->with(["error" => true, "message" => $this->getMessage()]);

    }
}
