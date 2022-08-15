<?php 

namespace Alura\Pdo\Domain\Model;

class Phone
{
    private ?int $phone_id;
    private string $areaCode;
    private string $number;

    public function __construct($phone_id, $areaCode, $number)
    {
        $this->phone_id = $phone_id;
        $this->areaCode = $areaCode;
        $this->number = $number;
    }
    public function formattedPhone() : string
    {
        return "($this->areaCode) $this->number";
    }
}