<?php

namespace Kernel\Http;

class Redirect implements RedirectInterface
{
    public function to(string $url)  {
        header("Location: $url");
        exit;
    }
}