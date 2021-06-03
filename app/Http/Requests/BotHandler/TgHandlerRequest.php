<?php

namespace App\Http\Requests\BotHandler;

use App\Bots\Users\TgUser;
use Illuminate\Foundation\Http\FormRequest;

class TgHandlerRequest extends FormRequest implements BotHandlerRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function getCommand(): string
    {
        $command = $this->json('message.text') ??
            $this->json('callback_query.data');

        $command = explode(' ', $command)[0];

        return $command;
    }

    public function getParameters(): ?array
    {
        $parameters = $this->json('message.text') ??
            $this->json('callback_query.data');

        $parameters = explode(' ', $parameters);

        if(count($parameters) == 1){
            return null;
        }

        unset($parameters[0]);

        return $parameters;
    }

    public function getUser(): TgUser
    {
        $user = (array) $this->json('message.from') ??
            (array) $this->json('callback_query.from');

        return new TgUser(
            $user['id'],
            $user['firstname'],
            $user['lastname'],
            $user['username'],
        );
    }
}
