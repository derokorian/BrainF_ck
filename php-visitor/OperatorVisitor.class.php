<?php

abstract class OperatorVisitor
{
    abstract public function visitShiftLeft(ShiftLeft $oShiftLeft);
    abstract public function visitShiftRight(ShiftRight $oShiftRight);
    abstract public function visitIncrement(Increment $oIncrement);
    abstract public function visitDecrement(Decrement $oDecrement);
    abstract public function visitInput(Input $oInput);
    abstract public function visitOutput(Output $oOutput);
    abstract public function visitBeginLoop(BeginLoop $oBeginLoop);
    abstract public function visitEndLoop(EndLoop $oEndLoop);

    public function visit(Operator $oOp)
    {
        call_user_func(array($this, 'visit' . get_class($oOp)), $oOp);
    }
}