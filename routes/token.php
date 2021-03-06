<?php
 
use Ramsey\Uuid\Uuid;
use Firebase\JWT\JWT;
use Tuupola\Base62;
$app->post("/token", function ($request, $response, $arguments) {
    $requested_scopes = $request->getParsedBody();
    $valid_scopes = [
        "todo.create",
        "todo.read",
        "todo.update",
        "todo.delete",
        "todo.list",
        "todo.all"
    ];
   $scopes= [];
   // $scopes = array_filter($requested_scopes, function ($needle) use ($valid_scopes) {
   //     return in_array($needle, $valid_scopes);
   // });
   echo file_get_contents("https://www.googleapis.com/oauth2/v1/userinfo?access_token="."ya29.Gl0FBJYhjVFYE7lAxWqhz8FJa3Dxmeyv6nK91Ys40fycFQKpOVAux71A441y28ToeRazHyLXUnhkEfLzX6k7z5RBnlbecV5a2T1OfjfzEZSAOheuyxzF0sDUuqEqftE");
    $now = new DateTime();
    $future = new DateTime("now +30 days");
    $server = $request->getServerParams();
    $jti = Base62::encode(random_bytes(16));
    $payload = [
        "iat" => $now->getTimeStamp(),
        "exp" => $future->getTimeStamp(),
        "jti" => $jti,
   //     "sub" => $server["PHP_AUTH_USER"],
   //     "scope" => $scopes
    ];
    $secret = getenv("JWT_SECRET");
    $token = JWT::encode($payload, $secret, "HS256");
    $data["status"] = "ok";
    $data["token"] = $token;
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
/* This is just for debugging, not usefull in real life. */
$app->get("/dump", function ($request, $response, $arguments) {
    print_r($this->token);
});
/* This is just for debugging, not usefull in real life. */
$app->get("/info", function ($request, $response, $arguments) {
    phpinfo();
});