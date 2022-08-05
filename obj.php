<?php
$array = [1, 2, 3, 4]; /// array co 4 phan tu nhe

class ObjArray {
    protected $arr;
    public function __construct($arr)
    {
        $this->arr = $arr;
    }

    function count()
    {
        return count($this->arr);
    }

    function toString()
    {
        return implode('-', $this->arr);
    }
}

$obj = new ObjArray($array);

echo count($array);
echo '--';
echo $obj->count();
