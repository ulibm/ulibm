
#n::
Send, {CTRLDOWN}{HOME}{CTRLUP}
Sleep, 100
Send, {END}

Sleep, 100
Send, {SPACE}
Send, //
SendUnicodeChar(0x0E1E)

Sleep, 100
MouseClick, left,  30,  47
Sleep, 100
MouseClick, left,  73,  257
Sleep, 100
WinWait, Save As, 
IfWinNotActive, Save As, , WinActivate, Save As, 
WinWaitActive, Save As, 
MouseClick, left,  494,  446
Sleep, 100
Send, {HOME}{DOWN}{DOWN}{ENTER}
MouseClick, left,  625,  443
Sleep, 100
WinWait, Confirm Save As, 
IfWinNotActive, Confirm Save As, , WinActivate, Confirm Save As, 
WinWaitActive, Confirm Save As, 
MouseClick, left,  251,  108
Sleep, 100
Send, {ALTDOWN}{ALTUP}
Send, f
Send, {ENTER}
Send, c
return


EncodeInteger(ref, val)
{
	DllCall("ntdll\RtlFillMemoryUlong", "Uint", ref, "Uint", 4, "Uint", val)
}
SendUnicodeChar(charCode)
{
	VarSetCapacity(ki, 28 * 2, 0)
	EncodeInteger(&ki + 0, 1)
	EncodeInteger(&ki + 6, charCode)
	EncodeInteger(&ki + 8, 4)
	EncodeInteger(&ki +28, 1)
	EncodeInteger(&ki +34, charCode)
	EncodeInteger(&ki +36, 4|2)

	DllCall("SendInput", "UInt", 2, "UInt", &ki, "Int", 28)
}