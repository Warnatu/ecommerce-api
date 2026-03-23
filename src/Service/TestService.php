<?php

namespace App\Service;

class TestService
{
    public function getData(): array
    {
        return [
            'message' => 'Servidor funcionando correctamente 🚀',
            'status' => 'ok',
            'time' => date('Y-m-d H:i:s')
        ];
    }
}