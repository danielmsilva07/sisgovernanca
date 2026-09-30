<?php

namespace App\Helpers;

class GoogleAuthenticator 
{
    private static $base32chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    // Gera uma chave secreta aleatória em Base32
    public function createSecret($secretLength = 16) 
    {
        $secret = '';
        for ($i = 0; $i < $secretLength; $i++) {
            $secret .= self::$base32chars[random_int(0, 31)];
        }
        return $secret;
    }

    // Calcula o token de 6 dígitos baseado na secret e no tempo atual (RFC 6238)
    public function getCode($secret, $timeSlice = null) 
    {
        if ($timeSlice === null) {
            $timeSlice = floor(time() / 30);
        }

        $secretkey = $this->base32Decode($secret);
        $time = pack("N*", 0) . pack("N*", $timeSlice);
        $hmac = hash_hmac('sha1', $time, $secretkey, true);
        $offset = ord(substr($hmac, -1)) & 0x0F;
        $hashpart = substr($hmac, $offset, 4);

        $value = unpack('N', $hashpart);
        $value = $value[1];
        $value = $value & 0x7FFFFFFF;

        $modulo = pow(10, 6);
        return str_pad($value % $modulo, 6, '0', STR_PAD_LEFT);
    }

    // Valida o código digitado pelo usuário (com margem de variação de tempo)
    public function verifyCode($secret, $code, $discrepancy = 1) 
    {
        $currentTimeSlice = floor(time() / 30);

        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            $calculatedCode = $this->getCode($secret, $currentTimeSlice + $i);
            if (hash_equals($calculatedCode, $code)) {
                return true;
            }
        }
        return false;
    }

    // Gera a URL da imagem do QR Code para o aplicativo Google Authenticator
    public function getQRCodeUrl($title, $account, $secret) 
    {
        $otpauthUrl = 'otpauth://totp/' . rawurlencode($title) . ':' . rawurlencode($account) . '?secret=' . $secret . '&issuer=' . rawurlencode($title);
        
        // Utiliza o serviço QRServer para renderizar a imagem do QR Code
        return 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . rawurlencode($otpauthUrl);
    }

    private function base32Decode($secret) 
    {
        if (empty($secret)) return '';

        $base32chars = self::$base32chars;
        $base32charsFlipped = array_flip(str_split($base32chars));

        $paddingCharCount = substr_count($secret, '=');
        $allowedValues = array(6, 4, 3, 1, 0);
        if (!in_array($paddingCharCount, $allowedValues)) return false;

        for ($i = 0; $i < 4; $i++) {
            if ($paddingCharCount == $allowedValues[$i] &&
                substr($secret, - $paddingCharCount) != str_repeat('=', $paddingCharCount)) return false;
        }

        $secret = str_replace('=', '', $secret);
        $secret = str_split($secret);
        $binaryString = '';

        for ($i = 0; $i < count($secret); $i = $i + 8) {
            $x = '';
            if (!in_array($secret[$i], str_split($base32chars))) return false;
            for ($j = 0; $j < 8; $j++) {
                $x .= str_pad(base_convert(@$base32charsFlipped[@$secret[$i + $j]], 10, 2), 5, '0', STR_PAD_LEFT);
            }
            $eightBits = str_split($x, 8);
            for ($z = 0; $z < count($eightBits); $z++) {
                $binaryString .= (($y = bin2hex(chr(base_convert($eightBits[$z], 2, 10)))) || $y === '0') ? chr(hexdec($y)) : '';
            }
        }
        return $binaryString;
    }
}