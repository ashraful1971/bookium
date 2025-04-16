<?php

namespace Ashraful\Bookium\Contracts;

interface Middleware
{
    public function handle(Request $request);
}
