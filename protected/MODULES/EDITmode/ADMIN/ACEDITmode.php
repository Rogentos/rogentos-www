<?php
class ACEDITmode
{
    function __construct(&$C)
    {
        $this->C = &$C;
        $button = "
          <input type='button' name='editMODE' value='edit Mode' onclick='EditMODE()' />
          <input type='button' name='exitEditMODE' value='Exit edit Mode' onclick='ExitEditMODE()' style='display: none;'/>
          <input type='hidden' name='status_editMODE' value='false'  id='status_editMODE' />";
        $C->TOOLbar->ADDbuttons($button);
    }
}