<?php

class BrainFuckVisitor extends OperatorVisitor
{
    /**
     * @var Operator[] $aOps
     */
    private $aOps = [];

    /**
     * @var int[]
     */
    private $aMem = [];

    /**
     * @var int[]
     */
    private $aLoops = [];

    /**
     * @var int
     */
    private $iMemKey = 0;

    /**
     * @var int
     */
    private $iLoopKey = 0;

    /**
     * @var int
     */
    private $iOpKey = 0;

    /**
     * @var int
     */
    private $iCur;

    /**
     * @var array
     */
    private $aInput;

    /**
     * @var int
     */
    private $iInputKey = 0;

    /**
     * @param Operator[] $aOps
     * @param string $strInput
     */
    function __construct(Array $aOps, $strInput = '')
    {
        $this->aOps = $aOps;
        $this->aInput = str_split($strInput);
        $this->iCur =& $this->aMem[$this->iMemKey];
        $iLength = count($this->aOps);
        for( $this->iOpKey = 0; $this->iOpKey < $iLength; $this->iOpKey++ )
        {
            $this->aOps[$this->iOpKey]->accept($this);
        }
    }

    public function visitShiftLeft(ShiftLeft $oShiftLeft)
    {
        $this->iMemKey++;
        $this->iCur =& $this->aMem[$this->iMemKey];
    }

    public function visitShiftRight(ShiftRight $oShiftRight)
    {
        $this->iMemKey--;
        $this->iCur =& $this->aMem[$this->iMemKey];
    }

    public function visitIncrement(Increment $oIncrement)
    {
        $this->iCur++;
    }

    public function visitDecrement(Decrement $oDecrement)
    {
        $this->iCur--;
    }

    public function visitInput(Input $oInput)
    {
        if( !isset($this->aInput[$this->iInputKey]) )
            $this->iCur = -1;
        else
            $this->iCur = ord($this->aInput[$this->iInputKey++]);
    }

    public function visitOutput(Output $oOutput)
    {
        print chr($this->iCur);
    }

    public function visitBeginLoop(BeginLoop $oBeginLoop)
    {
        $this->aLoops[$this->iLoopKey++] = $this->iOpKey;
    }

    public function visitEndLoop(EndLoop $oEndLoop)
    {
        if( $this->iCur === 0 )
        {
            $this->iLoopKey--;
        }
        else
        {
            $this->iOpKey = $this->aLoops[$this->iLoopKey - 1];
        }
    }

}