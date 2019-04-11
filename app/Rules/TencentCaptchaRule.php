<?php

namespace App\Rules;

use App\Http\Services\TencentCaptchaService;
use Illuminate\Contracts\Validation\Rule;

class TencentCaptchaRule implements Rule
{
    private $message;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $tencentCaptchaService = new TencentCaptchaService();
        $param = json_decode($value);
        $result = $tencentCaptchaService->auth($param->ticket, $param->randstr);
        if ($result['response'] == 1) {
            return true;
        } else {
            $this->setMessage($result['err_msg']);
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    private function setMessage($err_msg)
    {
        $this->message = $err_msg;
    }
}
