<?php

class EndLoop implements Operator
{
    public function accept(OperatorVisitor $oOp)
    {
        $oOp->visit($this);
    }

}