<?php

class Input implements Operator
{
    public function accept(OperatorVisitor $oOp)
    {
        $oOp->visit($this);
    }

}