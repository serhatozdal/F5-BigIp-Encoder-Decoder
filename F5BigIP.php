final class F5BigIP
{
    private function dec2hex($decimal, $length = 2)
    {
        return str_pad(dechex($decimal), $length, "0", STR_PAD_LEFT);
    }

    private function reverseBytes(string $payload)
    {
        $reversedBytes = "";
        for ($i = 0; $i < strlen($payload); $i+=2) {
            $reversedBytes = $payload[$i].$payload[$i+1] . $reversedBytes;
        }
        return $reversedBytes;
    }

    private function getPort($port)
    {
        $portHexadecimal = $this->dec2hex($port, 4);
        $portHexadecimal = $this->reverseBytes($portHexadecimal);

        return hexdec($portHexadecimal);
    }

    private function getEncodedIp($ip)
    {
        $ipOctets = explode('.', $ip);
        $ipHexadecimals = "";
        foreach ($ipOctets as $octet) {
            $ipHexadecimals .= self::dec2hex($octet);
        }
        $ipHexadecimals = self::reverseBytes($ipHexadecimals);

        return hexdec($ipHexadecimals);
    }

    private function getDecodedIp($encodedIp)
    {
        $ipHex = $this->dec2hex($encodedIp);
        $ipHex = $this->reverseBytes($ipHex);

        $hexOctets = str_split($ipHex, 2);
        return sprintf("%s.%s.%s.%s", hexdec($hexOctets[0]), hexdec($hexOctets[1]),
            hexdec($hexOctets[2]), hexdec($hexOctets[3]));
    }

    public function encode($ip, $port)
    {
        return sprintf('%s.%s.0000', $this->getEncodedIp($ip), $this->getPort($port));
    }

    public function decode($cookieString)
    {
        $cookieValues = explode('.', $cookieString);

        return sprintf('%s:%s', $this->getDecodedIp($cookieValues[0]), $this->getPort($cookieValues[1]));
    }
}
