<?php

    function tokenGenerator($id, $email, $name, $photo, $exp = 432000){
        
        
        
        // Criar token JWT manualmente
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'userId' => $id,
            'email' => $email,
            'name' => $name,
            'phot_url' => $photo,
            'exp' => time() + $exp,  // Expira em 5 dias
        ]);

        $secretKey = 'azhusgame';
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $secretKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $token = $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
        
        return $token;

    }
