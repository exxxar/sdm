<?php


namespace App\Classes;


use App\Enums\ModelType;
use App\History;
use Illuminate\Support\Facades\Auth;

trait OperationHistory
{

    protected $object_before = null;
    protected $object_after = null;

    public function setBefore($object)
    {
        $this->object_before = $object;
    }

    public function setAfter($object)
    {
        $this->object_after = $object;
    }

    public function saveHistory($action = "Какое-то действие", $type = 1)
    {
        $tmpId = ($this->object_before ?? $this->object_after)->id ?? null;

        $this->addHistory($action, $objectId = $tmpId, $type, $this->object_before, $this->object_after);

        $this->setAfter(null);
        $this->setBefore(null);
    }

    private function addHistory($action = "Какое-то действие", $objectId = null, $type = 1, $objectBefore = null, $objectAfter = null)
    {
        History::create([
            'user_id' => Auth::user()->id,
            'type' => ModelType::fromValue($type),
            'object_id' => $objectId,
            'action' => $action,
            'object_after' => $objectAfter,
            'object_before' => $objectBefore
        ]);
    }
}
