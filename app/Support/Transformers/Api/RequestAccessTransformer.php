<?php

namespace App\Support\Transformers\Api;

use App\Support\Metas\AccessToken;
use League\Fractal\TransformerAbstract;

class RequestAccessTransformer extends TransformerAbstract {

    public function transform(AccessToken $data) {
        return [
            'name' => $data->name,
            'access_payload' => \Illuminate\Support\Facades\Crypt::encrypt($data, true),
        ];
    }

}
