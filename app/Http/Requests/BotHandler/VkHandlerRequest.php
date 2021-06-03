<?php

namespace App\Http\Requests\BotHandler;

use App\Bots\Users\VkUser;
use Illuminate\Foundation\Http\FormRequest;

class VkHandlerRequest extends FormRequest implements BotHandlerRequestInterface
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
        $command = match ($this->json('type')) {
            'confirmation' => 'vk_confirmation',
            'message_new' => $this->json('object.message.payload.command')
                ?? $this->json('object.message.text'),
            default => null,
        };

        $command = explode(" ", $command)[0];

        return $command;
    }

    public function getParameters(): ?array
    {
        $parameters = match ($this->json('type')) {
            'message_new' => (string) $this->json('object.message.payload.command')
                ?? (string) $this->json('object.message.text'),
            default => null,
        };

        if($parameters == null){
            return null;
        }

        $parameters = explode(' ', $parameters);

        if(count($parameters) == 1){
            return null;
        }

        unset($parameters[0]);

        return $parameters;
    }

    public function getUser(): VkUser
    {
        return new VkUser($this->json('object.message.from_id'));
    }
}
