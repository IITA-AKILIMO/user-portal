<?php

namespace KentaCompanion\Vendor\Illuminate\Contracts\Support;

interface MessageProvider
{
    /**
     * Get the messages for the instance.
     *
     * @return \KentaCompanion\Vendor\Illuminate\Contracts\Support\MessageBag
     */
    public function getMessageBag();
}
