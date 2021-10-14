<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\RequestAccessRequest;
use App\Support\Metas\AccessToken;
use App\Support\Transformers\Api\RequestAccessTransformer;
use Illuminate\Routing\Controller;
use League\Fractal\Resource\Item;
use function response;

class ChatApiController extends Controller {

    public function request_aceess(RequestAccessRequest $request) {
        $access_payload = new AccessToken(uniqid('', true), $request->name, null);

        return response()->json_from_transformer(new Item(
                                $access_payload,
                                new RequestAccessTransformer()
        ));
        // ddd($request);
    }

}
